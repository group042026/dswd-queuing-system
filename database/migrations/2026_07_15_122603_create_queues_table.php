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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number');

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->boolean('priority');
            $table->string('queue_status'); //Waiting / Serving / Completed / Cancelled
            $table->timestamp('date_issued')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
