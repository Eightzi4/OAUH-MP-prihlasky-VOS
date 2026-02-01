<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('study_program_id')->constrained('study_programs');
            $table->string('status')->default('draft');
            $table->string('application_number')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_city')->nullable();
            $table->string('citizenship')->nullable();

            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();

            $table->string('previous_school')->nullable();
            $table->string('izo')->nullable();
            $table->string('school_type')->nullable();
            $table->string('previous_study_field')->nullable();
            $table->string('previous_study_field_code')->nullable();
            $table->string('graduation_year')->nullable();
            $table->decimal('grade_average', 4, 2)->nullable();

            $table->text('specific_needs')->nullable();
            $table->text('note')->nullable();
            $table->string('other_file_path')->nullable();

            $table->timestamps();
        });

        Schema::create('application_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->string('type');
            $table->string('filename');
            $table->string('disk_path');
            $table->string('mime_type')->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_attachments');
        Schema::dropIfExists('applicant_details');
        Schema::dropIfExists('applications');
    }
};
