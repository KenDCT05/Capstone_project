<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100">
        <div class="max-w-6xl mx-auto p-6">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-500 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center"> 
                        <svg class="w-16 h-16 text-white mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                        My Grades & Progress
                    </h1>
                    <p class="text-red-100 mt-2">Track your academic performance and attendance records</p>
                </div>
                
                <div class="px-8 py-6">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                <!-- Overall Grade Summary (if subject is selected) -->
                @if($subject && !empty($columns))
                    @php
                        // Calculate overall academic average (excluding attendance)
                        $academicScores = [];
                        $transmutedAcademicGrades = [];
                        $attendanceScores = [];
                        
                        foreach($columns as $label) {
                            $score = $scores[$label] ?? null;
                            $max = $maxScores[$label] ?? null;
                            
                            if($score !== null && $max !== null && $max > 0) {
                                $percentage = ($score / $max) * 100;
                                
                                if(str_contains(strtolower($label), 'attendance')) {
                                    $attendanceScores[] = $percentage;
                                } else {
                                    $academicScores[] = $percentage;
                                    $individualGrade = null;
if ($percentage >= 100.00) $individualGrade = 100;
elseif ($percentage >= 98.40) $individualGrade = 99;
elseif ($percentage >= 96.80) $individualGrade = 98;
elseif ($percentage >= 95.20) $individualGrade = 97;
elseif ($percentage >= 93.60) $individualGrade = 96;
elseif ($percentage >= 92.00) $individualGrade = 95;
elseif ($percentage >= 90.40) $individualGrade = 94;
elseif ($percentage >= 88.80) $individualGrade = 93;
elseif ($percentage >= 87.20) $individualGrade = 92;
elseif ($percentage >= 85.60) $individualGrade = 91;
elseif ($percentage >= 84.00) $individualGrade = 90;
elseif ($percentage >= 82.40) $individualGrade = 89;
elseif ($percentage >= 80.80) $individualGrade = 88;
elseif ($percentage >= 79.20) $individualGrade = 87;
elseif ($percentage >= 77.60) $individualGrade = 86;
elseif ($percentage >= 76.00) $individualGrade = 85;
elseif ($percentage >= 74.40) $individualGrade = 84;
elseif ($percentage >= 72.80) $individualGrade = 83;
elseif ($percentage >= 71.20) $individualGrade = 82;
elseif ($percentage >= 69.60) $individualGrade = 81;
elseif ($percentage >= 68.00) $individualGrade = 80;
elseif ($percentage >= 66.40) $individualGrade = 79;
elseif ($percentage >= 64.80) $individualGrade = 78;
elseif ($percentage >= 63.20) $individualGrade = 77;
elseif ($percentage >= 61.60) $individualGrade = 76;
elseif ($percentage >= 60.00) $individualGrade = 75;
elseif ($percentage >= 56.00) $individualGrade = 74;
elseif ($percentage >= 52.00) $individualGrade = 73;
elseif ($percentage >= 48.00) $individualGrade = 72;
elseif ($percentage >= 44.00) $individualGrade = 71;
elseif ($percentage >= 40.00) $individualGrade = 70;
elseif ($percentage >= 36.00) $individualGrade = 69;
elseif ($percentage >= 32.00) $individualGrade = 68;
elseif ($percentage >= 28.00) $individualGrade = 67;
elseif ($percentage >= 24.00) $individualGrade = 66;
elseif ($percentage >= 20.00) $individualGrade = 65;
elseif ($percentage >= 16.00) $individualGrade = 64;
elseif ($percentage >= 12.00) $individualGrade = 63;
elseif ($percentage >= 8.00)  $individualGrade = 62;
elseif ($percentage >= 4.00)  $individualGrade = 61;
else $individualGrade = 60;

$transmutedAcademicGrades[] = $individualGrade;
                                }
                            }
                        }
                        
// START: New replacement logic
// This is the old calculation, which we still need for the "Raw Average" display
$academicAverage = !empty($academicScores) ? array_sum($academicScores) / count($academicScores) : null;
$attendanceAverage = !empty($attendanceScores) ? array_sum($attendanceScores) / count($attendanceScores) : null;

// This is the new calculation for the average of TRANSMUTED grades
$transmutedAverage = !empty($transmutedAcademicGrades) ? array_sum($transmutedAcademicGrades) / count($transmutedAcademicGrades) : null;

// Now, build the $academicTransmuted array using the new $transmutedAverage
$academicTransmuted = null;
$attendanceTransmuted = null;

