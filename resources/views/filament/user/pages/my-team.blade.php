<x-filament::page>
    <div class="space-y-6">
        <!-- Team Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-semibold">Total Team Members</h3>
                <p class="text-2xl font-bold mt-1">{{ $totalTeam }}</p>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-semibold">Active Members</h3>
                <p class="text-2xl font-bold mt-1">{{ $activeTeam }}</p>
            </div>
            
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-semibold">Left Team</h3>
                <p class="text-2xl font-bold mt-1">{{ $leftTeamCount }}</p>
            </div>
            
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-semibold">Right Team</h3>
                <p class="text-2xl font-bold mt-1">{{ $rightTeamCount }}</p>
            </div>
        </div>

        <!-- Team Members Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-semibold">Direct Team Members</h3>
            </div>
            
            <div class="overflow-x-auto">
                @if(count($teamMembers) > 0)
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email/Phone</th>
                                <th class="px-4 py-3">Position</th>
                                <th class="px-4 py-3">Joined Date</th>
                                <th class="px-4 py-3">Downline</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teamMembers as $index => $member)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 font-medium">{{ $member['name'] }}</td>
                                    <td class="px-4 py-2">
                                        <div>{{ $member['email'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $member['phone'] }}</div>
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($member['position'] == 'left')
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Left</span>
                                        @elseif($member['position'] == 'right')
                                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">Right</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ $member['joined_at']->format('d M Y') }}</td>
                                    <td class="px-4 py-2">{{ $member['downline_count'] }}</td>
                                    <td class="px-4 py-2">
                                        @if($member['status'] == 'active')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Active</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">₹{{ number_format($member['total_earned'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-5xl mb-3">👥</div>
                        <p class="text-gray-500">No team members yet.</p>
                        <p class="text-gray-400 text-sm mt-2">Share your referral link to build your team.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Referral Link Box -->
        <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg">
            <h3 class="text-md font-semibold mb-2">Invite More Members</h3>
            <div class="flex items-center space-x-2">
                <code class="text-sm break-all bg-white dark:bg-gray-900 p-2 rounded flex-1">
                    {{ url('/user/register?ref=' . auth()->user()->referral_code) }}
                </code>
                <button onclick="copyToClipboard('{{ url('/user/register?ref=' . auth()->user()->referral_code) }}')" 
                        class="bg-primary-500 text-white px-4 py-2 rounded hover:bg-primary-600 text-sm">
                    Copy Link
                </button>
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