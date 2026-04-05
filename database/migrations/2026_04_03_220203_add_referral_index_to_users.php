<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('referral_code');
            $table->index('referred_by');
            $table->index('role');
            $table->index('status');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('type');
            $table->index('status');
        });

        Schema::table('withdraw_requests', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['referral_code']);
            $table->dropIndex(['referred_by']);
            $table->dropIndex(['role']);
            $table->dropIndex(['status']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['status']);
        });

        Schema::table('withdraw_requests', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
        });
    }
};