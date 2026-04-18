<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'pan_number',
        'name',
        'email',
        'password',
        'phone',
        'referral_code',
        'referred_by',
        'role',
        'status',
        'wallet_balance',
        'total_earned',
        'left_count',
        'right_count',
        'position',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'wallet_balance' => 'decimal:2',
        'total_earned' => 'decimal:2',
    ];

    // Referral relationship: who referred this user
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    // Referral relationship: users this user referred
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    // Binary left child
    

    // Transactions relationship
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Withdraw requests relationship
    public function withdrawRequests()
    {
        return $this->hasMany(WithdrawRequest::class);
    }

    // Get all upline users (ancestors)
    public function getUpline($levels = 10)
    {
        $upline = [];
        $currentUser = $this;
        
        for ($i = 0; $i < $levels; $i++) {
            if ($currentUser->referrer) {
                $upline[] = $currentUser->referrer;
                $currentUser = $currentUser->referrer;
            } else {
                break;
            }
        }
        
        return collect($upline);
    }

    // Get downline users by level
    public function getDownlineByLevel($level = 1, $currentLevel = 1)
    {
        if ($currentLevel > $level) {
            return collect();
        }

        $downline = collect();
        
        foreach ($this->referrals as $referral) {
            $downline->push($referral);
            if ($currentLevel < $level) {
                $downline = $downline->merge($referral->getDownlineByLevel($level, $currentLevel + 1));
            }
        }
        
        return $downline;
    }

    // Get team size
    public function getTeamSizeAttribute(): int
{
    return $this->getTotalTeamCount();
}

private function getTotalTeamCount(int $depth = 0): int
{
    if ($depth > 10) return 0;
    $count = $this->referrals()->count();
    foreach ($this->referrals as $child) {
        $count += $child->getTotalTeamCount($depth + 1);
    }
    return $count;
}

    // Add wallet balance
    public function addWalletBalance($amount, $note = null)
    {
        $this->wallet_balance += $amount;
        $this->total_earned += $amount;
        $this->save();
        
        return $this;
    }

    // Deduct wallet balance
    public function deductWalletBalance($amount, $note = null)
    {
        if ($this->wallet_balance >= $amount) {
            $this->wallet_balance -= $amount;
            $this->save();
            return true;
        }
        
        return false;
    }
}