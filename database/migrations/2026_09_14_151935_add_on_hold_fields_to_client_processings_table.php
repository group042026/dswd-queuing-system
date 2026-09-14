<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_processings', function (Blueprint $table): void {
            $table->boolean('is_returnee')
                ->default(false)
                ->after('current_status');

            $table->text('on_hold_reason')
                ->nullable()
                ->after('is_returnee');

            $table->timestamp('on_hold_at')
                ->nullable()
                ->after('on_hold_reason');

            $table->timestamp('resumed_at')
                ->nullable()
                ->after('on_hold_at');
        });
    }

    public function down(): void
    {
        Schema::table('client_processings', function (Blueprint $table): void {
            $table->dropColumn([
                'is_returnee',
                'on_hold_reason',
                'on_hold_at',
                'resumed_at',
            ]);
        });
    }
};