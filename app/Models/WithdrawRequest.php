<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use HasFactory;

    protected $table = 'withdraw_requests';

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'account_details',
        'status',
        'admin_note',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'account_details' => 'array',
        'processed_at' => 'datetime',
    ];

    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for pending requests
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Approve withdrawal
    public function approve($adminNote = null)
    {
        $this->status = 'approved';
        $this->admin_note = $adminNote;
        $this->processed_at = now();
        $this->save();
        
        // Create transaction record
        Transaction::createWithdrawal($this->user_id, $this->amount, 'Withdrawal approved');
        
        // Deduct from wallet
        $this->user->deductWalletBalance($this->amount);
        
        return $this;
    }

    // Reject withdrawal
    public function reject($adminNote = null)
    {
        $this->status = 'rejected';
        $this->admin_note = $adminNote;
        $this->processed_at = now();
        $this->save();
        
        return $this;
    }

    // Mark as paid
    public function markAsPaid($adminNote = null)
    {
        $this->status = 'paid';
        $this->admin_note = $adminNote;
        $this->processed_at = now();
        $this->save();
        
        return $this;
    }
}