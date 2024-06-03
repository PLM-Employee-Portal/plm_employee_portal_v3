<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachpermits', function (Blueprint $table) {
            $table->foreignId('employee_id');
            $table->string('reference_num')->primary();
            $table->string('department_name');
            $table->date('application_date');
            $table->date('start_period_cover');
            $table->date('end_period_cover');
            $table->string('designation_rank');
            $table->longText('name_of_school_description');
            $table->json('load');
            $table->string('inside_outside_university');
            $table->string('total_load_plm')->nullable();
            $table->string('total_load_otherunivs')->nullable();
            $table->string('total_aggregate_load')->nullable();
            $table->longText('applicant_signature')->charset('binary');
            $table->string('status')->default('reviewing');
            $table->decimal('total_units_enrolled', 10, 2)->nullable();
            $table->decimal('available_units', 10, 2)->nullable();
            $table->dateTime('deleted_at')->nullable();

            // $table->longText('signature_of_head_office')->charset('binary')->nullable();
            // $table->string('verdict_of_head_office')->nullable();
            // $table->date('date_of_signature_of_head_office')->nullable();
            // $table->longText('signature_of_human_resource')->charset('binary')->nullable();
            // $table->string('verdict_of_human_resource')->nullable();
            // $table->date('date_of_signature_of_human_resource')->nullable();
            // $table->longText('signature_of_vp_for_academic_affair')->charset('binary')->nullable();
            // $table->string('verdict_of_vp_for_academic_affair')->nullable();
            // $table->date('date_of_signature_of_vp_for_academic_affair')->nullable();
            // $table->longText('signature_of_university_president')->charset('binary')->nullable();
            // $table->string('verdict_of_university_president')->nullable();
            // $table->date('date_of_signature_of_university_president')->nullable();
            $table->longText('permit_to_teach')->charset('binary')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachpermits');
    }
};
