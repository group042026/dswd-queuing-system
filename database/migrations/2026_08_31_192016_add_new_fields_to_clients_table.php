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
            $table->string('district')->nullable()->after('barangay');
            $table->string('mode_of_admission')->nullable()->after('district');
            $table->string('mode_of_release')->nullable()->after('mode_of_admission');
            $table->string('subcategory')->nullable()->after('client_category');
            $table->decimal('amount', 10, 2)->nullable()->after('subcategory');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['district', 'mode_of_admission', 'mode_of_release', 'subcategory', 'amount']);
        });
    }
};
