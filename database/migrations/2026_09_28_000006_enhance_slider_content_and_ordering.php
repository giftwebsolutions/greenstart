<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table): void {
            $table->text('description')->nullable()->change();
        });
        Schema::table('slider_items', function (Blueprint $table): void {
            $table->text('description')->nullable()->change();
            $table->unsignedSmallInteger('sort_order')->default(0)->after('target');
        });
    }

    public function down(): void
    {
        Schema::table('slider_items', function (Blueprint $table): void {
            $table->dropColumn('sort_order');
            $table->string('description', 255)->nullable()->change();
        });
        Schema::table('sliders', function (Blueprint $table): void {
            $table->string('description', 255)->nullable()->change();
        });
    }
};
