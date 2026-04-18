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
    DB::statement("ALTER TABLE users MODIFY role ENUM('super_admin','admin','sub_admin','user') DEFAULT 'user'");
}

public function down(): void
{
    DB::statement("ALTER TABLE users MODIFY role ENUM('admin','sub_admin','user') DEFAULT 'user'");
}
};
