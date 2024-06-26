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
        Schema::create('change_information', function (Blueprint $table) {
            $table->foreignId('employee_id');
            $table->string('reference_num')->primary();
            $table->string('status');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            // $table->decimal('age');
            $table->string('gender')->default('Would Rather Not say');
            $table->string('personal_email');
            $table->string('phone');
            // $table->date('birth_date');
            $table->string('address');
            $table->json('employee_history')->nullable();
            $table->dateTime('deleted_at')->nullable();


             //Documents
            $table->longText('emp_photo')->charset('binary')->nullable();
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
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_information');
    }
};
