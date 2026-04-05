<x-filament::page>
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Wallet Balance</h3>
                        <<p class="text-3xl font-bold mt-2">₹{{ number_format($walletBalance, 2) }}</p>
                    </div>
                    <div class="text-4xl opacity-50">💰</div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Total Earned</h3>
                        <p class="text-3xl font-bold mt-2">₹{{ number_format($totalEarned, 2) }}</p>
                    </div>
                    <div class="text-4xl opacity-50">📈</div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Team Size</h3>
                        <p class="text-3xl font-bold mt-2">{{ $teamSize }}</p>
                    </div>
                    <div class="text-4xl opacity-50">👥</div>
                </div>
            </div>
        </div>
        
        <!-- MLM Plan Info -->
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Active MLM Plan</h3>
                    <p class="text-xl font-semibold capitalize">{{ $mlmPlan }}</p>
                </div>
                <div class="text-2xl">
                    @if($mlmPlan == 'unilevel') 📊
                    @elseif($mlmPlan == 'binary') 🌳
                    @elseif($mlmPlan == 'matrix') 🔢
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Referral Link -->
        <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Your Referral Link</h3>
            <div class="flex items-center space-x-2">
                <code class="text-sm break-all bg-white dark:bg-gray-900 p-2 rounded flex-1">
                    {{ $referralLink }}
                </code>
                <button onclick="copyToClipboard('{{ $referralLink }}')" 
                        class="bg-primary-500 text-white px-4 py-2 rounded hover:bg-primary-600">
                    Copy
                </button>
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-semibold">Recent Transactions</h3>
            </div>
            <div class="p-4">
                @if($recentTransactions->count() > 0)
                    <div class="space-y-2">
                        @foreach($recentTransactions as $transaction)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded">
                                <div>
                                    <p class="font-medium">
                                        {{ ucfirst($transaction->type) }}
                                        @if($transaction->level)
                                            <span class="text-sm text-gray-500">(Level {{ $transaction->level }})</span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $transaction->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold {{ $transaction->type == 'withdrawal' ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $transaction->type == 'withdrawal' ? '-' : '+' }}{{ number_format($transaction->amount, 2) }} BDT
                                    </p>
                                    <p class="text-xs text-gray-500 capitalize">{{ $transaction->status }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No transactions yet.</p>
                @endif
            </div>
        </div>
    </div>
    
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            alert('Referral link copied to clipboard!');
        }
    </script>
</x-filament::page>