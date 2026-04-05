<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.user.pages.dashboard';

    public $walletBalance;
    public $totalEarned;
    public $teamSize;
    public $referralLink;
    public $mlmPlan;
    public $recentTransactions;

    public function mount(): void
    {
        $user = auth()->user();
        $this->walletBalance = $user->wallet_balance;
        $this->totalEarned = $user->total_earned;
        $this->teamSize = $user->referrals()->count();
        $this->referralLink = url('/user/register?ref=' . $user->referral_code);
        
        $mlmSetting = \App\Models\MlmSetting::getActive();
        $this->mlmPlan = $mlmSetting ? $mlmSetting->plan_type : 'unilevel';
        
        $this->recentTransactions = \App\Models\Transaction::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();
    }

    public function getTitle(): string
    {
        return 'User Dashboard';
    }
}