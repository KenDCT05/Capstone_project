<x-app-layout>
    <div class="py-8 min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-red-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Custom Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 6V4c0-1.11.89-2 2-2s2 .89 2 2v2c1.11 0 2 .89 2 2v10c0 1.11-.89 2-2 2H4c-1.11 0-2-.89-2-2V8c0-1.11.89-2 2-2h6V4c0-1.11.89-2 2-2s2 .89 2 2v2h2z"/>
                        </svg>
                        Subject Performance Comparison - Transmuted Grades
                    </h1>
                    <p class="text-red-100 mt-2">Compare performance across all subjects using transmuted grading system</p>
                </div>
                <div class="px-8 py-6">
                    <a href="{{ route('analytics.dashboard') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Analytics Dashboard</span>
                    </a>
                </div>
            </div>

            @if($comparison->isEmpty())
                <div class="bg-gradient-to-br from-red-50 to-red-100 border-2 border-dashed border-red-300 rounded-2xl p-12 text-center shadow-lg">
                    <div class="text-red-600">
                        <div class="text-8xl mb-6">📊</div>
                        <h3 class="font-bold text-3xl mb-4">No Data Available</h3>
                        <p class="text-xl">You need to have students take assessments in your subjects to view comparison data.</p>
                    </div>
                </div>
            @else
                <!-- Performance Overview Chart -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100 hover:shadow-2xl transition-all duration-300">
                    <h3 class="font-bold text-2xl text-gray-800 mb-6 flex items-center">
                        <span class="mr-3 text-2xl">📊</span>
                        Subject Performance Overview (Transmuted vs Raw Scores)
                    </h3>
                    <div class="relative h-96 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4">
                        <canvas id="comparisonChart"></canvas>
                    </div>
                </div>

                <!-- Enhanced Detailed Comparison Table -->
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-red-100">
                    <div class="px-8 py-6 bg-gradient-to-r from-red-800 to-red-900 text-white">
                        <h3 class="text-2xl font-bold">Detailed Subject Analysis with Transmuted Grades</h3>
                        <p class="text-red-100 mt-2">Performance metrics across all your subjects using the transmuted grading system</p>
                    </div>

                    <div class="overflow-x-auto bg-gradient-to-br from-gray-50 to-gray-100 p-4">
                        <table class="w-full table-auto">
                            <thead class="bg-gradient-to-r from-red-500 to-red-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left font-bold uppercase tracking-wider rounded-tl-xl">Subject</th>
                                    <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Avg Transmuted</th>
                                    <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Avg Percentage</th>
                                    <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Students</th>
                                    <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Assessments</th>
                                    <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Transmuted Range</th>
                                    <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Passing Rate</th>
                                    <th class="px-6 py-4 text-left font-bold uppercase tracking-wider rounded-tr-xl">Performance Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-100">
                                @foreach($comparison as $subject)
                                    <tr class="hover:bg-red-50 transition-all duration-200 group">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-red-700">
                                                {{ $subject['subject_name'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow-md
                                                    @if($subject['average_transmuted'] >= 96)
                                                        bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 border border-purple-300
                                                    @elseif($subject['average_transmuted'] >= 92)
                                                        bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300
                                                    @elseif($subject['average_transmuted'] >= 84)
                                                        bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300
                                                    @elseif($subject['average_transmuted'] >= 75)
                                                        bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300
                                                    @elseif($subject['average_transmuted'] >= 60)
                                                        bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 border border-orange-300
                                                    @else
                                                        bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300
                                                    @endif
                                                ">
                                                    {{ $subject['average_transmuted'] }}
                                                </span>
                                                <div class="w-24 bg-gray-200 rounded-full h-3">
                                                    <div class="h-3 rounded-full 
                                                        @if($subject['average_transmuted'] >= 96)
                                                            bg-purple-500
                                                        @elseif($subject['average_transmuted'] >= 92)
                                                            bg-blue-500
                                                        @elseif($subject['average_transmuted'] >= 84)
                                                            bg-green-500
                                                        @elseif($subject['average_transmuted'] >= 75)
                                                            bg-yellow-500
                                                        @elseif($subject['average_transmuted'] >= 60)
                                                            bg-orange-500
                                                        @else
                                                            bg-red-500
                                                        @endif"
                                                         style="width: {{ min(100, max(0, ($subject['average_transmuted'] - 60) / 40 * 100)) }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center bg-gray-100 px-3 py-1 rounded-full font-medium text-sm">
                                                {{ $subject['average_percentage'] }}%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <span class="inline-flex items-center bg-gray-100 px-3 py-1 rounded-full font-medium">
                                                <span class="mr-1">👥</span>
                                                {{ $subject['total_students'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <span class="inline-flex items-center bg-gray-100 px-3 py-1 rounded-full font-medium">
                                                <span class="mr-1">📝</span>
                                                {{ $subject['total_assessments'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex items-center space-x-3">
                                                <span class="text-red-600 font-bold">{{ $subject['lowest_transmuted'] }}</span>
                                                <span class="text-gray-400">→</span>
                                                <span class="text-green-600 font-bold">{{ $subject['highest_transmuted'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-gray-600 font-bold">{{ round($subject['passing_rate'], 1) }}%</span>
                                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                                    <div class="h-2 rounded-full 
                                                        @if($subject['passing_rate'] >= 80)
                                                            bg-green-500
                                                        @elseif($subject['passing_rate'] >= 60)
                                                            bg-yellow-500
                                                        @else
                                                            bg-red-500
                                                        @endif"
                                                         style="width: {{ $subject['passing_rate'] }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($subject['average_transmuted'] >= 96)
                                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold bg-purple-100 text-purple-800 border border-purple-300">
                                                    🏆 Excellent
                                                </span>
                                            @elseif($subject['average_transmuted'] >= 92)
                                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold bg-blue-100 text-blue-800 border border-blue-300">
                                                    ⭐ Very Good
                                                </span>
                                            @elseif($subject['average_transmuted'] >= 84)
                                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800 border border-green-300">
                                                    👍 Good
                                                </span>
                                            @elseif($subject['average_transmuted'] >= 75)
                                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 border border-yellow-300">
                                                    📚 Fair
                                                </span>
                                            @elseif($subject['average_transmuted'] >= 60)
                                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold bg-orange-100 text-orange-800 border border-orange-300">
                                                    ✅ Passed
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold bg-red-100 text-red-800 border border-red-300">
                                                    ❌ Failed
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Enhanced Insights and Recommendations -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Best Performing Subjects -->
                    <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100 hover:shadow-2xl transition-all duration-300">
                        <h3 class="font-bold text-2xl text-gray-800 mb-6 flex items-center">
                            <span class="text-green-500 mr-3 text-2xl">🏆</span>
                            Top Performing Subjects (Transmuted Grades)
                        </h3>
                        @php
                            $topSubjects = $comparison->take(3);
                        @endphp
                        <div class="space-y-4">
                            @foreach($topSubjects as $index => $subject)
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-bold text-white">#{{ $index + 1 }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $subject['subject_name'] }}</div>
                                            <div class="text-xs text-green-600">Transmuted Avg: {{ $subject['average_transmuted'] }} | Raw: {{ $subject['average_percentage'] }}%</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-600 font-medium">{{ round($subject['passing_rate'], 1) }}% passing rate</div>
                                        <div class="text-xs text-gray-500">(≥75 transmuted)</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Subjects Needing Attention -->
                    <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100 hover:shadow-2xl transition-all duration-300">
                        <h3 class="font-bold text-2xl text-gray-800 mb-6 flex items-center">
                            <span class="text-red-500 mr-3 text-2xl">📈</span>
                            Needs Improvement (<75 Transmuted)
                        </h3>
                        @php
                            $needsImprovement = $comparison->where('average_transmuted', '<', 75)->take(3);
                        @endphp
                        @if($needsImprovement->count() > 0)
                            <div class="space-y-4">
                                @foreach($needsImprovement as $subject)
                                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-xl border border-red-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-bold text-white">!</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $subject['subject_name'] }}</div>
                                                <div class="text-xs text-red-600">Transmuted Avg: {{ $subject['average_transmuted'] }} | Raw: {{ $subject['average_percentage'] }}%</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs text-gray-600 font-medium">{{ round($subject['passing_rate'], 1) }}% passing rate</div>
                                            <div class="text-xs text-red-500">Below 75 transmuted</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-green-50 p-6 rounded-xl border border-green-200 text-center">
                                <div class="text-4xl mb-2">🎉</div>
                                <p class="text-green-700 font-medium">All subjects performing at or above 75 transmuted grade!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Performance Distribution Analysis -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100">
                    <h3 class="font-bold text-2xl text-gray-800 mb-6 flex items-center">
                        <span class="text-purple-500 mr-3 text-2xl">📊</span>
                        Overall Performance Distribution (Transmuted Grades)
                    </h3>
                    @php
                        $overallStats = [
                            'excellent' => $comparison->where('average_transmuted', '>=', 96)->count(),
                            'very_good' => $comparison->whereBetween('average_transmuted', [92, 95.99])->count(),
                            'good' => $comparison->whereBetween('average_transmuted', [84, 91.99])->count(),
                            'fair' => $comparison->whereBetween('average_transmuted', [75, 83.99])->count(),
                            'passed' => $comparison->whereBetween('average_transmuted', [60, 74.99])->count(),
                            'failed' => $comparison->where('average_transmuted', '<', 60)->count(),
                        ];
                    @endphp
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                            <div class="text-3xl font-black text-purple-600">{{ $overallStats['excellent'] }}</div>
                            <div class="text-sm text-gray-600 font-medium mt-2">Excellent</div>
                            <div class="text-xs text-purple-600">(96-100)</div>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                            <div class="text-3xl font-black text-blue-600">{{ $overallStats['very_good'] }}</div>
                            <div class="text-sm text-gray-600 font-medium mt-2">Very Good</div>
                            <div class="text-xs text-blue-600">(92-95)</div>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200">
                            <div class="text-3xl font-black text-green-600">{{ $overallStats['good'] }}</div>
                            <div class="text-sm text-gray-600 font-medium mt-2">Good</div>
                            <div class="text-xs text-green-600">(84-91)</div>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl border border-yellow-200">
                            <div class="text-3xl font-black text-yellow-600">{{ $overallStats['fair'] }}</div>
                            <div class="text-sm text-gray-600 font-medium mt-2">Fair</div>
                            <div class="text-xs text-yellow-600">(75-83)</div>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200">
                            <div class="text-3xl font-black text-orange-600">{{ $overallStats['passed'] }}</div>
                            <div class="text-sm text-gray-600 font-medium mt-2">Passed</div>
                            <div class="text-xs text-orange-600">(60-74)</div>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-red-50 to-red-100 rounded-xl border border-red-200">
                            <div class="text-3xl font-black text-red-600">{{ $overallStats['failed'] }}</div>
                            <div class="text-sm text-gray-600 font-medium mt-2">Failed</div>
                            <div class="text-xs text-red-600">(<60)</div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Action Items -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-100">
                    <h3 class="font-bold text-2xl text-gray-800 mb-6 flex items-center">
                        <span class="text-blue-500 mr-3 text-2xl">💡</span>
                        Recommended Actions (Based on Transmuted Grades)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if($comparison->where('average_transmuted', '<', 60)->count() > 0)
                            <div class="p-6 border-l-4 border-red-500 rounded-xl bg-red-50">
                                <h4 class="font-bold text-red-800 mb-3 text-lg flex items-center">
                                    <span class="mr-2">🚨</span>
                                    Critical Intervention
                                </h4>
                                <p class="text-sm text-red-700 font-medium">
                                    {{ $comparison->where('average_transmuted', '<', 60)->count() }} subject(s) with average below 60 transmuted grade need immediate, comprehensive intervention.
                                </p>
                            </div>
                        @endif

                        @if($comparison->whereBetween('average_transmuted', [60, 74])->count() > 0)
                            <div class="p-6 border-l-4 border-orange-500 rounded-xl bg-orange-50">
                                <h4 class="font-bold text-orange-800 mb-3 text-lg flex items-center">
                                    <span class="mr-2">⚠️</span>
                                    Additional Support
                                </h4>
                                <p class="text-sm text-orange-700 font-medium">
                                    {{ $comparison->whereBetween('average_transmuted', [60, 74])->count() }} subject(s) scoring 60-74 transmuted grade - provide targeted remediation and support.
                                </p>
                            </div>
                        @endif

                        @if($comparison->whereBetween('average_transmuted', [75, 83])->count() > 0)
                            <div class="p-6 border-l-4 border-yellow-500 rounded-xl bg-yellow-50">
                                <h4 class="font-bold text-yellow-800 mb-3 text-lg flex items-center">
                                    <span class="mr-2">📈</span>
                                    Enhancement Opportunities
                                </h4>
                                <p class="text-sm text-yellow-700 font-medium">
                                    {{ $comparison->whereBetween('average_transmuted', [75, 83])->count() }} subject(s) in fair range (75-83 transmuted) - focus on improving to good level.
                                </p>
                            </div>
                        @endif

                        @if($comparison->where('average_transmuted', '>=', 92)->count() > 0)
                            <div class="p-6 border-l-4 border-green-500 rounded-xl bg-green-50">
                                <h4 class="font-bold text-green-800 mb-3 text-lg flex items-center">
                                    <span class="mr-2">🏆</span>
                                    Maintain Excellence
                                </h4>
                                <p class="text-sm text-green-700 font-medium">
                                    {{ $comparison->where('average_transmuted', '>=', 92)->count() }} subject(s) performing excellently (≥92 transmuted) - share successful strategies across subjects.
                                </p>
                            </div>
                        @endif

                        <div class="p-6 border-l-4 border-blue-500 rounded-xl bg-blue-50">
                            <h4 class="font-bold text-blue-800 mb-3 text-lg flex items-center">
                                <span class="mr-2">📊</span>
                                Continuous Monitoring
                            </h4>
                            <p class="text-sm text-blue-700 font-medium">
                                Regularly track transmuted grade trends and implement data-driven instructional adjustments to improve overall performance.
                            </p>
                        </div>

                        <div class="p-6 border-l-4 border-purple-500 rounded-xl bg-purple-50">
                            <h4 class="font-bold text-purple-800 mb-3 text-lg flex items-center">
                                <span class="mr-2">🎯</span>
                                Goal Setting
                            </h4>
                            <p class="text-sm text-purple-700 font-medium">
                                Set realistic targets for each subject to reach at least 75 transmuted grade average, with stretch goals for higher performance levels.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Export Options -->

            @endif
        </div>
    </div>

    @if($comparison->isNotEmpty())
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Subject Comparison Chart with Transmuted and Raw Scores
            new Chart(document.getElementById('comparisonChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($comparison->pluck('subject_name')->toArray()) !!},
                    datasets: [
                        {
                            label: 'Transmuted Grade',
                            data: {!! json_encode($comparison->pluck('average_transmuted')->toArray()) !!},
                            backgroundColor: function(context) {
                                const value = context.parsed.y;
                                if (value >= 96) return 'rgba(147, 51, 234, 0.8)'; // Purple - Excellent
                                if (value >= 92) return 'rgba(59, 130, 246, 0.8)';  // Blue - Very Good
                                if (value >= 84) return 'rgba(34, 197, 94, 0.8)';   // Green - Good
                                if (value >= 75) return 'rgba(245, 158, 11, 0.8)';  // Yellow - Fair
                                if (value >= 60) return 'rgba(249, 115, 22, 0.8)';  // Orange - Passed
                                return 'rgba(239, 68, 68, 0.8)';                    // Red - Failed
                            },
                            borderColor: function(context) {
                                const value = context.parsed.y;
                                if (value >= 96) return 'rgb(147, 51, 234)';
                                if (value >= 92) return 'rgb(59, 130, 246)';
                                if (value >= 84) return 'rgb(34, 197, 94)';
                                if (value >= 75) return 'rgb(245, 158, 11)';
                                if (value >= 60) return 'rgb(249, 115, 22)';
                                return 'rgb(239, 68, 68)';
                            },
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        },
                        {
                            label: 'Raw Percentage',
                            data: {!! json_encode($comparison->pluck('average_percentage')->toArray()) !!},
                            type: 'line',
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            fill: false,
                            tension: 0.4,
                            pointBackgroundColor: '#ef4444',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            borderWidth: 3,
                            yAxisID: 'y1'
                        },
                        {
                            label: 'Passing Rate (≥75 Transmuted)',
                            data: {!! json_encode($comparison->pluck('passing_rate')->toArray()) !!},
                            type: 'line',
                            borderColor: '#9333ea',
                            backgroundColor: 'rgba(147, 51, 234, 0.1)',
                            fill: false,
                            tension: 0.4,
                            pointBackgroundColor: '#9333ea',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            borderWidth: 2,
                            borderDash: [5, 5],
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (context.datasetIndex === 0) {
                                        return 'Transmuted: ' + context.parsed.y;
                                    } else if (context.datasetIndex === 1) {
                                        return 'Raw: ' + context.parsed.y + '%';
                                    } else {
                                        return 'Passing Rate: ' + Math.round(context.parsed.y * 10) / 10 + '%';
                                    }
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            min: 60,
                            max: 100,
                            grid: {
                                color: 'rgba(239, 68, 68, 0.1)'
                            },
                            ticks: {
                                color: 'rgb(75, 85, 99)',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Transmuted Grade',
                                color: 'rgb(75, 85, 99)',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                },
                                color: 'rgb(75, 85, 99)',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Percentage / Passing Rate',
                                color: 'rgb(75, 85, 99)',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
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

            function exportComparisonData() {
                const comparisonData = {
                    report_date: new Date().toISOString(),
                    grading_system: 'transmuted',
                    grade_scale: {
                        'Excellent': '96-100 transmuted',
                        'Very Good': '92-95 transmuted',
                        'Good': '84-91 transmuted',
                        'Fair': '75-83 transmuted',
                        'Passed': '60-74 transmuted',
                        'Failed': 'Below 60 transmuted'
                    },
                    summary: {
                        total_subjects: {{ $comparison->count() }},
                        total_students: {{ $comparison->sum('total_students') }},
                        total_assessments: {{ $comparison->sum('total_assessments') }},
                        overall_average_transmuted: {{ round($comparison->avg('average_transmuted'), 2) }},
                        overall_average_percentage: {{ round($comparison->avg('average_percentage'), 2) }},
                        overall_passing_rate: {{ round($comparison->avg('passing_rate'), 2) }}
                    },
                    performance_distribution: {
                        excellent: {{ $overallStats['excellent'] }},
                        very_good: {{ $overallStats['very_good'] }},
                        good: {{ $overallStats['good'] }},
                        fair: {{ $overallStats['fair'] }},
                        passed: {{ $overallStats['passed'] }},
                        failed: {{ $overallStats['failed'] }}
                    },
                    subjects: @json($comparison->values())
                };

                const dataStr = JSON.stringify(comparisonData, null, 2);
                const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
                
                const exportFileDefaultName = 'transmuted-subject-comparison-' + new Date().toISOString().split('T')[0] + '.json';
                
                const linkElement = document.createElement('a');
                linkElement.setAttribute('href', dataUri);
                linkElement.setAttribute('download', exportFileDefaultName);
                linkElement.click();
            }
        </script>
    @endif
</x-app-layout>