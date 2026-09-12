<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->text('assessment_findings')->nullable()->change();
            $table->text('recommendation')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->text('assessment_findings')->nullable(false)->change();
            $table->text('recommendation')->nullable(false)->change();
        });
    }
};