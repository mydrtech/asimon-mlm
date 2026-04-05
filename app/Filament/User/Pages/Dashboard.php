<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected string $view = 'filament.user.pages.dashboard';
    
    public function getTitle(): string
    {
        return 'Dashboard';
    }
    
    protected function getViewData(): array
    {
        $user = auth()->user();
        
        return [
            'walletBalance' => $user->wallet_balance,
            'totalEarned' => $user->total_earned,
            'teamSize' => $user->referrals()->count(),
            'referralLink' => url('/user/register?ref=' . $user->referral_code),
            'mlmPlan' => optional(\App\Models\MlmSetting::getActive())->plan_type ?? 'unilevel',
            'recentTransactions' => \App\Models\Transaction::where('user_id', $user->id)
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }
}