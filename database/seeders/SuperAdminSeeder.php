<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mydrtech.in'],
            [
                'name'           => 'System Administrator',
                'email'          => 'admin@mydrtech.in',
                'password'       => Hash::make('123#DrTech'),
                'role'           => 'super_admin',
                'status'         => 'active',
                'referral_code'  => 'DRTECH01',
                'wallet_balance' => 0,
                'total_earned'   => 0,
            ]
        );
    }
}