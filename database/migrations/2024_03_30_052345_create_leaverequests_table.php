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
        Schema::create('leaverequests', function (Blueprint $table) {
            $table->foreignId('employee_id');
            $table->string('reference_num')->primary();
            $table->string('status')->default('reviewing');
            $table->date('date_of_filling')->default(now());
            
            // Details of application
            $table->string('type_of_leave');
            $table->string('type_of_leave_others')->default('Not Applicable')->nullable();
            $table->string('type_of_leave_sub_category');
            $table->string('type_of_leave_description')->default('Not Applicable')->nullable();
            $table->decimal('num_of_days_work_days_applied');
            $table->dateTime('inclusive_start_date')->default(now()->timezone('Asia/Manila'));
            $table->dateTime('inclusive_end_date')->default(now()->timezone('Asia/Manila'));
            $table->string('commutation');
            $table->longText('commutation_signature_of_appli');
            $table->dateTime('deleted_at')->nullable();

            // Approve Requests
            $table->string('office_department');
            $table->decimal('total_earned_vaca', 10, 2)->nullable();
            $table->decimal('less_this_appli_vaca', 10, 2)->nullable();
            $table->decimal('balance_vaca', 10, 2)->nullable();
            $table->decimal('total_earned_sick', 10, 2)->nullable();
            $table->decimal('less_this_appli_sick', 10, 2)->nullable();
            $table->decimal('balance_sick', 10, 2)->nullable();
            $table->date('as_of_filling')->nullable();
            $table->string('status_description')->nullable();
            $table->string('days_with_pay')->nullable();
            $table->string('days_without_pay')->nullable();
            $table->string('others')->nullable();
            $table->binary('auth_off_sig_b')->nullable();
            $table->boolean('department_head_verdict')->nullable();
            $table->string('head_disapprove_reason')->nullable();
            $table->boolean('human_resource_verdict_a')->nullable();
            $table->binary('auth_off_sig_a')->nullable();
            $table->string('hr_a_disapprove_reason')->nullable();
            $table->boolean('human_resource_verdict_cd')->nullable();
            $table->string('hr_cd_disapprove_reason')->nullable();
            $table->binary('auth_off_sig_c_and_d')->nullable();
            $table->binary('leave_form')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaverequests');
    }
};
