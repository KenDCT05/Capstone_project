<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100">
        <div class="max-w-6xl mx-auto p-6">
            <!-- Header Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border-t-4 border-red-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-red-900 mb-2">My Grades</h1>
                        <div class="flex items-center text-red-700">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-lg font-semibold">{{ $subject->name }}</span>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-2 text-red-600">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Subject Selection Form -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <form method="GET" action="{{ route('gradebook.student') }}" class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <label for="subject_id" class="text-red-800 font-semibold text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Select Subject:
                    </label>
                    <select name="subject_id" onchange="this.form.submit()" 
                            class="flex-1 sm:flex-none border-2 border-red-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 px-4 py-3 rounded-lg shadow-sm bg-white text-red-800 font-medium transition-all duration-200 hover:border-red-300 min-w-[200px]">
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" {{ $s->id == $subject->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Grades Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Assessment Results
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-red-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Assessment</th>
                                <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Score</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-red-100">
                            @foreach($columns as $index => $label)
                                <tr class="hover:bg-red-50 transition-colors duration-150 {{ $index % 2 === 0 ? 'bg-white' : 'bg-red-25' }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-3 h-3 bg-red-600 rounded-full mr-3"></div>
                                            <span class="font-semibold text-red-900 text-lg">{{ $label }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $score = $scores[$label] ?? null;
                                            $max = $maxScores[$label] ?? null;
                                        @endphp

                                        @if($score !== null && $max !== null)
                                            <div class="flex items-center space-x-3">
                                                <span class="text-xl font-bold text-red-800">{{ $score }}/{{ $max }}</span>
                                                @php
                                                    $percentage = $max > 0 ? ($score / $max) * 100 : 0;
                                                    $colorClass = $percentage >= 90 ? 'text-green-600' : ($percentage >= 80 ? 'text-yellow-600' : 'text-red-600');
                                                @endphp
                                                <span class="text-sm font-medium {{ $colorClass }}">
                                                    ({{ number_format($percentage, 1) }}%)
                                                </span>
                                            </div>
                                        @elseif($score !== null)
                                            <span class="text-xl font-bold text-red-800">{{ $score }}</span>
                                        @elseif($max !== null)
                                            <div class="flex items-center space-x-3">
                                                <span class="text-xl font-bold text-red-800">0/{{ $max }}</span>
                                                <span class="text-sm font-medium text-red-600">(0.0%)</span>
                                            </div>
                                        @else
                                            <span class="text-lg font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                @if(empty($columns))
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-red-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-red-800 mb-2">No Assessments Yet</h3>
                        <p class="text-red-600">No grades have been recorded for this subject.</p>
                    </div>
                @endif
            </div>

            <!-- Footer Info -->
            <div class="mt-6 bg-white rounded-xl shadow-lg p-4">
                <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-red-600">
                    <div class="flex items-center mb-2 sm:mb-0">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Grades are updated regularly by your instructors</span>
                    </div>
                    <div class="text-red-500">
                        Last updated: {{ now()->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>