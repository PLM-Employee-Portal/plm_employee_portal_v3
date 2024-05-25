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
        Schema::create('employees', function (Blueprint $table) {
            $table->foreignId('employee_id')->primary();
            $table->longText('employee_type');
            $table->string('school_email')->nullable();
            $table->json('college_id')->nullable();
            $table->json('department_id')->nullable();
            $table->json('is_department_head')->nullable();
            $table->json('is_college_head')->nullable();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->decimal('age');
            $table->string('gender')->default('Would Rather Not say');
            $table->string('personal_email');
            $table->string('phone');
            $table->date('birth_date');
            $table->string('address');
            $table->date('start_of_employment');
            $table->date('end_of_employment')->nullable();
            $table->json('employee_history')->nullable();
            $table->decimal('vacation_credits')->nullable();
            $table->decimal('sick_credits')->nullable();
            $table->integer('study_available_units')->nullable();
            $table->integer('teach_available_units')->nullable();
            $table->string('current_position');
            $table->boolean('is_faculty');
            $table->decimal('salary', 10, 2);
            
            //Documents
            $table->string('emp_image')->nullable();
            $table->json('emp_diploma')->nullable();
            $table->json('emp_tor')->nullable();
            $table->json('emp_cert_of_trainings_seminars')->nullable();
            $table->json('emp_auth_copy_of_csc_or_prc')->nullable();
            $table->json('emp_auth_copy_of_prc_board_rating')->nullable();
            $table->json('emp_med_certif')->nullable();
            $table->json('emp_nbi_clearance')->nullable();
            $table->json('emp_psa_birth_certif')->nullable();
            $table->json('emp_psa_marriage_certif')->nullable();
            $table->json('emp_service_record_from_other_govt_agency')->nullable();
            $table->json('emp_approved_clearance_prev_employer')->nullable();
            $table->json('other_documents')->nullable();
            
            // Account Creation


            // $table->integer('employee_role');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
