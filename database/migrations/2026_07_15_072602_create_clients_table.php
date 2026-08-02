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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('control_number')
                ->nullable()
                ->unique();
            
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix');
            $table->string('sex');
            $table->timestamp('birthdate')->nullable();
            $table->integer('age');
            $table->string('civil_status'); //Single/Married/etc.  
            $table->text('address');
            $table->text('barangay');
            $table->text('municipality');
            $table->text('province');
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->text('occupation');
            $table->decimal('monthly_income');
            $table->integer('household_size');
            $table->string('valid_id_type');
            $table->string('valid_id_number');
            $table->string('client_category'); //Senior/PWD/Solo Parent/Regular
            $table->string('program_requested'); //AICS, etc.
            $table->text('reason_for_assistance');
            $table->timestamp('date_registered')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
