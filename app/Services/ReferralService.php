<?php

namespace App\Services;

use App\Models\User;
use App\Models\MlmSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralService
{
    protected $mlmSetting;

    public function __construct()
    {
        $this->mlmSetting = MlmSetting::getActive();
    }

    /**
     * Generate unique referral code
     *
     * @param int $length
     * @return string
     */
    public function generateCode(int $length = 8): string
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (User::where('referral_code', $code)->exists());
        
        return $code;
    }

    /**
     * Assign position for binary plan
     *
     * @param User $user
     * @param User $referrer
     * @param string|null $preferredPosition
     * @return bool
     */
    public function assignPosition(User $user, User $referrer, ?string $preferredPosition = null): bool
    {
        if (!$this->mlmSetting || !$this->mlmSetting->isBinary()) {
            // For unilevel or matrix, position doesn't matter
            $user->position = null;
            $user->save();
            return true;
        }

        // For binary plan
        if ($preferredPosition && in_array($preferredPosition, ['left', 'right'])) {
            $position = $preferredPosition;
        } else {
            // Auto assign to the side with fewer users
            $position = $referrer->left_count <= $referrer->right_count ? 'left' : 'right';
        }

        $user->position = $position;
        $user->save();

        // Update referrer's left/right count
        if ($position === 'left') {
            $referrer->increment('left_count');
        } else {
            $referrer->increment('right_count');
        }

        Log::info('Position assigned', [
            'user_id' => $user->id,
            'referrer_id' => $referrer->id,
            'position' => $position
        ]);

        return true;
    }

    /**
     * Register user with referral
     *
     * @param array $userData
     * @param string|null $referralCode
     * @return User|null
     */
    public function registerWithReferral(array $userData, ?string $referralCode = null): ?User
    {
        DB::beginTransaction();
        
        try {
            // Find referrer
            $referrer = null;
            if ($referralCode) {
                $referrer = User::where('referral_code', $referralCode)->first();
            }
            
            // Generate unique referral code for new user
            $userData['referral_code'] = $this->generateCode();
            $userData['referred_by'] = $referrer ? $referrer->id : null;
            $userData['role'] = 'user';
            $userData['status'] = 'active';
            $userData['wallet_balance'] = 0;
            $userData['total_earned'] = 0;
            $userData['left_count'] = 0;
            $userData['right_count'] = 0;
            
            // Create user
            $user = User::create($userData);
            
            // Assign position if has referrer
            if ($referrer) {
                $this->assignPosition($user, $referrer);
            }
            
            DB::commit();
            
            Log::info('User registered with referral', [
                'user_id' => $user->id,
                'referral_code' => $user->referral_code,
                'referred_by' => $referrer ? $referrer->id : null
            ]);
            
            return $user;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Referral registration failed', [
                'error' => $e->getMessage(),
                'user_data' => $userData
            ]);
            
            return null;
        }
    }

    /**
     * Get referral tree for a user
     *
     * @param User $user
     * @param int $depth
     * @return array
     */
    public function getReferralTree(User $user, int $depth = 3): array
    {
        $tree = [
            'user' => $user,
            'children' => []
        ];
        
        if ($depth > 0) {
            foreach ($user->referrals as $child) {
                $tree['children'][] = $this->getReferralTree($child, $depth - 1);
            }
        }
        
        return $tree;
    }

    /**
     * Get downline count by level
     *
     * @param User $user
     * @param int $level
     * @return int
     */
    public function getDownlineCountByLevel(User $user, int $level): int
    {
        if ($level <= 0) {
            return 0;
        }
        
        $count = 0;
        
        foreach ($user->referrals as $referral) {
            if ($level === 1) {
                $count++;
            } else {
                $count += $this->getDownlineCountByLevel($referral, $level - 1);
            }
        }
        
        return $count;
    }

    /**
     * Get total downline count
     *
     * @param User $user
     * @return int
     */
    public function getTotalDownlineCount(User $user): int
    {
        $count = $user->referrals()->count();
        
        foreach ($user->referrals as $referral) {
            $count += $this->getTotalDownlineCount($referral);
        }
        
        return $count;
    }

    /**
     * Validate referral code
     *
     * @param string $code
     * @return bool
     */
    public function validateReferralCode(string $code): bool
    {
        return User::where('referral_code', $code)->exists();
    }

    /**
     * Get referrer by code
     *
     * @param string $code
     * @return User|null
     */
    public function getReferrerByCode(string $code): ?User
    {
        return User::where('referral_code', $code)->first();
    }
}