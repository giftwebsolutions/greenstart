<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('galleries')) {
            Schema::create('galleries', function (Blueprint $table): void {
                $table->id();
                $table->string('name', 120)->unique();
                $table->string('slug', 160)->unique();
                $table->text('description')->nullable();
                $table->unsignedTinyInteger('status')->default(1)->index();
                $table->string('thumbnail')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('gallery_items')) {
            Schema::create('gallery_items', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('gallery_id')->constrained('galleries')->cascadeOnDelete();
                $table->string('path');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->timestamp('timestamp')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('tags')) {
            Schema::create('tags', function (Blueprint $table): void {
                $table->id();
                $table->string('name', 100)->unique();
                $table->string('slug', 120)->unique();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('tags');
    }
};
