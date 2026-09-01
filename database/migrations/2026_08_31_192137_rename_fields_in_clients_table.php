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
        Schema::table('clients', function (Blueprint $table) {
            $table->renameColumn('reason_for_assistance', 'type_of_assistance');
            $table->renameColumn('monthly_income', 'salary');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->renameColumn('type_of_assistance', 'reason_for_assistance');
            $table->renameColumn('salary', 'monthly_income');
        });
    }
};
