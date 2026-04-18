<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mlm_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('plan_type', ['unilevel'])->default('unilevel');
            $table->integer('max_levels')->default(10);
            $table->integer('matrix_width')->default(3);
            $table->integer('matrix_depth')->default(5);
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->string('currency', 3)->default('INR');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mlm_settings');
    }
};