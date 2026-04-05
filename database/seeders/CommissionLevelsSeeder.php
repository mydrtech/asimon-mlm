<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommissionLevel;

class CommissionLevelsSeeder extends Seeder
{
    public function run(): void
    {
        $commissionLevels = [
            ['level' => 1, 'percentage' => 10, 'bonus_amount' => 0, 'is_active' => true],
            ['level' => 2, 'percentage' => 8, 'bonus_amount' => 0, 'is_active' => true],
            ['level' => 3, 'percentage' => 6, 'bonus_amount' => 0, 'is_active' => true],
            ['level' => 4, 'percentage' => 5, 'bonus_amount' => 0, 'is_active' => true],
            ['level' => 5, 'percentage' => 4, 'bonus_amount' => 0, 'is_active' => true],
            ['level' => 6, 'percentage' => 3, 'bonus_amount' => 0, 'is_active' => true],
            ['level' => 7, 'percentage' => 2, 'bonus_amount' => 0, 'is_active' => true],
            ['level' => 8, 'percentage' => 2, 'bonus_amount' => 0, 'is_active' => true],
            ['level' => 9, 'percentage' => 1, 'bonus_amount' => 0, 'is_active' => true],
            ['level' => 10, 'percentage' => 1, 'bonus_amount' => 0, 'is_active' => true],
        ];

        foreach ($commissionLevels as $level) {
            CommissionLevel::updateOrCreate(
                ['level' => $level['level']],
                $level
            );
        }
    }
}