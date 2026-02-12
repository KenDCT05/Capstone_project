<x-app-layout>
    <div class="py-8 min-h-screen bg-gradient-to-br from-rose-50 via-red-50 to-pink-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header Section -->
            <div class="bg-white rounded-3xl shadow-2xl border border-red-100 mb-8 overflow-hidden transform hover:scale-[1.01] transition-all duration-300">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-8 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></div>
                    <h1 class="text-4xl font-black text-white flex items-center relative z-10">
                        <svg class="w-10 h-10 mr-4 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        SMS & Email Communication Logs
                    </h1>
                    <p class="text-red-100 mt-3 text-lg font-medium relative z-10">Track all parent/guardian communications in real-time</p>
                </div>
                <div class="px-8 py-6 flex flex-wrap items-center justify-between gap-4 bg-gradient-to-r from-gray-50 to-red-50">
                    <a href="{{ route('analytics.risk-alerts') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-bold rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 group">
                        <svg class="w-5 h-5 mr-3 transform group-hover:-translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>  
                        <span class="font-extrabold tracking-wide">Back to Risk Alerts</span>
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total SMS Sent -->
                <div class="bg-gradient-to-br from-emerald-600 via-green-600 to-teal-700 text-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 hover:scale-105 transition-all duration-300 border-2 border-white/20 backdrop-blur-sm">
                    <div class="text-5xl mb-3 animate-bounce-slow">📱</div>
                    <p class="text-green-100 text-xs font-bold uppercase tracking-widest mb-2">Total SMS Sent</p>
                    <p class="text-5xl font-black mt-2 mb-3">{{ $smsLogs->count() }}</p>
                    <div class="h-1.5 bg-green-300 rounded-full my-3 shadow-inner"></div>
                    <p class="text-green-100 text-sm font-medium">Last 30 days</p>
                </div>

                <!-- Total Emails Sent -->
                <div class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 text-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 hover:scale-105 transition-all duration-300 border-2 border-white/20 backdrop-blur-sm">
                    <div class="text-5xl mb-3 animate-bounce-slow">📧</div>
                    <p class="text-blue-100 text-xs font-bold uppercase tracking-widest mb-2">Total Emails Sent</p>
                    <p class="text-5xl font-black mt-2 mb-3">{{ $emailLogs->count() }}</p>
                    <div class="h-1.5 bg-blue-300 rounded-full my-3 shadow-inner"></div>
                    <p class="text-blue-100 text-sm font-medium">Last 30 days</p>
                </div>

                <!-- Critical Alerts -->
                <div class="bg-gradient-to-br from-red-600 via-red-700 to-rose-700 text-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 hover:scale-105 transition-all duration-300 border-2 border-white/20 backdrop-blur-sm animate-pulse-slow">
                    <div class="text-5xl mb-3">🚨</div>
                    <p class="text-red-100 text-xs font-bold uppercase tracking-widest mb-2">Critical Alerts</p>
                    <p class="text-5xl font-black mt-2 mb-3">{{ $criticalCount }}</p>
                    <div class="h-1.5 bg-red-300 rounded-full my-3 shadow-inner"></div>
                    <p class="text-red-100 text-sm font-medium">Urgent communications</p>
                </div>

                <!-- Failed Alerts -->
                <div class="bg-gradient-to-br from-red-800 via-red-900 to-rose-900 text-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transform hover:-translate-y-3 hover:scale-105 transition-all duration-300 border-2 border-white/20 backdrop-blur-sm">
                    <div class="text-5xl mb-3 animate-shake">⚠️</div>
                    <p class="text-red-100 text-xs font-bold uppercase tracking-widest mb-2">Failed Alerts</p>
                    <p class="text-5xl font-black mt-2 mb-3">
                        {{ $combinedLogs->where('status', 'failed')->count() }}
                    </p>
                    <div class="h-1.5 bg-red-300 rounded-full my-3 shadow-inner"></div>
                    <p class="text-red-100 text-sm font-medium">Delivery issues</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow-2xl rounded-3xl p-8 border-2 border-red-100 backdrop-blur-sm">
                <h3 class="text-2xl font-black text-gray-800 mb-6 flex items-center">
                    <span class="text-3xl mr-3">🔍</span>
                    <span class="bg-gradient-to-r from-red-600 to-rose-700 bg-clip-text text-transparent">Filter Communication Logs</span>
                </h3>
                
                <form method="GET" action="{{ route('analytics.communication-logs') }}" class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
                    <!-- Type Filter -->
                    <div class="transform hover:scale-105 transition-transform duration-200">
                        <label class="block text-sm font-black text-gray-700 mb-3 uppercase tracking-wide">Communication Type</label>
                        <select name="type" class="w-full border-2 border-red-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-red-200 focus:border-red-500 transition-all duration-300 bg-white shadow-lg font-semibold text-gray-700 hover:border-red-400">
                            <option value="">All Types</option>
                            <option value="sms" {{ request('type') == 'sms' ? 'selected' : '' }}>📱 SMS Only</option>
                            <option value="email" {{ request('type') == 'email' ? 'selected' : '' }}>📧 Email Only</option>
                        </select>
                    </div>

                    <!-- Student Filter -->
                    <div class="transform hover:scale-105 transition-transform duration-200">
                        <label class="block text-sm font-black text-gray-700 mb-3 uppercase tracking-wide">Student</label>
                        <select name="student_id" class="w-full border-2 border-red-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-red-200 focus:border-red-500 transition-all duration-300 bg-white shadow-lg font-semibold text-gray-700 hover:border-red-400">
                            <option value="">All Students</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 md:col-span-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-black rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 uppercase tracking-wide">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Apply Filters
                        </button>
                        <a href="{{ route('analytics.communication-logs') }}" 
                           class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 uppercase tracking-wide">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Combined Communication Logs -->
            <div class="bg-white rounded-3xl shadow-2xl border-2 border-red-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6">
                    <h2 class="text-3xl font-black text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                        </svg>
                        Communication History
                    </h2>
                    <p class="text-red-100 mt-2 text-lg font-medium">All SMS and email communications to parents/guardians</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gradient-to-r from-gray-100 to-red-50 border-b-4 border-red-200">
                            <tr>
                                <th class="px-4 py-4 text-left font-black uppercase tracking-wider text-gray-800 text-xs">Type</th>
                                <th class="px-4 py-4 text-left font-black uppercase tracking-wider text-gray-800 text-xs">Status</th>
                                <th class="px-4 py-4 text-left font-black uppercase tracking-wider text-gray-800 text-xs">Student</th>
                                <th class="px-4 py-4 text-left font-black uppercase tracking-wider text-gray-800 text-xs">Contact Info</th>
                                <th class="px-4 py-4 text-left font-black uppercase tracking-wider text-gray-800 text-xs">Sent At</th>
                                <th class="px-4 py-4 text-left font-black uppercase tracking-wider text-gray-800 text-xs">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-gray-100 bg-white">
                            @forelse($combinedLogs as $log)
                                <tr class="hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-all duration-300 border-l-4 border-transparent hover:border-red-500">
                                    <!-- Type -->
                                    <td class="px-4 py-4">
                                        @if($log['type'] === 'sms')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-black bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-300 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
                                                </svg>
                                                SMS
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-black bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-2 border-blue-300 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                                </svg>
                                                EMAIL
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="px-4 py-4">
                                        <div class="space-y-2">
                                            @if(isset($log['status']))
                                                @if($log['status'] === 'sent')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-black bg-green-100 text-green-800 border-2 border-green-300 shadow-sm">
                                                        ✓ DELIVERED
                                                    </span>
                                                @elseif($log['status'] === 'failed')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-black bg-red-100 text-red-800 border-2 border-red-300 animate-pulse shadow-sm">
                                                        ✗ FAILED
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-black bg-yellow-100 text-yellow-800 border-2 border-yellow-300 shadow-sm">
                                                        ⏳ PENDING
                                                    </span>
                                                @endif
                                            @endif
                                            
                                            @if(isset($log['error_message']) && $log['error_message'])
                                                <div class="text-xs font-bold text-red-700 bg-red-100 px-2 py-1 rounded-lg border-2 border-red-200 shadow-sm" 
                                                     title="{{ $log['error_message'] }}">
                                                    ⚠️ {{ Str::limit($log['error_message'], 30) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Student -->
                                    <td class="px-4 py-4">
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $log['student_name'] }}</div>
                                            <div class="text-xs font-medium text-gray-500">ID: {{ $log['student_id'] }}</div>
                                        </div>
                                    </td>

                                    <!-- Contact Info -->
                                    <td class="px-4 py-4">
                                        <div class="text-xs">
                                            @if($log['type'] === 'sms')
                                                <div class="text-gray-900 font-bold">{{ $log['contact'] }}</div>
                                                <div class="text-xs text-gray-500 flex items-center mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                                    </svg>
                                                    Phone
                                                </div>
                                            @else
                                                <div class="text-gray-900 font-bold break-all text-xs">{{ Str::limit($log['contact'], 25) }}</div>
                                                <div class="text-xs text-gray-500 flex items-center mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                                    </svg>
                                                    Email
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Risk Details -->
                                    
                                    <!-- Sent At -->
                                    <td class="px-4 py-4">
                                        <div class="text-xs text-gray-900 font-bold">{{ $log['sent_at']->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $log['sent_at']->format('h:i A') }}</div>
                                        <div class="text-xs text-gray-400">{{ $log['sent_at']->diffForHumans() }}</div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-4 py-4">
                                        <div class="flex flex-col space-y-2">
                                            <button onclick="showLogDetails({{ json_encode($log) }})" 
                                                    class="inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-black rounded-lg hover:from-blue-700 hover:to-indigo-800 transition-all duration-300 shadow-md hover:shadow-lg text-xs transform hover:-translate-y-1">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                VIEW
                                            </button>
                                            
                                            @if($log['type'] === 'email')
                                                <button onclick="viewEmailDetails({{ $log['id'] }})" 
                                                        class="inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-purple-600 to-pink-700 text-white font-black rounded-lg hover:from-purple-700 hover:to-pink-800 transition-all duration-300 shadow-md hover:shadow-lg text-xs transform hover:-translate-y-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                                    </svg>
                                                    EMAIL
                                                </button>
                                            @endif
                                            
                                            @if(isset($log['status']) && $log['status'] === 'failed')
                                                @if($log['type'] === 'sms')
                                                    <button onclick="retrySms({{ $log['id'] }})" 
                                                            id="retry-sms-{{ $log['id'] }}"
                                                            class="inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-black rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-xs transform hover:-translate-y-1 animate-pulse">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                        RETRY
                                                    </button>
                                                @else
                                                    <button onclick="retryEmail({{ $log['id'] }})" 
                                                            id="retry-email-{{ $log['id'] }}"
                                                            class="inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-black rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-xs transform hover:-translate-y-1 animate-pulse">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                        RETRY
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="text-8xl mb-6 animate-bounce">📭</div>
                                            <div class="text-3xl font-black text-gray-700 mb-3">No Communications Found</div>
                                            <div class="text-lg font-medium text-gray-500">No SMS or email alerts have been sent yet</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                 @if($combinedLogs->count() > 0)
                    <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-red-50 border-t-2 border-red-100">
                        <div class="flex items-center justify-between">
                            <div class="text-base font-bold text-gray-700 bg-white px-4 py-2 rounded-xl shadow-md border border-gray-200">
                                Showing <span class="text-red-600 font-black">{{ $combinedLogs->count() }}</span> of <span class="text-red-600 font-black">{{ $totalCount }}</span> communications
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Log Details Modal -->
    <div id="logDetailsModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4 animate-fade-in">
        <div class="bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto border-4 border-red-200 transform transition-all duration-300 scale-95 hover:scale-100">
            <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6 rounded-t-3xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></div>
                <div class="flex items-center justify-between relative z-10">
                    <h3 class="text-2xl font-black text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 3h-2v10h2V3zm4.83 2.17l-1.42 1.42C17.99 7.86 19 9.81 19 12c0 3.87-3.13 7-7 7s-7-3.13-7-7c0-2.19 1.01-4.14 2.58-5.42L6.17 5.17C4.23 6.82 3 9.26 3 12c0 4.97 4.03 9 9 9s9-4.03 9-9c0-2.74-1.23-5.18-3.17-6.83z"/>
                        </svg>
                        Communication Details
                    </h3>
                    <button onclick="closeLogDetailsModal()" class="text-white hover:text-red-200 text-3xl font-black transition-colors duration-200 hover:rotate-90 transform transition-transform">&times;</button>
                </div>
            </div>
            <div class="p-8">
                <div id="logDetailsContent" class="space-y-6">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="mt-8 flex gap-4 justify-end">
                    <button onclick="closeLogDetailsModal()" 
                            class="px-8 py-4 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-2xl font-black uppercase tracking-wide shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .animate-shimmer {
            animation: shimmer 3s infinite;
        }
        
        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }
        
        .animate-pulse-slow {
            animation: pulse-slow 2s infinite;
        }
        
        .animate-shake {
            animation: shake 0.5s infinite;
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        function showLogDetails(log) {
            const modal = document.getElementById('logDetailsModal');
            const content = document.getElementById('logDetailsContent');
            
            const severityColors = {
                'critical': 'red',
                'high': 'orange',
                'moderate': 'yellow',
                'low': 'blue'
            };
            
            const severityColor = severityColors[log.risk_severity] || 'gray';
            
            let detailsHtml = `
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br ${log.type === 'sms' ? 'from-green-50 to-emerald-50' : 'from-blue-50 to-indigo-50'} p-6 rounded-2xl border-2 ${log.type === 'sms' ? 'border-green-200' : 'border-blue-200'} shadow-lg">
                            <h4 class="text-sm font-black text-gray-700 mb-3 uppercase tracking-wider">Communication Type</h4>
                            <p class="text-2xl font-black ${log.type === 'sms' ? 'text-green-600' : 'text-blue-600'}">${log.type === 'sms' ? '📱 SMS' : '📧 EMAIL'}</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-2xl border-2 border-purple-200 shadow-lg">
                            <h4 class="text-sm font-black text-gray-700 mb-3 uppercase tracking-wider">Student</h4>
                            <p class="text-2xl font-black text-purple-600">${log.student_name}</p>
                            <p class="text-sm font-bold text-gray-600 mt-2">ID: ${log.student_id}</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-gray-50 to-slate-50 p-6 rounded-2xl border-2 border-gray-200 shadow-lg">
                        <h4 class="text-sm font-black text-gray-700 mb-3 uppercase tracking-wider flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            Contact Information
                        </h4>
                        <p class="text-lg font-bold text-gray-900 bg-white px-4 py-3 rounded-xl border border-gray-300">${log.contact}</p>
                    </div>

                    ${log.risk_severity ? `
                        <div class="bg-gradient-to-br from-${severityColor}-50 to-${severityColor}-100 p-6 rounded-2xl border-2 border-${severityColor}-300 shadow-lg">
                            <h4 class="text-sm font-black text-gray-700 mb-4 uppercase tracking-wider flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                                </svg>
                                Risk Assessment
                            </h4>
                            <div class="space-y-3 bg-white p-4 rounded-xl">
                                <div class="flex items-center justify-between">
                                    <span class="font-black text-gray-700">Severity:</span> 
                                    <span class="px-4 py-2 rounded-xl text-sm font-black uppercase bg-${severityColor}-100 text-${severityColor}-800 border-2 border-${severityColor}-300">${log.risk_severity}</span>
                                </div>
                                ${log.failed_count ? `
                                    <div class="flex items-center justify-between">
                                        <span class="font-black text-gray-700">Failed Assessments:</span> 
                                        <span class="px-4 py-2 rounded-xl text-sm font-black bg-red-100 text-red-800 border-2 border-red-300">${log.failed_count}</span>
                                    </div>
                                ` : ''}
                                ${log.trend ? `
                                    <div class="flex items-center justify-between">
                                        <span class="font-black text-gray-700">Trend:</span> 
                                        <span class="px-4 py-2 rounded-xl text-sm font-black ${
                                            log.trend === 'improving' ? 'bg-green-100 text-green-800 border-2 border-green-300' :
                                            log.trend === 'declining' ? 'bg-red-100 text-red-800 border-2 border-red-300' :
                                            'bg-gray-100 text-gray-800 border-2 border-gray-300'
                                        }">
                                            ${log.trend === 'improving' ? '↗' : log.trend === 'declining' ? '↘' : '→'} ${log.trend.toUpperCase()}
                                        </span>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    ` : ''}

                    ${log.status ? `
                        <div class="bg-gradient-to-br ${
                            log.status === 'sent' ? 'from-green-50 to-emerald-50 border-green-300' :
                            log.status === 'failed' ? 'from-red-50 to-rose-50 border-red-300' :
                            'from-yellow-50 to-amber-50 border-yellow-300'
                        } p-6 rounded-2xl border-2 shadow-lg">
                            <h4 class="text-sm font-black text-gray-700 mb-3 uppercase tracking-wider">Delivery Status</h4>
                            <span class="inline-flex items-center px-6 py-3 rounded-xl text-lg font-black uppercase ${
                                log.status === 'sent' ? 'bg-green-100 text-green-800 border-2 border-green-300' :
                                log.status === 'failed' ? 'bg-red-100 text-red-800 border-2 border-red-300' :
                                'bg-yellow-100 text-yellow-800 border-2 border-yellow-300'
                            }">
                                ${log.status === 'sent' ? '✓ DELIVERED' : log.status === 'failed' ? '✗ FAILED' : '⏳ PENDING'}
                            </span>
                            ${log.error_message ? `
                                <div class="mt-4 bg-red-100 border-2 border-red-300 rounded-xl p-4">
                                    <p class="text-sm font-bold text-red-800">
                                        <strong>Error:</strong> ${log.error_message}
                                    </p>
                                </div>
                            ` : ''}
                        </div>
                    ` : ''}

                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-6 rounded-2xl border-2 border-indigo-200 shadow-lg">
                        <h4 class="text-sm font-black text-gray-700 mb-4 uppercase tracking-wider flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
                            </svg>
                            ${log.type === 'email' ? 'Email Content' : 'Message Content'}
                        </h4>
                        ${log.type === 'email' ? `
                            <div class="bg-white p-5 rounded-xl border-2 border-gray-200 space-y-3">
                                <div>
                                    <p class="text-xs font-black text-gray-600 uppercase tracking-wider mb-2">Subject Line</p>
                                    <p class="text-lg font-black text-gray-900">${log.subject}</p>
                                </div>
                                <div class="pt-3 border-t-2 border-gray-200">
                                    <p class="text-sm font-bold text-gray-600 italic">📧 Full email content has been delivered to guardian's inbox</p>
                                </div>
                            </div>
                        ` : `
                            <div class="bg-white p-5 rounded-xl border-2 border-gray-200">
                                <p class="text-base font-medium text-gray-900 leading-relaxed">${log.message}</p>
                            </div>
                        `}
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-6 rounded-2xl border-2 border-blue-300 shadow-lg">
                        <h4 class="text-sm font-black text-gray-700 mb-4 uppercase tracking-wider flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                            Timestamp Information
                        </h4>
                        <div class="bg-white p-5 rounded-xl border-2 border-gray-200 space-y-2">
                            <p class="text-lg font-black text-gray-900">${new Date(log.sent_at).toLocaleString('en-US', { 
                                weekday: 'long', 
                                year: 'numeric', 
                                month: 'long', 
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}</p>
                            <p class="text-sm font-bold text-gray-600">${log.sent_at_human}</p>
                        </div>
                    </div>
                </div>
            `;
            
            content.innerHTML = detailsHtml;
            modal.classList.remove('hidden');
        }

        function closeLogDetailsModal() {
            document.getElementById('logDetailsModal').classList.add('hidden');
        }

        function viewEmailDetails(emailId) {
            window.open(`/analytics/email-log/${emailId}`, '_blank');
        }

        document.getElementById('logDetailsModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogDetailsModal();
            }
        });

        function retrySms(logId) {
            const button = document.getElementById(`retry-sms-${logId}`);
            const originalText = button.innerHTML;
            
            if (!confirm('Are you sure you want to retry sending this SMS?')) {
                return;
            }
            
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                SENDING...
            `;
            
            fetch('{{ route("analytics.retry-sms") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ log_id: logId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('✅ SMS sent successfully!', 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showNotification('❌ ' + data.message, 'error');
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('❌ Network error occurred. Please try again.', 'error');
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }

        function retryEmail(logId) {
            const button = document.getElementById(`retry-email-${logId}`);
            const originalText = button.innerHTML;
            
            if (!confirm('Are you sure you want to retry sending this email?')) {
                return;
            }
            
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                SENDING...
            `;
            
            fetch('{{ route("analytics.retry-email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ log_id: logId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('✅ Email sent successfully!', 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showNotification('❌ ' + data.message, 'error');
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('❌ Network error occurred. Please try again.', 'error');
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-6 right-6 px-8 py-5 rounded-2xl shadow-2xl z-50 transition-all duration-300 transform translate-x-[400px] border-2 ${
                type === 'success' 
                    ? 'bg-gradient-to-r from-green-600 to-emerald-700 text-white border-green-400' 
                    : 'bg-gradient-to-r from-red-600 via-red-700 to-rose-700 text-white border-red-400'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <span class="text-lg font-black">${message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLogDetailsModal();
            }
        });
    </script>
</x-app-layout>