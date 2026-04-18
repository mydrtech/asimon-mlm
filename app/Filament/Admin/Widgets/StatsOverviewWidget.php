<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use App\Models\Transaction;
use App\Models\WithdrawRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getColumns(): int { return 3; }

    protected function getStats(): array
    {
        $totalUsers       = User::where('role', 'user')->count();
        $activeUsers      = User::where('role', 'user')->where('status', 'active')->count();
        $todayUsers       = User::where('role', 'user')->whereDate('created_at', today())->count();
        $totalCommission  = Transaction::where('type', 'commission')->where('status', 'completed')->sum('amount');
        $pendingWithdraw  = WithdrawRequest::where('status', 'pending')->sum('amount');
        $pendingCount     = WithdrawRequest::where('status', 'pending')->count();
        $paidWithdraw     = WithdrawRequest::where('status', 'paid')->sum('amount');
        $totalRevenue     = Transaction::where('type', 'deposit')->where('status', 'completed')->sum('amount');
        $thisMonthUsers   = User::where('role', 'user')->whereMonth('created_at', now()->month)->count();
        $suspendedUsers   = User::where('status', 'suspended')->count();

        return [
            Stat::make('🌻 Total Members', number_format($totalUsers))
                ->description("Active: {$activeUsers} | Suspended: {$suspendedUsers}")
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([
                    User::where('role','user')->whereDate('created_at', now()->subDays(6))->count(),
                    User::where('role','user')->whereDate('created_at', now()->subDays(5))->count(),
                    User::where('role','user')->whereDate('created_at', now()->subDays(4))->count(),
                    User::where('role','user')->whereDate('created_at', now()->subDays(3))->count(),
                    User::where('role','user')->whereDate('created_at', now()->subDays(2))->count(),
                    User::where('role','user')->whereDate('created_at', now()->subDays(1))->count(),
                    $todayUsers,
                ]),

            Stat::make('💰 Total Commission Paid', '₹ ' . number_format($totalCommission, 2))
                ->description("This month: {$thisMonthUsers} new members")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),

            Stat::make('⏳ Pending Withdrawals', '₹ ' . number_format($pendingWithdraw, 2))
                ->description("{$pendingCount} requests waiting approval")
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingCount > 0 ? 'danger' : 'success'),

            Stat::make('📅 Today Registrations', $todayUsers)
                ->description('New members joined today')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),

            Stat::make('✅ Total Withdrawn', '₹ ' . number_format($paidWithdraw, 2))
                ->description('Successfully paid out')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('📊 This Month Members', $thisMonthUsers)
                ->description('Registered in ' . now()->format('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),
        ];
    }
}