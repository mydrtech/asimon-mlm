/**
 * Request withdrawal
 *
 * @param User $user
 * @param float $amount
 * @param string $method
 * @param array $accountDetails
 * @return array
 */
public function requestWithdraw(User $user, float $amount, string $method, array $accountDetails): array
{
    // Check minimum withdrawal amount (500 INR)
    $minWithdraw = 500; // ₹500 minimum withdrawal
    
    if ($amount < $minWithdraw) {
        return [
            'success' => false,
            'message' => "Minimum withdrawal amount is ₹{$minWithdraw}"
        ];
    }

    // Check if user has sufficient balance
    if ($user->wallet_balance < $amount) {
        return [
            'success' => false,
            'message' => 'Insufficient wallet balance'
        ];
    }

    DB::beginTransaction();
    
    try {
        // Create withdrawal request
        $withdrawRequest = WithdrawRequest::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'method' => $method,
            'account_details' => $accountDetails,
            'status' => 'pending',
            'admin_note' => null,
            'processed_at' => null,
        ]);

        // Create pending transaction
        Transaction::create([
            'user_id' => $user->id,
            'from_user_id' => null,
            'type' => 'withdrawal',
            'amount' => $amount,
            'level' => null,
            'status' => 'pending',
            'note' => "Withdrawal request #{$withdrawRequest->id} - {$method}"
        ]);

        DB::commit();
        
        Log::info('Withdrawal request created', [
            'user_id' => $user->id,
            'amount' => $amount,
            'method' => $method,
            'request_id' => $withdrawRequest->id
        ]);
        
        return [
            'success' => true,
            'message' => 'Withdrawal request submitted successfully',
            'request_id' => $withdrawRequest->id
        ];
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Withdrawal request failed', [
            'user_id' => $user->id,
            'amount' => $amount,
            'error' => $e->getMessage()
        ]);
        
        return [
            'success' => false,
            'message' => 'Failed to create withdrawal request: ' . $e->getMessage()
        ];
    }
}