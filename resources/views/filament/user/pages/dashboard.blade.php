<x-filament::page>
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Wallet Balance</h3>
                <p class="text-3xl font-bold mt-2">₹{{ number_format($walletBalance, 2) }}</p>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Total Earned</h3>
                <p class="text-3xl font-bold mt-2">₹{{ number_format($totalEarned, 2) }}</p>
            </div>
            
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Team Size</h3>
                <p class="text-3xl font-bold mt-2">{{ $teamSize }}</p>
            </div>
        </div>
        
        <!-- Referral Link -->
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Your Referral Link</h3>
            <div class="flex items-center space-x-2">
                <code class="text-sm break-all bg-white dark:bg-gray-900 p-2 rounded flex-1">
                                    {{ $referralLink }}
                </code>
                <button onclick="navigator.clipboard.writeText('{{ $referralLink }}')" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Copy
                </button>
            </div>
        </div>
        
        <!-- User Info -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-2">Welcome, {{ $user->name }}!</h3>
            <p class="text-gray-600">Your Referral Code: <strong>{{ $user->referral_code }}</strong></p>
        </div>
    </div>
</x-filament::page>