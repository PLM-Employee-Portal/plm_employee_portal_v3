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
        Schema::create('monetizations', function (Blueprint $table) {
            $table->foreignId('employee_id');
            $table->string('reference_num')->primary();
            $table->tinyText('status')->default("Pending");
            $table->dateTime('date_of_filling')->default(now());
            $table->string('salary_grade');
            $table->string('requested_vacation_credits');
            $table->string('requested_sick_credits');
            $table->string('total_requested');
            $table->string('purpose');
            $table->dateTime('deleted_at')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monetizations');
    }
};
