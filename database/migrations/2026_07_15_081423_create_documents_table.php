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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();
            
            $table->foreignId('assessment_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('document_name');
            $table->string('file_path');
            $table->timestamp('upload_date')->useCurrent();
            $table->boolean('verified');//Yes/No

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
