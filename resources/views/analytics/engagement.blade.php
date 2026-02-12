<!-- resources/views/analytics/engagement.blade.php -->
<x-app-layout>
    <div class="py-8 min-h-screen bg-gradient-to-br from-red-50 via-rose-50 to-red-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header -->
<div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
    <!-- Gradient Header -->
    <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-white flex items-center">
            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
            Student Engagement Analytics
        </h1>
        <p class="text-red-100 mt-2">Track student activity across all subjects. Filter by subject enrollment and date range.</p>
    </div>
        <!-- Export & Print Buttons -->
        <div class="flex gap-2">
            <button onclick="exportToCSV()" 
                class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                Export CSV
            </button>

            <button onclick="printReport()" 
                class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path>
                </svg>
                Print
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="px-8 py-6">
        <form method="GET" action="{{ route('analytics.engagement') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <!-- Subject Filter -->
<div>
    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-2">
        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Filter by Subject
    </label>

    <select name="subject_id" id="subject_id"
        class="block w-full border-gray-300 rounded-lg shadow-sm 
               focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150"
        onchange="this.form.submit()">

        {{-- Loop through all subjects --}}
        @foreach($subjects as $index => $subject)
            <option value="{{ $subject->id }}"
                {{ request('subject_id') == $subject->id || (!request('subject_id') && $index === 0) ? 'selected' : '' }}>
                {{ $subject->name }} ({{ $subject->teacher->name }})
            </option>
        @endforeach
    </select>
</div>


            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-wrap gap-3">
                                <!-- Go Back Button -->
                <a href="{{ route('analytics.dashboard') }}" 
                    class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Analytics Dashboard
                </a>



            </div>
        </form>
    </div>
</div>


            <!-- Enhanced Stats Cards - Students Only -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @php
                    $totalStudents = $engagementSummary->count();
                    $totalActivities = collect($activityStats)->sum();
                    $avgTimeSpent = $engagementSummary->avg(function($records) {
                        return $records->where('action', 'time_spent')->sum('total_value') / 60;
                    });
                    $mostActiveAction = collect($activityStats)->sortDesc()->keys()->first() ?? 'N/A';
                    $maxActivities = collect($activityStats)->max();
                @endphp

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-600 transform hover:scale-105 transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Total Students</h3>
                            <p class="text-3xl font-bold text-red-900">{{ number_format($totalStudents) }}</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        {{ $totalStudents > 0 ? 'Active learners' : 'No students yet' }}
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-700 transform hover:scale-105 transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Student Activities</h3>
                            <p class="text-3xl font-bold text-red-900">{{ number_format($totalActivities) }}</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-8 h-8 text-red-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        Tracked student actions
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-900 transform hover:scale-105 transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Avg Time Spent</h3>
                            <p class="text-3xl font-bold text-red-900">{{ number_format($avgTimeSpent, 1) }}min</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-8 h-8 text-red-900" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        Per student session
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-rose-600 transform hover:scale-105 transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Most Active Action</h3>
                            <p class="text-lg font-bold text-red-900 capitalize">{{ str_replace('_', ' ', $mostActiveAction) }}</p>
                        </div>
                        <div class="p-3 bg-rose-100 rounded-full">
                            <svg class="w-8 h-8 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        {{ $maxActivities }} total occurrences
                    </div>
                </div>
            </div>

<!-- Showing the key section with separated heatmaps -->
<!-- This replaces the grid section with the heatmaps -->

<!-- Student-Only Heatmaps -->
<div class="grid grid-cols-1 gap-6">
    <!-- Daily Activity Calendar Heatmap - TOP -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-red-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                Daily Student Activity
            </h3>
            <div class="text-sm text-gray-500">
                Daily data
            </div>
        </div>
        <div id="dailyHeatmap" class="min-h-[350px] relative">
            <div id="dailyHeatmapLoader" class="absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
            </div>
        </div>
    </div>

    <!-- Weekly Pattern Heatmap - BOTTOM -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-red-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                Weekly Student Pattern
            </h3>
            <div class="text-sm text-gray-500">
                Hours vs Days of Week
            </div>
        </div>
        <div id="weeklyHeatmap" class="min-h-[500px] relative">
            <div id="weeklyHeatmapLoader" class="absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
            </div>
        </div>
    </div>
</div>
            <!-- Student Activity Matrix Heatmap -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-red-700 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                        Student Activity Matrix
                    </h3>
                    <div class="text-sm text-gray-500">
                        Students vs Activity Types 
                    </div>
                </div>
                <div id="studentMatrixHeatmap" class="min-h-[400px] relative overflow-x-auto">
                    <div id="matrixHeatmapLoader" class="absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Charts - Student Data Only -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Activity Distribution -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-red-700 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            Student Activity Distribution
                        </h3>
                        <div class="text-sm text-gray-500">
                            {{ number_format($totalActivities) }} total student activities
                        </div>
                    </div>
                    <div style="height: 350px;" class="relative">
                        <div id="activityChartLoader" class="absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
                        </div>
                        <canvas id="activityChart" class="opacity-0 transition-opacity duration-500"></canvas>
                    </div>
                </div>

                <!-- Top Students -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-red-700 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Most Engaged Students
                        </h3>
                        <div class="text-sm text-gray-500">
                            Top 10 performers
                        </div>
                    </div>
                    <div style="height: 300px;" class="relative">
                        <div id="engagementChartLoader" class="absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
                        </div>
                        <canvas id="engagementChart" class="opacity-0 transition-opacity duration-500"></canvas>
                    </div>
                </div>
            </div>

            <!-- Enhanced Data Table - Students Only -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                        </svg>
                        Student Engagement Data
                    </h3>
                    
                    <!-- Search Box -->
                    <div class="relative">
                        <input type="text" id="studentSearch" placeholder="Search students..." 
                            class="pl-10 pr-4 py-2 border border-red-300 rounded-lg text-gray-700 bg-white focus:outline-none focus:border-red-500 text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

