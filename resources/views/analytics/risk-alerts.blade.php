<x-app-layout>
    <div class="py-8 min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-red-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Enhanced Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                        Academic Risk Analysis Dashboard
                    </h1>
                    <p class="text-red-100 mt-2">Students requiring intervention based on transmuted grade performance (&lt;75 average)</p>
                </div>
                <div class="px-8 py-6 flex flex-wrap items-center justify-between gap-4">
                    <a href="{{ route('analytics.dashboard') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Analytics Dashboard</span>
                    </a>
                    <div class="text-sm text-gray-600 bg-gray-100 px-4 py-2 rounded-full font-medium">
                        Last updated: {{ now()->format('M d, Y h:i A') }}
                    </div>
                </div>
            </div>

            <!-- Enhanced Alert Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">
                <!-- Critical Risk Card -->
                <div class="group bg-gradient-to-br from-red-600 via-red-700 to-red-800 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-400/10 to-red-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-5 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-6xl opacity-80 group-hover:scale-110 transition-transform duration-300">🚨</div>
                            <div class="text-right">
                                <p class="text-red-100 text-sm font-medium uppercase tracking-wider">Critical Risk</p>
                                <p class="text-5xl font-black mt-2">{{ $atRisk->where('risk_level', 'critical')->count() }}</p>
                            </div>
                        </div>
                        <div class="h-1 bg-red-300 rounded-full mb-2"></div>
                        <div class="flex justify-between items-center">
                            <p class="text-red-100 text-xs font-medium">&lt;60 Transmuted</p>
                            <div class="bg-red-500 text-red-100 px-2 py-1 rounded text-xs font-bold">URGENT</div>
                        </div>
                    </div>
                </div>

                <!-- High Risk Card -->
                <div class="group bg-gradient-to-br from-orange-600 via-orange-700 to-orange-800 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-400/10 to-orange-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-5 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-6xl opacity-80 group-hover:scale-110 transition-transform duration-300">⚠️</div>
                            <div class="text-right">
                                <p class="text-orange-100 text-sm font-medium uppercase tracking-wider">High Risk</p>
                                <p class="text-5xl font-black mt-2">{{ $atRisk->where('risk_level', 'high')->count() }}</p>
                            </div>
                        </div>
                        <div class="h-1 bg-orange-300 rounded-full mb-2"></div>
                        <div class="flex justify-between items-center">
                            <p class="text-orange-100 text-xs font-medium">60-69 Transmuted</p>
                            <div class="bg-orange-500 text-orange-100 px-2 py-1 rounded text-xs font-bold">HIGH</div>
                        </div>
                    </div>
                </div>

                <!-- Moderate Risk Card -->
                <div class="group bg-gradient-to-br from-yellow-600 via-yellow-700 to-yellow-800 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 to-yellow-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-5 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-6xl opacity-80 group-hover:scale-110 transition-transform duration-300">📊</div>
                            <div class="text-right">
                                <p class="text-yellow-100 text-sm font-medium uppercase tracking-wider">Moderate Risk</p>
                                <p class="text-5xl font-black mt-2">{{ $atRisk->where('risk_level', 'moderate')->count() }}</p>
                            </div>
                        </div>
                        <div class="h-1 bg-yellow-300 rounded-full mb-2"></div>
                        <div class="flex justify-between items-center">
                            <p class="text-yellow-100 text-xs font-medium">70-74 Transmuted</p>
                            <div class="bg-yellow-500 text-yellow-100 px-2 py-1 rounded text-xs font-bold">MODERATE</div>
                        </div>
                    </div>
                </div>

                <!-- Total At Risk Card -->
                <div class="group bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400/10 to-blue-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-5 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-6xl opacity-80 group-hover:scale-110 transition-transform duration-300">👥</div>
                            <div class="text-right">
                                <p class="text-blue-100 text-sm font-medium uppercase tracking-wider">Total At Risk</p>
                                <p class="text-5xl font-black mt-2">{{ $atRisk->count() }}</p>
                            </div>
                        </div>
                        <div class="h-1 bg-blue-300 rounded-full mb-2"></div>
                        <div class="flex justify-between items-center">
                            <p class="text-blue-100 text-xs font-medium">&lt;75 Transmuted</p>
                            <div class="bg-blue-500 text-blue-100 px-2 py-1 rounded text-xs font-bold">TOTAL</div>
                        </div>
                    </div>
                </div>

                <!-- Safe Students Card -->
                <div class="group bg-gradient-to-br from-green-600 via-green-700 to-green-800 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400/10 to-green-600/10 rounded-2xl"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-5 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-6xl opacity-80 group-hover:scale-110 transition-transform duration-300">✅</div>
                            <div class="text-right">
                                <p class="text-green-100 text-sm font-medium uppercase tracking-wider">Safe Students</p>
                                <p class="text-5xl font-black mt-2">{{ $safeStudents->count() }}</p>
                            </div>
                        </div>
                        <div class="h-1 bg-green-300 rounded-full mb-2"></div>
                        <div class="flex justify-between items-center">
                            <p class="text-green-100 text-xs font-medium">≥75 Transmuted</p>
                            <div class="bg-green-500 text-green-100 px-2 py-1 rounded text-xs font-bold">SAFE</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Filters -->
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-red-100">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="mr-3 text-xl">🔍</span>
                    Filter Risk Analysis
                </h3>
                <form method="GET" action="{{ route('analytics.risk-alerts') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    <!-- Subject Filter -->
                    <div>
                        <label for="subject_id" class="block text-sm font-bold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <span class="mr-2">📚</span>
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
                                <span class="mr-2">👤</span>
                                Filter by Student
                            </span>
                        </label>
                        <select name="student_id" id="student_id"
                                class="w-full border-2 border-red-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-red-200 focus:border-red-500 transition-all duration-300 bg-white shadow-md font-medium">
                            <option value="">All Students ({{ $safeStudents->merge($atRisk)->unique('student_id')->count() }} total)</option>
                            @foreach($safeStudents->merge($atRisk)->unique('student_id') as $student)
                                <option value="{{ $student['student_id'] }}" {{ $selectedStudent == $student['student_id'] ? 'selected' : '' }}>
                                    {{ $student['student_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <span class="mr-2">🔍</span>
                            Apply Filters
                        </button>
                        <a href="{{ route('analytics.risk-alerts') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition-colors duration-200">
                            Clear All
                        </a>
                    </div>
                </form>
            </div>

            <!-- Risk Level Progress Bar -->
            @if($atRisk->count() > 0 || $safeStudents->count() > 0)
                @php
                    $totalStudents = $atRisk->count() + $safeStudents->count();
                    $criticalPercent = $totalStudents > 0 ? ($atRisk->where('risk_level', 'critical')->count() / $totalStudents) * 100 : 0;
                    $highPercent = $totalStudents > 0 ? ($atRisk->where('risk_level', 'high')->count() / $totalStudents) * 100 : 0;
                    $moderatePercent = $totalStudents > 0 ? ($atRisk->where('risk_level', 'moderate')->count() / $totalStudents) * 100 : 0;
                    $safePercent = $totalStudents > 0 ? ($safeStudents->count() / $totalStudents) * 100 : 0;
                @endphp
                
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-red-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="mr-3 text-xl">📈</span>
                        Risk Distribution Overview
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
                                <span class="text-gray-700">Critical: {{ $atRisk->where('risk_level', 'critical')->count() }} ({{ round($criticalPercent, 1) }}%)</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-orange-500 rounded-full mr-2"></div>
                                <span class="text-gray-700">High: {{ $atRisk->where('risk_level', 'high')->count() }} ({{ round($highPercent, 1) }}%)</span>
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

            <!-- At Risk Students Table -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-8 py-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                <span class="mr-3 text-2xl">⚠️</span>
                                Students Requiring Intervention
                            </h2>
                            <p class="text-red-100 mt-1">Based on transmuted grade performance below 75</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <span class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-full font-bold">
                                {{ $atRisk->count() }} Students
                            </span>
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
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Subject -->
                                    <td class="px-6 py-6">
                                        <div class="text-sm font-medium text-gray-900">{{ $student['subject_name'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $student['total_assessments'] }} assessments</div>
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
                                        </div>
                                    </td>

                                    <!-- Risk Analysis -->
                                    <td class="px-6 py-6">
                                        <div class="space-y-2">
                                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold uppercase tracking-wider shadow-md
                                                {{ $student['risk_level'] === 'critical' ? 'bg-red-100 text-red-800 border-2 border-red-300 animate-pulse' : 
                                                   ($student['risk_level'] === 'high' ? 'bg-orange-100 text-orange-800 border-2 border-orange-300' : 'bg-yellow-100 text-yellow-800 border-2 border-yellow-300') }}">
                                                @if($student['risk_level'] === 'critical')
                                                    🚨 {{ $student['risk_level'] }}
                                                @elseif($student['risk_level'] === 'high')
                                                    ⚠️ {{ $student['risk_level'] }}
                                                @else
                                                    📊 {{ $student['risk_level'] }}
                                                @endif
                                            </span>
                                            <div class="text-xs text-gray-600">
                                                @if($student['risk_level'] === 'critical')
                                                    Immediate intervention needed
                                                @elseif($student['risk_level'] === 'high') 
                                                    Requires close monitoring
                                                @else
                                                    Additional support recommended
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-6">
                                        <div class="flex flex-col space-y-2">
                                            <a href="{{ route('analytics.insights', $student['student_id']) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg text-sm">
                                                📊 Full Report
                                            </a>
                                            <button onclick="showInterventionModal('{{ $student['student_name'] }}', '{{ $student['risk_level'] }}', {{ $student['average_transmuted'] }})" 
                                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg text-sm">
                                                🎯 Intervention
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
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

            <!-- Enhanced Intervention Recommendations -->
            @if($atRisk->isNotEmpty())
                <div class="bg-white shadow-xl rounded-2xl p-8 border border-red-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="mr-3 text-2xl">💡</span>
                        Evidence-Based Intervention Strategies
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        @if($atRisk->where('risk_level', 'critical')->count() > 0)
                            <div class="border-l-4 border-red-500 pl-6 bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl">
                                <div class="flex items-center mb-4">
                                    <span class="text-2xl mr-3">🚨</span>
                                    <h4 class="font-bold text-red-800 text-lg">Critical Risk Response</h4>
                                </div>
                                <div class="bg-red-200 text-red-800 px-3 py-1 rounded-full text-xs font-bold mb-4 inline-block">
                                    &lt;60 TRANSMUTED GRADE
                                </div>
                                <ul class="text-sm text-gray-700 space-y-3 font-medium">
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2 font-bold">1.</span>
                                        <div>
                                            <strong>Immediate 1-on-1 intervention</strong>
                                            <div class="text-xs text-gray-600 mt-1">Schedule within 48 hours</div>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2 font-bold">2.</span>
                                        <div>
                                            <strong>Parent/guardian conference</strong>
                                            <div class="text-xs text-gray-600 mt-1">Urgent communication required</div>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2 font-bold">3.</span>
                                        <div>
                                            <strong>Individual learning plan</strong>
                                            <div class="text-xs text-gray-600 mt-1">Focus on foundational skills</div>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2 font-bold">4.</span>
                                        <div>
                                            <strong>Daily progress monitoring</strong>
                                            <div class="text-xs text-gray-600 mt-1">Track small improvements</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endif

                        @if($atRisk->where('risk_level', 'high')->count() > 0)
                            <div class="border-l-4 border-orange-500 pl-6 bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-xl">
                                <div class="flex items-center mb-4">
                                    <span class="text-2xl mr-3">⚠️</span>
                                    <h4 class="font-bold text-orange-800 text-lg">High Risk Support</h4>
                                </div>
                                <div class="bg-orange-200 text-orange-800 px-3 py-1 rounded-full text-xs font-bold mb-4 inline-block">
                                    60-69 TRANSMUTED GRADE
                                </div>
                                <ul class="text-sm text-gray-700 space-y-3 font-medium">
                                    <li class="flex items-start">
                                        <span class="text-orange-500 mr-2 font-bold">1.</span>
                                        <div>
                                            <strong>Intensive tutoring program</strong>
                                            <div class="text-xs text-gray-600 mt-1">3x per week minimum</div>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-orange-500 mr-2 font-bold">2.</span>
                                        <div>
                                            <strong>Small group interventions</strong>
                                            <div class="text-xs text-gray-600 mt-1">Focus on specific skill gaps</div>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-orange-500 mr-2 font-bold">3.</span>
                                        <div>
                                            <strong>Weekly progress meetings</strong>
                                            <div class="text-xs text-gray-600 mt-1">Student-teacher conferences</div>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-orange-500 mr-2 font-bold">4.</span>
                                        <div>
                                            <strong>Parent communication</strong>
                                            <div class="text-xs text-gray-600 mt-1">Bi-weekly updates</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endif

                        @if($atRisk->where('risk_level', 'moderate')->count() > 0)
                            <div class="border-l-4 border-yellow-500 pl-6 bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl">
                                <div class="flex items-center mb-4">
                                    <span class="text-2xl mr-3">📊</span>
                                    <h4 class="font-bold text-yellow-800 text-lg">Moderate Risk Prevention</h4>
                                </div>
                                <div class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold mb-4 inline-block">
                                    70-74 TRANSMUTED GRADE
                                </div>
                                <ul class="text-sm text-gray-700 space-y-3 font-medium">
                                    <li class="flex items-start">
                                        <span class="text-yellow-500 mr-2 font-bold">1.</span>
                                        <div>
                                            <strong>Enhanced study resources</strong>
                                            <div class="text-xs text-gray-600 mt-1">Additional practice materials</div>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-yellow-500 mr-2 font-bold">2.</span>
                                        <div>
                                            <strong>Peer study groups</strong>
                                            <div class="text-xs text-gray-600 mt-1">Collaborative learning</div>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-yellow-500 mr-2 font-bold">3.</span>
                                        <div>
                                            <strong>Review sessions</strong>
                                            <div class="text-xs text-gray-600 mt-1">Before major assessments</div>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-yellow-500 mr-2 font-bold">4.</span>
                                        <div>
                                            <strong>Study skills training</strong>
                                            <div class="text-xs text-gray-600 mt-1">Time management & organization</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Success Metrics -->
                    <div class="mt-8 bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                        <h4 class="font-bold text-blue-800 text-lg mb-4 flex items-center">
                            <span class="mr-2">📈</span>
                            Success Metrics & Timeline
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                            <div>
                                <div class="font-bold text-blue-700">Short Term (2-4 weeks)</div>
                                <ul class="text-gray-700 mt-2 space-y-1">
                                    <li>• 5+ point improvement in transmuted grade</li>
                                    <li>• Consistent assessment submission</li>
                                    <li>• Improved engagement metrics</li>
                                </ul>
                            </div>
                            <div>
                                <div class="font-bold text-blue-700">Medium Term (1-2 months)</div>
                                <ul class="text-gray-700 mt-2 space-y-1">
                                    <li>• Achieve 75+ transmuted grade average</li>
                                    <li>• Reduced achievement gap</li>
                                    <li>• Self-advocacy development</li>
                                </ul>
                            </div>
                            <div>
                                <div class="font-bold text-blue-700">Long Term (3+ months)</div>
                                <ul class="text-gray-700 mt-2 space-y-1">
                                    <li>• Sustained performance improvement</li>
                                    <li>• Independent learning skills</li>
                                    <li>• Academic confidence building</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Export and Action Panel -->
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-red-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600 font-medium">
                            📊 Risk analysis based on transmuted grading system
                        </div>
                        <div class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Updated: {{ now()->format('M d, Y h:i A') }}
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button onclick="window.print()"
                                class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <span class="mr-2">🖨️</span>
                            Print Report
                        </button>
                        <button onclick="exportRiskData()"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <span class="mr-2">📊</span>
                            Export Analysis
                        </button>
                        <button onclick="generateInterventionPlan()"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <span class="mr-2">🎯</span>
                            Generate Plan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Intervention Modal -->
    <div id="interventionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
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
                    <button onclick="closeInterventionModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg font-medium">
                        Close
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Scripts -->
    <script>
        // Export functionality
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
                    critical_risk: {{ $atRisk->where('risk_level', 'critical')->count() }},
                    high_risk: {{ $atRisk->where('risk_level', 'high')->count() }},
                    moderate_risk: {{ $atRisk->where('risk_level', 'moderate')->count() }},
                    safe_students: {{ $safeStudents->count() }}
                },
                risk_thresholds: {
                    critical: 'Below 60 transmuted grade',
                    high: '60-69 transmuted grade',
                    moderate: '70-74 transmuted grade',
                    safe: '75+ transmuted grade'
                },
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
        }

        // Intervention modal functions
        function showInterventionModal(studentName, riskLevel, averageTransmuted) {
            const modal = document.getElementById('interventionModal');
            const content = document.getElementById('interventionContent');
            
            let strategies = '';
            let timeline = '';
            let resources = '';
            
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
                        </ul>
                    </div>
                `;
                timeline = '48 hours to initiate, daily monitoring';
                resources = 'Counseling services, tutoring program, parent conference';
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
                        </ul>
                    </div>
                `;
                timeline = '1 week to implement, weekly reviews';
                resources = 'Tutoring program, additional practice materials';
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
                        </ul>
                    </div>
                `;
                timeline = '2 weeks to implement, bi-weekly reviews';
                resources = 'Study materials, peer study groups';
            }
            
            content.innerHTML = `
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-2">Student: ${studentName}</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Risk Level:</span>
                            <span class="ml-2 font-semibold text-${riskLevel === 'critical' ? 'red' : riskLevel === 'high' ? 'orange' : 'yellow'}-700">${riskLevel.toUpperCase()}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Current Average:</span>
                            <span class="ml-2 font-semibold">${averageTransmuted} transmuted</span>
                        </div>
                    </div>
                </div>
                
                ${strategies}
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h5 class="font-bold text-blue-800 mb-2">Timeline</h5>
                        <p class="text-sm text-gray-700">${timeline}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h5 class="font-bold text-green-800 mb-2">Resources Needed</h5>
                        <p class="text-sm text-gray-700">${resources}</p>
                    </div>
                </div>
                
            `;
            
            modal.classList.remove('hidden');
        }

        function closeInterventionModal() {
            document.getElementById('interventionModal').classList.add('hidden');
        }

        function saveInterventionPlan() {
            const notes = document.getElementById('interventionNotes').value;
            // Here you would typically send this to your backend
            alert('Intervention plan saved! (This would integrate with your backend system)');
            closeInterventionModal();
        }

        function generateInterventionPlan() {
            const atRiskCount = {{ $atRisk->count() }};
            if (atRiskCount === 0) {
                alert('No students currently at risk. All students are performing well!');
                return;
            }
            
            const planData = {
                generated_date: new Date().toISOString(),
                total_at_risk: atRiskCount,
                risk_breakdown: {
                    critical: {{ $atRisk->where('risk_level', 'critical')->count() }},
                    high: {{ $atRisk->where('risk_level', 'high')->count() }},
                    moderate: {{ $atRisk->where('risk_level', 'moderate')->count() }}
                },
                recommended_actions: [
                    "Implement immediate interventions for critical risk students",
                    "Schedule weekly progress monitoring meetings", 
                    "Coordinate with counseling services for support",
                    "Develop individualized learning plans",
                    "Establish parent communication protocols",
                    "Monitor effectiveness of interventions monthly"
                ],
                students: @json($atRisk->values())
            };

            const dataStr = JSON.stringify(planData, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,' + encodeURIComponent(dataStr);
            const exportFileDefaultName = 'intervention-plan-' + new Date().toISOString().split('T')[0] + '.json';

            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
        }

        // Auto-refresh functionality (every 10 minutes)
        setTimeout(() => {
            if (confirm('Risk data may have changed. Would you like to refresh for the latest information?')) {
                window.location.reload();
            }
        }, 10 * 60 * 1000);

        // Quick filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const subjectFilter = document.getElementById('subject_id');
            const studentFilter = document.getElementById('student_id');
            
            if (subjectFilter) {
                subjectFilter.addEventListener('change', function() {
                    if (this.value) {
                        // Auto-submit form when subject is selected
                        setTimeout(() => {
                            this.closest('form').submit();
                        }, 100);
                    }
                });
            }
        });
    </script>
</x-app-layout>