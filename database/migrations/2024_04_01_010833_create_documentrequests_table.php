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
        Schema::create('documentrequests', function (Blueprint $table) {
            $table->foreignId('employee_id');
            $table->string('reference_num')->primary();
            $table->string('name');
            $table->string('office_department');
            $table->string('employment_status');
            $table->string('status')->default('reviewing');
            $table->date('date_of_filling');
            $table->date('documents')->nullable();
            $table->json('requests');
            $table->longText('milc_description')->nullable();
            $table->longText('other_request')->nullable();
            $table->longText('purpose');
            // $table->binary('signature_requesting_party');
            $table->longText('signature_requesting_party')->charset('binary');
            $table->dateTime('deleted_at')->nullable();

            $table->longText('certificate_of_employment')->charset('binary')->nullable();
            $table->longText('certificate_of_employment_with_compensation')->charset('binary')->nullable();
            $table->longText('service_record')->charset('binary')->nullable();
            $table->longText('part_time_teaching_services')->charset('binary')->nullable();
            $table->longText('milc_certification')->charset('binary')->nullable();
            $table->longText('certificate_of_no_pending_administrative_case')->charset('binary')->nullable();
            $table->longText('other_documents')->charset('binary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentrequests');
    }
};
