<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-red-100 to-red-200">
        <div class="max-w-7xl mx-auto p-6">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-900 via-red-800 to-red-900 rounded-xl shadow-2xl p-8 mb-8 border-4 border-red-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-white flex items-center mb-3">
                            <svg class="w-10 h-10 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Gradebook - Teacher View
                        </h1>
                        <p class="text-red-100 text-lg">Manage your student grades and assessments with ease</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-red-800 bg-opacity-50 rounded-full p-4">
                            <svg class="w-12 h-12 text-red-200" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject Selection -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border-l-4 border-red-700">
                <form method="GET" action="{{ route('gradebook.teacher') }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <label for="subject_id" class="text-red-900 font-bold text-xl flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Select Subject:
                    </label>
                    <select name="subject_id" onchange="this.form.submit()" 
                            class="flex-1 sm:flex-none min-w-[250px] border-3 border-red-300 rounded-lg px-6 py-3 bg-gradient-to-r from-white to-red-50 text-red-900 focus:border-red-600 focus:ring-4 focus:ring-red-200 shadow-md hover:shadow-lg font-semibold text-lg">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border-t-4 border-red-600">
                <div class="flex items-center mb-6">
                    <svg class="w-7 h-7 mr-3 text-red-800" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-red-900 font-bold text-xl">Add New Assessment</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <button type="button" id="add-quiz" 
                            class="px-8 py-4 bg-gradient-to-br from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 font-bold text-lg flex items-center justify-center gap-3 border-2 border-red-400 hover:border-red-500">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Quiz
                    </button>
                    <button type="button" id="add-activity" 
                            class="px-8 py-4 bg-gradient-to-br from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 font-bold text-lg flex items-center justify-center gap-3 border-2 border-red-500 hover:border-red-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Activity
                    </button>
                    <button type="button" id="add-exam" 
                            class="px-8 py-4 bg-gradient-to-br from-red-800 to-red-900 text-white rounded-xl hover:from-red-900 hover:to-red-950 font-bold text-lg flex items-center justify-center gap-3 border-2 border-red-600 hover:border-red-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Exam
                    </button>
                </div>
            </div>

            <!-- Gradebook Table Container -->
            <div class="bg-white rounded-xl shadow-2xl p-8 mb-8 border-t-4 border-red-700">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-red-900 font-bold text-2xl flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                        Grade Records
                    </h3>
                    <div class="flex items-center text-red-600">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">Right-click columns to rename or delete</span>
                    </div>
                </div>
                
                <!-- FIXED: Horizontal scroll container -->
                <div class="overflow-x-auto border border-red-200 rounded-lg" id="gradebook-scroll-wrapper">
                    <div id="gradebook-table" class="min-w-full"></div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-center">
                <button id="save-button" 
                        class="px-12 py-5 bg-gradient-to-r from-red-700 via-red-800 to-red-700 text-white rounded-xl hover:from-red-800 hover:via-red-900 hover:to-red-800 font-bold text-xl flex items-center gap-4 border-3 border-red-600 hover:border-red-500">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"/>
                    </svg>
                    Save All Grades
                </button>
            </div>

            <!-- Footer Info -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-600">
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
            /* Container scrollbar styling */
            #gradebook-scroll-wrapper {
                overflow-x: auto !important;
                overflow-y: hidden !important;
                max-width: 100% !important;
                width: 100% !important;
                scrollbar-width: thin;
                scrollbar-color: #dc2626 #fef2f2;
            }

            #gradebook-scroll-wrapper::-webkit-scrollbar {
                height: 12px !important;
            }

            #gradebook-scroll-wrapper::-webkit-scrollbar-track {
                background: #fef2f2 !important;
                border-radius: 8px !important;
            }

            #gradebook-scroll-wrapper::-webkit-scrollbar-thumb {
                background-color: #dc2626 !important;
                border-radius: 8px !important;
                border: 2px solid #fef2f2 !important;
            }

            #gradebook-scroll-wrapper::-webkit-scrollbar-thumb:hover {
                background-color: #b91c1c !important;
            }

            #gradebook-table {
                min-width: 1200px !important;
                width: max-content !important;
            }

            /* Handsontable styling */
            .handsontable {
                font-family: inherit !important;
                overflow: visible !important;
            }

            /* Force handsontable to not have its own scrollbars */
            .handsontable .ht_master .wtHolder {
                border: 3px solid #b91c1c !important;
                border-radius: 12px !important;
                overflow: visible !important;
                box-shadow: 0 8px 25px rgba(127, 29, 29, 0.2) !important;
            }

            .handsontable .ht_master .wtHider {
                overflow: visible !important;
            }

            .handsontable .ht_master .wtSpreader {
                overflow: visible !important;
            }

            .handsontable .ht_master .wtTable {
                border-collapse: separate !important;
                border-spacing: 0 !important;
            }

            .handsontable .colHeader {
                background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;
                color: white !important;
                font-weight: 700 !important;
                text-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
                font-size: 14px !important;
                padding: 12px 8px !important;
                border-bottom: 2px solid #7f1d1d !important;
            }

            .handsontable .rowHeader {
                background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;
                color: white !important;
                font-weight: 700 !important;
                font-size: 14px !important;
                padding: 8px 12px !important;
                border-right: 2px solid #7f1d1d !important;
            }

            .handsontable tbody tr:nth-child(even) td {
                background-color: #fef2f2 !important;
            }

            .handsontable tbody tr:nth-child(odd) td {
                background-color: #ffffff !important;
            }

            .handsontable td {
                border: 1px solid #fecaca !important;
                padding: 8px !important;
                font-size: 14px !important;
                box-shadow: none !important;
            }

            .handsontable td:hover {
                background-color: #fed7d7 !important;
                outline: 1px solid #dc2626 !important;
                box-shadow: none !important;
            }

            .handsontable .current {
                background-color: #fee2e2 !important;
                outline: 2px solid #dc2626 !important;
                box-shadow: none !important;
            }

            .handsontable .area {
                background-color: rgba(239, 68, 68, 0.15) !important;
                outline: 1px solid #dc2626 !important;
            }

            .handsontable .htContextMenu {
                border: 3px solid #dc2626 !important;
                border-radius: 12px !important;
                box-shadow: 0 15px 35px rgba(127, 29, 29, 0.4) !important;
                background: white !important;
            }

            .handsontable .htContextMenu .ht_master .wtTable tbody tr td {
                background: white !important;
                color: #7f1d1d !important;
                padding: 12px 16px !important;
                font-weight: 500 !important;
            }

            .handsontable .htContextMenu .ht_master .wtTable tbody tr td:hover {
                background: #fef2f2 !important;
                color: #991b1b !important;
                font-weight: 600 !important;
            }

            .handsontable .htContextMenu .ht_master .wtTable tbody tr td.htSeparator {
                border-bottom: 2px solid #fecaca !important;
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
            </style>

<script>
    const container = document.getElementById('gradebook-table');
    const students = @json($students);
    const rawScores = @json($scores);
    const subjectId = {{ $selectedSubject }};
    let allLabels = @json($columns);
    let maxScores = @json(isset($maxScores) ? $maxScores : []);

    // Create table data from student scores
    let gradebookData = students.map(student => {
        const scores = rawScores[student.id] || [];
        const map = {};
        scores.forEach(s => map[s.label] = s.score);

        const row = { Name: student.name, student_id: student.id };
        allLabels.forEach(label => row[label] = map[label] || '');
        return row;
    });

    // Add max score row to the top
    const maxRow = { Name: 'Max Score', student_id: null };
    allLabels.forEach(label => maxRow[label] = maxScores[label] || '');
    gradebookData.unshift(maxRow);

    // Calculate total table width
    const totalWidth = 150 + (allLabels.length * 100);
    document.getElementById('gradebook-table').style.minWidth = totalWidth + 'px';

    // Initialize Handsontable
    const hot = new Handsontable(container, {
        data: gradebookData,
        colHeaders: ['Name', ...allLabels],
        columns: [
            { data: 'Name', readOnly: true, width: 150 }, 
            ...allLabels.map(label => ({ data: label, type: 'numeric', width: 100 }))
        ],
        stretchH: 'none',
        width: totalWidth,
        height: 500,
        rowHeaders: true,
        licenseKey: 'non-commercial-and-evaluation',
        manualColumnResize: true,
        disableVisualSelection: false,
        contextMenu: {
            callback: function (key, selection) {
                const colIndex = selection[0].start.col;
                if (colIndex === 0) return; // Prevent modifying Name column

                const labelIndex = colIndex - 1;
                const oldLabel = allLabels[labelIndex];

                if (key === 'rename_column') {
                    const newLabel = prompt('Rename column:', oldLabel);
                    if (newLabel && newLabel !== oldLabel && newLabel.trim() !== '') {
                        allLabels[labelIndex] = newLabel;
                        gradebookData.forEach(row => {
                            row[newLabel] = row[oldLabel] || '';
                            delete row[oldLabel];
                        });
                        updateTable();
                    }
                }

                if (key === 'delete_column') {
                    if (confirm(`Delete column "${oldLabel}"?`)) {
                        allLabels.splice(labelIndex, 1);
                        gradebookData.forEach(row => delete row[oldLabel]);
                        updateTable();
                    }
                }
            },
            items: {
                "rename_column": {
                    name: "🏷️ Rename column",
                    disabled: function() {
                        const selection = hot.getSelected();
                        return selection && selection[0][1] === 0;
                    }
                },
                "delete_column": {
                    name: "🗑️ Delete column",
                    disabled: function() {
                        const selection = hot.getSelected();
                        return selection && selection[0][1] === 0;
                    }
                },
                "hsep1": "---------",
                "row_above": { name: "➕ Insert row above" },
                "row_below": { name: "➕ Insert row below" },
                "remove_row": { name: "❌ Remove row" }
            }
        },
        cells: function (row) {
            if (row === 0) {
                return { className: 'htMaxScore' };
            }
        }
    });

    function updateTable() {
        const columns = [{ data: 'Name', readOnly: true, width: 150 }];
        allLabels.forEach(label => columns.push({ data: label, type: 'numeric', width: 100 }));

        // Rebuild rows with maxRow on top
        const updatedData = students.map(student => {
            const scores = rawScores[student.id] || [];
            const map = {};
            scores.forEach(s => map[s.label] = s.score);

            const row = { Name: student.name, student_id: student.id };
            allLabels.forEach(label => row[label] = map[label] || '');
            return row;
        });

        const newMaxRow = { Name: 'Max Score', student_id: null };
        allLabels.forEach(label => newMaxRow[label] = maxRow[label] || '');
        gradebookData = [newMaxRow, ...updatedData];

        // Update table width
        const newTotalWidth = 150 + (allLabels.length * 100);
        document.getElementById('gradebook-table').style.minWidth = newTotalWidth + 'px';

        hot.updateSettings({
            data: gradebookData,
            colHeaders: ['Name', ...allLabels],
            columns: columns,
            width: newTotalWidth
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
        updateTable();
    }

    document.getElementById('add-quiz').addEventListener('click', () => addColumn('Quiz'));
    document.getElementById('add-activity').addEventListener('click', () => addColumn('Activity'));
    document.getElementById('add-exam').addEventListener('click', () => addColumn('Exam'));

    document.getElementById('save-button').addEventListener('click', function () {
        const saveButton = this;
        const originalText = saveButton.innerHTML;
        
        // Show loading state
        saveButton.innerHTML = `
            <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Saving...
        `;
        saveButton.disabled = true;
        
        const maxRow = gradebookData[0];
        const updatedData = gradebookData.slice(1).map(row => {
            const { student_id, Name, ...scores } = row;
            return { student_id, scores };
        });

        const maxScores = {};
        allLabels.forEach(label => {
            maxScores[label] = maxRow[label] || null;
        });

        fetch('{{ route('gradebook.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                subject_id: subjectId,
                data: updatedData,
                max_scores: maxScores
            })
        })
        .then(res => res.json())
        .then(res => {
            alert(res.message);
            // Restore button state
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving grades. Please try again.');
            // Restore button state
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        });
    });
</script>

@endpush
</x-app-layout>