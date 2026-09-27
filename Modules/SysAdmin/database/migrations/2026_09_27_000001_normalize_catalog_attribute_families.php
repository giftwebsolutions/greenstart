<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attribute_families', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 64)->unique();
            $table->string('name', 120);
            $table->unsignedTinyInteger('status')->default(1)->index();
            $table->timestamps();
        });

        // Legacy groups used TINYINT identifiers, which capped the complete
        // catalog at 255 groups. Widen the key and every referencing column
        // before introducing family-owned groups.
        Schema::table('attribute_mapping', function (Blueprint $table): void {
            $table->dropForeign('attribute_mapping_group_fk');
        });
        Schema::table('attribute', function (Blueprint $table): void {
            $table->dropForeign('fk_attribute_group_id');
        });
        Schema::table('attribute_group', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement()->change();
        });
        Schema::table('attribute_mapping', function (Blueprint $table): void {
            $table->unsignedBigInteger('group_id')->change();
            $table->foreign('group_id', 'attribute_mapping_group_fk')->references('id')->on('attribute_group')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::table('attribute', function (Blueprint $table): void {
            $table->unsignedBigInteger('group_id')->nullable()->change();
            $table->foreign('group_id', 'fk_attribute_group_id')->references('id')->on('attribute_group')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::table('attribute_group', function (Blueprint $table): void {
            $table->foreignId('family_id')->nullable()->after('id')->constrained('attribute_families')->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(0)->after('slug');
            $table->boolean('is_user_defined')->default(true)->after('position');
        });

        Schema::table('attribute_mapping', function (Blueprint $table): void {
            $table->unsignedSmallInteger('position')->default(0)->after('group_id');
        });

        Schema::table('attribute', function (Blueprint $table): void {
            $table->string('code', 64)->nullable()->after('name');
        });

        $usedFamilyCodes = [];

        DB::table('attribute_group')->orderBy('id')->get()->each(function (object $legacyGroup) use (&$usedFamilyCodes): void {
            $baseCode = Str::slug($legacyGroup->slug ?: $legacyGroup->name, '_') ?: 'family_'.$legacyGroup->id;
            $code = $baseCode;
            $suffix = 2;

            while (isset($usedFamilyCodes[$code])) {
                $code = $baseCode.'_'.$suffix++;
            }

            $usedFamilyCodes[$code] = true;

            DB::table('attribute_families')->insert([
                'id' => $legacyGroup->id,
                'code' => $code,
                'name' => $legacyGroup->name,
                'status' => $legacyGroup->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('attribute_group')->where('id', $legacyGroup->id)->update([
                'family_id' => $legacyGroup->id,
                'name' => 'General',
                'slug' => 'general',
                'position' => 0,
                'is_user_defined' => false,
            ]);
        });

        if (! DB::table('attribute_families')->exists()) {
            $familyId = DB::table('attribute_families')->insertGetId([
                'code' => 'default',
                'name' => 'Default',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('attribute_group')->insert([
                'family_id' => $familyId,
                'name' => 'General',
                'slug' => 'general',
                'position' => 0,
                'is_user_defined' => false,
                'status' => 1,
            ]);
        }

        Schema::table('attribute_group', function (Blueprint $table): void {
            $table->unsignedBigInteger('family_id')->nullable(false)->change();
            $table->unique(['family_id', 'slug'], 'attribute_group_family_slug_unique');
            $table->index(['family_id', 'position'], 'attribute_group_family_position_index');
        });

        Schema::table('attribute_mapping', function (Blueprint $table): void {
            $table->index(['group_id', 'position'], 'attribute_mapping_group_position_index');
        });

        $usedAttributeCodes = [];

        DB::table('attribute')->orderBy('id')->get(['id', 'name', 'group_id', 'sort_order'])->each(
            function (object $attribute) use (&$usedAttributeCodes): void {
                $baseCode = Str::slug($attribute->name, '_') ?: 'attribute_'.$attribute->id;
                $code = $baseCode;
                $suffix = 2;

                while (isset($usedAttributeCodes[$code])) {
                    $code = $baseCode.'_'.$suffix++;
                }

                $usedAttributeCodes[$code] = true;
                DB::table('attribute')->where('id', $attribute->id)->update(['code' => $code]);

                if ($attribute->group_id) {
                    DB::table('attribute_mapping')->updateOrInsert(
                        ['attribute_id' => $attribute->id, 'group_id' => $attribute->group_id],
                        ['position' => (int) ($attribute->sort_order ?? 0), 'updated_at' => now(), 'created_at' => now()]
                    );
                }
            }
        );

        if (Schema::hasColumn('product', 'attribute_set_id')) {
            Schema::table('product', function (Blueprint $table): void {
                $table->renameColumn('attribute_set_id', 'attribute_family_id');
            });

            Schema::table('product', function (Blueprint $table): void {
                $table->unsignedBigInteger('attribute_family_id')->nullable()->change();
                $table->foreign('attribute_family_id')->references('id')->on('attribute_families')->nullOnDelete();
            });
        }

        Schema::table('attribute', function (Blueprint $table): void {
            $table->unique('code', 'attribute_code_unique');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('product', 'attribute_family_id')) {
            Schema::table('product', function (Blueprint $table): void {
                $table->dropForeign(['attribute_family_id']);
                $table->renameColumn('attribute_family_id', 'attribute_set_id');
            });
        }

        Schema::table('attribute', function (Blueprint $table): void {
            $table->dropUnique('attribute_code_unique');
            $table->dropColumn('code');
        });

        Schema::table('attribute_mapping', function (Blueprint $table): void {
            $table->dropIndex('attribute_mapping_group_position_index');
            $table->dropColumn('position');
        });

        Schema::table('attribute_group', function (Blueprint $table): void {
            $table->dropUnique('attribute_group_family_slug_unique');
            $table->dropIndex('attribute_group_family_position_index');
            $table->dropForeign(['family_id']);
            $table->dropColumn(['family_id', 'position', 'is_user_defined']);
        });

        Schema::dropIfExists('attribute_families');
    }
};
