<x-app-layout>
    <div class="py-8 min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-red-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!--  Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                        </svg>
                        Analytics Dashboard
                    </h1>
                    <p class="text-red-100 mt-2">View Analytics of Grades</p>
                </div>
                <div class="px-8 py-6">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                </div>
            </div>

            @if($subjects->isEmpty())
                <div class="bg-gradient-to-br from-red-50 to-red-100 border-l-4 border-red-400 rounded-xl p-8 text-center shadow-lg">
                    <div class="text-red-800">
                        <div class="text-6xl mb-4">🎯</div>
                        <h3 class="font-bold text-2xl mb-3">No Subjects Available</h3>
                        <p class="text-lg">You haven't created any subjects yet. Create a subject first to view analytics.</p>
                    </div>
                </div>
            @else
                <!--  Subject Selector & Quick Stats with Student Filter -->
                <div class="bg-white shadow-xl rounded-2xl p-8 border border-red-100">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between space-y-6 lg:space-y-0 lg:space-x-8">
                        <!-- Subject and Student Filters -->
                        <div class="flex-1 space-y-6">
                            <form method="GET" action="{{ route('analytics.dashboard') }}" id="filterForm" class="space-y-4">
                                <!-- Subject Filter -->
                                <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                    <label class="font-bold text-xl text-gray-800 flex items-center min-w-fit">
                                        <span class="mr-2">🎯</span>
                                        Select Subject:
                                    </label>
                                    <select name="subject_id" onchange="document.getElementById('filterForm').submit()" 
                                            class="flex-1 border-2 border-red-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-red-200 focus:border-red-500 transition-all duration-300 bg-white shadow-md text-lg font-medium">
                                        <option value="">-- Choose a Subject --</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if($selectedSubject && $students->isNotEmpty())
                                    <!-- Student Filter -->
                                    <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                        <label class="font-bold text-lg text-gray-800 flex items-center min-w-fit">
                                            <span class="mr-2">👤</span>
                                            Filter by Student:
                                        </label>
                                        <select name="student_id" onchange="document.getElementById('filterForm').submit()" 
                                                class="flex-1 border-2 border-blue-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 bg-white shadow-md text-base font-medium">
                                            <option value="">All Students ({{ $students->count() }} total)</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" {{ $selectedStudent == $student->id ? 'selected' : '' }}>
                                                    {{ $student->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if($selectedStudent)
                                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                                        <span class="text-white font-bold text-lg">{{ substr($students->firstWhere('id', $selectedStudent)->name ?? 'U', 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-bold text-lg text-blue-800">
                                                            Viewing: {{ $students->firstWhere('id', $selectedStudent)->name ?? 'Selected Student' }}
                                                        </h4>
                                                        <p class="text-blue-600 text-sm">All analytics below are filtered for this student only</p>
                                                    </div>
                                                </div>
                                                <a href="{{ route('analytics.insights', $selectedStudent) }}" 
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                                    View Full Report
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </form>
                        </div>

                        @if($selectedSubject)

                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('analytics.subject-comparison') }}" 
                            class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold flex items-center">
                                Compare Subjects
                            </a>

                            <a href="{{ route('analytics.risk-alerts') }}" 
                            class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold flex items-center">
                                Risk Alerts
                            </a>

                            <a href="{{ route('analytics.engagement') }}" 
                            class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold flex items-center">
                                Engagement
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                @if($selectedSubject)
                    <!--  Key Metrics Cards with Transmuted Grades -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                        <!-- Total Assessments (excluding attendance) -->
                        <div class="group bg-gradient-to-br from-red-500 via-red-600 to-red-700 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-6xl opacity-80 group-hover:scale-110 transition-transform duration-300">📝</div>
                                    <div class="text-right">
                                        <p class="text-red-100 text-sm font-medium uppercase tracking-wider">
                                            {{ $selectedStudent ? 'Student Submissions' : 'Total Assessments' }}
                                        </p>
                                        <p class="text-4xl font-black mt-2">{{ $selectedStudent ? array_sum($distribution) : $totalAssessments }}</p>
                                    </div>
                                </div>
                                <div class="h-1 bg-red-400 rounded-full"></div>
                    
                                    <p class="text-red-200 text-xs mt-2 opacity-75">Excluding attendance</p>
                               
                            </div>
                        </div>

                        <!-- Average Transmuted Grade -->
                        <div class="group bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-6xl opacity-80 group-hover:scale-110 transition-transform duration-300">🏆</div>
                                    <div class="text-right">
                                        <p class="text-emerald-100 text-sm font-medium uppercase tracking-wider">
                                            {{ $selectedStudent ? 'Student Average' : 'Class Average' }}
                                        </p>
                                        <p class="text-4xl font-black mt-2">{{ $subjectAverages[$selectedSubject] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <br>
                                <div class="h-1 bg-emerald-400 rounded-full"></div>
                                <p class="text-emerald-200 text-xs mt-2 opacity-75">Transmuted Grade</p>
                            </div>
                        </div>

                        <!-- Excellent Performers -->
                        <div class="group bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-6xl opacity-80 group-hover:scale-110 transition-transform duration-300">⭐</div>
                                    <div class="text-right">
                                        <p class="text-purple-100 text-sm font-medium uppercase tracking-wider">Excellent</p>
                                        <p class="text-4xl font-black mt-2">{{ $distribution['excellent'] }}</p>
                                    </div>
                                </div>
                                <br>
                                <div class="h-1 bg-purple-400 rounded-full"></div>
                                <p class="text-purple-200 text-xs mt-2 opacity-75">96+ Percentage</p>
                            </div>
                        </div>

                        <!-- Failed Students -->
                        <div class="group bg-gradient-to-br from-rose-500 via-rose-600 to-rose-700 text-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-6xl opacity-80 group-hover:scale-110 transition-transform duration-300">❌</div>
                                    <div class="text-right">
                                        <p class="text-rose-100 text-sm font-medium uppercase tracking-wider">Failed</p>
                                        <p class="text-4xl font-black mt-2">{{ $distribution['failed'] }}</p>
                                    </div>
                                </div>
                                <br>
                                <div class="h-1 bg-rose-400 rounded-full"></div>
                                <p class="text-rose-200 text-xs mt-2 opacity-75">&lt;75 Percentage</p>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row 1 -->
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Performance Distribution with Transmuted Categories -->
                        <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="font-bold text-2xl text-gray-800 flex items-center">
                                    <span class="mr-3 text-2xl">📊</span>
                                    Performance Distribution
                                </h3>
                                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-2 rounded-full font-medium">
                                    {{ $selectedStudent ? 'Student Performance' : 'Class Performance' }}
                                </span>
                            </div>
                            <div class="relative h-80 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4">
                                <canvas id="distributionChart"></canvas>
                            </div>
                        </div>

                        <!-- Subject Averages with Transmuted Grades -->
                        <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="font-bold text-2xl text-gray-800 flex items-center">
                                    <span class="mr-3 text-2xl">📈</span>
                                    {{ $selectedStudent ? 'Student vs Subjects' : 'Subject Comparison' }}
                                </h3>
                                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-2 rounded-full font-medium">Subject Average</span>
                            </div>
                            <div class="relative h-80 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4">
                                <canvas id="avgChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!--  Charts Row 2 -->
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Progress Over Time with Transmuted Grades -->
                        <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="font-bold text-2xl text-gray-800 flex items-center">
                                    <span class="mr-3 text-2xl">📈</span>
                                    {{ $selectedStudent ? 'Student Progress' : 'Progress Trend' }}
                                </h3>
                                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-2 rounded-full font-medium">Daily Average</span>
                            </div>
                            <div class="relative h-80 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4">
                                <canvas id="progressChart"></canvas>
                            </div>
                        </div>

                        <!-- Assessment Difficulty with Transmuted Performance -->
                        <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="font-bold text-2xl text-gray-800 flex items-center">
                                    <span class="mr-3 text-2xl">📋</span>
                                    Assessment Performance
                                </h3>
                                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-2 rounded-full font-medium">
                                    {{ $selectedStudent ? 'Student performance' : 'Average Assessments' }}
                                </span>
                            </div>
                            <div class="relative h-80 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4">
                                <canvas id="columnChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Assessment Performance Table -->
@if($columnPerformance->isNotEmpty())
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-8 space-y-4 lg:space-y-0">
            <h3 class="font-bold text-2xl text-gray-800 flex items-center">
                <span class="mr-3 text-2xl">📋</span>
                Assessment Performance Details
                @if($selectedStudent)
                    <span class="ml-3 text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-normal">
                        For: {{ $students->firstWhere('id', $selectedStudent)->name ?? 'Selected Student' }}
                    </span>
                @endif
            </h3>

            @if($selectedStudent)
                <div class="flex items-center space-x-3">
                    <a href="{{ route('analytics.dashboard', ['subject_id' => $selectedSubject]) }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                        Clear Filter
                    </a>
                    <a href="{{ route('analytics.insights', $selectedStudent) }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                        Detailed Report
                    </a>
                </div>
            @endif
        </div>
       
        <div class="overflow-x-auto bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4">
            <table class="w-full table-auto">
                <thead class="bg-gradient-to-r from-red-500 to-red-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider rounded-tl-xl">Assessment</th>
                        <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Avg Transmuted</th>
                        <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Avg Percentage</th>
                        <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                            {{ $selectedStudent ? 'Score Count' : 'Students' }}
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Performance Level</th>
                        <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider rounded-tr-xl">Max Points</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-red-100">
                    @foreach($columnPerformance as $performance)
                        <tr class="hover:bg-red-50 transition-all duration-200 group">
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 group-hover:text-red-700">
                                {{ $performance['column_name'] }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow-md
                                    {{ $performance['avg_transmuted'] >= 96 ? 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 border border-purple-300' : 
                                       ($performance['avg_transmuted'] >= 92 ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300' : 
                                        ($performance['avg_transmuted'] >= 88 ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300' : 
                                         ($performance['avg_transmuted'] >= 84 ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300' : 
                                          ($performance['avg_transmuted'] >= 75 ? 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 border border-orange-300' : 'bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300')))) }}">
                                    {{ $performance['avg_transmuted'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                {{ $performance['avg_percentage'] }}%
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $performance['student_count'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $dominantPerformance = $performance['dominant_performance'] ?? 'Unknown';
                                    $passed = $performance['passed_count'] ?? 0;
                                    $failed = $performance['failed_count'] ?? 0;
                                @endphp

                                {{-- Show dominant performance badge --}}
                                @if($dominantPerformance === 'Excellent')
                                    <span class="text-purple-700 font-bold flex items-center mb-1">
                                        <span class="mr-2 text-lg">🏆</span> Excellent
                                    </span>
                                @elseif($dominantPerformance === 'Very Good')
                                    <span class="text-blue-700 font-bold flex items-center mb-1">
                                        <span class="mr-2 text-lg">⭐</span> Very Good
                                    </span>
                                @elseif($dominantPerformance === 'Good')
                                    <span class="text-green-700 font-bold flex items-center mb-1">
                                        <span class="mr-2 text-lg">👍</span> Good
                                    </span>
                                @elseif($dominantPerformance === 'Fair')
                                    <span class="text-yellow-700 font-bold flex items-center mb-1">
                                        <span class="mr-2 text-lg">📚</span> Fair
                                    </span>
                                @elseif($dominantPerformance === 'Passed')
                                    <span class="text-orange-700 font-bold flex items-center mb-1">
                                        <span class="mr-2 text-lg">✅</span> Passed
                                    </span>
                                @else
                                    <span class="text-red-700 font-bold flex items-center mb-1">
                                        <span class="mr-2 text-lg">❌</span> Failed
                                    </span>
                                @endif

                                {{-- Show pass/fail counts if multiple students --}}
                                @if(!$selectedStudent)
                                    <div class="text-xs mt-1">
                                        <span class="text-green-700 font-bold">{{ $passed }} Passed</span>
                                        <span class="mx-1 text-gray-400">|</span>
                                        <span class="text-red-700 font-bold">{{ $failed }} Failed</span>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $performance['max_possible'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
                @else
                    <div class="bg-gradient-to-br from-red-50 to-red-100 border-2 border-dashed border-red-300 rounded-2xl p-12 text-center shadow-lg">
                        <div class="text-red-600">
                            <div class="text-8xl mb-6">🎯</div>
                            <h3 class="font-bold text-3xl mb-4">Select a Subject</h3>
                            <p class="text-xl">Choose a subject from the dropdown above to view detailed analytics grades.</p>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

@if($selectedSubject)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            //Doughnut Chart: Performance Distribution with 6 Categories
            new Chart(document.getElementById('distributionChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Excellent (96-100)', 'Very Good (92-95)', 'Good (88-91)', 'Fair (84-87)', 'Passed (75-83)', 'Failed (<75)'],
                    datasets: [{
                        data: [
                            {{ $distribution['excellent'] }}, 
                            {{ $distribution['very_good'] }}, 
                            {{ $distribution['good'] }}, 
                            {{ $distribution['fair'] }}, 
                            {{ $distribution['passed'] }}, 
                            {{ $distribution['failed'] }}
                        ],
                        backgroundColor: [
                            'rgba(147, 51, 234, 0.8)',  // Purple - Excellent
                            'rgba(59, 130, 246, 0.8)',   // Blue - Very Good
                            'rgba(34, 197, 94, 0.8)',    // Green - Good
                            'rgba(245, 158, 11, 0.8)',   // Yellow - Fair
                            'rgba(249, 115, 22, 0.8)',   // Orange - Passed
                            'rgba(239, 68, 68, 0.8)'     // Red - Failed
                        ],
                        borderColor: [
                            'rgb(147, 51, 234)',
                            'rgb(59, 130, 246)',
                            'rgb(34, 197, 94)',
                            'rgb(245, 158, 11)',
                            'rgb(249, 115, 22)',
                            'rgb(239, 68, 68)'
                        ],
                        borderWidth: 3,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });

            //Bar Chart: Subject Averages with Transmuted Grades
            new Chart(document.getElementById('avgChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($subjects->pluck('name')) !!},
                    datasets: [{
                        label: '{{ $selectedStudent ? "Student Average Grade" : "Average Grade" }}',
                        data: {!! json_encode(array_values($subjectAverages->toArray())) !!},
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderColor: 'rgb(220, 38, 38)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                        hoverBackgroundColor: 'rgba(220, 38, 38, 0.9)',
                        hoverBorderColor: 'rgb(185, 28, 28)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            min: 60,
                            max: 100,
                            grid: {
                                color: 'rgba(239, 68, 68, 0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value;
                                },
                                color: 'rgb(75, 85, 99)',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: 'rgb(75, 85, 99)',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });

            //Line Chart: Progress with Transmuted Grades
            new Chart(document.getElementById('progressChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($progress->keys()->toArray()) !!},
                    datasets: [{
                        label: '{{ $selectedStudent ? "Student Progress" : "Average Transmuted Grade" }}',
                        data: {!! json_encode($progress->values()->toArray()) !!},
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(239, 68, 68)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            min: 60,
                            max: 100,
                            grid: {
                                color: 'rgba(239, 68, 68, 0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value;
                                },
                                color: 'rgb(75, 85, 99)',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(239, 68, 68, 0.1)'
                            },
                            ticks: {
                                color: 'rgb(75, 85, 99)',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });

            // Enhanced Assessment Performance Chart with Transmuted Grades
new Chart(document.getElementById('columnChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($columnPerformance->pluck('column_name')->toArray()) !!},
        datasets: [{
            label: '{{ $selectedStudent ? "Student Grade" : "Average Grade" }}',
            data: {!! json_encode($columnPerformance->pluck('avg_transmuted')->toArray()) !!},
            backgroundColor: function(context) {
                const value = context.parsed.y;
                if (value >= 96) return 'rgba(147, 51, 234, 0.8)'; // Purple - Excellent
                if (value >= 92) return 'rgba(59, 130, 246, 0.8)';  // Blue - Very Good
                if (value >= 88) return 'rgba(34, 197, 94, 0.8)';   // Green - Good (updated from 84)
                if (value >= 84) return 'rgba(245, 158, 11, 0.8)';  // Yellow - Fair (updated from 75)
                if (value >= 75) return 'rgba(249, 115, 22, 0.8)';  // Orange - Passed (updated from 60)
                return 'rgba(239, 68, 68, 0.8)';                    // Red - Failed (<75)
            },
            borderColor: function(context) {
                const value = context.parsed.y;
                if (value >= 96) return 'rgb(147, 51, 234)';
                if (value >= 92) return 'rgb(59, 130, 246)';
                if (value >= 88) return 'rgb(34, 197, 94)';  
                if (value >= 84) return 'rgb(245, 158, 11)';  
                if (value >= 75) return 'rgb(249, 115, 22)';  
                return 'rgb(239, 68, 68)';
            },
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                min: 60,
                max: 100,
                grid: {
                    color: 'rgba(239, 68, 68, 0.1)'
                },
                ticks: {
                    callback: function(value) {
                        return value;
                    },
                    color: 'rgb(75, 85, 99)',
                    font: {
                        weight: 'bold'
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    maxRotation: 45,
                    color: 'rgb(75, 85, 99)',
                    font: {
                        weight: 'bold'
                    }
                }
            }
        }
    }
});
        </script>
    @endif
</x-app-layout>