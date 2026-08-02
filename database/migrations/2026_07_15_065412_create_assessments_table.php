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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();

            

            $table->foreignId('social_worker_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();  

            $table->timestamp('interview_date')->nullable();
            $table->text('means_verification');
            $table->text('assessment_findings');
            $table->text('recommendation');
            $table->string('assessment_status'); //Pending/Completed
            $table->text('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
