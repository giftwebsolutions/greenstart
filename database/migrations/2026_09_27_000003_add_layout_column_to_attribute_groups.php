<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attribute_group', function (Blueprint $table): void {
            $table->unsignedTinyInteger('column')->default(1)->after('position');
        });
    }

    public function down(): void
    {
        Schema::table('attribute_group', function (Blueprint $table): void {
            $table->dropColumn('column');
        });
    }
};