if ($transmutedAverage !== null) {
    $grade = round($transmutedAverage); // This will be 73
    $letter = '';
    $performance = '';

    // This logic maps the final GRADE (73) to its Performance
    if ($grade >= 75) {
        $performance = 'Passed';
        if ($grade >= 85) $performance = 'Fair';
        if ($grade >= 90) $performance = 'Good';
        if ($grade >= 92) $performance = 'Very Good';
        if ($grade >= 96) $performance = 'Excellent';
    } else {
        $performance = 'Failed'; 
    }

    if ($grade == 100) $letter = 'A+';
    elseif ($grade == 99) $letter = 'A';
    elseif ($grade == 98) $letter = 'A';
    elseif ($grade == 97) $letter = 'A-';
    elseif ($grade == 96) $letter = 'A-';
    elseif ($grade >= 94) $letter = 'B+';
    elseif ($grade >= 92) $letter = 'B';
    elseif ($grade >= 90) $letter = 'B-';
    elseif ($grade >= 88) $letter = 'C+';
    elseif ($grade >= 86) $letter = 'C';
    elseif ($grade >= 84) $letter = 'C-';
    elseif ($grade >= 82) $letter = 'D+';
    elseif ($grade >= 80) $letter = 'D';
    elseif ($grade >= 76) $letter = 'D-';
    elseif ($grade == 75) $letter = 'D-';
    elseif ($grade == 74) $letter = 'E';
    elseif ($grade == 73) $letter = 'E'; 
    elseif ($grade == 72) $letter = 'E';
    elseif ($grade == 71) $letter = 'E';
    elseif ($grade == 70) $letter = 'E';
    elseif ($grade <= 69) $letter = 'F';
    else $letter = 'F';

$academicTransmuted = ['grade' => number_format($transmutedAverage, 2), 'letter' => $letter, 'performance' => $performance];}

                    @endphp

                    <!-- Grade Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Academic Performance -->
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl text-white p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Academic Grade</h3>
                                <svg class="w-8 h-8 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            @if($academicTransmuted)
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-3xl font-bold">{{ $academicTransmuted['grade'] }}</span>
                                        <span class="text-xl font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">{{ $academicTransmuted['letter'] }}</span>
                                    </div>
                                    <p class="text-blue-100">{{ $academicTransmuted['performance'] }}</p>
                                    <p class="text-xs text-blue-200">Raw Average: {{ number_format($academicAverage, 2) }}%</p>
                                </div>
                            @else
                                <div class="space-y-2">
                                    <span class="text-2xl font-bold text-blue-200">No Grades Yet</span>
                                    <p class="text-blue-100">Waiting for assessments</p>
                                </div>
                            @endif
                        </div>

                        <!-- Attendance Performance -->
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl text-white p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Attendance</h3>
                                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            @if($attendanceAverage !== null)
                                <div class="space-y-2">
                                    <span class="text-3xl font-bold">{{ number_format($attendanceAverage, 1) }}%</span>
                                    <p class="text-green-100">
                                        @if($attendanceAverage >= 95) Excellent Attendance
                                        @elseif($attendanceAverage >= 85) Good Attendance
                                        @elseif($attendanceAverage >= 75) Fair Attendance
                                        @else Needs Improvement
                                        @endif
                                    </p>
                                    <p class="text-xs text-green-200">{{ count($attendanceScores) }} record(s)</p>
                                </div>
                            @else
                                <div class="space-y-2">
                                    <span class="text-2xl font-bold text-green-200">No Records</span>
                                    <p class="text-green-100">Attendance not tracked yet</p>
                                </div>
                            @endif
                        </div>

                        <!-- Total Assessments -->
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl text-white p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Progress</h3>
                                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold">{{ count($academicScores) }}</span>
                                    <span class="text-sm bg-white bg-opacity-20 px-2 py-1 rounded">Academic</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold">{{ count($attendanceScores) }}</span>
                                    <span class="text-sm bg-white bg-opacity-20 px-2 py-1 rounded">Attendance</span>
                                </div>
                                <p class="text-xs text-purple-200">Total: {{ count($columns) }} assessments</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Detailed Grades Table -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-red-500 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Individual Assessment Results
                        </h3>
                    </div>

                    @if(!$subject)
                        <!-- No Subject Selected State -->
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-red-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-red-800 mb-2">Select a Subject</h3>
                            <p class="text-red-600">Choose a subject from the dropdown above to view your grades.</p>
                        </div>
                    @elseif(empty($columns))
                        <!-- No Assessments State -->
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-red-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-red-800 mb-2">No Assessments Yet</h3>
                            <p class="text-red-600">Your teacher hasn't posted any grades for this subject yet.</p>
                        </div>
                    @else
                        <!-- Grades Table Content -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-red-400">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Assessment</th>
                                        <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Type</th>
                                        <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Score & Raw Grade</th>
                                        <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide"> Grade</th>
                                        <th class="px-6 py-4 text-left text-white font-semibold text-lg tracking-wide">Performance</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-red-100">
                                    @foreach($columns as $index => $label)
                                        @php
                                            $isAttendance = str_contains(strtolower($label), 'attendance');
                                            $score = $scores[$label] ?? null;
                                            $max = $maxScores[$label] ?? null;
                                            $percentage = null;
                                            $transmuted = null;
                                            
                                            if($score !== null && $max !== null && $max > 0) {
                                                $percentage = ($score / $max) * 100;
                                                
                                                // Accurate transmutation logic based on the provided table
                                                // This is the CORRECTED block
if(!$isAttendance) {
    if ($percentage >= 100.00) $transmuted = ['grade' => 100, 'letter' => 'A+', 'performance' => 'Excellent'];
    elseif ($percentage >= 98.40) $transmuted = ['grade' => 99, 'letter' => 'A', 'performance' => 'Excellent'];
    elseif ($percentage >= 96.80) $transmuted = ['grade' => 98, 'letter' => 'A', 'performance' => 'Excellent'];
    elseif ($percentage >= 95.20) $transmuted = ['grade' => 97, 'letter' => 'A-', 'performance' => 'Excellent'];
    elseif ($percentage >= 93.60) $transmuted = ['grade' => 96, 'letter' => 'A-', 'performance' => 'Excellent'];
    elseif ($percentage >= 92.00) $transmuted = ['grade' => 95, 'letter' => 'B+', 'performance' => 'Very Good'];
    elseif ($percentage >= 90.40) $transmuted = ['grade' => 94, 'letter' => 'B+', 'performance' => 'Very Good'];
    elseif ($percentage >= 88.80) $transmuted = ['grade' => 93, 'letter' => 'B', 'performance' => 'Very Good'];
    elseif ($percentage >= 87.20) $transmuted = ['grade' => 92, 'letter' => 'B', 'performance' => 'Very Good'];
    elseif ($percentage >= 85.60) $transmuted = ['grade' => 91, 'letter' => 'B-', 'performance' => 'Good'];
    elseif ($percentage >= 84.00) $transmuted = ['grade' => 90, 'letter' => 'B-', 'performance' => 'Good'];
    elseif ($percentage >= 82.40) $transmuted = ['grade' => 89, 'letter' => 'C+', 'performance' => 'Good'];
    elseif ($percentage >= 80.80) $transmuted = ['grade' => 88, 'letter' => 'C+', 'performance' => 'Good'];
    elseif ($percentage >= 79.20) $transmuted = ['grade' => 87, 'letter' => 'C', 'performance' => 'Fair'];
    elseif ($percentage >= 77.60) $transmuted = ['grade' => 86, 'letter' => 'C', 'performance' => 'Fair'];
    elseif ($percentage >= 76.00) $transmuted = ['grade' => 85, 'letter' => 'C-', 'performance' => 'Fair'];
    elseif ($percentage >= 74.40) $transmuted = ['grade' => 84, 'letter' => 'C-', 'performance' => 'Fair'];
    elseif ($percentage >= 72.80) $transmuted = ['grade' => 83, 'letter' => 'D+', 'performance' => 'Passed'];
    elseif ($percentage >= 71.20) $transmuted = ['grade' => 82, 'letter' => 'D+', 'performance' => 'Passed'];
    elseif ($percentage >= 69.60) $transmuted = ['grade' => 81, 'letter' => 'D', 'performance' => 'Passed'];
    elseif ($percentage >= 68.00) $transmuted = ['grade' => 80, 'letter' => 'D', 'performance' => 'Passed'];
    elseif ($percentage >= 66.40) $transmuted = ['grade' => 79, 'letter' => 'D-', 'performance' => 'Passed'];
    elseif ($percentage >= 64.80) $transmuted = ['grade' => 78, 'letter' => 'D-', 'performance' => 'Passed'];
    elseif ($percentage >= 63.20) $transmuted = ['grade' => 77, 'letter' => 'D-', 'performance' => 'Passed'];
    elseif ($percentage >= 61.60) $transmuted = ['grade' => 76, 'letter' => 'D-', 'performance' => 'Passed'];
    elseif ($percentage >= 60.00) $transmuted = ['grade' => 75, 'letter' => 'D-', 'performance' => 'Passed'];
    elseif ($percentage >= 56.00) $transmuted = ['grade' => 74, 'letter' => 'E', 'performance' => 'Failed'];
    elseif ($percentage >= 52.00) $transmuted = ['grade' => 73, 'letter' => 'E', 'performance' => 'Failed'];
    elseif ($percentage >= 48.00) $transmuted = ['grade' => 72, 'letter' => 'E', 'performance' => 'Failed'];
    elseif ($percentage >= 44.00) $transmuted = ['grade' => 71, 'letter' => 'E', 'performance' => 'Failed'];
    elseif ($percentage >= 40.00) $transmuted = ['grade' => 70, 'letter' => 'E', 'performance' => 'Failed'];
    elseif ($percentage >= 36.00) $transmuted = ['grade' => 69, 'letter' => 'F', 'performance' => 'Failed'];
    elseif ($percentage >= 32.00) $transmuted = ['grade' => 68, 'letter' => 'F', 'performance' => 'Failed'];
    elseif ($percentage >= 28.00) $transmuted = ['grade' => 67, 'letter' => 'F', 'performance' => 'Failed'];
    elseif ($percentage >= 24.00) $transmuted = ['grade' => 66, 'letter' => 'F', 'performance' => 'Failed'];
    elseif ($percentage >= 20.00) $transmuted = ['grade' => 65, 'letter' => 'F', 'performance' => 'Failed'];
    elseif ($percentage >= 16.00) $transmuted = ['grade' => 64, 'letter' => 'F', 'performance' => 'Failed'];
    elseif ($percentage >= 12.00) $transmuted = ['grade' => 63, 'letter' => 'F', 'performance' => 'Failed'];
    elseif ($percentage >= 8.00)  $transmuted = ['grade' => 62, 'letter' => 'F', 'performance' => 'Failed'];
    elseif ($percentage >= 4.00)  $transmuted = ['grade' => 61, 'letter' => 'F', 'performance' => 'Failed'];
    else $transmuted = ['grade' => 60, 'letter' => 'F', 'performance' => 'Failed'];
}
                                            }
                                        @endphp
                                        <tr class="hover:bg-red-50 transition-colors duration-150 {{ $index % 2 === 0 ? 'bg-white' : 'bg-red-25' }}">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if($isAttendance)
                                                        <div class="flex-shrink-0 w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                                                        <span class="font-semibold text-yellow-900 text-lg">{{ $label }}</span>
                                                    @elseif(str_contains(strtolower($label), 'activity'))
                                                        <div class="flex-shrink-0 w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                                                        <span class="font-semibold text-green-900 text-lg">{{ $label }}</span>
                                                    @elseif(str_contains(strtolower($label), 'exam'))
                                                        <div class="flex-shrink-0 w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                                                        <span class="font-semibold text-blue-900 text-lg">{{ $label }}</span>
                                                    @else
                                                        <div class="flex-shrink-0 w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                                                        <span class="font-semibold text-red-900 text-lg">{{ $label }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($isAttendance)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Attendance
                                                    </span>
                                                @elseif(str_contains(strtolower($label), 'activity'))
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                        </svg>
                                                        Activity
                                                    </span>
                                                @elseif(str_contains(strtolower($label), 'exam'))
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        Exam
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Quiz
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($score !== null && $max !== null)
                                                    <div class="flex items-center space-x-3">
                                                        <span class="text-xl font-bold text-gray-900">
                                                            {{ $score }}/{{ $max }}
                                                        </span>
                                                        @if($percentage !== null)
                                                            <span class="text-lg text-gray-600">
                                                                ({{ number_format($percentage, 2) }}%)
                                                            </span>
                                                        @endif
                                                    </div>
                                                @elseif($score !== null)
                                                    <span class="text-xl font-bold text-gray-900">{{ $score }}</span>
                                                @else
                                                    <span class="text-lg font-medium text-gray-400 bg-gray-100 px-3 py-1 rounded-full">Not Graded</span>
                                                @endif
                                            </td>
                                    <td class="px-6 py-4">
                                                @if($transmuted)
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-2xl font-bold text-blue-600">{{ $transmuted['grade'] }}</span>
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                                            {{ $transmuted['letter'] }}
                                                        </span>
                                                    </div>
                                                @elseif($isAttendance && $percentage !== null)
                                                    <span class="text-xl font-bold text-yellow-600">{{ number_format($percentage, 1) }}%</span>
                                                @else
                                                    <span class="text-sm font-medium text-gray-500">--</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($transmuted)
                                                    @php
                                                        $performanceColors = [
                                                            'Excellent' => 'text-green-700 bg-green-100',
                                                            'Very Good' => 'text-blue-700 bg-blue-100',
                                                            'Good' => 'text-indigo-700 bg-indigo-100',
                                                            'Fair' => 'text-yellow-700 bg-yellow-100',
                                                            'Passed' => 'text-orange-700 bg-orange-100',
                                                            'Failed' => 'text-red-700 bg-red-100'
                                                        ];
                                                        $colorClass = $performanceColors[$transmuted['performance']] ?? 'text-gray-700 bg-gray-100';
                                                    @endphp
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $colorClass }}">
                                                        {{ $transmuted['performance'] }}
                                                    </span>
                                                @elseif($isAttendance && $percentage !== null)
                                                    @php
                                                        if($percentage >= 95) $attendanceStatus = ['text' => 'Excellent', 'class' => 'text-green-700 bg-green-100'];
                                                        elseif($percentage >= 85) $attendanceStatus = ['text' => 'Good', 'class' => 'text-blue-700 bg-blue-100'];
                                                        elseif($percentage >= 75) $attendanceStatus = ['text' => 'Fair', 'class' => 'text-yellow-700 bg-yellow-100'];
                                                        else $attendanceStatus = ['text' => 'Poor', 'class' => 'text-red-700 bg-red-100'];
                                                    @endphp
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $attendanceStatus['class'] }}">
                                                        {{ $attendanceStatus['text'] }}
                                                    </span>
                                                @else
                                                    <span class="text-sm font-medium text-gray-500">Not Available</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Grade Legend -->
                @if($subject && !empty($columns))
                    <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Understanding Your Grades
                        </h4>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Grade Scale -->
                        <div>
                            <h5 class="font-semibold text-gray-700 mb-3">Grade Scale</h5>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-2 bg-green-50 rounded-lg">
                                    <span class="font-medium text-green-800">A+ to A-</span>
                                    <span class="text-sm text-green-600">Excellent (93.60-100)</span>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-blue-50 rounded-lg">
                                    <span class="font-medium text-blue-800">B+ to B-</span>
                                    <span class="text-sm text-blue-600">Very Good to Good (84.00-91.99)</span>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-indigo-50 rounded-lg">
                                    <span class="font-medium text-indigo-800">C+ to C-</span>
                                    <span class="text-sm text-indigo-600">Fair (74.40-83.99)</span>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-orange-50 rounded-lg">
                                    <span class="font-medium text-orange-800">D+ to D-</span>
                                    <span class="text-sm text-orange-600">Passed (60.00-74.39)</span>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-red-50 rounded-lg">
                                    <span class="font-medium text-red-800">E & F</span>
                                    <span class="text-sm text-red-600">Failed (Below 60)</span>
                                </div>
                            </div>
                        </div>

                            <!-- Assessment Types -->
                            <div>
                                <h5 class="font-semibold text-gray-700 mb-3">Assessment Types</h5>
                                <div class="space-y-2">
                                    <div class="flex items-center p-2 bg-red-50 rounded-lg">
                                        <div class="w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                                        <span class="font-medium text-red-800">Quiz</span>
                                        <span class="ml-auto text-sm text-red-600">Short assessments</span>
                                    </div>
                                    <div class="flex items-center p-2 bg-green-50 rounded-lg">
                                        <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                                        <span class="font-medium text-green-800">Activity</span>
                                        <span class="ml-auto text-sm text-green-600">Class activities & projects</span>
                                    </div>
                                    <div class="flex items-center p-2 bg-blue-50 rounded-lg">
                                        <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                                        <span class="font-medium text-blue-800">Exam</span>
                                        <span class="ml-auto text-sm text-blue-600">Major examinations</span>
                                    </div>
                                    <div class="flex items-center p-2 bg-yellow-50 rounded-lg">
                                        <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                                        <span class="font-medium text-yellow-800">Attendance</span>
                                        <span class="ml-auto text-sm text-yellow-600">Class participation</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Footer Info -->
            <div class="mt-6 bg-white rounded-xl shadow-lg p-4">
                <div class="flex flex-col sm:flex-row items-center justify-between text-sm">
                    <div class="flex items-center mb-2 sm:mb-0 text-gray-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Your grades are based on the Philippine K-12 transmutation table</span>
                    </div>
                    <div class="text-gray-500 text-xs">
                        Last updated: {{ now()->format('M d, Y g:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>