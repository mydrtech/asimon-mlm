<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@asimon-mlm.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'phone' => '01700000000',
                'referral_code' => 'ADMIN123',
                'referred_by' => null,
                'role' => 'admin',
                'status' => 'active',
                'wallet_balance' => 0,
                'total_earned' => 0,
                'left_count' => 0,
                'right_count' => 0,
                'position' => null,
            ]
        );

        // Create demo user 1 (referred by admin)
        $demoUser1 = User::updateOrCreate(
            ['email' => 'user1@asimon-mlm.com'],
            [
                'name' => 'Demo User 1',
                'password' => Hash::make('password123'),
                'phone' => '01711111111',
                'referral_code' => 'USER1001',
                'referred_by' => User::where('email', 'admin@asimon-mlm.com')->first()->id ?? null,
                'role' => 'user',
                'status' => 'active',
                'wallet_balance' => 500,
                'total_earned' => 1000,
                'left_count' => 0,
                'right_count' => 0,
                'position' => 'left',
            ]
        );

        // Create demo user 2 (referred by admin)
        User::updateOrCreate(
            ['email' => 'user2@asimon-mlm.com'],
            [
                'name' => 'Demo User 2',
                'password' => Hash::make('password123'),
                'phone' => '01722222222',
                'referral_code' => 'USER1002',
                'referred_by' => User::where('email', 'admin@asimon-mlm.com')->first()->id ?? null,
                'role' => 'user',
                'status' => 'active',
                'wallet_balance' => 300,
                'total_earned' => 800,
                'left_count' => 0,
                'right_count' => 0,
                'position' => 'right',
            ]
        );

        // Create demo user 3 (referred by user1)
        if ($demoUser1) {
            User::updateOrCreate(
                ['email' => 'user3@asimon-mlm.com'],
                [
                    'name' => 'Demo User 3',
                    'password' => Hash::make('password123'),
                    'phone' => '01733333333',
                    'referral_code' => 'USER1003',
                    'referred_by' => $demoUser1->id,
                    'role' => 'user',
                    'status' => 'active',
                    'wallet_balance' => 100,
                    'total_earned' => 200,
                    'left_count' => 0,
                    'right_count' => 0,
                    'position' => 'left',
                ]
            );
        }
    }
}