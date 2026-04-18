<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Models\MlmSetting;
use App\Models\CommissionLevel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommissionService
{
    protected $mlmSetting;
    protected $maxLevels;

    public function __construct()
    {
        $this->mlmSetting = MlmSetting::getActive();
        $this->maxLevels = $this->mlmSetting ? $this->mlmSetting->max_levels : 10;
    }

    /**
     * Distribute commission to upline users
     *
     * @param User $newUser
     * @param float $amount
     * @return array
     */
    public function distribute(User $newUser, float $amount): array
    {
        if (!$this->mlmSetting || !$this->mlmSetting->is_active) {
            Log::warning('MLM system is inactive');
            return ['success' => false, 'message' => 'MLM system is inactive'];
        }

        $distributed = [];
        
        DB::beginTransaction();
        
        try {
            $upline = $newUser->getUpline($this->maxLevels);
            $currentLevel = 1;
            
            foreach ($upline as $upliner) {
                if ($currentLevel > $this->maxLevels) {
                    break;
                }
                
                // Get commission percentage for this level
                $percentage = CommissionLevel::getPercentage($currentLevel);
                
                if ($percentage > 0) {
                    $commissionAmount = ($amount * $percentage) / 100;
                    
                    if ($commissionAmount > 0) {
                        // Add commission to upliner's wallet
                        $upliner->addWalletBalance($commissionAmount, "Level {$currentLevel} commission from {$newUser->name}");
                        
                        // Create transaction record
                        $transaction = Transaction::createCommission(
                            $upliner->id,
                            $newUser->id,
                            $commissionAmount,
                            $currentLevel,
                            "Commission from {$newUser->name} (Level {$currentLevel}) - {$percentage}% of {$amount}"
                        );
                        
                        $distributed[] = [
                            'user_id' => $upliner->id,
                            'user_name' => $upliner->name,
                            'level' => $currentLevel,
                            'percentage' => $percentage,
                            'amount' => $commissionAmount,
                            'transaction_id' => $transaction->id
                        ];
                    }
                }
                
                $currentLevel++;
            }
            
            DB::commit();
            
            Log::info('Commission distributed successfully', [
                'user_id' => $newUser->id,
                'amount' => $amount,
                'distributions' => count($distributed)
            ]);
            
            return [
                'success' => true,
                'message' => 'Commission distributed successfully',
                'distributions' => $distributed,
                'total_distributed' => count($distributed)
            ];
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Commission distribution failed', [
                'user_id' => $newUser->id,
                'amount' => $amount,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Commission distribution failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Distribute binary commission (left/right matching)
     *
     * @param User $user
     * @param float $amount
     * @return array
     */
   

    /**
     * Get commission summary for a user
     *
     * @param User $user
     * @return array
     */
    public function getCommissionSummary(User $user): array
    {
        $totalCommission = Transaction::where('user_id', $user->id)
            ->where('type', 'commission')
            ->where('status', 'completed')
            ->sum('amount');
            
        $levelWiseCommission = Transaction::where('user_id', $user->id)
            ->where('type', 'commission')
            ->where('status', 'completed')
            ->select('level', DB::raw('SUM(amount) as total'))
            ->groupBy('level')
            ->get()
            ->keyBy('level');
            
        return [
            'total_commission' => $totalCommission,
            'level_wise_commission' => $levelWiseCommission,
            'last_commission' => Transaction::where('user_id', $user->id)
                ->where('type', 'commission')
                ->latest()
                ->first()
        ];
    }
}