<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-stone-50 via-red-50 to-rose-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="relative overflow-hidden bg-gradient-to-r from-red-900 via-red-800 to-red-900 rounded-2xl shadow-2xl p-8 mb-8 text-white">
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold mb-3 tracking-tight">Admin Gradebook</h1>
                            <p class="text-red-100 text-lg font-medium">Manage and override student scores across all subjects</p>
                        </div>
                        <div class="hidden md:block">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-4">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-red-100">
                <form method="GET" action="{{ route('admin.gradebook') }}" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Subject Selection -->
                        <div class="space-y-2">
                            <label class="block text-red-900 font-semibold text-sm uppercase tracking-wide">
                                Select Subject
                            </label>
                            <div class="relative">
                                <select name="subject_id" 
                                        onchange="this.form.submit()" 
                                        class="w-full bg-white border-2 border-red-200 rounded-xl px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 appearance-none">
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ $subject->id == $selectedSubject ? 'selected' : '' }}>
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

                        <!-- Teacher Selection -->
                        <div class="space-y-2">
                            <label class="block text-red-900 font-semibold text-sm uppercase tracking-wide">
                                Select Teacher
                            </label>
                            <div class="relative">
                                <select name="teacher_id" 
                                        onchange="this.form.submit()" 
                                        class="w-full bg-white border-2 border-red-200 rounded-xl px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 appearance-none">
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ $teacher->id == $selectedTeacher ? 'selected' : '' }}>
                                            {{ $teacher->name }}
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
                </form>
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
                            <h2 class="text-white text-xl font-bold">Student Scores</h2>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-3 py-1">
                                <span class="text-white text-sm font-medium">Right-click to modify columns</span>
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
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/handsontable@13.0.0/dist/handsontable.full.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@13.0.0/dist/handsontable.full.min.css" />

        <style>
            /* Custom Handsontable Styling */
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
        </style>

        <script>
            const container = document.getElementById('gradebook-table');
            const students = @json($students);
            const scores = @json($scores);
            const subjectId = {{ $selectedSubject }};
            const teacherId = {{ $selectedTeacher }};

            // Process data for Handsontable
            const allLabels = [...new Set(scores.map(s => s.label))];
            const scoreMap = {};

            scores.forEach(s => {
                if (!scoreMap[s.student_id]) scoreMap[s.student_id] = {};
                scoreMap[s.student_id][s.label] = s.score;
            });

            const data = students.map(s => {
                const row = { Name: s.name, student_id: s.id };
                allLabels.forEach(label => {
                    row[label] = scoreMap[s.id]?.[label] ?? '';
                });
                return row;
            });

            // Initialize Handsontable
            const hot = new Handsontable(container, {
                data: data,
                colHeaders: ['Student Name', ...allLabels],
                columns: [
                    { 
                        data: 'Name', 
                        readOnly: true,
                        className: 'text-red-900 font-semibold'
                    },
                    ...allLabels.map(label => ({ 
                        data: label, 
                        type: 'numeric',
                        numericFormat: {
                            pattern: '0.00'
                        }
                    }))
                ],
                rowHeaders: true,
                width: '100%',
                height: 500,
                licenseKey: 'non-commercial-and-evaluation',
                stretchH: 'all',
                contextMenu: {
                    items: {
                        'row_above': {
                            name: 'Insert row above'
                        },
                        'row_below': {
                            name: 'Insert row below'
                        },
                        'hsep1': '---------',
                        'col_left': {
                            name: 'Insert column left'
                        },
                        'col_right': {
                            name: 'Insert column right'
                        },
                        'hsep2': '---------',
                        'remove_row': {
                            name: 'Remove row'
                        },
                        'remove_col': {
                            name: 'Remove column'
                        },
                        'hsep3': '---------',
                        'rename_col': {
                            name: 'Rename column'
                        }
                    }
                },
                beforeColumnResize: function(newSize, column, isDoubleClick) {
                    return true;
                },
                afterColumnResize: function(newSize, column, isDoubleClick) {
                    // Column resized
                }
            });

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

                const payload = hot.getData().map((row, i) => {
                    const student = students[i];
                    const scores = {};
                    allLabels.forEach((label, idx) => {
                        scores[label] = row[idx + 1];
                    });
                    return {
                        student_id: student.id,
                        scores: scores
                    };
                });

                fetch("{{ route('admin.gradebook.save') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        subject_id: subjectId,
                        teacher_id: teacherId,
                        data: payload
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Show success state
                    button.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Saved Successfully!</span>
                        </div>
                    `;
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Show error state
                    button.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Save Failed</span>
                        </div>
                    `;
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                });
            });
        </script>
    @endpush
</x-app-layout>