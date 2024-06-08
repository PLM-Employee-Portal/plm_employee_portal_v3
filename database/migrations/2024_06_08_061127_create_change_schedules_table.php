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
        Schema::create('change_schedules', function (Blueprint $table) {
            $table->foreignId('employee_id');
            $table->string('reference_num')->primary();
            $table->tinyText('status')->default("Pending");
            $table->dateTime('date_of_filling')->default(now());
            $table->date('start_period_cover');
            $table->date('end_period_cover');
            $table->json('original');
            $table->json('proposed');
            $table->longText('reason');
            $table->longText('applicant_signature')->charset('binary');
            $table->dateTime('deleted_at')->default(now());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_schedules');
    }
};
