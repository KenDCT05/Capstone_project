<x-app-layout>
    <div class="py-8 min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-red-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Enhanced Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2c2.21 0 4 1.79 4 4 0 2.21-1.79 4-4 4s-4-1.79-4-4c0-2.21 1.79-4 4-4zM21 9v3l-2-1.5V9c-2.25 0-4-1.75-4-4h2c0 1.25 1.75 2 4 2zM7 9c2.25 0 4-1.75 4-4H9c0 1.25-1.75 2-4 2v1.5L3 12v-3zM16.5 16.5l1-1.5c-.5-.5-1.5-.5-2 0-.5.5-.5 1.5 0 2 .5.5 1.5.5 2 0z"/>
                        </svg>
                        Performance Insights – {{ $student->name }}
                    </h1>
                    <p class="text-red-100 mt-2">Comprehensive Student Performance Analysis with Transmuted Grades</p>
                </div>
                <div class="px-8 py-6 flex flex-wrap items-center justify-between gap-4">
                    <a href="{{ route('analytics.dashboard') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Analytics Dashboard</span>
                    </a>
                    <div class="flex gap-3">
                        <button onclick="window.print()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                            Print Report
                        </button>
                        <button onclick="exportStudentData()" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                            Export Data
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Student Overview Card -->
            <div class="bg-gradient-to-br from-red-500 via-red-600 to-red-700 text-white rounded-2xl shadow-xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full -mr-24 -mt-24"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-5 rounded-full -ml-16 -mb-16"></div>
                <div class="relative">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                        <div class="flex items-center space-x-6">
                            <div class="bg-white bg-opacity-20 rounded-2xl p-6 backdrop-blur-sm">
                                <div class="w-16 h-16 bg-white bg-opacity-30 rounded-xl flex items-center justify-center text-3xl">
                                    👨‍🎓
                                </div>
                            </div>
                            <div>
                                <h3 class="text-4xl font-black mb-2">{{ $student->name }}</h3>
                                <div class="flex flex-wrap gap-3 items-center">
                                    @if($student->grade_level && $student->section)
                                        <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full text-red-100 font-medium">
                                            Grade {{ $student->grade_level }} - Section {{ $student->section }}
                                        </span>
                                    @endif
                                    <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full text-red-100 font-medium">
                                        {{ $overallStats['total_subjects'] }} Subject(s)
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center lg:text-right">
                            <div class="flex items-baseline gap-2 justify-center lg:justify-end mb-2">
                                <div class="text-6xl font-black">{{ $overallStats['overall_average_transmuted'] }}</div>
                                <div class="text-2xl font-bold opacity-80">
                                    @if($overallStats['overall_average_transmuted'] >= 96)
                                        🏆
                                    @elseif($overallStats['overall_average_transmuted'] >= 92)
                                        ⭐
                                    @elseif($overallStats['overall_average_transmuted'] >= 84)
                                        👍
                                    @elseif($overallStats['overall_average_transmuted'] >= 75)
                                        📚
                                    @elseif($overallStats['overall_average_transmuted'] >= 60)
                                        ✅
                                    @else
                                        ❌
                                    @endif
                                </div>
                            </div>
                            <div class="text-red-100 text-lg font-medium mb-3">Overall Average Transmuted</div>
                            <div class="flex gap-4 justify-center lg:justify-end text-sm">
                                <div class="text-center">
                                    <div class="text-2xl font-bold">{{ $overallStats['overall_average_percentage'] }}%</div>
                                    <div class="text-red-200 opacity-80">Raw Average</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold">
                                        @if($overallStats['overall_average_transmuted'] >= 96)
                                            Excellent
                                        @elseif($overallStats['overall_average_transmuted'] >= 92)
                                            Very Good
                                        @elseif($overallStats['overall_average_transmuted'] >= 84)
                                            Good
                                        @elseif($overallStats['overall_average_transmuted'] >= 75)
                                            Fair
                                        @elseif($overallStats['overall_average_transmuted'] >= 60)
                                            Passed
                                        @else
                                            Failed
                                        @endif
                                    </div>
                                    <div class="text-red-200 opacity-80">Performance</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Quick Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="group bg-white p-8 rounded-2xl shadow-xl border-l-4 border-red-500 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-red-50 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium uppercase tracking-wider mb-2">Subjects Enrolled</p>
                            <p class="text-5xl font-black text-gray-900">{{ $overallStats['total_subjects'] }}</p>
                            <p class="text-gray-500 text-xs mt-1">Active subjects</p>
                        </div>
                        <div class="text-5xl opacity-60 group-hover:scale-110 group-hover:opacity-80 transition-all duration-300">📚</div>
                    </div>
                </div>

                <div class="group bg-white p-8 rounded-2xl shadow-xl border-l-4 border-green-500 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium uppercase tracking-wider mb-2">Strengths</p>
                            <p class="text-5xl font-black text-gray-900">{{ count($overallStats['strengths']) }}</p>
                            <p class="text-gray-500 text-xs mt-1">90+ transmuted avg</p>
                        </div>
                        <div class="text-5xl opacity-60 group-hover:scale-110 group-hover:opacity-80 transition-all duration-300">💪</div>
                    </div>
                </div>

                <div class="group bg-white p-8 rounded-2xl shadow-xl border-l-4 border-orange-500 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-orange-50 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium uppercase tracking-wider mb-2">Needs Support</p>
                            <p class="text-5xl font-black text-gray-900">{{ count($overallStats['needs_improvement']) }}</p>
                            <p class="text-gray-500 text-xs mt-1">&lt;75 transmuted avg</p>
                        </div>
                        <div class="text-5xl opacity-60 group-hover:scale-110 group-hover:opacity-80 transition-all duration-300">📈</div>
                    </div>
                </div>

                <div class="group bg-white p-8 rounded-2xl shadow-xl border-l-4 border-purple-500 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-purple-50 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium uppercase tracking-wider mb-2">Grade Range</p>
                            <p class="text-3xl font-black text-gray-900">
                                @if($overallStats['overall_average_transmuted'] >= 96)
                                    A+ - A-
                                @elseif($overallStats['overall_average_transmuted'] >= 92)
                                    B+ - B
                                @elseif($overallStats['overall_average_transmuted'] >= 84)
                                    B- - C+
                                @elseif($overallStats['overall_average_transmuted'] >= 75)
                                    C - C-
                                @elseif($overallStats['overall_average_transmuted'] >= 60)
                                    D+ - D-
                                @else
                                    E - F
                                @endif
                            </p>
                            <p class="text-gray-500 text-xs mt-1">Letter grade</p>
                        </div>
                        <div class="text-5xl opacity-60 group-hover:scale-110 group-hover:opacity-80 transition-all duration-300">
                            @if($overallStats['overall_average_transmuted'] >= 96)
                                🏆
                            @elseif($overallStats['overall_average_transmuted'] >= 92)
                                ⭐
                            @elseif($overallStats['overall_average_transmuted'] >= 84)
                                👍
                            @elseif($overallStats['overall_average_transmuted'] >= 75)
                                📚
                            @elseif($overallStats['overall_average_transmuted'] >= 60)
                                ✅
                            @else
                                ❌
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Strengths and Areas for Improvement -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Strengths -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-green-100 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-2xl text-gray-800 flex items-center">
                            <span class="text-green-500 mr-3 text-2xl">💪</span>
                            Strong Subjects
                        </h3>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">
                            {{ count($overallStats['strengths']) }} subject(s)
                        </span>
                    </div>
                    @if(!empty($overallStats['strengths']))
                        <div class="space-y-4">
                            @foreach($overallStats['strengths'] as $strength)
                                <div class="flex items-center justify-between bg-green-50 p-4 rounded-xl border border-green-200">
                                    <div class="flex items-center">
                                        <span class="text-green-500 mr-3 text-xl">✓</span>
                                        <span class="font-semibold text-green-800">{{ $strength }}</span>
                                    </div>
                                    <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-bold">
                                        90+ Transmuted
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 p-4 bg-green-50 rounded-xl border-l-4 border-green-400">
                            <p class="text-green-700 font-medium text-sm">
                                🎯 <strong>Recommendation:</strong> Use these strong subjects as confidence builders and consider peer tutoring opportunities.
                            </p>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🎯</div>
                            <p class="text-gray-500 italic text-lg">No subjects with 90+ transmuted average yet.</p>
                            <p class="text-gray-400 text-sm mt-2">Keep working towards excellence!</p>
                        </div>
                    @endif
                </div>

                <!-- Areas for Improvement -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-2xl text-gray-800 flex items-center">
                            <span class="text-red-500 mr-3 text-2xl">📈</span>
                            Focus Areas
                        </h3>
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-bold">
                            {{ count($overallStats['needs_improvement']) }} subject(s)
                        </span>
                    </div>
                    @if(!empty($overallStats['needs_improvement']))
                        <div class="space-y-4">
                            @foreach($overallStats['needs_improvement'] as $improvement)
                                <div class="flex items-center justify-between bg-red-50 p-4 rounded-xl border border-red-200">
                                    <div class="flex items-center">
                                        <span class="text-red-500 mr-3 text-xl">⚠️</span>
                                        <span class="font-semibold text-red-800">{{ $improvement }}</span>
                                    </div>
                                    <span class="bg-red-200 text-red-800 px-3 py-1 rounded-full text-xs font-bold">
                                        &lt;75 Transmuted
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 p-4 bg-red-50 rounded-xl border-l-4 border-red-400">
                            <p class="text-red-700 font-medium text-sm">
                                🚨 <strong>Action Needed:</strong> These subjects require immediate attention and additional support to reach passing grade.
                            </p>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🎉</div>
                            <p class="text-gray-500 italic text-lg">All subjects above 75 transmuted - Excellent work!</p>
                            <p class="text-gray-400 text-sm mt-2">Keep maintaining this great performance.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Subject Performance Details -->
            @if(!empty($studentPerformance))
                @foreach($studentPerformance as $subjectName => $performance)
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-red-100 hover:shadow-2xl transition-all duration-300">
                        <!-- Subject Header -->
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 space-y-4 lg:space-y-0">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-800 mb-2">{{ $subjectName }}</h3>
                                <div class="flex flex-wrap gap-2">
                                    <span class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                        {{ $performance['total_assessments'] }} assessments completed
                                    </span>
                                    <span class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                        Range: {{ $performance['lowest_transmuted'] }} - {{ $performance['highest_transmuted'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold shadow-md
                                    {{ $performance['overall_average_transmuted'] >= 96 ? 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 border border-purple-300' : 
                                       ($performance['overall_average_transmuted'] >= 92 ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300' : 
                                        ($performance['overall_average_transmuted'] >= 84 ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300' : 
                                         ($performance['overall_average_transmuted'] >= 75 ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300' : 
                                          ($performance['overall_average_transmuted'] >= 60 ? 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 border border-orange-300' : 'bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300')))) }}">
                                    {{ $performance['overall_average_transmuted'] }} Transmuted
                                </span>
                                <span class="text-sm text-gray-600 bg-gray-100 px-3 py-2 rounded-full">
                                    {{ $performance['overall_average_percentage'] }}% Raw Average
                                </span>
                            </div>
                        </div>

                        <!-- Enhanced Subject Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 hover:shadow-md transition-shadow duration-200">
                                <div class="text-4xl font-black text-green-600 mb-2">{{ $performance['highest_transmuted'] }}</div>
                                <div class="text-sm text-gray-600 font-medium">Highest Transmuted</div>
                                <div class="text-xs text-green-600 mt-1 font-semibold">Peak Performance</div>
                            </div>
                            <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 hover:shadow-md transition-shadow duration-200">
                                <div class="text-4xl font-black text-blue-600 mb-2">{{ $performance['overall_average_transmuted'] }}</div>
                                <div class="text-sm text-gray-600 font-medium">Average Transmuted</div>
                                <div class="text-xs text-blue-600 mt-1 font-semibold">Overall Performance</div>
                            </div>
                            <div class="text-center p-6 bg-gradient-to-br from-red-50 to-red-100 rounded-xl border border-red-200 hover:shadow-md transition-shadow duration-200">
                                <div class="text-4xl font-black text-red-600 mb-2">{{ $performance['lowest_transmuted'] }}</div>
                                <div class="text-sm text-gray-600 font-medium">Lowest Transmuted</div>
                                <div class="text-xs text-red-600 mt-1 font-semibold">Needs Attention</div>
                            </div>
                        </div>

                        <!-- Enhanced Performance Distribution -->
                        @if(isset($performance['performance_distribution']) && $performance['performance_distribution']->isNotEmpty())
                            <div class="mb-8 p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                                <h4 class="font-bold text-xl text-gray-800 mb-6">Performance Distribution Analysis</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-4">
                                    @foreach(['Excellent', 'Very Good', 'Good', 'Fair', 'Passed', 'Failed'] as $level)
                                        @php
                                            $count = $performance['performance_distribution'][$level] ?? 0;
                                            $colors = [
                                                'Excellent' => ['bg' => 'purple', 'text' => 'purple', 'emoji' => '🏆'],
                                                'Very Good' => ['bg' => 'blue', 'text' => 'blue', 'emoji' => '⭐'], 
                                                'Good' => ['bg' => 'green', 'text' => 'green', 'emoji' => '👍'],
                                                'Fair' => ['bg' => 'yellow', 'text' => 'yellow', 'emoji' => '📚'],
                                                'Passed' => ['bg' => 'orange', 'text' => 'orange', 'emoji' => '✅'],
                                                'Failed' => ['bg' => 'red', 'text' => 'red', 'emoji' => '❌']
                                            ];
                                            $color = $colors[$level];
                                        @endphp
                                        <div class="text-center p-4 bg-{{ $color['bg'] }}-50 border-2 border-{{ $color['bg'] }}-200 rounded-xl hover:shadow-md transition-shadow duration-200">
                                            <div class="text-2xl mb-2">{{ $color['emoji'] }}</div>
                                            <div class="text-3xl font-black text-{{ $color['text'] }}-700 mb-1">{{ $count }}</div>
                                            <div class="text-xs text-gray-600 font-medium">{{ $level }}</div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-center text-sm text-gray-600 font-medium">
                                    Total: {{ $performance['performance_distribution']->sum() }} assessments completed
                                </div>
                            </div>
                        @endif

                        <!-- Enhanced Performance Chart -->
                        <div class="mb-8">
                            <h4 class="font-bold text-xl text-gray-800 mb-4">Assessment Progress Tracking</h4>
                            <div class="relative h-96 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                                <canvas id="chart-{{ $performance['subject_id'] }}"></canvas>
                            </div>
                        </div>

                        <!-- Enhanced Assessment Details Table -->
                        <div class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                                <h4 class="font-bold text-xl text-gray-800">Detailed Assessment Breakdown</h4>
                                <p class="text-sm text-gray-600 mt-1">Complete performance history for {{ $subjectName }}</p>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full table-auto text-sm">
                                    <thead class="bg-gradient-to-r from-red-500 to-red-600 text-white">
                                        <tr>
                                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Assessment</th>
                                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Score</th>
                                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Raw %</th>
                                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Transmuted</th>
                                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Letter</th>
                                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Performance</th>
                                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($performance['assessments'] as $assessment)
                                            <tr class="hover:bg-red-50 transition-all duration-200 group">
                                                <td class="px-6 py-4 font-bold text-gray-900 group-hover:text-red-700">
                                                    {{ $assessment['column_name'] }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="font-medium text-gray-700">{{ $assessment['score'] }}</span>
                                                    <span class="text-gray-400 text-xs">/ {{ $assessment['max_score'] }}</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm
                                                        {{ $assessment['percentage'] >= 90 ? 'bg-green-100 text-green-800 border border-green-200' : 
                                                           ($assessment['percentage'] >= 80 ? 'bg-blue-100 text-blue-800 border border-blue-200' : 
                                                            ($assessment['percentage'] >= 70 ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 'bg-red-100 text-red-800 border border-red-200')) }}">
                                                        {{ $assessment['percentage'] }}%
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow-md
                                                        {{ $assessment['transmuted_grade'] >= 96 ? 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 border border-purple-300' : 
                                                           ($assessment['transmuted_grade'] >= 92 ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300' : 
                                                            ($assessment['transmuted_grade'] >= 84 ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300' : 
                                                             ($assessment['transmuted_grade'] >= 75 ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300' : 
                                                              ($assessment['transmuted_grade'] >= 60 ? 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 border border-orange-300' : 'bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300')))) }}">
                                                        {{ $assessment['transmuted_grade'] }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="font-mono text-sm font-bold text-gray-700 bg-gray-100 px-2 py-1 rounded">
                                                        {{ $assessment['letter_grade'] ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        @if($assessment['performance'] === 'Excellent')
                                                            <span class="w-3 h-3 bg-purple-500 rounded-full mr-2"></span>
                                                            <span class="font-bold text-purple-700">{{ $assessment['performance'] }}</span>
                                                        @elseif($assessment['performance'] === 'Very Good')
                                                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                                            <span class="font-bold text-blue-700">{{ $assessment['performance'] }}</span>
                                                        @elseif($assessment['performance'] === 'Good')
                                                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                                            <span class="font-bold text-green-700">{{ $assessment['performance'] }}</span>
                                                        @elseif($assessment['performance'] === 'Fair')
                                                            <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                                                            <span class="font-bold text-yellow-700">{{ $assessment['performance'] }}</span>
                                                        @elseif($assessment['performance'] === 'Passed')
                                                            <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                                                            <span class="font-bold text-orange-700">{{ $assessment['performance'] }}</span>
                                                        @else
                                                            <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                                            <span class="font-bold text-red-700">{{ $assessment['performance'] }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-gray-600 font-medium">
                                                    {{ $assessment['date'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Performance Recommendations -->
                @if(!empty($studentPerformance))
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-blue-100">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="text-blue-500 mr-3 text-2xl">💡</span>
                            Personalized Recommendations
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Academic Recommendations -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                                <h4 class="font-bold text-blue-800 text-lg mb-4">Academic Development</h4>
                                <ul class="space-y-3 text-sm">
                                    @if($overallStats['overall_average_transmuted'] >= 96)
                                        <li class="flex items-start">
                                            <span class="text-blue-500 mr-2 mt-1">•</span>
                                            <span class="text-gray-700">Continue maintaining excellent performance across all subjects</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-blue-500 mr-2 mt-1">•</span>
                                            <span class="text-gray-700">Consider advanced or enrichment activities</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-blue-500 mr-2 mt-1">•</span>
                                            <span class="text-gray-700">Explore leadership opportunities in academic activities</span>
                                        </li>
                                    @elseif($overallStats['overall_average_transmuted'] >= 84)
                                        <li class="flex items-start">
                                            <span class="text-blue-500 mr-2 mt-1">•</span>
                                            <span class="text-gray-700">Focus on consistency to achieve excellence</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-blue-500 mr-2 mt-1">•</span>
                                            <span class="text-gray-700">Target improvement in weaker assessment areas</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-blue-500 mr-2 mt-1">•</span>
                                            <span class="text-gray-700">Participate in study groups for peer learning</span>
                                        </li>
                                    @else
                                        <li class="flex items-start">
                                            <span class="text-blue-500 mr-2 mt-1">•</span>
                                            <span class="text-gray-700">Prioritize subjects below 75 transmuted grade</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-blue-500 mr-2 mt-1">•</span>
                                            <span class="text-gray-700">Seek additional help or tutoring in challenging areas</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-blue-500 mr-2 mt-1">•</span>
                                            <span class="text-gray-700">Develop better study habits and time management</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <!-- Study Strategy Recommendations -->
                            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                                <h4 class="font-bold text-green-800 text-lg mb-4">Study Strategies</h4>
                                <ul class="space-y-3 text-sm">
                                    <li class="flex items-start">
                                        <span class="text-green-500 mr-2 mt-1">•</span>
                                        <span class="text-gray-700">Review performance patterns to identify peak learning times</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-green-500 mr-2 mt-1">•</span>
                                        <span class="text-gray-700">Use strengths in {{ !empty($overallStats['strengths']) ? $overallStats['strengths'][0] : 'strong subjects' }} to build confidence</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-green-500 mr-2 mt-1">•</span>
                                        <span class="text-gray-700">Create study schedule focusing on challenging subjects</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-green-500 mr-2 mt-1">•</span>
                                        <span class="text-gray-700">Practice active recall and spaced repetition techniques</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-gradient-to-br from-red-50 to-red-100 border-2 border-dashed border-red-300 rounded-2xl p-12 text-center shadow-lg">
                    <div class="text-red-600">
                        <div class="text-8xl mb-6">📊</div>
                        <h3 class="font-bold text-3xl mb-4">No Performance Data Available</h3>
                        <p class="text-xl mb-4">This student hasn't taken any assessments yet in your subjects.</p>
                        <div class="bg-red-100 rounded-xl p-4 text-left max-w-md mx-auto">
                            <h4 class="font-bold text-red-800 mb-2">Next Steps:</h4>
                            <ul class="text-red-700 text-sm space-y-1">
                                <li>• Ensure student is enrolled in your subjects</li>
                                <li>• Create and assign initial assessments</li>
                                <li>• Check if scores have been properly recorded</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Scripts -->
    @if(!empty($studentPerformance))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Export functionality
            window.exportStudentData = function() {
                const studentData = {
                    student_name: '{{ $student->name }}',
                    export_date: new Date().toISOString(),
                    overall_stats: @json($overallStats),
                    subjects: @json($studentPerformance)
                };

                const dataStr = JSON.stringify(studentData, null, 2);
                const dataUri = 'data:application/json;charset=utf-8,' + encodeURIComponent(dataStr);
                const exportFileDefaultName = 'student-insights-{{ strtolower(str_replace(" ", "-", $student->name)) }}-' + new Date().toISOString().split('T')[0] + '.json';

                const linkElement = document.createElement('a');
                linkElement.setAttribute('href', dataUri);
                linkElement.setAttribute('download', exportFileDefaultName);
                linkElement.click();
            };

            // Chart configurations
            @foreach($studentPerformance as $subjectName => $performance)
                new Chart(document.getElementById('chart-{{ $performance['subject_id'] }}'), {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($performance['assessments']->pluck('column_name')->toArray()) !!},
                        datasets: [
                            {
                                label: 'Transmuted Grade',
                                data: {!! json_encode($performance['assessments']->pluck('transmuted_grade')->toArray()) !!},
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#ef4444',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 3,
                                pointRadius: 6,
                                pointHoverRadius: 10,
                                borderWidth: 3,
                                pointHoverBackgroundColor: '#dc2626'
                            },
                            {
                                label: 'Raw Percentage',
                                data: {!! json_encode($performance['assessments']->pluck('percentage')->toArray()) !!},
                                borderColor: '#9333ea',
                                backgroundColor: 'rgba(147, 51, 234, 0.05)',
                                fill: false,
                                tension: 0.4,
                                pointBackgroundColor: '#9333ea',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 8,
                                borderWidth: 2,
                                borderDash: [8, 4],
                                pointHoverBackgroundColor: '#7c3aed'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        weight: 'bold',
                                        size: 13
                                    },
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 13 },
                                cornerRadius: 8,
                                displayColors: true,
                                callbacks: {
                                    title: function(context) {
                                        return context[0].label;
                                    },
                                    label: function(context) {
                                        if (context.datasetIndex === 0) {
                                            return 'Transmuted Grade: ' + context.parsed.y;
                                        } else {
                                            return 'Raw Percentage: ' + context.parsed.y + '%';
                                        }
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: Math.min(60, Math.min(...{!! json_encode($performance['assessments']->pluck('transmuted_grade')->toArray()) !!}) - 5),
                                max: 100,
                                grid: {
                                    color: 'rgba(239, 68, 68, 0.1)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: 'rgb(75, 85, 99)',
                                    font: {
                                        weight: 'bold',
                                        size: 11
                                    },
                                    padding: 8
                                },
                                title: {
                                    display: true,
                                    text: 'Grade',
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    },
                                    color: 'rgb(75, 85, 99)'
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(239, 68, 68, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    maxRotation: 45,
                                    color: 'rgb(75, 85, 99)',
                                    font: {
                                        weight: 'bold',
                                        size: 10
                                    },
                                    padding: 8
                                },
                                title: {
                                    display: true,
                                    text: 'Assessments',
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    },
                                    color: 'rgb(75, 85, 99)'
                                }
                            }
                        },
                        elements: {
                            point: {
                                hoverBackgroundColor: '#dc2626',
                                hoverBorderWidth: 4
                            }
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            @endforeach
        </script>
    @endif
</x-app-layout>