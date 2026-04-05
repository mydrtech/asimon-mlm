<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static string $view = 'filament.user.pages.dashboard';
    
    public function getTitle(): string
    {
        return 'Dashboard';
    }
    
    protected function getViewData(): array
    {
        $user = auth()->user();
        
        // Simple team count using direct query
        $teamCount = \App\Models\User::where('referred_by', $user->id)->count();
        
        return [
            'user' => $user,
            'walletBalance' => $user->wallet_balance,
            'totalEarned' => $user->total_earned,
            'teamSize' => $teamCount,
            'referralLink' => url('/user/register?ref=' . $user->referral_code),
        ];
    }
}