<div class="overflow-x-auto" style="max-height: 600px; overflow-y: auto;">
    <table class="min-w-full divide-y divide-gray-200" id="engagementTable">
        <thead class="bg-red-900 sticky top-0">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase cursor-pointer hover:bg-red-800 transition duration-150" 
                    onclick="sortTable(0)">
                    <div class="flex items-center">
                        Student
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase cursor-pointer hover:bg-red-800 transition duration-150" 
                    onclick="sortTable(1)">
                    <div class="flex items-center justify-center">
                        Logins
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase cursor-pointer hover:bg-red-800 transition duration-150" 
                    onclick="sortTable(2)">
                    <div class="flex items-center justify-center">
                        Quizzes
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase cursor-pointer hover:bg-red-800 transition duration-150" 
                    onclick="sortTable(3)">
                    <div class="flex items-center justify-center">
                        Uploads
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase cursor-pointer hover:bg-red-800 transition duration-150" 
                    onclick="sortTable(4)">
                    <div class="flex items-center justify-center">
                        Enrollments
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase cursor-pointer hover:bg-red-800 transition duration-150" 
                    onclick="sortTable(5)">
                    <div class="flex items-center justify-center">
                        Downloads
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase cursor-pointer hover:bg-red-800 transition duration-150" 
                    onclick="sortTable(6)">
                    <div class="flex items-center justify-center">
                        Time (min)
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </th>
                <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase">
                    Total Score
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
    @forelse($engagementSummary as $studentId => $records)
        @php
            $student = $records->first()->user;
            // FIXED: Only process if user is a student
            if (!$student || $student->role !== 'student') continue;
            
            $logins = $records->where('action', 'login')->sum('total');
            $quizzes = $records->where('action', 'quiz_attempt')->sum('total');
            $uploads = $records->where('action', 'activity_upload')->sum('total');
            $enrollments = $records->where('action', 'course_enrollment')->sum('total');
            $downloads = $records->where('action', 'material_download')->sum('total');
            $timeSpent = round($records->where('action', 'time_spent')->sum('total_value') / 60, 1);
            $totalScore = $logins + $quizzes + $uploads + $enrollments + $downloads;
        @endphp
        <tr class="hover:bg-red-50 transition duration-150">
            <!-- Student Column (0) -->
            <td class="px-6 py-4" data-label="{{ strtolower($student->name) }}">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-red-600 to-red-700 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                        {{ strtoupper(substr($student->name, 0, 2)) }}
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                        <div class="text-xs text-gray-500">{{ $student->email ?? 'N/A' }}</div>
                    </div>
                </div>
            </td>
            
            <!-- Logins Column (1) -->
            <td class="px-6 py-4 text-center" data-value="{{ $logins }}">
                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $logins }}
                </span>
            </td>
            
            <!-- Quizzes Column (2) -->
            <td class="px-6 py-4 text-center" data-value="{{ $quizzes }}">
                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 002 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $quizzes }}
                </span>
            </td>
            
            <!-- Uploads Column (3) -->
            <td class="px-6 py-4 text-center" data-value="{{ $uploads }}">
                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $uploads }}
                </span>
            </td>
            
            <!-- Enrollments Column (4) -->
            <td class="px-6 py-4 text-center" data-value="{{ $enrollments }}">
                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                    </svg>
                    {{ $enrollments }}
                </span>
            </td>
            
            <!-- Downloads Column (5) -->
            <td class="px-6 py-4 text-center" data-value="{{ $downloads }}">
                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $downloads }}
                </span>
            </td>
            
            <!-- Time Column (6) - Moved to second-to-last -->
            <td class="px-6 py-4 text-center" data-value="{{ $timeSpent }}">
                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $timeSpent }}
                </span>
            </td>
            
            <!-- Total Score Column (7) - Last -->
            <td class="px-6 py-4 text-center" data-value="{{ $totalScore }}">
                <div class="flex items-center justify-center">
                    <div class="text-sm font-bold text-gray-900">{{ $totalScore }}</div>
                    <div class="ml-2 w-16 bg-gray-200 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-red-600 to-red-700 h-1.5 rounded-full transition-all duration-300" 
                             style="width: {{ min(100, ($totalScore / max(1, $engagementSummary->max(fn($r) => $r->sum('total')))) * 100) }}%"></div>
                    </div>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div class="text-lg font-medium">No student engagement data found</div>
                <div class="text-sm">Try adjusting your filters or check back later.</div>
            </td>
        </tr>
    @endforelse
</tbody>
    </table>
