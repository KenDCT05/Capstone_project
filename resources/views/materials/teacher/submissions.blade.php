<x-app-layout>
    <div class="max-w-7xl mx-auto p-4">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Activity Submissions</h2>
            <h3 class="text-lg text-gray-600 mt-1">{{ $material->title }}</h3>
            <div class="flex items-center space-x-4 text-sm text-gray-500 mt-2">
                <span>Subject: {{ $material->subject->name }}</span>
                @if($material->due_date)
                    <span>Due: {{ $material->due_date->format('M d, Y g:i A') }}</span>
                @endif
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg">
                <div class="text-2xl font-bold text-blue-800">{{ $submissions->count() }}</div>
                <div class="text-sm text-blue-600">Submissions</div>
            </div>
            <div class="bg-green-100 p-4 rounded-lg">
                <div class="text-2xl font-bold text-green-800">{{ $submissions->where('status', 'submitted')->count() }}</div>
                <div class="text-sm text-green-600">On Time</div>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg">
                <div class="text-2xl font-bold text-yellow-800">{{ $submissions->where('status', 'late')->count() }}</div>
                <div class="text-sm text-yellow-600">Late</div>
            </div>
            <div class="bg-red-100 p-4 rounded-lg">
                <div class="text-2xl font-bold text-red-800">{{ $enrolledStudents->count() }}</div>
                <div class="text-sm text-red-600">Not Submitted</div>
            </div>
        </div>

        <!-- Submissions Table -->
        @if($submissions->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($submissions as $submission)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $submission->student->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $submission->student->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $submission->status === 'late' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($submission->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $submission->submitted_at->format('M d, Y g:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $submission->grade ?? 'Not graded' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('submissions.download', $submission) }}" 
                                       class="text-blue-600 hover:text-blue-900">Download</a>
                                    <button onclick="openFeedbackModal({{ $submission->id }}, '{{ $submission->student->name }}', '{{ $submission->teacher_feedback }}', '{{ $submission->grade }}')"
                                            class="text-green-600 hover:text-green-900">Grade</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Students Who Haven't Submitted -->
        @if($enrolledStudents->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Students Who Haven't Submitted</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $enrolledStudents->count() }} students</p>
                </div>
                <div class="border-t border-gray-200">
                    <ul class="divide-y divide-gray-200">
                        @foreach($enrolledStudents as $student)
                            <li class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                <div class="text-sm text-gray-500">{{ $student->email }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Provide Feedback</h3>
                <form id="feedbackForm" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Grade (0-100)</label>
                        <input type="number" name="grade" id="gradeInput" min="0" max="100" step="0.1"
                               class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Feedback</label>
                        <textarea name="feedback" id="feedbackInput" rows="4" 
                                  class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeFeedbackModal()"
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                            Save Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openFeedbackModal(submissionId, studentName, currentFeedback, currentGrade) {
            document.getElementById('modalTitle').textContent = `Feedback for ${studentName}`;
            document.getElementById('feedbackForm').action = `/submissions/${submissionId}/feedback`;
            document.getElementById('gradeInput').value = currentGrade || '';
            document.getElementById('feedbackInput').value = currentFeedback || '';
            document.getElementById('feedbackModal').classList.remove('hidden');
        }

        function closeFeedbackModal() {
            document.getElementById('feedbackModal').classList.add('hidden');
        }
    </script>
</x-app-layout>