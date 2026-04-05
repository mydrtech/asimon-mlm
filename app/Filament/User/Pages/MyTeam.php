<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use App\Models\User;

class MyTeam extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'My Team';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.user.pages.my-team';

    public $teamMembers = [];
    public $totalTeam = 0;
    public $activeTeam = 0;
    public $leftTeamCount = 0;
    public $rightTeamCount = 0;
    public $currentLevel = 1;
    public $maxLevels = 5;

    public function mount(): void
    {
        $user = auth()->user();
        $this->totalTeam = User::where('referred_by', $user->id)->count();
        $this->activeTeam = User::where('referred_by', $user->id)->where('status', 'active')->count();
        $this->leftTeamCount = $user->left_count;
        $this->rightTeamCount = $user->right_count;
        $this->loadTeamMembers();
    }

    public function loadTeamMembers(): void
    {
        $user = auth()->user();
        $this->teamMembers = User::where('referred_by', $user->id)
            ->with('referrals')
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'phone' => $member->phone,
                    'position' => $member->position,
                    'joined_at' => $member->created_at,
                    'status' => $member->status,
                    'total_earned' => $member->total_earned,
                    'downline_count' => $member->referrals()->count(),
                ];
            });
    }

    public function getTitle(): string
    {
        return 'My Team';
    }
}