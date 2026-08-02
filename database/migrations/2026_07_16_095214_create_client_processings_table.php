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
        Schema::create('client_processings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();
            
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();   
            
            $table->foreignId('queue_id')
                ->constrained()
                ->cascadeOnDelete();
            
            $table->string('current_step'); //Validation / Assessment / Review / Releasing
            $table->string('current_status'); //Waiting / Processing / Completed
            $table->timestamp('start_time')->useCurrent();
            $table->timestamp('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_processings');
    }
};
