<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-stone-50 via-red-50 to-rose-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                                <svg class="w-10 h-10 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                        Gradebook - Teacher View
                    </h1>
                    <p class="text-red-100 mt-2">Manage your student grades and assessments with ease</p>
                </div>
                
                <div class="px-8 py-6">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a> 
                </div>
            </div>
            
            <!-- Subject Selection -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-red-100">
                <form method="GET" action="{{ route('gradebook.teacher') }}" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-red-900 font-semibold text-sm uppercase tracking-wide">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                                Select Subject
                            </label>
                            <div class="relative">
                                <select name="subject_id" 
                                        onchange="this.form.submit()" 
                                        class="w-full bg-white border-2 border-red-200 rounded-xl px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 appearance-none">
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($selectedSubject)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-red-900 font-medium">
                                    Currently viewing: <strong>{{ $subjects->find($selectedSubject)->name ?? 'Unknown Subject' }}</strong>
                                    @if($students->isNotEmpty())
                                        ({{ $students->count() }} students enrolled)
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-red-100">
                <div class="flex items-center mb-6">
                    <div class="bg-red-100 rounded-lg p-2 mr-3">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-red-900 font-bold text-xl">Add New Assessment</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <button type="button" id="add-quiz" 
                            class="group relative px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:from-red-700 hover:to-red-800">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Quiz
                            </div>
                            <span class="text-xs text-red-100 opacity-90">Short assessments</span>
                        </div>
                    </button>
                    <button type="button" id="add-activity" 
                            class="group relative px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:from-green-800 hover:to-green-900">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Activity
                            </div>
                            <span class="text-xs text-green-100 opacity-90">Hands-on tasks • Always 100 points</span>
                        </div>
                    </button>
                    <button type="button" id="add-exam" 
                            class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:from-blue-900 hover:to-blue-950">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Exam
                            </div>
                            <span class="text-xs text-blue-100 opacity-90">Major tests</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Gradebook Table Section -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-red-100">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-6 py-4 border-b border-red-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-white text-xl font-bold">Student Scores ({{ $students->count() }} students)</h2>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-3 py-1">
                                <span class="text-white text-sm font-medium">Student grade management system</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="border-2 border-red-100 rounded-xl overflow-hidden">
                        <div id="gradebook-table" class="min-h-[500px]"></div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-center mt-8">
                <button id="save-button"
                        class="group relative px-12 py-4 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:from-red-800 hover:via-red-900 hover:to-red-800">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        <span>Save All Changes</span>
                    </div>
                </button>
            </div>

            <!-- Footer Info -->
            <div class="mt-8 bg-white rounded-2xl shadow-xl p-6 border border-red-100">
                <div class="flex flex-col sm:flex-row items-center justify-between text-red-700">
                    <div class="flex items-center mb-3 sm:mb-0">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">Remember to save your changes before leaving</span>
                    </div>
                    <div class="text-red-600 font-semibold">
                        Last updated: {{ now()->format('M d, Y \a\t g:i A') }}
                    </div>
                </div>
            </div>
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
                background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #be123c 100%);
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

            .htActivityMaxScore {
                background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important;
                font-weight: 800 !important;
                color: #166534 !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
                border: 2px solid #16a34a !important;
                font-size: 15px !important;
                cursor: not-allowed !important;
            }

            .htActivityMaxScore:hover {
                background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%) !important;
            }

            .htExamMaxScore {
                background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
                font-weight: 800 !important;
                color: #1e40af !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
                border: 2px solid #2563eb !important;
                font-size: 15px !important;
            }

            .htExamMaxScore:hover {
                background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
            }

            .htAttendanceMaxScore {
                background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%) !important;
                font-weight: 800 !important;
                color: #92400e !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
                border: 2px solid #f59e0b !important;
                font-size: 15px !important;
                cursor: not-allowed !important;
            }

            .htAttendanceMaxScore:hover {
                background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
            }

            .htQuizColumn {
                background-color: #fee2e2 !important;
            }

            .htQuizColumn:hover {
                background-color: #fecaca !important;
            }

            .htActivityColumn {
                background-color: #f0fdf4 !important;
            }

            .htActivityColumn:hover {
                background-color: #dcfce7 !important;
            }

            .htExamColumn {
                background-color: #eff6ff !important;
            }

            .htExamColumn:hover {
                background-color: #dbeafe !important;
            }

            .htAttendanceColumn {
                background-color: #fefce8 !important;
            }

            .htAttendanceColumn:hover {
                background-color: #fef3c7 !important;
            }

            .htStudentNameHeader {
                background: linear-gradient(135deg, #334155 0%, #1e293b 100%) !important;
                color: white !important;
                font-weight: 800 !important;
                font-size: 15px !important;
                text-align: center !important;
            }

            .htStudentNameCell {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%) !important;
                color: #334155 !important;
                font-weight: 600 !important;
                border-right: 3px solid #64748b !important;
            }

            .htStudentNameCell:hover {
                background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            }
        </style>

        <script>
            const container = document.getElementById('gradebook-table');
            const students = @json($students ?? []);
            const rawScores = @json($scores ?? []);
            const subjectId = {{ $selectedSubject ?? 0 }};
            let allLabels = @json($columns ?? []);
            let maxScores = @json($maxScores ?? []);

            // ✅ FIX: Store original types from database AND quiz IDs
            const scoreTypes = {};
            const scoreQuizIds = {};
            @foreach($scores ?? [] as $studentId => $studentScores)
                @foreach($studentScores as $score)
                    scoreTypes['{{ $score->label }}'] = '{{ $score->type }}';
                    @if($score->quiz_id)
                        scoreQuizIds['{{ $score->label }}'] = {{ $score->quiz_id }};
                    @endif
                @endforeach
            @endforeach

            console.log('Score Types:', scoreTypes);
            console.log('Score Quiz IDs:', scoreQuizIds);

            console.log('Debug Data:', {
                students: students,
                rawScores: rawScores,
                subjectId: subjectId,
                allLabels: allLabels,
                maxScores: maxScores,
                scoreTypes: scoreTypes  // ✅ NEW: Log stored types
            });

            // ✅ FIXED: Use stored types first, then detect
            function getAssessmentType(label) {
                // Check if we have a stored type from database
                if (scoreTypes[label]) {
                    return scoreTypes[label];
                }
                
                // Otherwise, detect from label
                const labelLower = label.toLowerCase();
                if (labelLower.includes('quiz')) return 'quiz';
                if (labelLower.includes('exam')) return 'exam';
                if (labelLower.includes('attendance') || labelLower.includes('character')) return 'attendance';
                if (labelLower.includes('activity')) return 'activity';
                return 'activity'; // default
            }

            if (!allLabels || allLabels.length === 0) {
                allLabels = ['Attendance'];
                maxScores = { 'Attendance': 10 };
            }

            if (!allLabels.includes('Attendance')) {
                allLabels.push('Attendance');
                maxScores['Attendance'] = 10;
            }

            let gradebookData = [];
            
            if (students && students.length > 0) {
                gradebookData = students.map(student => {
                    const scores = rawScores[student.id] || [];
                    const map = {};
                    scores.forEach(s => map[s.label] = s.score);

                    const row = { Name: student.name, student_id: student.id };
                    allLabels.forEach(label => row[label] = map[label] ?? '');
                    return row;
                });
            } else {
                gradebookData = [{
                    Name: 'No students enrolled',
                    student_id: null,
                    ...Object.fromEntries(allLabels.map(label => [label, '']))
                }];
            }

            const maxRow = { Name: 'Max Score', student_id: null };
            allLabels.forEach(label => {
                const type = getAssessmentType(label);
                if (type === 'activity') {
                    maxRow[label] = 100;
                } else if (label === 'Attendance') {
                    maxRow[label] = 10;
                } else {
                    maxRow[label] = maxScores[label] || '';
                }
            });
            gradebookData.unshift(maxRow);

            console.log('Final gradebook data:', gradebookData);

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
                        width: 100
                    }))
                ],
                rowHeaders: true,
                width: '100%',
                height: 500,
                licenseKey: 'non-commercial-and-evaluation',
                stretchH: 'all',
                contextMenu: false,
                
                cells: function (row, col) {
                    const cellProperties = {};

                    if (col === 0) {
                        if (row === 0) {
                            cellProperties.className = 'htStudentNameHeader';
                        } else {
                            cellProperties.className = 'htStudentNameCell';
                        }
                    }

                    if (row === 0 && col > 0) {
                        const label = allLabels[col - 1];
                        const type = getAssessmentType(label);
                        
                        if (type === 'activity') {
                            cellProperties.readOnly = true;
                            cellProperties.className = 'htActivityMaxScore';
                        } else if (type === 'exam') {
                            cellProperties.className = 'htExamMaxScore';
                        } else if (type === 'attendance' || label === 'Attendance') {
                            cellProperties.readOnly = true;
                            cellProperties.className = 'htAttendanceMaxScore';
                        } else {
                            cellProperties.className = 'htMaxScore';
                        }
                    }
                    
                    if (row > 0 && col > 0) {
                        const label = allLabels[col - 1];
                        const type = getAssessmentType(label);
                        
                        if (type === 'activity') {
                            cellProperties.className = 'htActivityColumn';
                        } else if (type === 'exam') {
                            cellProperties.className = 'htExamColumn';
                        } else if (type === 'attendance' || label === 'Attendance') {
                            cellProperties.className = 'htAttendanceColumn';
                        } else {
                            cellProperties.className = 'htQuizColumn';
                        }
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
                    width: 100
                }));

                let updatedData = [];
                
                if (students && students.length > 0) {
                    updatedData = students.map(student => {
                        const scores = rawScores[student.id] || [];
                        const map = {};
                        scores.forEach(s => map[s.label] = s.score);

                        const row = { Name: student.name, student_id: student.id };
                        allLabels.forEach(label => row[label] = map[label] ?? '');
                        return row;
                    });
                } else {
                    updatedData = [{
                        Name: 'No students enrolled',
                        student_id: null,
                        ...Object.fromEntries(allLabels.map(label => [label, '']))
                    }];
                }

                const newMaxRow = { Name: 'Max Score', student_id: null };
                allLabels.forEach(label => {
                    const type = getAssessmentType(label);
                    if (type === 'activity') {
                        newMaxRow[label] = 100;
                    } else if (label === 'Attendance') {
                        newMaxRow[label] = 10;
                    } else {
                        newMaxRow[label] = gradebookData[0] ? gradebookData[0][label] : '';
                    }
                });
                gradebookData = [newMaxRow, ...updatedData];

                hot.updateSettings({
                    data: gradebookData,
                    colHeaders: ['Student Name', ...allLabels],
                    columns: columns
                });

                hot.render();
                console.log('Table updated with data:', gradebookData);
            }

            function getNextLabel(prefix) {
                const existing = allLabels.filter(l => l.startsWith(prefix));
                const nextNumber = existing.length + 1;
                return `${prefix} ${nextNumber}`;
            }

            function addColumn(type) {
                const newLabel = getNextLabel(type);
                allLabels.push(newLabel);
                
                // ✅ Store the type for newly created columns
                scoreTypes[newLabel] = type.toLowerCase();
                
                gradebookData.forEach((row, index) => {
                    if (index === 0) {
                        if (type === 'Activity') {
                            row[newLabel] = 100;
                        } else {
                            row[newLabel] = '';
                        }
                    } else {
                        row[newLabel] = '';
                    }
                });
                
                updateTable();
            }

            document.getElementById('add-quiz').addEventListener('click', () => addColumn('Quiz'));
            document.getElementById('add-activity').addEventListener('click', () => addColumn('Activity'));
            document.getElementById('add-exam').addEventListener('click', () => addColumn('Exam'));

            document.getElementById('save-button').addEventListener('click', function () {
                const saveButton = this;
                const originalText = saveButton.innerHTML;
                
                saveButton.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Saving...</span>
                    </div>
                `;
                saveButton.disabled = true;
                
                const maxRow = gradebookData[0];
                const updatedData = gradebookData.slice(1).map(row => {
                    const { student_id, Name, ...scores } = row;
                    return { student_id, scores };
                });

                const maxScoresData = {};
                allLabels.forEach(label => {
                    const type = getAssessmentType(label);
                    if (type === 'activity') {
                        maxScoresData[label] = 100;
                    } else {
                        maxScoresData[label] = maxRow[label] || null;
                    }
                });

                // ✅ NEW: Send types along with the data
                const scoresWithTypes = gradebookData.slice(1).map(row => {
                    const { student_id, Name, ...scores } = row;
                    const scoresData = {};
                    
                    Object.keys(scores).forEach(label => {
                        scoresData[label] = {
                            score: scores[label],
                            type: getAssessmentType(label) // Include type
                        };
                    });
                    
                    return { student_id, scores: scoresData };
                });

                fetch('{{ route('gradebook.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        subject_id: subjectId,
                        data: scoresWithTypes, // ✅ Send with types
                        max_scores: maxScoresData
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Save response:', data);
                    
                    saveButton.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Saved Successfully!</span>
                        </div>
                    `;
                    
                    setTimeout(() => {
                        saveButton.innerHTML = originalText;
                        saveButton.disabled = false;
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    saveButton.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Save Failed</span>
                        </div>
                    `;
                    
                    setTimeout(() => {
                        saveButton.innerHTML = originalText;
                        saveButton.disabled = false;
                    }, 2000);
                });
            });
        </script>
    @endpush
</x-app-layout>