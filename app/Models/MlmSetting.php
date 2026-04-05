<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MlmSetting extends Model
{
    use HasFactory;

    protected $table = 'mlm_settings';

    protected $fillable = [
        'plan_type',
        'max_levels',
        'binary_limit',
        'matrix_width',
        'matrix_depth',
        'registration_fee',
        'currency',
        'is_active',
    ];

    protected $casts = [
        'max_levels' => 'integer',
        'binary_limit' => 'integer',
        'matrix_width' => 'integer',
        'matrix_depth' => 'integer',
        'registration_fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Get active settings
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    // Check if binary plan
    public function isBinary()
    {
        return $this->plan_type === 'binary';
    }

    // Check if unilevel plan
    public function isUnilevel()
    {
        return $this->plan_type === 'unilevel';
    }

    // Check if matrix plan
    public function isMatrix()
    {
        return $this->plan_type === 'matrix';
    }
}