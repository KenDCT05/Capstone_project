<x-app-layout>
    <div class="py-8 min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-red-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Enhanced Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                        Academic Risk Analysis Dashboard
                    </h1>
                    <p class="text-red-100 mt-2">Students requiring intervention</p>
                </div>
                <div class="px-8 py-6 flex flex-wrap items-center justify-between gap-4">
                    <a href="{{ route('analytics.dashboard') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>  
                        <span class="font-medium">Analytics Dashboard</span>
                    </a>
                    <div class="text-sm text-gray-600 bg-gray-100 px-4 py-2 rounded-full font-medium flex items-center space-x-2">
                        <div id="lastUpdated">Last updated: {{ now()->format('M d, Y h:i A') }}</div>

                    </div>
                </div>
            </div>

            <!-- Priority Action Queue -->
           

            <!-- Enhanced Alert Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-6">
                <!-- Critical Risk Card -->
                <div class="group bg-gradient-to-r from-red-600 via-red-700 to-rose-700 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-400/10 to-red-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-5 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative">
                        <div class="text-4xl opacity-80 mb-2">🚨</div>
                        <p class="text-red-100 text-xs font-medium uppercase tracking-wider">Critical Risk</p>
                        <p class="text-3xl font-black mt-1">{{ $criticalRisk->count() ?? $atRisk->where('risk_level', 'critical')->count() }}</p>
                        <div class="h-1 bg-red-300 rounded-full my-2"></div>
                        <p class="text-red-100 text-xs">&lt;60 Percentage</p>
                    </div>
                </div>

                <!-- High Risk Card -->
                <div class="group bg-gradient-to-br from-orange-600 via-orange-700 to-orange-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-400/10 to-orange-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-5 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative">
                        <div class="text-4xl opacity-80 mb-2">⚠️</div>
                        <p class="text-orange-100 text-xs font-medium uppercase tracking-wider">High Risk</p>
                        <p class="text-3xl font-black mt-1">{{ $highRisk->count() ?? $atRisk->where('risk_level', 'high')->count() }}</p>
                        <div class="h-1 bg-orange-300 rounded-full my-2"></div>
                        <p class="text-orange-100 text-xs">60-69 Percentage</p>
                    </div>
                </div>

                <!-- Moderate Risk Card -->
                <div class="group bg-gradient-to-br from-yellow-600 via-yellow-700 to-yellow-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 to-yellow-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-5 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative">
                        <div class="text-4xl opacity-80 mb-2">📊</div>
                        <p class="text-yellow-100 text-xs font-medium uppercase tracking-wider">Moderate Risk</p>
                        <p class="text-3xl font-black mt-1">{{ $atRisk->where('risk_level', 'moderate')->count() }}</p>
                        <div class="h-1 bg-yellow-300 rounded-full my-2"></div>
                        <p class="text-yellow-100 text-xs">70-74 Percentage</p>
                    </div>
                </div>

                <!-- Safe Students Card -->
                <div class="group bg-gradient-to-br from-green-600 via-green-700 to-green-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400/10 to-green-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-5 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative">
                        <div class="text-4xl opacity-80 mb-2">✅</div>
                        <p class="text-green-100 text-xs font-medium uppercase tracking-wider">Safe Students</p>
                        <p class="text-3xl font-black mt-1">{{ $safeStudents->count() }}</p>
                        <div class="h-1 bg-green-300 rounded-full my-2"></div>
                        <p class="text-green-100 text-xs">≥75 Percentage</p>
                    </div>
                </div>
                <!-- Total At Risk Card -->
                <div class="group bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400/10 to-blue-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-5 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative">
                        <div class="text-4xl opacity-80 mb-2">👥</div>
                        <p class="text-blue-100 text-xs font-medium uppercase tracking-wider">Total At Risk</p>
                        <p class="text-3xl font-black mt-1">{{ $atRisk->count() }}</p>
                        <div class="h-1 bg-blue-300 rounded-full my-2"></div>
                        <p class="text-blue-100 text-xs">&lt;75 Percentage</p>
                    </div>
                </div>
                <!-- SMS Alerts Card -->
                <div class="group bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-400/10 to-purple-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-5 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative">
                        <div class="text-4xl opacity-80 mb-2">📱</div>
                        <p class="text-purple-100 text-xs font-medium uppercase tracking-wider">SMS Ready</p>
                        <p class="text-3xl font-black mt-1">{{ $atRisk->where('failed_count', '>=', 3)->count() }}</p>
                        <div class="h-1 bg-purple-300 rounded-full my-2"></div>
                        <p class="text-purple-100 text-xs">3+ Failures</p>
                    </div>
                </div>
            </div>

            <!-- Enhanced Filters with Quick Actions -->
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-red-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2 flex items-center">
                            <span class="mr-3 text-xl">🔍</span>
                            Filter Risk Analysis
                        </h3>
                    </div>

                </div>
                
                <form method="GET" action="{{ route('analytics.risk-alerts') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end mt-6">
                    <!-- Subject Filter -->
                    <div>
                        <label for="subject_id" class="block text-sm font-bold text-gray-700 mb-2">
                            <span class="flex items-center">
                                 Filter by Subject
                            </span>
                        </label>
                        <select name="subject_id" id="subject_id"
                                class="w-full border-2 border-red-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-red-200 focus:border-red-500 transition-all duration-300 bg-white shadow-md font-medium">
                            <option value="">All Subjects ({{ $subjects->count() }} total)</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Student Filter -->
                    <div>
                        <label for="student_id" class="block text-sm font-bold text-gray-700 mb-2">
                            <span class="flex items-center">
                                 Filter by Student
                            </span>
                        </label>
                        <select name="student_id" id="student_id"
                                class="w-full border-2 border-red-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-red-200 focus:border-red-500 transition-all duration-300 bg-white shadow-md font-medium">
                                <option value="">All Students ({{ $allStudentsForFilter->count() }} total)</option>
                                @foreach($allStudentsForFilter as $student)
                                    <option value="{{ $student->id }}" {{ $selectedStudent == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            Apply
                        </button>
                        <a href="{{ route('analytics.risk-alerts') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition-colors duration-200">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Risk Level Progress Bar -->
            @if($atRisk->count() > 0 || $safeStudents->count() > 0)
                @php
                    $totalStudents = $atRisk->count() + $safeStudents->count();
                    $criticalPercent = $totalStudents > 0 ? (($criticalRisk->count() ?? $atRisk->where('risk_level', 'critical')->count()) / $totalStudents) * 100 : 0;
                    $highPercent = $totalStudents > 0 ? (($highRisk->count() ?? $atRisk->where('risk_level', 'high')->count()) / $totalStudents) * 100 : 0;
                    $moderatePercent = $totalStudents > 0 ? ($atRisk->where('risk_level', 'moderate')->count() / $totalStudents) * 100 : 0;
                    $safePercent = $totalStudents > 0 ? ($safeStudents->count() / $totalStudents) * 100 : 0;
                @endphp
                
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-red-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        📈 Risk Distribution Overview & Trends
                    </h3>
                    
                    <div class="mb-6">
                        <div class="flex justify-between text-sm font-medium text-gray-600 mb-2">
                            <span>Risk Level Distribution</span>
                            <span>{{ $totalStudents }} Total Students</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                            <div class="h-full flex">
                                @if($criticalPercent > 0)
                                    <div class="bg-red-600 flex items-center justify-center text-white text-xs font-bold" style="width: {{ $criticalPercent }}%">
                                        @if($criticalPercent > 8){{ round($criticalPercent) }}%@endif
                                    </div>
                                @endif
                                @if($highPercent > 0)
                                    <div class="bg-orange-500 flex items-center justify-center text-white text-xs font-bold" style="width: {{ $highPercent }}%">
                                        @if($highPercent > 8){{ round($highPercent) }}%@endif
                                    </div>
                                @endif
                                @if($moderatePercent > 0)
                                    <div class="bg-yellow-500 flex items-center justify-center text-white text-xs font-bold" style="width: {{ $moderatePercent }}%">
                                        @if($moderatePercent > 8){{ round($moderatePercent) }}%@endif
                                    </div>
                                @endif
                                @if($safePercent > 0)
                                    <div class="bg-green-500 flex items-center justify-center text-white text-xs font-bold" style="width: {{ $safePercent }}%">
                                        @if($safePercent > 8){{ round($safePercent) }}%@endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-600 rounded-full mr-2"></div>
                                <span class="text-gray-700">Critical: {{ $criticalRisk->count() ?? $atRisk->where('risk_level', 'critical')->count() }} ({{ round($criticalPercent, 1) }}%)</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-orange-500 rounded-full mr-2"></div>
                                <span class="text-gray-700">High: {{ $highRisk->count() ?? $atRisk->where('risk_level', 'high')->count() }} ({{ round($highPercent, 1) }}%)</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="text-gray-700">Moderate: {{ $atRisk->where('risk_level', 'moderate')->count() }} ({{ round($moderatePercent, 1) }}%)</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-gray-700">Safe: {{ $safeStudents->count() }} ({{ round($safePercent, 1) }}%)</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Enhanced At Risk Students Table -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-8 py-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                ⚠️ Students Requiring Intervention
                            </h2>
                            <p class="text-red-100 mt-1">Based on performance below 75</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex space-x-2">
                            <span class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-full font-bold">
                                {{ $atRisk->count() }} Students
                            </span>
                            <div class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm">
                                {{ $atRisk->where('failed_count', '>=', 3)->count() }} SMS Ready
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-gray-700 text-sm">Student Info</th>
                                <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-gray-700 text-sm">Subject</th>
                                <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-gray-700 text-sm">Performance</th>
                                <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-gray-700 text-sm">Risk Analysis</th>
                                <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-gray-700 text-sm">Communication Status</th>
                                <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-gray-700 text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($atRisk as $student)
                                <tr class="hover:bg-red-50 transition-all duration-200 group">
                                    <!-- Student Info -->
                                    <td class="px-6 py-6">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12 bg-red-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                                {{ substr($student['student_name'], 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-lg font-bold text-gray-900 group-hover:text-red-700">
                                                    {{ $student['student_name'] }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    ID: {{ $student['student_id'] }}
                                                </div>
                                                @if($student['guardian_contact'])
                                                    <div class="text-xs text-green-600 font-medium">
                                                        Contact: {{ $student['guardian_contact'] }}
                                                    </div>
                                                @else
                                                    <div class="text-xs text-red-600 font-medium">
                                                        No guardian contact
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Subject -->
                                    <td class="px-6 py-6">
                                        <div class="text-sm font-medium text-gray-900">{{ $student['subject_name'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $student['total_assessments'] }} assessments</div>
                                        @if(isset($student['recent_failed_count']) && $student['recent_failed_count'] > 0)
                                            <div class="text-xs text-orange-600 font-medium mt-1">
                                                {{ $student['recent_failed_count'] }} failed recently
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Performance -->
                                    <td class="px-6 py-6">
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-gray-500">Transmuted:</span>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold shadow-md
                                                    {{ $student['average_transmuted'] >= 70 ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300' : 
                                                       ($student['average_transmuted'] >= 60 ? 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 border border-orange-300' : 'bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300') }}">
                                                    {{ $student['average_transmuted'] }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-gray-500">Raw:</span>
                                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm font-medium">{{ $student['average_percentage'] }}%</span>
                                            </div>
                                            <div class="text-xs font-medium
                                                {{ $student['performance_level'] === 'Excellent' ? 'text-purple-700' : 
                                                   ($student['performance_level'] === 'Very Good' ? 'text-blue-700' : 
                                                    ($student['performance_level'] === 'Good' ? 'text-green-700' : 
                                                     ($student['performance_level'] === 'Fair' ? 'text-yellow-700' : 
                                                      ($student['performance_level'] === 'Passed' ? 'text-orange-700' : 'text-red-700')))) }}">
                                                {{ $student['performance_level'] }}
                                            </div>
                                            <div class="mt-1 text-xs">
                                                <span class="text-gray-500">Failed:</span>
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full font-bold ml-1">
                                                    {{ $student['failed_count'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Risk Analysis -->
                                    <td class="px-6 py-6">
                                        <div class="space-y-2">
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold uppercase tracking-wider shadow-md
                                                    {{ ($student['risk_severity'] ?? $student['risk_level'] ?? 'moderate') === 'critical' ? 'bg-red-100 text-red-800 border-2 border-red-300 animate-pulse' : 
                                                       (($student['risk_severity'] ?? $student['risk_level'] ?? 'moderate') === 'high' ? 'bg-orange-100 text-orange-800 border-2 border-orange-300' : 'bg-yellow-100 text-yellow-800 border-2 border-yellow-300') }}">
                                                    @if(($student['risk_severity'] ?? $student['risk_level'] ?? 'moderate') === 'critical')
                                                        Critical
                                                    @elseif(($student['risk_severity'] ?? $student['risk_level'] ?? 'moderate') === 'high')
                                                        High
                                                    @else
                                                        Moderate
                                                    @endif
                                                </span>
                                                
                                                @if(isset($student['trend']))
                                                    <div class="text-xs font-medium">
                                                        @if($student['trend'] === 'improving')
                                                            <span class="text-green-600 bg-green-100 px-2 py-1 rounded-full">Improving</span>
                                                        @elseif($student['trend'] === 'declining')
                                                            <span class="text-red-600 bg-red-100 px-2 py-1 rounded-full">Declining</span>
                                                        @else
                                                            <span class="text-gray-600 bg-gray-100 px-2 py-1 rounded-full">Stable</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-600">
                                                @if(($student['risk_severity'] ?? $student['risk_level'] ?? 'moderate') === 'critical')
                                                    Immediate intervention needed
                                                @elseif(($student['risk_severity'] ?? $student['risk_level'] ?? 'moderate') === 'high') 
                                                    Requires close monitoring
                                                @else
                                                    Additional support recommended
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- SMS Status -->
<td class="px-6 py-6">
    @php
        $lastSms = \App\Models\SmsLog::where('student_id', $student['student_id'])
            ->latest('sent_at')
            ->first();

        $lastSentAt = $lastSms ? \Carbon\Carbon::parse($lastSms->sent_at) : null;

        $requiredGap = match($student['risk_severity'] ?? 'moderate') {
            'critical' => 3,
            'high' => 5,
            default => 7
        };

        $daysSinceLastSms = $lastSentAt ? $lastSentAt->diffInDays(now()) : null;
        $nextSmsDate = $lastSentAt ? $lastSentAt->copy()->addDays($requiredGap) : now();
    @endphp

    <div class="space-y-1">
        @if($student['failed_count'] >= 3)
            @if($student['guardian_contact'])
                @if($lastSentAt && $daysSinceLastSms < $requiredGap)
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Sent {{ $lastSentAt->diffForHumans() }}
                    </span>
                    <div class="text-xs text-gray-500">
                        Next: {{ $nextSmsDate->diffForHumans() }}
                    </div>
                @else
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        Ready to send
                    </span>
                    <button onclick="sendSingleSMS('{{ $student['student_id'] }}')" 
                            class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                        Send now
                    </button>
                @endif
            @else
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    No contact info
                </span>
            @endif
        @else
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                Not triggered
            </span>
            <div class="text-xs text-gray-500">
                Need {{ 3 - $student['failed_count'] }} more fail{{ 3 - $student['failed_count'] > 1 ? 's' : '' }}
            </div>
        @endif
    </div>
</td>



                                    <!-- Actions -->
                                    <td class="px-6 py-6">
                                        <div class="flex flex-col space-y-2">
                                            <a href="{{ route('analytics.insights', $student['student_id']) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg text-sm">
                                                Full Report
                                            </a>
                                            <button onclick="showInterventionModal('{{ $student['student_name'] }}', '{{ $student['risk_severity'] ?? $student['risk_level'] ?? 'moderate' }}', {{ $student['average_transmuted'] }}, '{{ $student['trend'] ?? 'stable' }}', {{ $student['failed_count'] }})" 
                                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg text-sm">
                                                Intervention
                                            </button>
                                            @if($student['guardian_contact'])
                                                <button onclick="contactParent('{{ $student['guardian_contact'] }}', '{{ $student['student_name'] }}')" 
                                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-md hover:shadow-lg text-sm">
                                                    Contact Parent
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="text-6xl mb-4">🎉</div>
                                            <div class="text-2xl font-bold text-gray-600 mb-2">No Students at Risk!</div>
                                            <div class="text-gray-500">All students are performing at or above 75 transmuted grade average</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Safe Students Summary -->
            @if($safeStudents->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-xl border border-green-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-8 py-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-white flex items-center">
                                    <span class="mr-3 text-2xl">✅</span>
                                    Students Performing Well
                                </h2>
                                <p class="text-green-100 mt-1">Students with 75+ transmuted grade average</p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <span class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-full font-bold">
                                    {{ $safeStudents->count() }} Students
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                            @foreach($safeStudents->take(12) as $student)
                                <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl border border-green-200 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($student['student_name'], 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $student['student_name'] }}</div>
                                            <div class="text-xs text-gray-500">{{ $student['subject_name'] }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-green-200 text-green-800">
                                            {{ $student['average_transmuted'] }}
                                        </span>
                                        @if(isset($student['trend']) && $student['trend'] === 'improving')
                                            <div class="text-xs text-green-600 mt-1">↗ Improving</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($safeStudents->count() > 12)
                            <div class="mt-4 text-center">
                                <span class="text-sm text-gray-600">And {{ $safeStudents->count() - 12 }} more students...</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif



            <!-- Export and Action Panel -->
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-red-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600 font-medium">
                            Risk analysis
                        </div>
                        <div class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <span id="lastUpdateTime">Updated: {{ now()->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button onclick="window.print()"
                                class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            Print Report
                        </button>
                        <button onclick="exportRiskData()"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            Export Analysis
                        </button>
                        <a href="{{ route('analytics.communication-logs') }}"
    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-800 hover:to-indigo-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
    </svg>
    <span class="font-medium">View Communication Logs</span>
</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Intervention Modal -->
    <div id="interventionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Intervention Strategy</h3>
                    <button onclick="closeInterventionModal()" class="text-white hover:text-red-200 text-2xl">&times;</button>
                </div>
            </div>
            <div class="p-6">
                <div id="interventionContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="mt-6 flex gap-3 justify-end">
                    <button onclick="closeInterventionModal()" 
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Scripts -->
    <script>
        // Global variables for tracking
        let refreshInterval;
        const REFRESH_INTERVAL = 5 * 60 * 1000; // 5 minutes

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 ${
                type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // // Enhanced SMS functionality
        // function sendAllSMSAlerts() {
        //     const eligibleCount = {{ $atRisk->where('failed_count', '>=', 3)->count() }};
            
        //     if (eligibleCount === 0) {
        //         showNotification('No students eligible for SMS alerts', 'error');
        //         return;
        //     }

        //     if (!confirm(`Send SMS alerts to ${eligibleCount} students? This will only send to students who haven't received alerts recently.`)) {
        //         return;
        //     }

        //     fetch('/api/risk-alerts/send-all-sms', {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //         },
        //         body: JSON.stringify({
        //             subject_id: '{{ $selectedSubject }}',
        //             student_id: '{{ $selectedStudent }}'
        //         })
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.success) {
        //             showNotification(`SMS sent to ${data.sent_count} students`, 'success');
        //             setTimeout(() => window.location.reload(), 2000);
        //         } else {
        //             showNotification(data.message || 'Failed to send SMS alerts', 'error');
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Error sending SMS:', error);
        //         showNotification('Failed to send SMS alerts', 'error');
        //     });
        // }

        function sendSingleSMS(studentId) {
            fetch('/api/risk-alerts/send-sms', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ student_id: studentId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('SMS sent successfully', 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showNotification(data.message || 'Failed to send SMS', 'error');
                }
            })
            .catch(error => {
                console.error('Error sending SMS:', error);
                showNotification('Failed to send SMS', 'error');
            });
        }

        // Enhanced export functionality
        function exportRiskData() {
            const riskData = {
                report_date: new Date().toISOString(),
                grading_system: 'transmuted',
                filter_applied: {
                    subject: '{{ $selectedSubject ? $subjects->find($selectedSubject)->name : "All Subjects" }}',
                    student: '{{ $selectedStudent ? "Filtered" : "All Students" }}'
                },
                summary: {
                    total_students_analyzed: {{ $atRisk->count() + $safeStudents->count() }},
                    total_at_risk: {{ $atRisk->count() }},
                    critical_risk: {{ $criticalRisk->count() ?? $atRisk->where('risk_level', 'critical')->count() }},
                    high_risk: {{ $highRisk->count() ?? $atRisk->where('risk_level', 'high')->count() }},
                    moderate_risk: {{ $atRisk->where('risk_level', 'moderate')->count() }},
                    safe_students: {{ $safeStudents->count() }},
                    sms_ready: {{ $atRisk->where('failed_count', '>=', 3)->count() }}
                },
                risk_thresholds: {
                    critical: 'Below 60 transmuted grade',
                    high: '60-69 transmuted grade',
                    moderate: '70-74 transmuted grade',
                    safe: '75+ transmuted grade'
                },
                actionable_insights: {
                    immediate_interventions_needed: {{ $criticalRisk->count() ?? $atRisk->where('risk_level', 'critical')->count() }},
                    students_needing_sms_alerts: {{ $atRisk->where('failed_count', '>=', 3)->count() }},
                    parent_conferences_recommended: {{ $criticalRisk->count() ?? $atRisk->where('risk_level', 'critical')->count() }}
                },
                next_steps: [
                    "Contact parents of {{ $criticalRisk->count() ?? $atRisk->where('risk_level', 'critical')->count() }} critical risk students",
                    "Schedule tutoring for {{ $highRisk->count() ?? $atRisk->where('risk_level', 'high')->count() }} high risk students", 
                    "Send SMS alerts to {{ $atRisk->where('failed_count', '>=', 3)->count() }} students with multiple failures"
                ],
                students: {
                    at_risk: @json($atRisk->values()),
                    safe: @json($safeStudents->take(20)->values())
                }
            };

            const dataStr = JSON.stringify(riskData, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,' + encodeURIComponent(dataStr);
            const exportFileDefaultName = 'risk-analysis-report-' + new Date().toISOString().split('T')[0] + '.json';

            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
            
            showNotification('Risk analysis exported successfully', 'success');
        }

   

        // Enhanced intervention modal functions
        function showInterventionModal(studentName, riskLevel, averageTransmuted, trend, failedCount) {
            const modal = document.getElementById('interventionModal');
            const content = document.getElementById('interventionContent');
            
            let strategies = '';
            let timeline = '';
            let resources = '';
            let trendInfo = '';
            
            // Trend analysis
            if (trend === 'improving') {
                trendInfo = `
                    <div class="bg-green-50 border border-green-200 p-4 rounded-lg mb-4">
                        <div class="flex items-center">
                            <span class="text-green-600 mr-2">📈</span>
                            <div>
                                <h5 class="font-bold text-green-800">Positive Trend Detected</h5>
                                <p class="text-sm text-green-700">Student is showing improvement. Continue current interventions and provide encouragement.</p>
                            </div>
                        </div>
                    </div>
                `;
            } else if (trend === 'declining') {
                trendInfo = `
                    <div class="bg-red-50 border border-red-200 p-4 rounded-lg mb-4">
                        <div class="flex items-center">
                            <span class="text-red-600 mr-2">📉</span>
                            <div>
                                <h5 class="font-bold text-red-800">Declining Performance Alert</h5>
                                <p class="text-sm text-red-700">Student performance is worsening. Immediate escalation of interventions required.</p>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            if (riskLevel === 'critical') {
                strategies = `
                    <div class="border-l-4 border-red-500 pl-4 bg-red-50 p-4 rounded-lg mb-4">
                        <h4 class="font-bold text-red-800 mb-3">Critical Intervention Required</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li>• Schedule immediate one-on-one meeting within 24 hours</li>
                            <li>• Contact parent/guardian immediately</li>
                            <li>• Assess for learning disabilities or external factors</li>
                            <li>• Create individualized remediation plan</li>
                            <li>• Daily check-ins and progress monitoring</li>
                            <li>• Consider peer tutoring or mentorship</li>
                            <li>• Coordinate with counseling services</li>
                        </ul>
                    </div>
                `;
                timeline = '24 hours to initiate, daily monitoring required';
                resources = 'Counseling services, tutoring program, parent conference, possible referral to special services';
            } else if (riskLevel === 'high') {
                strategies = `
                    <div class="border-l-4 border-orange-500 pl-4 bg-orange-50 p-4 rounded-lg mb-4">
                        <h4 class="font-bold text-orange-800 mb-3">High Priority Support</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li>• Intensive tutoring 3x per week</li>
                            <li>• Weekly progress meetings</li>
                            <li>• Supplementary learning materials</li>
                            <li>• Study skills assessment and training</li>
                            <li>• Parent communication bi-weekly</li>
                            <li>• Small group interventions</li>
                            <li>• Modified assessment accommodations</li>
                        </ul>
                    </div>
                `;
                timeline = '1 week to implement, weekly reviews';
                resources = 'Tutoring program, additional practice materials, parent communication system';
            } else {
                strategies = `
                    <div class="border-l-4 border-yellow-500 pl-4 bg-yellow-50 p-4 rounded-lg mb-4">
                        <h4 class="font-bold text-yellow-800 mb-3">Preventive Support</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li>• Additional practice assignments</li>
                            <li>• Study group participation</li>
                            <li>• Regular office hours attendance</li>
                            <li>• Time management coaching</li>
                            <li>• Monthly progress check-ins</li>
                            <li>• Peer collaboration opportunities</li>
                            <li>• Organizational skills support</li>
                        </ul>
                    </div>
                `;
                timeline = '2 weeks to implement, bi-weekly reviews';
                resources = 'Study materials, peer study groups, organizational tools';
            }
            
            content.innerHTML = `
                <div class="mb-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-4">Intervention Plan: ${studentName}</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm bg-gray-50 p-4 rounded-lg">
                        <div>
                            <span class="text-gray-600 block">Risk Level:</span>
                            <span class="font-semibold text-${riskLevel === 'critical' ? 'red' : riskLevel === 'high' ? 'orange' : 'yellow'}-700">${riskLevel.toUpperCase()}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 block">Current Average:</span>
                            <span class="font-semibold">${averageTransmuted} transmuted</span>
                        </div>
                        <div>
                            <span class="text-gray-600 block">Failed Count:</span>
                            <span class="font-semibold text-red-600">${failedCount} assessments</span>
                        </div>
                        <div>
                            <span class="text-gray-600 block">Trend:</span>
                            <span class="font-semibold text-${trend === 'improving' ? 'green' : trend === 'declining' ? 'red' : 'gray'}-600">${trend}</span>
                        </div>
                    </div>
                </div>
                
                ${trendInfo}
                ${strategies}
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h5 class="font-bold text-blue-800 mb-2">Timeline</h5>
                        <p class="text-sm text-gray-700">${timeline}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <h5 class="font-bold text-green-800 mb-2">Resources Needed</h5>
                        <p class="text-sm text-gray-700">${resources}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                </div>
            `;
            
            modal.classList.remove('hidden');
        }

        function closeInterventionModal() {
            document.getElementById('interventionModal').classList.add('hidden');
        }


        function contactParent(phoneNumber, studentName) {
            if (confirm(`Contact parent/guardian at ${phoneNumber} for ${studentName}?`)) {
                // This would typically integrate with your phone system or create a communication log
                window.open(`tel:${phoneNumber}`);
                
                // Log the contact attempt
                fetch('/api/contact-log', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        phone_number: phoneNumber,
                        student_name: studentName,
                        contact_type: 'phone_call',
                        timestamp: new Date().toISOString()
                    })
                });
                
                showNotification(`Contact logged for ${studentName}`, 'success');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {

            
            // Auto-submit form when filters change
            const subjectFilter = document.getElementById('subject_id');
            const riskLevelFilter = document.getElementById('risk_level');
            
            if (subjectFilter) {
                subjectFilter.addEventListener('change', function() {
                    if (this.value) {
                        setTimeout(() => {
                            this.closest('form').submit();
                        }, 100);
                    }
                });
            }
            
            if (riskLevelFilter) {
                riskLevelFilter.addEventListener('change', function() {
                    setTimeout(() => {
                        this.closest('form').submit();
                    }, 100);
                });
            }
        });

        // Clean up on page unload
        window.addEventListener('beforeunload', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });
    </script>
</x-app-layout>