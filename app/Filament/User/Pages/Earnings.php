<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class Earnings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-rupee';
    protected static ?string $navigationLabel = 'Earnings';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.user.pages.earnings';

    public $totalCommission = 0;
    public $totalWithdrawn = 0;
    public $availableBalance = 0;
    public $levelWiseCommission = [];
    public $recentTransactions = [];
    public $filterType = 'all';
    public $filterDate = 'all';

    public function mount(): void
    {
        $this->loadStats();
        $this->loadTransactions();
    }

    public function loadStats(): void
    {
        $user = auth()->user();
        
        // Total commission earned
        $this->totalCommission = Transaction::where('user_id', $user->id)
            ->where('type', 'commission')
            ->where('status', 'completed')
            ->sum('amount');
        
        // Total withdrawn
        $this->totalWithdrawn = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->where('status', 'completed')
            ->sum('amount');
        
        // Available balance
        $this->availableBalance = $user->wallet_balance;
        
        // Level wise commission
        $this->levelWiseCommission = Transaction::where('user_id', $user->id)
            ->where('type', 'commission')
            ->where('status', 'completed')
            ->select('level', DB::raw('SUM(amount) as total'))
            ->groupBy('level')
            ->orderBy('level')
            ->get()
            ->toArray();
    }

    public function loadTransactions(): void
    {
        $user = auth()->user();
        $query = Transaction::where('user_id', $user->id);
        
        // Apply type filter
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }
        
        // Apply date filter
        if ($this->filterDate === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($this->filterDate === 'week') {
            $query->whereBetween('created_at', [now()->subDays(7), now()]);
        } elseif ($this->filterDate === 'month') {
            $query->whereBetween('created_at', [now()->subDays(30), now()]);
        }
        
        $this->recentTransactions = $query->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->toArray();
    }

    public function updatedFilterType(): void
    {
        $this->loadTransactions();
    }

    public function updatedFilterDate(): void
    {
        $this->loadTransactions();
    }

    public function getTitle(): string
    {
        return 'My Earnings';
    }
}