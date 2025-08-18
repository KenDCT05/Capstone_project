<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">

        {{-- Title Header --}}
        <div class="bg-gradient-to-br from-[#722F37] via-[#8B1538] to-[#A91B60] rounded-2xl text-white shadow-2xl p-8 mb-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                        <span class="text-2xl">👩‍🏫</span>
                    </div>
                    <h1 class="text-4xl font-bold tracking-tight">Assign Students to Teachers</h1>
                </div>
                <p class="text-lg mt-2 opacity-90 font-medium">Easily assign students manually or randomly, and manage existing assignments with precision.</p>
            </div>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="mb-8 px-6 py-4 bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-800 border-l-4 border-emerald-500 rounded-xl shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="grid lg:grid-cols-2 gap-8 mb-12">

            {{-- Random Assignment --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                <div class="bg-gradient-to-r from-[#8B1538] to-[#B91C1C] p-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                            <span class="text-xl">🎲</span>
                        </div>
                        <h2 class="text-xl font-bold text-white">Random Assignment</h2>
                    </div>
                    <p class="text-white/80 text-sm mt-2">Automatically distribute students evenly across all teachers</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.assign.random') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-[#B91C1C] to-[#DC2626] hover:from-[#991B1B] hover:to-[#B91C1C] text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 group-hover:scale-[1.02]">
                            <span class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span>Randomly & Evenly Assign Students</span>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Manual Assignment --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                <div class="bg-gradient-to-r from-[#722F37] to-[#8B1538] p-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                            <span class="text-xl">📝</span>
                        </div>
                        <h2 class="text-xl font-bold text-white">Manual Assignment</h2>
                    </div>
                    <p class="text-white/80 text-sm mt-2">Handpick specific students for individual teachers</p>
                </div>
                <div class="p-6 space-y-6">
                    <form action="{{ route('admin.assign.manual') }}" method="POST">
                        @csrf

                        <div class="space-y-2">
                            <label for="teacher_id" class="block text-sm font-bold text-gray-800">Select Teacher</label>
                            <select name="teacher_id" id="teacher_id"
                                class="w-full p-4 rounded-xl border-2 border-gray-200 focus:ring-4 focus:ring-[#B91C1C]/20 focus:border-[#B91C1C] transition-all duration-200 bg-gray-50 hover:bg-white">
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-800">Select Students</label>
                            <div class="h-56 overflow-y-auto bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-4 space-y-3 hover:border-gray-300 transition-colors">
                                @foreach($students as $student)
                                    <label class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/70 transition-colors cursor-pointer group">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                            class="w-4 h-4 text-[#B91C1C] bg-white border-2 border-gray-300 rounded focus:ring-[#B91C1C] focus:ring-2 transition-colors">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ $student->name }}</span>
                                        <span class="text-xs text-gray-500 group-hover:text-gray-700">({{ $student->email }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-[#8B1538] to-[#722F37] hover:from-[#6D112D] hover:to-[#5D1F28] text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 group-hover:scale-[1.02]">
                            <span class="flex items-center justify-center space-x-2">
                                <span>✅</span>
                                <span>Assign Selected Students</span>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Assignment Overview --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-[#8B1538] via-[#A91B60] to-[#B91C1C] p-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                        <span class="text-xl">📋</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Current Assignments</h3>
                </div>
                <p class="text-white/80 text-sm mt-2">Overview of all student-teacher assignments</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm bg-white">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left font-bold text-gray-800 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-4 text-left font-bold text-gray-800 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left font-bold text-gray-800 uppercase tracking-wider">Assigned Teacher(s)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($students as $student)
                            <tr class="hover:bg-gradient-to-r hover:from-gray-50/50 hover:to-transparent transition-all duration-200 group">
                                <td class="px-6 py-5">
                                    <div class="font-semibold text-gray-900 group-hover:text-[#8B1538] transition-colors">{{ $student->name }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-gray-600 font-medium">{{ $student->email }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    @if ($student->teachers->count())
                                        <div class="space-y-2">
                                            @foreach ($student->teachers as $teacher)
                                                <div class="flex items-center justify-between bg-gradient-to-r from-[#8B1538]/5 to-[#B91C1C]/5 rounded-lg p-3 border border-[#8B1538]/10">
                                                    <div class="flex items-center space-x-2">
                                                        <div class="w-2 h-2 bg-[#8B1538] rounded-full"></div>
                                                        <span class="font-semibold text-gray-800">{{ $teacher->name }}</span>
                                                        <span class="text-gray-500 text-xs">({{ $teacher->email }})</span>
                                                    </div>
                                                    <form action="{{ route('admin.unassign.teacher') }}" method="POST" class="ml-4">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                        <button type="submit" 
                                                            class="bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 px-3 py-1 rounded-lg text-xs font-bold transition-all duration-200 hover:scale-105 shadow-sm hover:shadow-md">
                                                            Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex items-center space-x-2 text-gray-400 italic bg-gray-50 rounded-lg p-3 border border-gray-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.382 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <span>No teacher assigned</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-12">
                                    <div class="flex flex-col items-center space-y-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        <div class="text-gray-500 font-medium">No students found</div>
                                        <div class="text-gray-400 text-sm">Students will appear here once they're added to the system</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>