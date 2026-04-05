<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MlmSetting;

class MlmSettingsSeeder extends Seeder
{
    public function run(): void
    {
        MlmSetting::updateOrCreate(
            ['id' => 1],
            [
                'plan_type' => 'unilevel',
                'max_levels' => 10,
                'binary_limit' => 2,
                'matrix_width' => 3,
                'matrix_depth' => 5,
                'registration_fee' => 0,
                'currency' => 'INR',
                'is_active' => true,
            ]
        );
    }
}