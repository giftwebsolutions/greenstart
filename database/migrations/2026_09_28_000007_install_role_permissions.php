<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\SysAdmin\Support\PermissionCatalog;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        $this->createPermissionTablesWhenMissing();

        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('password');
            }
        });

        $now = now();
        DB::table('permissions')->insertOrIgnore(array_map(fn (string $name): array => [
            'name' => $name,
            'guard_name' => 'web',
            'created_at' => $now,
            'updated_at' => $now,
        ], PermissionCatalog::names()));

        foreach (['super-admin', 'admin', 'staff'] as $role) {
            DB::table('roles')->insertOrIgnore([
                'name' => $role,
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $adminRoleId = DB::table('roles')->where('name', 'admin')->where('guard_name', 'web')->value('id');
        $permissionIds = DB::table('permissions')->whereIn('name', PermissionCatalog::names())->pluck('id');
        foreach ($permissionIds as $permissionId) {
            DB::table('role_has_permissions')->insertOrIgnore(['permission_id' => $permissionId, 'role_id' => $adminRoleId]);
        }

        $staffRoleId = DB::table('roles')->where('name', 'staff')->where('guard_name', 'web')->value('id');
        $staffPermissions = DB::table('permissions')->whereIn('name', [
            'sysadmin.dashboard.view',
            'catalog.products.view',
            'catalog.categories.view',
            'customer.enquiries.view',
        ])->pluck('id');
        foreach ($staffPermissions as $permissionId) {
            DB::table('role_has_permissions')->insertOrIgnore(['permission_id' => $permissionId, 'role_id' => $staffRoleId]);
        }

        DB::table('model_has_roles')
            ->where('model_type', 'Modules\\SysAdmin\\Models\\User')
            ->update(['model_type' => User::class]);
        DB::table('model_has_permissions')
            ->where('model_type', 'Modules\\SysAdmin\\Models\\User')
            ->update(['model_type' => User::class]);

        if (DB::table('users')->exists() && ! DB::table('model_has_roles')->exists()) {
            $superAdminRoleId = DB::table('roles')->where('name', 'super-admin')->where('guard_name', 'web')->value('id');
            DB::table('model_has_roles')->insert([
                'role_id' => $superAdminRoleId,
                'model_type' => User::class,
                'model_id' => DB::table('users')->orderBy('id')->value('id'),
            ]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }

    private function createPermissionTablesWhenMissing(): void
    {
        if (! Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table): void {
                $table->id();
                $table->string('name', 125);
                $table->string('guard_name', 125);
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }

        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table): void {
                $table->id();
                $table->string('name', 125);
                $table->string('guard_name', 125);
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }

        if (! Schema::hasTable('model_has_permissions')) {
            Schema::create('model_has_permissions', function (Blueprint $table): void {
                $table->unsignedBigInteger('permission_id');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->index(['model_id', 'model_type']);
                $table->foreign('permission_id')->references('id')->on('permissions')->cascadeOnDelete();
                $table->primary(['permission_id', 'model_id', 'model_type']);
            });
        }

        if (! Schema::hasTable('model_has_roles')) {
            Schema::create('model_has_roles', function (Blueprint $table): void {
                $table->unsignedBigInteger('role_id');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->index(['model_id', 'model_type']);
                $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
                $table->primary(['role_id', 'model_id', 'model_type']);
            });
        }

        if (! Schema::hasTable('role_has_permissions')) {
            Schema::create('role_has_permissions', function (Blueprint $table): void {
                $table->unsignedBigInteger('permission_id');
                $table->unsignedBigInteger('role_id');
                $table->foreign('permission_id')->references('id')->on('permissions')->cascadeOnDelete();
                $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
                $table->primary(['permission_id', 'role_id']);
            });
        }
    }
};
