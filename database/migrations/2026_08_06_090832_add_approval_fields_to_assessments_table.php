<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->string('assessment_status')->nullable()->after('remarks');
            $table->foreignId('approving_officer_id')->nullable()->after('social_worker_id')->constrained('users')->nullOnDelete();
            $table->string('approval_status')->nullable()->after('assessment_status');
            $table->text('approval_remarks')->nullable()->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('approval_remarks');
        });
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropForeign(['approving_officer_id']);
            $table->dropColumn(['assessment_status', 'approving_officer_id', 'approval_status', 'approval_remarks', 'approved_at']);
        });
    }
};
