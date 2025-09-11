<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100">
        <div class="max-w-6xl mx-auto p-6">
            <!-- Header Section -->
      
                <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center"> 
                        <br>
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                                
                         My Grades & Attendance
                    </h1>
                    <p class="text-red-100 mt-2">Let you and your parents view your progress.</p>
                </div>
                
                <div class="px-8 py-6">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a> 
                </div>
            </div>

            <!-- Check if student has any subjects -->
            @if(empty($subjects) || $subjects->count() == 0)
                <!-- No Subjects Enrolled State -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="text-center py-12">
                        <svg class="w-20 h-20 mx-auto text-red-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <h3 class="text-2xl font-bold text-red-800 mb-3">No Subjects Enrolled</h3>
                        <p class="text-red-600 text-lg mb-4">You are not currently enrolled in any subjects.</p>
                        <p class="text-red-500">Please contact your administrator to enroll in subjects.</p>
                    </div>
                </div>
            @else
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
                            <option value="">Choose a subject...</option>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}" {{ ($subject && $s->id == $subject->id) ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Summary Stats -->
                @if($subject && !empty($columns))
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Academic Performance -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-600">
                            <div class="flex items-center">
                                <div class="bg-red-100 rounded-lg p-3 mr-4">
                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Academic Assessments</p>
                                    <p class="text-2xl font-bold text-red-800">
                                        {{ count(array_filter($columns, fn($col) => !str_contains(strtolower($col), 'attendance'))) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance Performance -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg p-3 mr-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Attendance Records</p>
                                    <p class="text-2xl font-bold text-blue-800">
                                        {{ count(array_filter($columns, fn($col) => str_contains(strtolower($col), 'attendance'))) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Overall Progress -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-600">
                            <div class="flex items-center">
                                <div class="bg-green-100 rounded-lg p-3 mr-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Assessments</p>
                                    <p class="text-2xl font-bold text-green-800">{{ count($columns) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Grades Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-red-800 to-red-900 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Assessment Results & Attendance
                        </h3>
                    </div>

                    @if(!$subject)
                        <!-- No Subject Selected State -->
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-red-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-red-800 mb-2">Select a Subject</h3>
                            <p class="text-red-600">Please select a subject from the dropdown above to view your grades and attendance.</p>
                        </div>
                    @elseif(empty($columns))
                        <!-- No Assessments State -->
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-red-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-red-800 mb-2">No Assessments Yet</h3>
                            <p class="text-red-600">No grades or attendance records have been posted for this subject.</p>
                        </div>
                    @else
                        <!-- Grades Table Content -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-red-700">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Assessment / Record</th>
                                        <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Type</th>
                                        <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Score</th>
                                        <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-red-100">
                                    @php
                                        $academicCount = 0;
                                        $attendanceCount = 0;
                                    @endphp
                                    @foreach($columns as $index => $label)
                                        @php
                                            $isAttendance = str_contains(strtolower($label), 'attendance');
                                            if ($isAttendance) {
                                                $attendanceCount++;
                                            } else {
                                                $academicCount++;
                                            }
                                            $score = $scores[$label] ?? null;
                                            $max = $maxScores[$label] ?? null;
                                        @endphp
                                        <tr class="hover:bg-red-50 transition-colors duration-150 {{ $index % 2 === 0 ? 'bg-white' : 'bg-red-25' }}">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if($isAttendance)
                                                        <div class="flex-shrink-0 w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                                                        <span class="font-semibold text-blue-900 text-lg">{{ $label }}</span>
                                                    @else
                                                        <div class="flex-shrink-0 w-3 h-3 bg-red-600 rounded-full mr-3"></div>
                                                        <span class="font-semibold text-red-900 text-lg">{{ $label }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($isAttendance)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Attendance
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                        </svg>
                                                        Academic
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($score !== null && $max !== null)
                                                    <div class="flex items-center space-x-3">
                                                        <span class="text-xl font-bold {{ $isAttendance ? 'text-blue-800' : 'text-red-800' }}">
                                                            {{ $score }}/{{ $max }}
                                                        </span>
                                                    </div>
                                                @elseif($score !== null)
                                                    <span class="text-xl font-bold {{ $isAttendance ? 'text-blue-800' : 'text-red-800' }}">{{ $score }}</span>
                                                @elseif($max !== null)
                                                    <div class="flex items-center space-x-3">
                                                        <span class="text-xl font-bold {{ $isAttendance ? 'text-blue-800' : 'text-red-800' }}">0/{{ $max }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-lg font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Not Graded</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($score !== null && $max !== null && $max > 0)
                                                    @php
                                                        $percentage = ($score / $max) * 100;
                                                        if ($isAttendance) {
                                                            $colorClass = $percentage >= 90 ? 'text-green-600 bg-green-100' : 
                                                                         ($percentage >= 80 ? 'text-yellow-600 bg-yellow-100' : 'text-red-600 bg-red-100');
                                                        } else {
                                                            $colorClass = $percentage >= 90 ? 'text-green-600 bg-green-100' : 
                                                                         ($percentage >= 80 ? 'text-yellow-600 bg-yellow-100' : 'text-red-600 bg-red-100');
                                                        }
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-semibold {{ $colorClass }}">
                                                        {{ number_format($percentage, 1) }}%
                                                    </span>
                                                @elseif($score !== null && $max !== null)
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-semibold text-red-600 bg-red-100">
                                                        0.0%
                                                    </span>
                                                @else
                                                    <span class="text-sm font-medium text-gray-500">--</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Footer Info -->
            <div class="mt-6 bg-white rounded-xl shadow-lg p-4">
                <div class="flex flex-col sm:flex-row items-center justify-between text-sm">
                    <div class="flex items-center mb-2 sm:mb-0 text-gray-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Grades and attendance are updated regularly by your instructors</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center text-red-600">
                            <div class="w-3 h-3 bg-red-600 rounded-full mr-2"></div>
                            <span class="text-xs">Academic</span>
                        </div>
                        <div class="flex items-center text-blue-600">
                            <div class="w-3 h-3 bg-blue-600 rounded-full mr-2"></div>
                            <span class="text-xs">Attendance</span>
                        </div>
                        <div class="text-gray-500 text-xs">
                            Last updated: {{ now()->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>