</div>

                
                <!-- Pagination Info -->
                @if($engagementSummary->count() > 0)
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $engagementSummary->count() }}</span> students
                        </div>
                        <div class="text-sm text-gray-500">
                            Last updated: {{ now()->format('M d, Y H:i') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
    @php
    $topStudents = $engagementSummary
        ->filter(function($records) {
            return $records->first()->user && $records->first()->user->role === 'student';
        })
        ->take(10)
        ->map(function($records) {
            $logins = $records->where('action', 'login')->sum('total');
            $quizzes = $records->where('action', 'quiz_attempt')->sum('total');
            $uploads = $records->where('action', 'activity_upload')->sum('total');
            $enrollments = $records->where('action', 'course_enrollment')->sum('total');
            $downloads = $records->where('action', 'material_download')->sum('total');

            return [
                'name' => $records->first()->user->name,
                'total' => $logins + $quizzes + $uploads + $enrollments + $downloads,
            ];
        })
        ->values();
@endphp

    <!-- Chart.js and D3.js for heatmaps -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.6.1/d3.min.js"></script>
    
    <script>

            document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (!params.has('subject_id')) {
            document.getElementById('subject_id').form.submit();
        }
    });
        // Global variables - FIXED: Only student data
    window.topStudentsData = @json($topStudents);
    window.heatmapData = @json($heatmapData ?? []);
    let activityChart, engagementChart;
    let sortDirection = 1;
    const heatmapData = @json($heatmapData ?? []);

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            initializeCharts();
            initializeHeatmaps();
            initializeSearch();
        }, 100);
    });

        function initializeCharts() {
            const activityCtx = document.getElementById('activityChart');
            if (!activityCtx) return;
            
            const ctx = activityCtx.getContext('2d');
            
            activityChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Logins', 'Quiz Attempts', 'Uploads', 'Enrollments', 'Downloads'],
                    datasets: [{
                        data: [
                            parseInt('{{ $activityStats["logins"] ?? 0 }}'),
                            parseInt('{{ $activityStats["quizzes"] ?? 0 }}'),
                            parseInt('{{ $activityStats["uploads"] ?? 0 }}'),
                            parseInt('{{ $activityStats["enrollments"] ?? 0 }}'),
                            parseInt('{{ $activityStats["downloads"] ?? 0 }}')
                        ],
                        backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EF4444'],
                        borderWidth: 4,
                        borderColor: '#FFFFFF',
                        hoverOffset: 12,
                        hoverBorderWidth: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 25,
                                usePointStyle: true,
                                font: { size: 13, weight: '500' }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.9)',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            cornerRadius: 8,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                    return `${context.label}: ${context.raw} student activities (${percentage}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1200,
                        easing: 'easeOutQuart'
                    }
                }
            });

            const engagementCtx = document.getElementById('engagementChart');
            if (!engagementCtx) return;
            
            const engCtx = engagementCtx.getContext('2d');
            const topStudentsData = window.topStudentsData || [];
            
            const gradient = engCtx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, '#DC2626');
            gradient.addColorStop(1, '#B91C1C');

            engagementChart = new Chart(engCtx, {
                type: 'bar',
                data: {
                    labels: topStudentsData.map(s => s.name && s.name.length > 15 ? s.name.substring(0, 15) + '...' : s.name || 'N/A'),
                    datasets: [{
                        label: 'Total Activities',
                        data: topStudentsData.map(s => s.total || 0),
                        backgroundColor: gradient,
                        borderColor: '#991B1B',
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                        hoverBackgroundColor: '#7F1D1D',
                        hoverBorderColor: '#450A0A',
                        hoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.08)', lineWidth: 1 },
                            ticks: { font: { size: 12, weight: '500' }, color: '#6B7280', padding: 8 },
                            title: { display: true, text: 'Number of Student Activities', color: '#374151', font: { size: 13, weight: '600' } }
                        },
                        x: { 
                            ticks: { maxRotation: 45, font: { size: 11, weight: '500' }, color: '#6B7280', padding: 8 },
                            grid: { display: false },
                            title: { display: true, text: 'Students', color: '#374151', font: { size: 13, weight: '600' } }
                        }
                    },
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.9)',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            borderColor: '#DC2626',
                            borderWidth: 2,
                            cornerRadius: 8,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return `Total Student Activities: ${context.raw}`;
                                }
                            }
                        }
                    },
                    animation: { duration: 1500, easing: 'easeOutQuart' }
                }
            });

            setTimeout(() => {
                const activityLoader = document.getElementById('activityChartLoader');
                const engagementLoader = document.getElementById('engagementChartLoader');
                
                if (activityLoader) activityLoader.style.display = 'none';
                if (engagementLoader) engagementLoader.style.display = 'none';
                
                if (activityCtx) activityCtx.classList.remove('opacity-0');
                if (engagementCtx) engagementCtx.classList.remove('opacity-0');
            }, 800);
        }

        function initializeHeatmaps() {
            if (!heatmapData || Object.keys(heatmapData).length === 0) {
                console.log('No student heatmap data available');
                return;
            }

            initializeDailyHeatmap();
            initializeWeeklyHeatmap();
            initializeStudentMatrixHeatmap();

            setTimeout(() => {
                document.getElementById('dailyHeatmapLoader').style.display = 'none';
                document.getElementById('weeklyHeatmapLoader').style.display = 'none';
                document.getElementById('matrixHeatmapLoader').style.display = 'none';
            }, 1000);
        }

        function initializeSearch() {
            const searchInput = document.getElementById('studentSearch');
            const tableBody = document.getElementById('tableBody');
            const rows = Array.from(tableBody.getElementsByTagName('tr'));

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                rows.forEach(row => {
                    const studentCell = row.querySelector('td[data-label]');
                    if (studentCell) {
                        const studentName = studentCell.getAttribute('data-label');
                        if (studentName.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
                
                const visibleRows = rows.filter(row => row.style.display !== 'none');
                if (visibleRows.length === 0 && searchTerm !== '') {
                    showNoResultsMessage();
                } else {
                    hideNoResultsMessage();
                }
            });
        }

        function sortTable(columnIndex) {
            const table = document.getElementById('engagementTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');
            
            sortDirection *= -1;
            
            rows.sort((a, b) => {
                let aValue, bValue;
                
                if (columnIndex === 0) {
                    aValue = a.querySelector('td[data-label]').getAttribute('data-label');
                    bValue = b.querySelector('td[data-label]').getAttribute('data-label');
                } else {
                    aValue = parseInt(a.cells[columnIndex].getAttribute('data-value') || 0);
                    bValue = parseInt(b.cells[columnIndex].getAttribute('data-value') || 0);
                }
                
                if (typeof aValue === 'string') {
                    return sortDirection * aValue.localeCompare(bValue);
                } else {
                    return sortDirection * (aValue - bValue);
                }
            });
            
            rows.forEach(row => tbody.appendChild(row));
            updateSortIndicators(columnIndex);
        }

        function updateSortIndicators(activeColumn) {
            const headers = document.querySelectorAll('#engagementTable th');
            headers.forEach((header, index) => {
                const svg = header.querySelector('svg');
                if (svg) {
                    if (index === activeColumn) {
                        svg.style.transform = sortDirection === 1 ? 'rotate(0deg)' : 'rotate(180deg)';
                        svg.style.opacity = '1';
                    } else {
                        svg.style.transform = 'rotate(0deg)';
                        svg.style.opacity = '0.5';
                    }
                }
            });
        }

        function exportToCSV() {
            const table = document.getElementById('engagementTable');
            const rows = table.querySelectorAll('tr');
            let csvContent = '';
            
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    const cells = row.querySelectorAll('th, td');
                    const rowData = Array.from(cells).map(cell => {
                        return '"' + cell.textContent.trim().replace(/"/g, '""') + '"';
                    });
                    csvContent += rowData.join(',') + '\n';
                }
            });
            
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', `student_engagement_${new Date().toISOString().split('T')[0]}.csv`);
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function printReport() {
            const printWindow = window.open('', '', 'height=600,width=800');
            const tableHTML = document.getElementById('engagementTable').outerHTML;
            
            printWindow.document.write(`
                <html>
                <head>
                    <title>Student Engagement Report</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        table { border-collapse: collapse; width: 100%; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #DC2626; color: white; }
                        .badge { background-color: #f0f0f0; padding: 2px 6px; border-radius: 4px; }
                        h1 { color: #DC2626; }
                    </style>
                </head>
                <body>
                    <h1>Student Engagement Analytics Report</h1>
                    <p>Generated on: ${new Date().toLocaleDateString()}</p>
                    <p>Note: This report contains student data.</p>
                    ${tableHTML}
                </body>
                </html>
            `);
            
            printWindow.document.close();
            printWindow.print();
        }

        function showNoResultsMessage() {
            const tbody = document.getElementById('tableBody');
            if (!document.getElementById('noResults')) {
                const noResults = document.createElement('tr');
                noResults.id = 'noResults';
                noResults.innerHTML = `
                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <div class="text-lg font-medium">No students found</div>
                        <div class="text-sm">Try adjusting your search terms.</div>
                    </td>
                `;
                tbody.appendChild(noResults);
            }
        }

        function hideNoResultsMessage() {
            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.remove();
            }
        }
  
