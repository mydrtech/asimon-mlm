<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_user_id',
        'type',
        'amount',
        'level',
        'status',
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'level' => 'integer',
    ];

    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // From user relationship (who gave commission)
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    // Scope for completed transactions
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Scope for commissions only
    public function scopeCommission($query)
    {
        return $query->where('type', 'commission');
    }

    // Create commission transaction
    public static function createCommission($userId, $fromUserId, $amount, $level, $note = null)
    {
        return static::create([
            'user_id' => $userId,
            'from_user_id' => $fromUserId,
            'type' => 'commission',
            'amount' => $amount,
            'level' => $level,
            'status' => 'completed',
            'note' => $note,
        ]);
    }

    // Create withdrawal transaction
    public static function createWithdrawal($userId, $amount, $note = null)
    {
        return static::create([
            'user_id' => $userId,
            'type' => 'withdrawal',
            'amount' => $amount,
            'status' => 'completed',
            'note' => $note,
        ]);
    }
}