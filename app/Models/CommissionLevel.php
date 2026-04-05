<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionLevel extends Model
{
    use HasFactory;

    protected $table = 'commission_levels';

    protected $fillable = [
        'level',
        'percentage',
        'bonus_amount',
        'is_active',
    ];

    protected $casts = [
        'level' => 'integer',
        'percentage' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Get active commission levels
    public static function getActiveLevels()
    {
        return static::where('is_active', true)
            ->orderBy('level')
            ->get();
    }

    // Get commission percentage by level
    public static function getPercentage($level)
    {
        $commission = static::where('level', $level)
            ->where('is_active', true)
            ->first();
            
        return $commission ? $commission->percentage : 0;
    }
}