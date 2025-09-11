<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-rose-50 to-pink-50">
        <div class="max-w-7xl mx-auto p-6">
            <!-- Header Section -->


             <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                         My Quizzes
                    </h1>
                    <p class="text-red-100 mt-2">Manage and organize your quiz collection</p>
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

            <!-- Filter and Action Bar -->
            <div class="bg-white/70 backdrop-blur-sm border border-red-100 rounded-2xl shadow-lg p-6 mb-8">
                <form method="GET" class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">

                    <div class="flex items-center gap-3">

                        <label class="text-red-700 font-semibold text-sm">Filter by Subject:</label>
                        <select name="subject_id" onchange="this.form.submit()" 
                                class="border-2 border-red-200 rounded-xl px-4 py-2 bg-white focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 text-red-700">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}" @selected($subjectId==$s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <a href="{{ route('quizzes.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Quiz
                    </a>
                </form>
            </div>

            <!-- Quiz Table -->
            <div class="bg-white/70 backdrop-blur-sm border border-red-100 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-red-600 to-rose-600 text-white">
                                <th class="p-4 text-left font-semibold">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Title
                                    </div>
                                </th>
                                <th class="p-4 text-left font-semibold">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        Subject
                                    </div>
                                </th>
                                <th class="p-4 text-center font-semibold">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Questions
                                    </div>
                                </th>
                                <th class="p-4 text-center font-semibold">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                        Published
                                    </div>
                                </th>
                                <th class="p-4 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-red-100">
                            @forelse($quizzes as $q)
                                <tr class="hover:bg-red-50/50 transition-colors duration-150">
                                    <td class="p-4">
                                        <div class="font-semibold text-red-800">{{ $q->title }}</div>
                                    </td>
                                    <td class="p-4">
                                        <span class="inline-flex px-3 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">
                                            {{ $q->subject->name }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-red-500 to-rose-500 text-white rounded-full text-sm font-bold">
                                            {{ $q->questions_count }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($q->is_published)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('quizzes.edit',$q) }}" 
                                               class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-sm font-medium rounded-lg shadow hover:shadow-md transform hover:scale-105 transition-all duration-150"
                                               title="Edit Quiz">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('quizzes.destroy',$q) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this quiz? This action cannot be undone.')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white text-sm font-medium rounded-lg shadow hover:shadow-md transform hover:scale-105 transition-all duration-150"
                                                        title="Delete Quiz">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>

                                            <!-- Publish Button -->
                                            @if(!$q->is_published)
                                                <form action="{{ route('quizzes.publish',$q) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-sm font-medium rounded-lg shadow hover:shadow-md transform hover:scale-105 transition-all duration-150"
                                                            title="Publish Quiz">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                        </svg>
                                                        Publish
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-12 text-center" colspan="5">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-red-700 mb-1">No quizzes yet</h3>
                                                <p class="text-red-500">Create your first quiz to get started!</p>
                                            </div>
                                            <a href="{{ route('quizzes.create') }}" 
                                               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Create First Quiz
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                <div class="bg-white/70 backdrop-blur-sm border border-red-100 rounded-2xl shadow-lg p-4">
                    {{ $quizzes->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom pagination styling for red theme */
        .pagination {
            @apply flex items-center gap-1;
        }
        
        .pagination a,
        .pagination span {
            @apply px-3 py-2 text-sm font-medium rounded-lg transition-all duration-150;
        }
        
        .pagination a {
            @apply text-red-600 hover:bg-red-50 hover:text-red-700 border border-red-200;
        }
        
        .pagination .active span {
            @apply bg-gradient-to-r from-red-600 to-rose-600 text-white border-transparent;
        }
        
        .pagination .disabled span {
            @apply text-red-300 cursor-not-allowed;
        }
    </style>
</x-app-layout>