<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-rose-50 to-pink-50">
        <div class="max-w-7xl mx-auto p-6">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Quiz Leaderboard
                    </h1>
                    <p class="text-red-100 mt-2">{{ $quiz->title }}</p>
                </div>
                
                <div class="px-8 py-6 flex justify-between items-center flex-wrap gap-4">
                    <a href="{{ route('quizzes.index', $quiz) }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Quiz
                    </a>
                    
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Total Attempts: <span class="font-bold text-red-600" data-total-attempts>{{ $totalAttempts }}</span></p>
                        <p class="text-sm text-gray-600">Average Score: <span class="font-bold text-red-600" data-average-score>{{ $averageScore }}%</span></p>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Table -->
            <div class="bg-white/70 backdrop-blur-sm border border-red-100 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-red-600 to-rose-600 text-white">
                                <th class="p-4 text-left font-semibold">Rank</th>
                                <th class="p-4 text-left font-semibold">Student Name</th>
                                <th class="p-4 text-left font-semibold">Email</th>
                                <th class="p-4 text-center font-semibold">Score</th>
                                <th class="p-4 text-center font-semibold">Percentage</th>
                                <th class="p-4 text-center font-semibold">Correct Answers</th>
                                <th class="p-4 text-center font-semibold">Submitted</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-red-100" id="leaderboard-body">
                            @forelse($attempts as $index => $attempt)
                                <tr class="hover:bg-red-50/50 transition-colors duration-150" data-student-id="{{ $attempt['student_id'] }}">
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            @if($index === 0)
                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-full text-sm font-bold">🥇</span>
                                            @elseif($index === 1)
                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-full text-sm font-bold">🥈</span>
                                            @elseif($index === 2)
                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-orange-400 to-orange-500 text-white rounded-full text-sm font-bold">🥉</span>
                                            @else
                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-200 text-gray-700 rounded-full text-sm font-bold">{{ $index + 1 }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-semibold text-red-800">{{ $attempt['student_name'] }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-gray-600 text-sm">{{ $attempt['student_email'] }}</div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex px-3 py-1 text-sm font-bold bg-red-100 text-red-700 rounded-full">
                                            {{ $attempt['score'] }}/{{ $attempt['max_score'] }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-red-600 to-rose-600 h-2 rounded-full" style="width: {{ $attempt['percentage'] }}%"></div>
                                            </div>
                                            <span class="font-bold text-red-600 text-sm w-12">{{ $attempt['percentage'] }}%</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full text-sm font-bold">
                                            ✓
                                        </span>
                                        <div class="text-gray-600 text-xs mt-1">{{ $attempt['correct_answers'] }}/{{ $attempt['total_questions'] }}</div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="text-gray-600 text-sm">{{ $attempt['submitted_at']->format('M j, g:i A') }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-12 text-center" colspan="7">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-red-700 mb-1">No submissions yet</h3>
                                                <p class="text-red-500">Leaderboard will update when students submit their quiz!</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const quizId = '{{ $quiz->id }}';
        const refreshInterval = 5000;

        function updateLeaderboard() {
            fetch(`/teacher/quizzes/${quizId}/leaderboard/api`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('leaderboard-body');
                    
                    if (data.attempts.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td class="p-12 text-center" colspan="7">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-red-700 mb-1">No submissions yet</h3>
                                            <p class="text-red-500">Leaderboard will update when students submit!</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    let html = '';
                    data.attempts.forEach((attempt, index) => {
                        const medal = index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : index + 1;
                        const medalClass = index < 3 ? 'bg-gradient-to-r' : 'bg-gray-200';
                        const medalColors = index === 0 ? 'from-yellow-400 to-yellow-500' : 
                                          index === 1 ? 'from-gray-400 to-gray-500' :
                                          index === 2 ? 'from-orange-400 to-orange-500' : '';
                        
                        html += `
                            <tr class="hover:bg-red-50/50 transition-colors duration-150" data-student-id="${attempt.student_id}">
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 ${medalClass} ${medalColors} text-white rounded-full text-sm font-bold ${index >= 3 ? 'text-gray-700' : ''}">
                                            ${typeof medal === 'string' ? medal : medal}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="font-semibold text-red-800">${attempt.student_name}</div>
                                </td>
                                <td class="p-4">
                                    <div class="text-gray-600 text-sm">${attempt.student_email || '-'}</div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex px-3 py-1 text-sm font-bold bg-red-100 text-red-700 rounded-full">
                                        ${attempt.score}/${attempt.max_score}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-red-600 to-rose-600 h-2 rounded-full" style="width: ${attempt.percentage}%"></div>
                                        </div>
                                        <span class="font-bold text-red-600 text-sm w-12">${attempt.percentage}%</span>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full text-sm font-bold">
                                        ✓
                                    </span>
                                    <div class="text-gray-600 text-xs mt-1">${attempt.correct_answers}/${attempt.total_questions}</div>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="text-gray-600 text-sm">${attempt.submitted_at}</div>
                                </td>
                            </tr>
                        `;
                    });

                    tbody.innerHTML = html;

                    document.querySelector('[data-total-attempts]').textContent = data.total_attempts;
                    document.querySelector('[data-average-score]').textContent = data.average_score + '%';
                })
                .catch(error => console.error('Error updating leaderboard:', error));
        }

        updateLeaderboard();
        setInterval(updateLeaderboard, refreshInterval);
    </script>
</x-app-layout>