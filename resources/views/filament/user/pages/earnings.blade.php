<x-filament::page>
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold opacity-90">Total Commission</h3>
                        <p class="text-2xl font-bold mt-1">₹{{ number_format($totalCommission, 2) }}</p>
                    </div>
                    <div class="text-3xl opacity-50">💰</div>
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
            
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold opacity-90">Available Balance</h3>
                        <p class="text-2xl font-bold mt-1">₹{{ number_format($availableBalance, 2) }}</p>
                    </div>
                    <div class="text-3xl opacity-50">💳</div>
                </div>
            </div>
        </div>

        <!-- Level Wise Commission Chart -->
        @if(count($levelWiseCommission) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-4">Level Wise Commission</h3>
            <div class="space-y-3">
                @foreach($levelWiseCommission as $level)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Level {{ $level['level'] }}</span>
                        <span>₹{{ number_format($level['total'], 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($level['total'] / max(array_column($levelWiseCommission, 'total'))) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Transaction Type</label>
                    <select wire:model.live="filterType" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        <option value="all">All Transactions</option>
                        <option value="commission">Commission Only</option>
                        <option value="withdrawal">Withdrawal Only</option>
                        <option value="deposit">Deposit Only</option>
                    </select>
                </div>
                
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Date Range</label>
                    <select wire:model.live="filterDate" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        <option value="all">All Time</option>
                        <option value="today">Today</option>
                        <option value="week">Last 7 Days</option>
                        <option value="month">Last 30 Days</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-semibold">Transaction History</h3>
            </div>
            
            <div class="overflow-x-auto">
                @if(count($recentTransactions) > 0)
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Level</th>
                                <th class="px-4 py-3">Amount</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaction)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($transaction['created_at'])->format('d M Y, h:i A') }}</td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex items-center">
                                        @if($transaction['type'] == 'commission')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Commission</span>
                                        @elseif($transaction['type'] == 'withdrawal')
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Withdrawal</span>
                                        @elseif($transaction['type'] == 'deposit')
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Deposit</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">{{ ucfirst($transaction['type']) }}</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $transaction['level'] ?? '-' }}</td>
                                <td class="px-4 py-2 font-semibold {{ $transaction['type'] == 'withdrawal' ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $transaction['type'] == 'withdrawal' ? '-' : '+' }}₹{{ number_format($transaction['amount'], 2) }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex items-center">
                                        @if($transaction['status'] == 'completed')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">✓ Completed</span>
                                        @elseif($transaction['status'] == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">⏳ Pending</span>
                                        @elseif($transaction['status'] == 'failed')
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">✗ Failed</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">{{ ucfirst($transaction['status']) }}</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $transaction['note'] ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-5xl mb-3">📊</div>
                        <p class="text-gray-500">No transactions found.</p>
                        <p class="text-gray-400 text-sm mt-2">Your earnings will appear here when you get commissions.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament::page>