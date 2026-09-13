<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('occupation')->nullable()->change();
            $table->decimal('salary', 8, 2)->nullable()->change();
            $table->integer('household_size')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('occupation')->nullable(false)->change();
            $table->decimal('salary', 8, 2)->nullable(false)->change();
            $table->integer('household_size')->nullable(false)->change();
        });
    }
};