<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use App\Models\Transaction;
use App\Models\WithdrawRequest;
use App\Models\MlmSetting;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class Wallet extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $navigationLabel = 'Wallet';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.user.pages.wallet';

    public $balance = 0;
    public $totalEarned = 0;
    public $totalWithdrawn = 0;
    public $pendingWithdraw = 0;
    public $withdrawAmount = '';
    public $withdrawMethod = 'bank';
    public $accountDetails = [];
    public $recentTransactions = [];
    public $withdrawHistory = [];
    public $currency = 'INR';
    public $minWithdraw = 500;

    public function mount(): void
    {
        $this->loadWalletData();
        $this->loadRecentTransactions();
        $this->loadWithdrawHistory();
        
        $setting = MlmSetting::getActive();
        $this->currency = $setting ? $setting->currency : 'INR';
    }

    public function loadWalletData(): void
    {
        $user = auth()->user();
        $this->balance = $user->wallet_balance;
        $this->totalEarned = $user->total_earned;
        
        $this->totalWithdrawn = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->where('status', 'completed')
            ->sum('amount');
            
        $this->pendingWithdraw = WithdrawRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');
    }

    public function loadRecentTransactions(): void
    {
        $user = auth()->user();
        $this->recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function loadWithdrawHistory(): void
    {
        $user = auth()->user();
        $this->withdrawHistory = WithdrawRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updatedWithdrawMethod($value): void
    {
        $this->accountDetails = [];
    }

    public function submitWithdrawRequest(): void
    {
        $this->validate([
            'withdrawAmount' => 'required|numeric|min:' . $this->minWithdraw,
            'withdrawMethod' => 'required|in:bank,upi,paytm,phonepe,googlepay',
        ]);

        $user = auth()->user();

        if ($user->wallet_balance < $this->withdrawAmount) {
            Notification::make()
                ->title('Insufficient Balance')
                ->body('Your wallet balance is less than the withdrawal amount.')
                ->danger()
                ->send();
            return;
        }

        // Validate account details based on method
        if ($this->withdrawMethod === 'bank') {
            $this->validate([
                'accountDetails.account_number' => 'required|string',
                'accountDetails.ifsc_code' => 'required|string',
                'accountDetails.account_holder_name' => 'required|string',
            ]);
        } elseif (in_array($this->withdrawMethod, ['upi', 'paytm', 'phonepe', 'googlepay'])) {
            $this->validate([
                'accountDetails.upi_id' => 'required|string',
            ]);
        }

        DB::beginTransaction();

        try {
            // Create withdrawal request
            $withdrawRequest = WithdrawRequest::create([
                'user_id' => $user->id,
                'amount' => $this->withdrawAmount,
                'method' => $this->withdrawMethod,
                'account_details' => $this->accountDetails,
                'status' => 'pending',
            ]);

            // Create pending transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $this->withdrawAmount,
                'status' => 'pending',
                'note' => "Withdrawal request #{$withdrawRequest->id} via " . strtoupper($this->withdrawMethod),
            ]);

            DB::commit();

            Notification::make()
                ->title('Withdrawal Request Submitted')
                ->body("Your withdrawal request of ₹" . number_format($this->withdrawAmount, 2) . " has been submitted. Admin will review it soon.")
                ->success()
                ->send();

            // Reset form
            $this->withdrawAmount = '';
            $this->accountDetails = [];
            
            // Reload data
            $this->loadWalletData();
            $this->loadRecentTransactions();
            $this->loadWithdrawHistory();

        } catch (\Exception $e) {
            DB::rollBack();
            Notification::make()
                ->title('Withdrawal Failed')
                ->body('Something went wrong. Please try again later.')
                ->danger()
                ->send();
        }
    }

    public function getTitle(): string
    {
        return 'My Wallet';
    }
}