<x-filament::page>
    <div class="space-y-6">
        <!-- Balance Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold opacity-90">Current Balance</h3>
                        <p class="text-2xl font-bold mt-1">₹{{ number_format($balance, 2) }}</p>
                    </div>
                    <div class="text-3xl opacity-50">💰</div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold opacity-90">Total Earned</h3>
                        <p class="text-2xl font-bold mt-1">₹{{ number_format($totalEarned, 2) }}</p>
                    </div>
                    <div class="text-3xl opacity-50">📈</div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold opacity-90">Total Withdrawn</h3>
                        <p class="text-2xl font-bold mt-1">₹{{ number_format($totalWithdrawn, 2) }}</p>
                    </div>
                    <div class="text-3xl opacity-50">💸</div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold opacity-90">Pending Withdraw</h3>
                        <p class="text-2xl font-bold mt-1">₹{{ number_format($pendingWithdraw, 2) }}</p>
                    </div>
                    <div class="text-3xl opacity-50">⏳</div>
                </div>
            </div>
        </div>

        <!-- Withdraw Request Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Request Withdrawal</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Amount (Min: ₹{{ number_format($minWithdraw, 2) }})</label>
                    <input type="number" wire:model="withdrawAmount" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                           placeholder="Enter amount in INR">
                    @error('withdrawAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1">Payment Method</label>
                    <select wire:model.live="withdrawMethod" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        <option value="bank">Bank Transfer</option>
                        <option value="upi">UPI (Google Pay, PhonePe, Paytm)</option>
                        <option value="paytm">Paytm Wallet</option>
                        <option value="phonepe">PhonePe</option>
                        <option value="googlepay">Google Pay</option>
                    </select>
                </div>
            </div>

            <!-- Bank Details Form -->
            @if($withdrawMethod == 'bank')
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Account Holder Name</label>
                    <input type="text" wire:model="accountDetails.account_holder_name" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                           placeholder="Full name as per bank">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Account Number</label>
                    <input type="text" wire:model="accountDetails.account_number" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                           placeholder="Bank account number">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">IFSC Code</label>
                    <input type="text" wire:model="accountDetails.ifsc_code" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                           placeholder="IFSC code">
                </div>
            </div>
            @endif

            <!-- UPI Details Form -->
            @if(in_array($withdrawMethod, ['upi', 'paytm', 'phonepe', 'googlepay']))
            <div class="mt-4">
                <label class="block text-sm font-medium mb-1">UPI ID / Mobile Number</label>
                <input type="text" wire:model="accountDetails.upi_id" 
                       class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                       placeholder="example@upi or 9876543210">
            </div>
            @endif

            <div class="mt-6">
                <button wire:click="submitWithdrawRequest" 
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    Submit Withdrawal Request
                </button>
            </div>
            
            <div class="mt-4 text-sm text-gray-500">
                <p>⚠️ Withdrawals are processed within 24-48 hours after admin approval.</p>
                <p>💡 Minimum withdrawal amount: ₹{{ number_format($minWithdraw, 2) }}</p>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-semibold">Recent Transactions</h3>
            </div>
            <div class="overflow-x-auto">
                @if(count($recentTransactions) > 0)
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Amount</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaction)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-2">{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
                                <td class="px-4 py-2 capitalize">{{ $transaction->type }}</td>
                                <td class="px-4 py-2 {{ $transaction->type == 'withdrawal' ? 'text-red-600' : 'text-green-600' }} font-semibold">
                                    {{ $transaction->type == 'withdrawal' ? '-' : '+' }}₹{{ number_format($transaction->amount, 2) }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-xs {{ $transaction->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $transaction->note ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-8 text-gray-500">No transactions yet.</div>
                @endif
            </div>
        </div>

        <!-- Withdrawal History -->
        @if(count($withdrawHistory) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-semibold">Withdrawal History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3">Request Date</th>
                            <th class="px-4 py-3">Amount</th>
                            <th class="px-4 py-3">Method</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Processed Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawHistory as $withdraw)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-2">{{ $withdraw->created_at->format('d M Y, h:i A') }}</td>
                            <td class="px-4 py-2 font-semibold">₹{{ number_format($withdraw->amount, 2) }}</td>
                            <td class="px-4 py-2 uppercase">{{ $withdraw->method }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs 
                                    {{ $withdraw->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($withdraw->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($withdraw->status == 'paid' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst($withdraw->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $withdraw->processed_at ? $withdraw->processed_at->format('d M Y') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</x-filament::page>