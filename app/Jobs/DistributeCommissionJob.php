<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Transaction;
use App\Models\MlmSetting;
use App\Models\CommissionLevel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DistributeCommissionJob implements ShouldQueue
{
    use Queueable;

    protected $userId;
    protected $amount;
    protected $type;

    public function __construct($userId, $amount, $type = 'registration')
    {
        $this->userId = $userId;
        $this->amount = $amount;
        $this->type = $type;
    }

    public function handle(): void
    {
        try {
            $user = User::find($this->userId);
            if (!$user) {
                Log::error('User not found for commission distribution', ['user_id' => $this->userId]);
                return;
            }

            $mlmSetting = MlmSetting::getActive();
            if (!$mlmSetting || !$mlmSetting->is_active) {
                Log::warning('MLM system is inactive');
                return;
            }

            $maxLevels = $mlmSetting->max_levels;
            $distributedCount = 0;

            DB::beginTransaction();

            $currentUser = $user;
            $currentLevel = 1;

            while ($currentUser->referred_by && $currentLevel <= $maxLevels) {
                $upliner = User::find($currentUser->referred_by);
                if (!$upliner) break;

                $percentage = CommissionLevel::getPercentage($currentLevel);
                
                if ($percentage > 0) {
                    $commissionAmount = ($this->amount * $percentage) / 100;
                    
                    if ($commissionAmount > 0) {
                        // Add commission to upliner's wallet
                        $upliner->wallet_balance += $commissionAmount;
                        $upliner->total_earned += $commissionAmount;
                        $upliner->save();

                        // Create transaction record
                        Transaction::create([
                            'user_id' => $upliner->id,
                            'from_user_id' => $user->id,
                            'type' => 'commission',
                            'amount' => $commissionAmount,
                            'level' => $currentLevel,
                            'status' => 'completed',
                            'note' => "Level {$currentLevel} commission from {$user->name} for {$this->type}",
                        ]);

                        $distributedCount++;
                    }
                }

                $currentUser = $upliner;
                $currentLevel++;
            }

            DB::commit();

            Log::info('Commission distributed via background job', [
                'user_id' => $user->id,
                'amount' => $this->amount,
                'levels' => $distributedCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Commission job failed', [
                'user_id' => $this->userId,
                'error' => $e->getMessage()
            ]);
        }
    }
}