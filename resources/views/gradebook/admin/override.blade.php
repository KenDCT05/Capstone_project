<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-stone-50 via-red-50 to-rose-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->

            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                
                        Admin Gradebook
                    </h1>
                    <p class="text-red-100 mt-2">Manage all student scores and attendance across all subjects</p>
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
            <!-- Filter Controls -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-red-100">
                <form method="GET" action="{{ route('admin.gradebook') }}" id="filter-form" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Teacher Selection -->
                        <div class="space-y-2">
                            <label class="block text-red-900 font-semibold text-sm uppercase tracking-wide">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                Select Teacher First
                            </label>
                            <div class="relative">
                                <select name="teacher_id" 
                                        id="teacher-select"
                                        class="w-full bg-white border-2 border-red-200 rounded-xl px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 appearance-none">
                                    @forelse($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ $selectedTeacher == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @empty
                                        <option disabled>No teachers available</option>
                                    @endforelse
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Subject Selection -->
                        <div class="space-y-2">
                            <label class="block text-red-900 font-semibold text-sm uppercase tracking-wide">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Select Subject
                            </label>
                            <div class="relative">
                                <select name="subject_id" 
                                        id="subject-select"
                                        class="w-full bg-white border-2 border-red-200 rounded-xl px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 appearance-none {{ $subjects->isEmpty() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $subjects->isEmpty() ? 'disabled' : '' }}>
                                    @forelse($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @empty
                                        <option disabled>
                                            @if($selectedTeacher)
                                                This teacher has no subjects assigned
                                            @else
                                                Please select a teacher first
                                            @endif
                                        </option>
                                    @endforelse
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Selection Display -->
                    @if($selectedTeacher && $selectedSubject)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-red-900 font-medium">
                                    Currently viewing: <strong>{{ $teachers->find($selectedTeacher)->name ?? 'Unknown Teacher' }}</strong> → 
                                    <strong>{{ $subjects->find($selectedSubject)->name ?? 'Unknown Subject' }}</strong>
                                    @if($students->isNotEmpty())
                                        ({{ $students->count() }} students enrolled)
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            <!-- No Data Message -->
            @if($students->isEmpty() || is_null($selectedSubject) || is_null($selectedTeacher))
                <div class="bg-white rounded-2xl shadow-xl p-8 text-center border border-red-100">
                    <div class="text-red-500 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 mt-4">Please Select a Subject</h3>
                        <p class="text-gray-600">Choose both a teacher and subject to view and edit the gradebook.</p>
                    </div>
                </div>
            @else
                <!-- Action Buttons for Adding New Assessments -->
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-red-100">
                    <div class="flex items-center mb-6">
                        <div class="bg-red-100 rounded-lg p-2 mr-3">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-red-900 font-bold text-xl">Add New Assessment</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <button type="button" id="add-quiz" 
                                class="group px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Quiz
                            </div>
                        </button>
                        <button type="button" id="add-activity" 
                                class="group px-8 py-4 bg-gradient-to-r from-red-700 to-red-800 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Activity
                            </div>
                        </button>
                        <button type="button" id="add-exam" 
                                class="group px-8 py-4 bg-gradient-to-r from-red-800 to-red-900 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Exam
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Gradebook Table Section -->
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-red-100">
                    <!-- Table Header -->
                    <div class="bg-gradient-to-r from-red-800 to-red-900 px-6 py-4 border-b border-red-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-white text-xl font-bold">Student Scores & Attendance ({{ $students->count() }} students)</h2>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-3 py-1">
                                    <span class="text-white text-sm font-medium">Admin override mode</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Container -->
                    <div class="p-6">
                        <div class="border-2 border-red-100 rounded-xl overflow-hidden">
                            <div id="gradebook-table" class="min-h-[500px]"></div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-center mt-8">
                    <button id="save-button"
                            class="group relative px-12 py-4 bg-gradient-to-r from-red-700 via-red-800 to-red-900 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:from-red-800 hover:via-red-900 hover:to-red-800">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            <span>Save All Changes</span>
                        </div>
                    </button>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/handsontable@13.0.0/dist/handsontable.full.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@13.0.0/dist/handsontable.full.min.css" />

        <style>
            .handsontable {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            }
            
            .handsontable .ht_master .wtHolder {
                background: #fef2f2;
            }
            
            .handsontable thead th {
                background: linear-gradient(135deg, #7c2d12 0%, #991b1b 100%);
                color: white;
                font-weight: 600;
                border-color: #dc2626;
            }
            
            .handsontable tbody th {
                background: #fef2f2;
                color: #7c2d12;
                font-weight: 600;
                border-color: #fecaca;
            }
            
            .handsontable td {
                border-color: #fecaca;
                transition: all 0.2s ease;
            }
            
            .handsontable td:hover {
                background-color: #fef2f2;
            }
            
            .handsontable td.area {
                background-color: #fee2e2;
            }
            
            .handsontable td.current {
                background-color: #dc2626 !important;
                color: white;
            }
            
            .handsontable .wtBorder {
                border-color: #dc2626;
            }
            
            .handsontable .htContextMenu {
                border-radius: 12px;
                box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            }

            /* Max Score Row Styling */
            .htMaxScore {
                background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%) !important;
                font-weight: 800 !important;
                color: #991b1b !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
                border: 2px solid #dc2626 !important;
                font-size: 15px !important;
            }

            .htMaxScore:hover {
                background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%) !important;
            }

            /* Attendance Column Styling */
            .htAttendance {
                background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
                color: #1e40af !important;
                font-weight: 600 !important;
            }
        </style>

        <script>
            // Fixed JavaScript for better form handling
            document.addEventListener('DOMContentLoaded', function() {
                const teacherSelect = document.getElementById('teacher-select');
                const subjectSelect = document.getElementById('subject-select');
                const form = document.getElementById('filter-form');

                // When teacher changes, reset subject and submit form
                teacherSelect.addEventListener('change', function() {
                    // Remove subject_id parameter when teacher changes
                    subjectSelect.value = '';
                    form.submit();
                });

                // When subject changes, submit form
                subjectSelect.addEventListener('change', function() {
                    form.submit();
                });
            });
        </script>

        @if($students->isNotEmpty() && !is_null($selectedSubject) && !is_null($selectedTeacher))
        <script>
            const container = document.getElementById('gradebook-table');
            const students = @json($students);
            const rawScores = @json($scores);
            const subjectId = {{ $selectedSubject }};
            const teacherId = {{ $selectedTeacher }};
            let allLabels = @json($columns);
            let maxScores = @json(isset($maxScores) ? $maxScores : []);

            // Ensure Attendance is always present
            if (!allLabels.includes('Attendance')) {
                allLabels.push('Attendance');
                maxScores['Attendance'] = 10; // Default max score for attendance
            }

            // Create table data from student scores
            let gradebookData = students.map(student => {
                const scores = rawScores[student.id] || [];
                const map = {};
                scores.forEach(s => map[s.label] = s.score);

                const row = { Name: student.name, student_id: student.id };
                allLabels.forEach(label => row[label] = map[label] ?? '');
                return row;
            });

            // Add max score row to the top
            const maxRow = { Name: 'Max Score', student_id: null };
            allLabels.forEach(label => {
                maxRow[label] = maxScores[label] || (label === 'Attendance' ? 10 : '');
            });
            gradebookData.unshift(maxRow);

            // Initialize Handsontable
            const hot = new Handsontable(container, {
                data: gradebookData,
                colHeaders: ['Student Name', ...allLabels],
                columns: [
                    { 
                        data: 'Name', 
                        readOnly: true,
                        width: 200,
                        className: 'text-red-900 font-semibold'
                    },
                    ...allLabels.map(label => ({ 
                        data: label, 
                        type: 'numeric',
                        numericFormat: {
                            pattern: '0.00'
                        },
                        width: label === 'Attendance' ? 120 : 100
                    }))
                ],
                rowHeaders: true,
                width: '100%',
                height: 500,
                licenseKey: 'non-commercial-and-evaluation',
                stretchH: 'all',
                
                cells: function (row, col) {
                    const cellProperties = {};

                    // Row 0 = Max Scores row
                    if (row === 0) {
                        cellProperties.className = 'htMaxScore';
                    }

                    // Attendance column styling
                    if (allLabels[col - 1] === 'Attendance' && row > 0) {
                        cellProperties.className = 'htAttendance';
                    }

                    return cellProperties;
                }
            });

            function updateTable() {
                const columns = [{ 
                    data: 'Name', 
                    readOnly: true, 
                    width: 200,
                    className: 'text-red-900 font-semibold'
                }];
                allLabels.forEach(label => columns.push({ 
                    data: label, 
                    type: 'numeric',
                    numericFormat: {
                        pattern: '0.00'
                    },
                    width: label === 'Attendance' ? 120 : 100
                }));

                // Rebuild rows with maxRow on top
                const updatedData = students.map(student => {
                    const scores = rawScores[student.id] || [];
                    const map = {};
                    scores.forEach(s => map[s.label] = s.score);

                    const row = { Name: student.name, student_id: student.id };
                    allLabels.forEach(label => row[label] = map[label] ?? '');
                    return row;
                });

                const newMaxRow = { Name: 'Max Score', student_id: null };
                allLabels.forEach(label => newMaxRow[label] = maxRow[label] || (label === 'Attendance' ? 10 : ''));
                gradebookData = [newMaxRow, ...updatedData];

                hot.updateSettings({
                    data: gradebookData,
                    colHeaders: ['Student Name', ...allLabels],
                    columns: columns
                });

                hot.render();
            }

            function getNextLabel(prefix) {
                const existing = allLabels.filter(l => l.startsWith(prefix));
                const nextNumber = existing.length + 1;
                return `${prefix} ${nextNumber}`;
            }

            function addColumn(type) {
                const newLabel = getNextLabel(type);
                allLabels.push(newLabel);
                gradebookData.forEach(row => row[newLabel] = '');
                
                // Set default max score for new column
                if (type === 'Attendance') {
                    maxRow[newLabel] = 10;
                } else {
                    maxRow[newLabel] = '';
                }
                
                updateTable();
            }

            // Event listeners for adding columns
            document.getElementById('add-quiz').addEventListener('click', () => addColumn('Quiz'));
            document.getElementById('add-activity').addEventListener('click', () => addColumn('Activity'));
            document.getElementById('add-exam').addEventListener('click', () => addColumn('Exam'));
         

            // Save functionality
            document.getElementById('save-button').addEventListener('click', function() {
                const button = this;
                const originalText = button.innerHTML;
                
                // Show loading state
                button.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Saving...</span>
                    </div>
                `;
                button.disabled = true;

                const maxRow = gradebookData[0];
                const updatedData = gradebookData.slice(1).map(row => {
                    const { student_id, Name, ...scores } = row;
                    return { student_id, scores };
                });

                const maxScoresData = {};
                allLabels.forEach(label => {
                    maxScoresData[label] = maxRow[label] ?? null;
                });

                fetch('/admin/gradebook/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        subject_id: subjectId,
                        teacher_id: teacherId,
                        data: updatedData,
                        max_scores: maxScoresData
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Save response:', data);
                    
                    // Show success state
                    button.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Saved Successfully!</span>
                        </div>
                    `;
                    
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    button.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Save Failed</span>
                        </div>
                    `;
                    
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                });
            });
        </script>
        @endif
    @endpush
</x-app-layout>