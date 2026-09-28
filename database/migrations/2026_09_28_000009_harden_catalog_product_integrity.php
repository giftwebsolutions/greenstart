<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('product', 'stock')) {
            Schema::table('product', function (Blueprint $table): void {
                // Preserve the legacy behaviour where products without explicit
                // inventory were treated as available.
                $table->unsignedInteger('stock')->default(1)->after('sales_price');
            });
        }

        $selectAttributeIds = DB::table('attribute')
            ->join('attribute_type', 'attribute.type', '=', 'attribute_type.attribute_type_id')
            ->where('attribute_type.identifier', 'select')
            ->pluck('attribute.id');

        DB::table('product_attribute_values')
            ->whereNull('attribute_value_id')
            ->whereIn('attribute_id', $selectAttributeIds)
            ->whereNotNull('value')
            ->orderBy('id')
            ->chunkById(250, function ($rows): void {
                foreach ($rows as $row) {
                    $rawValue = trim((string) $row->value);
                    if ($rawValue === '' || ! ctype_digit($rawValue)) {
                        continue;
                    }

                    $optionId = (int) $rawValue;
                    $validOption = DB::table('attribute_values')
                        ->where('id', $optionId)
                        ->where('attribute_id', $row->attribute_id)
                        ->exists();

                    if ($validOption) {
                        DB::table('product_attribute_values')->where('id', $row->id)->update([
                            'attribute_value_id' => $optionId,
                            'value' => null,
                            'updated_at' => now(),
                        ]);
                    }
                }
            });

        DB::table('product_image')
            ->whereNotExists(fn ($query) => $query
                ->selectRaw('1')
                ->from('product')
                ->whereColumn('product.id', 'product_image.product_id'))
            ->delete();

        DB::table('product_attribute_values')
            ->whereNotExists(fn ($query) => $query
                ->selectRaw('1')
                ->from('product')
                ->whereColumn('product.id', 'product_attribute_values.product_id'))
            ->orWhereNotExists(fn ($query) => $query
                ->selectRaw('1')
                ->from('attribute')
                ->whereColumn('attribute.id', 'product_attribute_values.attribute_id'))
            ->delete();

        Schema::table('product_image', function (Blueprint $table): void {
            $table->foreign('product_id', 'product_image_product_id_foreign')
                ->references('id')->on('product')->cascadeOnDelete();
        });

        Schema::table('product_attribute_values', function (Blueprint $table): void {
            $table->foreign('product_id', 'product_attribute_values_product_id_foreign')
                ->references('id')->on('product')->cascadeOnDelete();
            $table->foreign('attribute_id', 'product_attribute_values_attribute_id_foreign')
                ->references('id')->on('attribute')->cascadeOnDelete();
            $table->foreign('attribute_value_id', 'product_attribute_values_attribute_value_id_foreign')
                ->references('id')->on('attribute_values')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('product_attribute_values', function (Blueprint $table): void {
            $table->dropForeign('product_attribute_values_product_id_foreign');
            $table->dropForeign('product_attribute_values_attribute_id_foreign');
            $table->dropForeign('product_attribute_values_attribute_value_id_foreign');
        });

        Schema::table('product_image', function (Blueprint $table): void {
            $table->dropForeign('product_image_product_id_foreign');
        });

        if (Schema::hasColumn('product', 'stock')) {
            Schema::table('product', function (Blueprint $table): void {
                $table->dropColumn('stock');
            });
        }
    }
};
