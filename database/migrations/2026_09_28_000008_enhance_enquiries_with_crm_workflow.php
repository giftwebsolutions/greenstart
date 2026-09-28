<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table): void {
            $table->string('priority', 20)->default('normal')->after('status')->index();
            $table->foreignId('assigned_to')->nullable()->after('priority')->constrained('users')->nullOnDelete();
            $table->dateTime('next_follow_up_at')->nullable()->after('assigned_to')->index();
            $table->dateTime('last_contacted_at')->nullable()->after('next_follow_up_at');
            $table->dateTime('closed_at')->nullable()->after('last_contacted_at');
            $table->text('internal_notes')->nullable()->after('message');
        });

        Schema::create('enquiry_appointments', function (Blueprint $table): void {
            $table->id();
            $table->unsignedSmallInteger('enquiry_id')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title', 150);
            $table->string('customer_name', 120);
            $table->string('mobile', 30)->nullable();
            $table->string('email')->nullable();
            $table->dateTime('starts_at')->index();
            $table->dateTime('ends_at')->nullable();
            $table->string('meeting_type', 30)->default('in_person');
            $table->string('location')->nullable();
            $table->string('status', 20)->default('scheduled')->index();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('enquiry_id')->references('id')->on('enquiries')->nullOnDelete();
            $table->index(['starts_at', 'status']);
        });

        Schema::create('enquiry_follow_ups', function (Blueprint $table): void {
            $table->id();
            $table->unsignedSmallInteger('enquiry_id');
            $table->foreignId('appointment_id')->nullable()->constrained('enquiry_appointments')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type', 30)->default('call');
            $table->string('subject', 150);
            $table->text('notes')->nullable();
            $table->dateTime('scheduled_at')->index();
            $table->dateTime('completed_at')->nullable();
            $table->string('status', 20)->default('pending')->index();
            $table->string('outcome', 50)->nullable();
            $table->timestamps();

            $table->foreign('enquiry_id')->references('id')->on('enquiries')->cascadeOnDelete();
            $table->index(['enquiry_id', 'status', 'scheduled_at'], 'enquiry_follow_up_schedule_index');
        });

        Schema::create('enquiry_activities', function (Blueprint $table): void {
            $table->id();
            $table->unsignedSmallInteger('enquiry_id');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type', 40)->index();
            $table->text('description');
            $table->json('properties')->nullable();
            $table->timestamps();

            $table->foreign('enquiry_id')->references('id')->on('enquiries')->cascadeOnDelete();
            $table->index(['enquiry_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiry_activities');
        Schema::dropIfExists('enquiry_follow_ups');
        Schema::dropIfExists('enquiry_appointments');

        Schema::table('enquiries', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('assigned_to');
            $table->dropIndex(['priority']);
            $table->dropIndex(['next_follow_up_at']);
            $table->dropColumn(['priority', 'next_follow_up_at', 'last_contacted_at', 'closed_at', 'internal_notes']);
        });
    }
};