function initializeDailyHeatmap() {
    if (!heatmapData.daily_activity) return;

    const container = d3.select("#dailyHeatmap");
    container.selectAll("*").remove();

    // Create month selector dropdown
    const monthSelectorContainer = container.append("div")
        .style("margin-bottom", "20px")
        .style("display", "flex")
        .style("align-items", "center")
        .style("gap", "10px");

    monthSelectorContainer.append("label")
        .style("font-weight", "600")
        .style("color", "#374151")
        .style("font-size", "14px")
        .text("Select Month:");

    // Initialize with current month
    let selectedDate = new Date();
    selectedDate.setDate(1);

    const monthDropdown = monthSelectorContainer.append("select")
        .style("padding", "8px 12px")
        .style("border", "1px solid #d1d5db")
        .style("border-radius", "6px")
        .style("font-size", "14px")
        .style("background-color", "#ffffff")
        .style("cursor", "pointer")
        .style("font-weight", "500")
        .style("color", "#374151");

    // Populate dropdown with all months of current year
    const currentYear = new Date().getFullYear();
    const months = [];
    for (let i = 0; i < 12; i++) {
        const date = new Date(currentYear, i, 1);
        months.push({
            date: new Date(date),
            label: date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })
        });
    }

    monthDropdown.selectAll("option")
        .data(months)
        .enter().append("option")
        .attr("value", (d, i) => i)
        .attr("selected", (d, i) => i === new Date().getMonth() ? "selected" : null)
        .text(d => d.label);

    // Set dropdown to current month
    monthDropdown.property("value", new Date().getMonth());

    // Function to render heatmap
    function renderHeatmap(monthDate) {
        const data = heatmapData.daily_activity;
        const margin = { top: 40, right: 250, bottom: 120, left: 290 };
        const width = container.node().getBoundingClientRect().width - margin.left - margin.right;
        const height = 400 - margin.top - margin.bottom;

        const svg = container.append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .style("background", "linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)")
            .style("border-radius", "12px")
            .style("box-shadow", "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)");

        const g = svg.append("g")
            .attr("transform", `translate(${margin.left},${margin.top})`);

        // --- CALENDAR RANGE SETUP ---
        const selectedYear = monthDate.getFullYear();
        const selectedMonth = monthDate.getMonth();
        const today = new Date();

        const monthStart = new Date(selectedYear, selectedMonth, 1);
        const monthEnd = new Date(selectedYear, selectedMonth + 1, 0);

        // Force full week grid (Sunday–Saturday)
        const calendarStart = new Date(monthStart);
        calendarStart.setDate(monthStart.getDate() - monthStart.getDay());

        const calendarEnd = new Date(monthEnd);
        if (monthEnd.getDay() !== 6) {
            calendarEnd.setDate(monthEnd.getDate() + (6 - monthEnd.getDay()));
        }

        const totalDays = Math.round((calendarEnd - calendarStart) / (1000 * 60 * 60 * 24)) + 1;
        const weeks = Math.ceil(totalDays / 7);

        // Map data by date
        const dataMap = new Map();
        data.forEach(d => dataMap.set(d.date, d));

        // --- BUILD CALENDAR CELLS ---
        const calendarData = [];
        for (let i = 0; i < totalDays; i++) {
            const currentDate = new Date(calendarStart);
            currentDate.setDate(calendarStart.getDate() + i);
            const dateString = currentDate.toISOString().split('T')[0];

            // Parse the actual date
            const dateParts = dateString.split('-');
            const cellYear = parseInt(dateParts[0]);
            const cellMonth = parseInt(dateParts[1]) - 1;
            
            const isCurrentMonth = cellMonth === selectedMonth && cellYear === selectedYear;
            
            const record = dataMap.get(dateString) || {
                date: dateString,
                total: 0,
                activities: {
                    login: 0,
                    quiz_attempt: 0,
                    activity_upload: 0,
                    course_enrollment: 0,
                    material_download: 0
                },
                isEmpty: true
            };

            calendarData.push({ ...record, isCurrentMonth });
        }

        // --- TITLE ---
        svg.append("text")
            .attr("x", (width + margin.left + margin.right) / 2)
            .attr("y", 25)
            .attr("text-anchor", "middle")
            .attr("font-size", "18px")
            .attr("font-weight", "600")
            .attr("fill", "#1f2937")
            .text(`Daily Student Activity - ${monthStart.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}`);

        const cellSize = 45;
        const gridWidth = weeks * cellSize;
        const gridHeight = 7 * cellSize;
        const offsetX = (width - gridWidth) / 2;
        g.attr("transform", `translate(${margin.left + offsetX}, ${margin.top})`);

        // --- COLOR SCALE ---
        const maxTotal = d3.max(data, d => d.total) || 1;
        const colorScale = d3.scaleSequential()
            .domain([0, maxTotal])
            .interpolator(d3.interpolateRgb("#e5f3ff", "#1e40af"));

        // --- DAY LABELS ---
        const dayLabels = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
        g.selectAll(".day-label")
            .data(dayLabels)
            .enter().append("text")
            .attr("class", "day-label")
            .attr("x", -20)
            .attr("y", (d, i) => i * cellSize + cellSize / 2)
            .attr("text-anchor", "end")
            .attr("dominant-baseline", "middle")
            .attr("font-size", "12px")
            .attr("font-weight", "500")
            .attr("fill", "#6b7280")
            .text(d => d);

        // --- GRID CELLS ---
        const cells = g.selectAll(".day")
            .data(calendarData)
            .enter().append("g")
            .attr("class", "day")
            .attr("transform", d => {
                const date = new Date(d.date);
                const dayOfWeek = date.getDay();
                const daysSinceStart = Math.floor((date - calendarStart) / (1000 * 60 * 60 * 24));
                const week = Math.floor(daysSinceStart / 7);
                return `translate(${week * cellSize}, ${dayOfWeek * cellSize})`;
            });

        // --- SHADOW FILTER ---
        const defs = svg.append("defs");
        const filter = defs.append("filter")
            .attr("id", "dropshadow")
            .attr("width", "130%")
            .attr("height", "130%");
        filter.append("feDropShadow")
            .attr("dx", "1")
            .attr("dy", "1")
            .attr("stdDeviation", "1")
            .attr("flood-color", "rgba(0,0,0,0.1)")
            .attr("flood-opacity", "0.3");

        // --- RECTANGLES ---
        const todayStr = today.toISOString().split('T')[0];
        const rects = cells.append("rect")
            .attr("width", cellSize - 4)
            .attr("height", cellSize - 4)
            .attr("rx", 6)
            .attr("ry", 6)
            .attr("fill", d => (d.total === 0 || d.isEmpty) ? "#f9fafb" : colorScale(d.total))
            .attr("stroke", d => d.date === todayStr ? "#3b82f6" : "#ffffff")
            .attr("stroke-width", d => d.date === todayStr ? 3 : 2)
            .attr("filter", d => d.isEmpty ? "none" : "url(#dropshadow)")
            .attr("opacity", d => d.isCurrentMonth ? 1 : 0)
            .style("cursor", d => (d.isEmpty || !d.isCurrentMonth) ? "default" : "pointer")
            .style("transition", "all 0.2s ease")
            .on("mouseover", function(event, d) {
                if (d.isEmpty || !d.isCurrentMonth) return;
                
                d3.select(this)
                    .transition()
                    .duration(150)
                    .attr("transform", "scale(1.1)")
                    .attr("stroke", "#3b82f6")
                    .attr("stroke-width", 3);

                const tooltip = d3.select("body").append("div")
                    .attr("class", "heatmap-tooltip")
                    .style("position", "absolute")
                    .style("background", "linear-gradient(135deg, #1f2937 0%, #374151 100%)")
                    .style("color", "white")
                    .style("padding", "12px 16px")
                    .style("border-radius", "8px")
                    .style("font-size", "13px")
                    .style("font-family", "system-ui, -apple-system, sans-serif")
                    .style("box-shadow", "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)")
                    .style("z-index", "1000")
                    .style("opacity", "0")
                    .style("pointer-events", "none")
                    .html(`
                        <div style="font-weight: 600; margin-bottom: 8px; color: #f9fafb;">
                            ${new Date(d.date).toLocaleDateString('en-US', { 
                                weekday: 'long', 
                                year: 'numeric', 
                                month: 'short', 
                                day: 'numeric' 
                            })}
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <div style="display: flex; justify-content: space-between; min-width: 160px;">
                                <span style="color: #60a5fa;">🔑 Logins:</span>
                                <span style="font-weight: 600; color: #34d399;">${d.activities.login}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #60a5fa;">📝 Quiz Attempts:</span>
                                <span style="font-weight: 600; color: #fbbf24;">${d.activities.quiz_attempt}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #60a5fa;">📤 Uploads:</span>
                                <span style="font-weight: 600; color: #f87171;">${d.activities.activity_upload}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #60a5fa;">📚 Enrollments:</span>
                                <span style="font-weight: 600; color: #a78bfa;">${d.activities.course_enrollment}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #60a5fa;">⬇️ Downloads:</span>
                                <span style="font-weight: 600; color: #fb7185;">${d.activities.material_download}</span>
                            </div>
                            <div style="border-top: 1px solid #4b5563; margin-top: 6px; padding-top: 4px;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #e5e7eb; font-weight: 600;">Total Activities:</span>
                                    <span style="font-weight: 700; color: #fbbf24;">${d.total}</span>
                                </div>
                            </div>
                        </div>
                    `);

                tooltip.transition()
                    .duration(200)
                    .style("opacity", "1");

                const tooltipNode = tooltip.node();
                const tooltipRect = tooltipNode.getBoundingClientRect();
                const x = event.pageX + 15;
                const y = event.pageY - 10;
                
                tooltip.style("left", (x + tooltipRect.width > window.innerWidth ? x - tooltipRect.width - 30 : x) + "px")
                    .style("top", (y - tooltipRect.height < 0 ? y + 30 : y - tooltipRect.height) + "px");
            })
            .on("mouseout", function(event, d) {
                if (d.isEmpty || !d.isCurrentMonth) return;
                
                d3.select(this)
                    .transition()
                    .duration(150)
                    .attr("transform", "scale(1)")
                    .attr("stroke", d.date === todayStr ? "#3b82f6" : "#ffffff")
                    .attr("stroke-width", d.date === todayStr ? 3 : 2);

                d3.selectAll(".heatmap-tooltip")
                    .transition()
                    .duration(150)
                    .style("opacity", "0")
                    .remove();
            });

        // --- DATE TEXT ---
        cells.append("text")
            .attr("x", cellSize / 2 - 2)
            .attr("y", cellSize / 2)
            .attr("text-anchor", "middle")
            .attr("dominant-baseline", "middle")
            .attr("font-size", "11px")
            .attr("font-weight", d => d.date === todayStr ? "700" : "500")
            .attr("fill", d => {
                if (!d.isCurrentMonth) return "transparent";
                if (d.isEmpty) return "#9ca3af";
                const intensity = d.total / maxTotal;
                return intensity > 0.5 ? "rgba(255,255,255,0.9)" : "rgba(55,65,81,0.8)";
            })
            .text(d => {
                if (!d.isCurrentMonth) return "";
                const date = new Date(d.date);
                return date.getDate();
            });

        // --- LEGEND ---
        const legendWidth = 150;
        const legendHeight = 20;
        const legendX = width + margin.left - 50;
        const legendY = margin.top + 30;
        
        const legend = svg.append("g")
            .attr("transform", `translate(${legendX}, ${legendY})`);

        const legendScale = d3.scaleLinear()
            .domain([0, maxTotal])
            .range([0, legendWidth]);

        const legendAxis = d3.axisBottom(legendScale)
            .ticks(4)
            .tickFormat(d3.format("d"));

        // Create gradient for legend
        const legendGradient = defs.append("linearGradient")
            .attr("id", "legendGradient")
            .attr("x1", "0%").attr("y1", "0%")
            .attr("x2", "100%").attr("y2", "0%");

        const steps = 10;
        for (let i = 0; i <= steps; i++) {
            legendGradient.append("stop")
                .attr("offset", `${(i / steps) * 100}%`)
                .attr("stop-color", colorScale(maxTotal * i / steps));
        }

        legend.append("text")
            .attr("x", legendWidth / 2)
            .attr("y", -12)
            .attr("text-anchor", "middle")
            .attr("font-size", "12px")
            .attr("font-weight", "600")
            .attr("fill", "#374151")
            .text("Activity Level");

        legend.append("rect")
            .attr("width", legendWidth)
            .attr("height", legendHeight)
            .attr("fill", "url(#legendGradient)")
            .attr("stroke", "#d1d5db")
            .attr("stroke-width", 1)
            .attr("rx", 4);

        legend.append("g")
            .attr("transform", `translate(0, ${legendHeight})`)
            .call(legendAxis)
            .selectAll("text")
            .attr("font-size", "10px")
            .attr("fill", "#6b7280");

        // --- STATS PANEL ---
        const statsX = margin.left - 180;
        const statsY = margin.top + 30;
        const stats = svg.append("g")
            .attr("transform", `translate(${statsX}, ${statsY})`);

        // Calculate stats
        const totalActivities = data.reduce((sum, d) => sum + d.total, 0);
        const avgDaily = Math.round(totalActivities / data.length) || 0;
        const maxDay = Math.max(...data.map(d => d.total)) || 0;
        const activeDay = data.filter(d => d.total > 0).length;

        const statItems = [
            { label: "Total", value: totalActivities, color: "#3b82f6" },
            { label: "Avg/Day", value: avgDaily, color: "#10b981" },
            { label: "Peak", value: maxDay, color: "#f59e0b" },
            { label: "Active Days", value: activeDay, color: "#8b5cf6" }
        ];

        statItems.forEach((item, i) => {
            const statGroup = stats.append("g")
                .attr("transform", `translate(0, ${i * 70})`);

            statGroup.append("rect")
                .attr("width", 140)
                .attr("height", 60)
                .attr("rx", 8)
                .attr("fill", "#ffffff")
                .attr("stroke", "#e5e7eb")
                .attr("stroke-width", 1)
                .attr("opacity", 0.9);

            statGroup.append("circle")
                .attr("cx", 18)
                .attr("cy", 15)
                .attr("r", 6)
                .attr("fill", item.color);

            statGroup.append("text")
                .attr("x", 32)
                .attr("y", 13)
                .attr("font-size", "12px")
                .attr("font-weight", "600")
                .attr("fill", "#6b7280")
                .text(item.label);

            statGroup.append("text")
                .attr("x", 70)
                .attr("y", 42)
                .attr("text-anchor", "middle")
                .attr("font-size", "22px")
                .attr("font-weight", "700")
                .attr("fill", item.color)
                .text(item.value);
        });
    }

    // Initial render
    renderHeatmap(selectedDate);

    // Handle dropdown change
    monthDropdown.on("change", function() {
        const selectedIndex = parseInt(d3.select(this).property("value"));
        const newDate = new Date(months[selectedIndex].date);
        selectedDate = new Date(newDate);
        
        // Clear only the SVG, keep the dropdown
        container.selectAll("svg").remove();
        renderHeatmap(selectedDate);
    });
}
function initializeWeeklyHeatmap() {
    if (!heatmapData.weekly_pattern) return;

    const data = heatmapData.weekly_pattern;
    const container = d3.select("#weeklyHeatmap");
    
    container.selectAll("*").remove();

    const margin = { top: 60, right: 80, bottom: 120, left: 120 };
    const width = container.node().getBoundingClientRect().width - margin.left - margin.right;
    const height = 450 - margin.top - margin.bottom;

    const svg = container.append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .style("background", "#fefefe");

    const g = svg.append("g")
        .attr("transform", `translate(${margin.left},${margin.top})`);

    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    const hours = Array.from({length: 24}, (_, i) => i);

    // Calculate cell dimensions with padding built in
    const cellPadding = 2;
    const cellWidth = width / 24;
    const cellHeight = height / 7;
    const cellSize = Math.min(cellWidth, cellHeight) - cellPadding;

    const maxCount = d3.max(data, d => d.count) || 1;
    const colorScale = d3.scaleSequential()
        .domain([0, maxCount])
        .interpolator(d3.interpolateRgb("#fff5f5", "#dc2626"));

    // Create a container group for cells (will be drawn first)
    const cellsGroup = g.append("g").attr("class", "cells-group");

    // Create heatmap cells centered within their grid cells
    const cells = cellsGroup.selectAll(".cell")
        .data(data)
        .enter().append("rect")
        .attr("class", "cell")
        .attr("x", d => d.hour * cellWidth + (cellWidth - cellSize) / 2)
        .attr("y", d => d.day * cellHeight + (cellHeight - cellSize) / 2)
        .attr("width", cellSize)
        .attr("height", cellSize)
        .attr("rx", 2)
        .attr("ry", 2)
        .attr("fill", d => d.count === 0 ? "#f8fafc" : colorScale(d.count))
        .attr("stroke", d => d.count === 0 ? "#e2e8f0" : "#fecaca")
        .attr("stroke-width", 1)
        .style("cursor", "pointer")
        .style("transition", "all 0.2s ease")
        .on("mouseover", function(event, d) {
            d3.select(this)
                .attr("stroke", "#991b1b")
                .attr("stroke-width", 2)
                .style("filter", "brightness(1.1)");
            
            const tooltip = d3.select("body").append("div")
                .attr("class", "heatmap-tooltip")
                .style("position", "absolute")
                .style("background", "rgba(17, 24, 39, 0.95)")
                .style("color", "white")
                .style("padding", "12px 16px")
                .style("border-radius", "8px")
                .style("font-size", "13px")
                .style("font-family", "system-ui, -apple-system, sans-serif")
                .style("box-shadow", "0 10px 25px rgba(0,0,0,0.2)")
                .style("z-index", "1000")
                .style("pointer-events", "none")
                .style("border", "1px solid rgba(255,255,255,0.1)")
                .html(`
                    <div style="font-weight: 600; margin-bottom: 4px; color: #fca5a5;">
                        ${days[d.day]} ${d.hour.toString().padStart(2, '0')}:00
                    </div>
                    <div style="color: #e5e7eb;">
                        Student Activities: <span style="font-weight: 500; color: white;">${d.count}</span>
                    </div>
                `);
            
            tooltip.style("left", (event.pageX + 15) + "px")
                .style("top", (event.pageY + 15) + "px");
        })
        .on("mouseout", function() {
            d3.select(this)
                .attr("stroke", d => d.count === 0 ? "#e2e8f0" : "#fecaca")
                .attr("stroke-width", 1)
                .style("filter", "none");
            
            d3.selectAll(".heatmap-tooltip").remove();
        });

    // Create grid lines group (drawn after cells, so they appear on top)
    const gridGroup = g.append("g").attr("class", "grid-group");

    // Vertical grid lines
    gridGroup.selectAll(".grid-line-vertical")
        .data(hours)
        .enter().append("line")
        .attr("class", "grid-line-vertical")
        .attr("x1", d => d * cellWidth)
        .attr("x2", d => d * cellWidth)
        .attr("y1", 0)
        .attr("y2", height)
        .attr("stroke", "#e5e7eb")
        .attr("stroke-width", 1)
        .attr("pointer-events", "none");

    // Horizontal grid lines
    gridGroup.selectAll(".grid-line-horizontal")
        .data(days)
        .enter().append("line")
        .attr("class", "grid-line-horizontal")
        .attr("x1", 0)
        .attr("x2", width)
        .attr("y1", (d, i) => i * cellHeight)
        .attr("y2", (d, i) => i * cellHeight)
        .attr("stroke", "#e5e7eb")
        .attr("stroke-width", 1)
        .attr("pointer-events", "none");

    // Draw outer border to complete the frame
    gridGroup.append("rect")
        .attr("x", 0)
        .attr("y", 0)
        .attr("width", width)
        .attr("height", height)
        .attr("fill", "none")
        .attr("stroke", "#cbd5e1")
        .attr("stroke-width", 2)
        .attr("pointer-events", "none");

    // Day labels
    g.selectAll(".day-label")
        .data(days)
        .enter().append("text")
        .attr("class", "day-label")
        .attr("x", -20)
        .attr("y", (d, i) => i * cellHeight + cellHeight / 2)
        .attr("text-anchor", "end")
        .attr("dominant-baseline", "middle")
        .attr("font-size", "13px")
        .attr("font-weight", "500")
        .attr("fill", "#374151")
        .attr("font-family", "system-ui, -apple-system, sans-serif")
        .text(d => d);

    // Hour labels
    const hourLabels = Array.from({length: 24}, (_, i) => i);
    g.selectAll(".hour-label")
        .data(hourLabels)
        .enter().append("text")
        .attr("class", "hour-label")
        .attr("x", d => d * cellWidth + cellWidth / 2)
        .attr("y", height + 30)
        .attr("text-anchor", "middle")
        .attr("font-size", "10px")
        .attr("font-weight", "500")
        .attr("fill", "#6b7280")
        .attr("font-family", "system-ui, -apple-system, sans-serif")
        .text(d => {
            if (d === 0) return "12 AM";
            if (d < 12) return `${d} AM`;
            if (d === 12) return "12 PM";
            return `${d - 12} PM`;
        });

    // Title
    svg.append("text")
        .attr("class", "heatmap-title")
        .attr("x", margin.left + width / 2)
        .attr("y", 30)
        .attr("text-anchor", "middle")
        .attr("font-size", "18px")
        .attr("font-weight", "600")
        .attr("fill", "#111827")
        .attr("font-family", "system-ui, -apple-system, sans-serif")
        .text("Weekly Student Activity Pattern");

    // Legend
    const legendWidth = 180;
    const legendHeight = 10;
    const legend = svg.append("g")
        .attr("class", "legend")
        .attr("transform", `translate(${margin.left + (width - legendWidth) / 2}, ${height + margin.top + 55})`);

    const defs = svg.append("defs");
    const gradient = defs.append("linearGradient")
        .attr("id", "legend-gradient")
        .attr("x1", "0%")
        .attr("x2", "100%");

    gradient.append("stop")
        .attr("offset", "0%")
        .attr("stop-color", "#fff5f5");
    
    gradient.append("stop")
        .attr("offset", "100%")
        .attr("stop-color", "#dc2626");

    legend.append("rect")
        .attr("width", legendWidth)
        .attr("height", legendHeight)
        .attr("rx", 2)
        .style("fill", "url(#legend-gradient)")
        .attr("stroke", "#d1d5db")
        .attr("stroke-width", 1);

    legend.append("text")
        .attr("x", 0)
        .attr("y", legendHeight + 18)
        .attr("text-anchor", "start")
        .attr("font-size", "11px")
        .attr("fill", "#6b7280")
        .attr("font-family", "system-ui, -apple-system, sans-serif")
        .text("Less");

    legend.append("text")
        .attr("x", legendWidth)
        .attr("y", legendHeight + 18)
        .attr("text-anchor", "end")
        .attr("font-size", "11px")
        .attr("fill", "#6b7280")
        .attr("font-family", "system-ui, -apple-system, sans-serif")
        .text("More");

    legend.append("text")
        .attr("x", legendWidth / 2)
        .attr("y", -8)
        .attr("text-anchor", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "500")
        .attr("fill", "#374151")
        .attr("font-family", "system-ui, -apple-system, sans-serif")
        .text("Student Activity Level");
}
function initializeStudentMatrixHeatmap() {
    if (!heatmapData.student_matrix || !heatmapData.student_matrix.matrix) return;

    const matrixData = heatmapData.student_matrix.matrix;
    const activities = heatmapData.student_matrix.activities;
    const container = d3.select("#studentMatrixHeatmap");
    
    // Clear existing content
    container.selectAll("*").remove();

    // Enhanced margins and spacing
    const margin = { top: 40, right: 80, bottom: 120, left: 180 };
    const containerWidth = container.node().getBoundingClientRect().width;
    const width = Math.max(600, containerWidth - margin.left - margin.right);
    const height = Math.max(400, matrixData.length * 35) - margin.top - margin.bottom;

    // Create main SVG with enhanced styling
    const svg = container.append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .style("background", "linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)")
        .style("border-radius", "12px")
        .style("box-shadow", "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)")
        .style("font-family", "'Inter', -apple-system, BlinkMacSystemFont, sans-serif");

    // Add subtle border
    svg.append("rect")
        .attr("width", "100%")
        .attr("height", "100%")
        .attr("fill", "none")
        .attr("stroke", "#e2e8f0")
        .attr("stroke-width", 1)
        .attr("rx", 12);

    const g = svg.append("g")
        .attr("transform", `translate(${margin.left},${margin.top})`);

    // Enhanced dimensions with better spacing
    const cellWidth = Math.max(60, width / activities.length);
    const cellHeight = Math.max(30, height / matrixData.length);

    // Modern red color scale with lighter gradient
    const maxActivity = d3.max(matrixData, student => 
        d3.max(activities, activity => student.activities[activity])
    ) || 1;
    
    // Create a sophisticated red gradient color scale
    const colorScale = d3.scaleSequential()
        .domain([0, maxActivity])
        .interpolator(t => {
            if (t === 0) return "#fef2f2";
            // Light red to darker red gradient: from rose-50 to rose-600
            return d3.interpolateRgb("#fecaca", "#dc2626")(t);
        });

    // Create matrix data for visualization - ONLY STUDENTS
    const cellData = [];
    matrixData.forEach((student, studentIndex) => {
        activities.forEach((activity, activityIndex) => {
            cellData.push({
                student: student.student_name,
                activity: activity,
                value: student.activities[activity],
                studentIndex,
                activityIndex
            });
        });
    });

    // Add subtle grid background
    g.append("rect")
        .attr("width", width)
        .attr("height", height)
        .attr("fill", "#ffffff")
        .attr("stroke", "#f1f5f9")
        .attr("stroke-width", 1)
        .attr("rx", 8);

    // Create enhanced heatmap cells with animations
    const cells = g.selectAll(".matrix-cell")
        .data(cellData)
        .enter().append("rect")
        .attr("class", "matrix-cell")
        .attr("x", d => d.activityIndex * cellWidth)
        .attr("y", d => d.studentIndex * cellHeight)
        .attr("width", cellWidth - 2)
        .attr("height", cellHeight - 2)
        .attr("rx", 4)
        .attr("ry", 4)
        .attr("fill", d => colorScale(d.value))
        .attr("stroke", "#ffffff")
        .attr("stroke-width", 2)
        .style("cursor", "pointer")
        .style("transition", "all 0.3s ease")
        .style("opacity", 0)
        .on("mouseover", function(event, d) {
            // Enhanced hover effect
            d3.select(this)
                .attr("stroke", "#4f46e5")
                .attr("stroke-width", 3)
                .style("filter", "brightness(1.1)");
            
            // FIXED: Create enhanced tooltip - student activity only, no time data
            const tooltip = d3.select("body").append("div")
                .attr("class", "matrix-tooltip")
                .style("position", "absolute")
                .style("background", "rgba(15, 23, 42, 0.95)")
                .style("color", "white")
                .style("padding", "12px 16px")
                .style("border-radius", "8px")
                .style("font-size", "13px")
                .style("font-weight", "500")
                .style("box-shadow", "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)")
                .style("z-index", "1000")
                .style("backdrop-filter", "blur(8px)")
                .style("border", "1px solid rgba(255, 255, 255, 0.1)")
                .html(`
                    <div style="font-weight: 600; margin-bottom: 4px; color: #60a5fa;"> ${d.student}</div>
                    <div style="color: #e2e8f0;">${d.activity.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</div>
                    <div style="font-size: 16px; font-weight: 700; margin-top: 4px; color: #fbbf24;">${d.value} activities</div>
                `);
            
            tooltip.style("left", (event.pageX + 15) + "px")
                .style("top", (event.pageY - 10) + "px")
                .style("opacity", 0)
                .transition()
                .duration(200)
                .style("opacity", 1);
        })
        .on("mouseout", function() {
            // Reset hover effect
            d3.select(this)
                .attr("stroke", "#ffffff")
                .attr("stroke-width", 2)
                .style("filter", "brightness(1)");
            
            d3.selectAll(".matrix-tooltip")
                .transition()
                .duration(200)
                .style("opacity", 0)
                .remove();
        });

    // Animate cells on load
    cells.transition()
        .duration(800)
        .delay((d, i) => i * 10)
        .style("opacity", 1);

    // Add value labels inside cells for better readability
    g.selectAll(".cell-value")
        .data(cellData.filter(d => d.value > 0))
        .enter().append("text")
        .attr("class", "cell-value")
        .attr("x", d => d.activityIndex * cellWidth + cellWidth / 2)
        .attr("y", d => d.studentIndex * cellHeight + cellHeight / 2)
        .attr("text-anchor", "middle")
        .attr("dominant-baseline", "middle")
        .attr("font-size", "11px")
        .attr("font-weight", "600")
        .attr("fill", d => d.value > maxActivity * 0.5 ? "#ffffff" : "#7f1d1d")
        .text(d => d.value)
        .style("opacity", 0)
        .transition()
        .duration(1000)
        .delay((d, i) => i * 12)
        .style("opacity", 1);

    // Enhanced student labels with better styling
    g.selectAll(".student-label")
        .data(matrixData)
        .enter().append("text")
        .attr("class", "student-label")
        .attr("x", -15)
        .attr("y", (d, i) => i * cellHeight + cellHeight / 2)
        .attr("text-anchor", "end")
        .attr("dominant-baseline", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "500")
        .attr("fill", "#475569")
        .text(d => d.student_name.length > 22 ? d.student_name.substring(0, 22) + '...' : d.student_name)
        .style("opacity", 0)
        .transition()
        .duration(600)
        .delay(400)
        .style("opacity", 1);

    // Enhanced activity labels with better rotation and styling
    g.selectAll(".activity-label")
        .data(activities)
        .enter().append("text")
        .attr("class", "activity-label")
        .attr("x", (d, i) => i * cellWidth + cellWidth / 2)
        .attr("y", height + 25)
        .attr("text-anchor", "middle")
        .attr("dominant-baseline", "middle")
        .attr("font-size", "11px")
        .attr("font-weight", "500")
        .attr("fill", "#64748b")
        .text(d => d.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()))
        .style("opacity", 0)
        .transition()
        .duration(600)
        .delay(600)
        .style("opacity", 1);

    // Enhanced legend with modern styling
    const legend = svg.append("g")
        .attr("transform", `translate(${width + margin.left + 20}, ${margin.top + 20})`);

    // Legend background
    legend.append("rect")
        .attr("x", -10)
        .attr("y", -15)
        .attr("width", 60)
        .attr("height", 140)
        .attr("fill", "#ffffff")
        .attr("stroke", "#e2e8f0")
        .attr("stroke-width", 1)
        .attr("rx", 8)
        .style("opacity", 0)
        .transition()
        .duration(800)
        .delay(1000)
        .style("opacity", 1);

    // Legend title
    legend.append("text")
        .attr("x", 15)
        .attr("y", -5)
        .attr("text-anchor", "middle")
        .attr("font-size", "11px")
        .attr("font-weight", "600")
        .attr("fill", "#374151")
        .text("Activity Count")
        .style("opacity", 0)
        .transition()
        .duration(600)
        .delay(1200)
        .style("opacity", 1);

    const legendHeight = 100;
    const legendScale = d3.scaleLinear()
        .domain([maxActivity, 0])
        .range([0, legendHeight]);

    const legendAxis = d3.axisRight(legendScale)
        .ticks(5)
        .tickFormat(d3.format(".0f"))
        .tickSize(3);

    // Enhanced gradient
    const legendGradient = svg.append("defs")
        .append("linearGradient")
        .attr("id", "legend-gradient-enhanced")
        .attr("gradientUnits", "userSpaceOnUse")
        .attr("x1", 0).attr("y1", 0)
        .attr("x2", 0).attr("y2", legendHeight);

    const gradientStops = d3.range(0, 1.1, 0.1);
    legendGradient.selectAll("stop")
        .data(gradientStops)
        .enter().append("stop")
        .attr("offset", d => `${d * 100}%`)
        .attr("stop-color", d => colorScale(maxActivity * (1 - d)));

    // Legend rectangle with enhanced styling
    legend.append("rect")
        .attr("x", 0)
        .attr("y", 5)
        .attr("width", 18)
        .attr("height", legendHeight)
        .attr("rx", 3)
        .style("fill", "url(#legend-gradient-enhanced)")
        .attr("stroke", "#e2e8f0")
        .attr("stroke-width", 1)
        .style("opacity", 0)
        .transition()
        .duration(600)
        .delay(1400)
        .style("opacity", 1);

    // Legend axis with styling
    legend.append("g")
        .attr("transform", `translate(18, 5)`)
        .style("opacity", 0)
        .call(legendAxis)
        .selectAll("text")
        .attr("font-size", "10px")
        .attr("fill", "#6b7280");

    legend.select("g")
        .transition()
        .duration(600)
        .delay(1600)
        .style("opacity", 1);

    // Add title if needed
    if (container.select(".heatmap-title").empty()) {
        container.insert("div", "svg")
            .attr("class", "heatmap-title")
            .style("text-align", "center")
            .style("margin-bottom", "20px")
            .style("font-size", "18px")
            .style("font-weight", "600")
            .style("color", "#1e293b")
            .style("font-family", "'Inter', sans-serif")
            .text("Student Activity Matrix")
            .style("opacity", 0)
            .transition()
            .duration(800)
            .style("opacity", 1);
    }
}
    </script>
</x-app-layout> 