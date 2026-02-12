<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-rose-100 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-xl shadow-xl border border-red-100 mb-6 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/10 to-black/5"></div>
                    <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                    
                    <div class="relative">
                        <h1 class="text-3xl font-bold text-white mb-1 flex items-center"> 
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30 mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            Sections Management
                        </h1>
                        <p class="text-white/80 text-sm font-medium">Create and manage sections for your school</p>
                    </div>
                </div>
                
                <div class="px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('dashboard') }}" 
                       class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.sections.create') }}" 
                       class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="font-medium">Add Section</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Grade Level Filter - Moved Below Header -->
            <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 mb-6">
                <div class="flex items-center justify-left gap-4">
                    <label for="grade_filter" class="text-sm font-bold text-gray-700 whitespace-nowrap flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter by Grade:
                    </label>
                    <div class="relative">
                        <select id="grade_filter" 
                                class="appearance-none pl-4 pr-10 py-3 bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-200 rounded-xl text-sm font-bold text-gray-700 hover:border-red-300 focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all duration-300 cursor-pointer shadow-sm hover:shadow-md min-w-[200px]">
                            <option value="">All Grades</option>
                            <option value="1">Grade 1</option>
                            <option value="2">Grade 2</option>
                            <option value="3">Grade 3</option>
                            <option value="4">Grade 4</option>
                            <option value="5">Grade 5</option>
                            <option value="6">Grade 6</option>
                            <option value="7">Grade 7</option>
   
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-green-800 font-bold text-lg">Success!</h3>
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Sections Grid or Empty State -->
            @if($sections->count() > 0)
                <div id="sections_grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sections as $section)
                    <div class="section-card bg-white rounded-xl shadow-lg border border-red-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" 
                         data-grade="{{ $section->year_level }}">
                        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">{{ $section->name }}</h3>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-white text-xs font-bold border border-white/30">
                                    Grade {{ $section->year_level }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex gap-3">
                                <a href="{{ route('admin.sections.edit', $section) }}" 
                                   class="flex-1 group inline-flex items-center justify-center px-4 py-3 bg-red-50 hover:bg-red-100 text-red-700 font-semibold rounded-xl transition-all duration-300 border-2 border-red-100 hover:border-red-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this section?');"
                                      class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full group inline-flex items-center justify-center px-4 py-3 bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold rounded-xl transition-all duration-300 border-2 border-rose-100 hover:border-rose-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- No Results Message (hidden by default) -->
                <div id="no_results" class="hidden bg-white rounded-xl shadow-lg border border-red-100 p-12 text-center">
                    <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Sections Found</h3>
                    <p class="text-gray-600 mb-6 font-medium">No sections match the selected grade level</p>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg border border-red-100 p-12 text-center">
                    <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Sections Yet</h3>
                    <p class="text-gray-600 mb-6 font-medium">Get started by creating your first section</p>
                    <a href="{{ route('admin.sections.create') }}" 
                       class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create First Section
                        <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gradeFilter = document.getElementById('grade_filter');
            const sectionCards = document.querySelectorAll('.section-card');
            const sectionsGrid = document.getElementById('sections_grid');
            const noResults = document.getElementById('no_results');

            gradeFilter.addEventListener('change', function() {
                const selectedGrade = this.value;
                let visibleCount = 0;

                sectionCards.forEach(card => {
                    const cardGrade = card.getAttribute('data-grade');
                    
                    if (selectedGrade === '' || cardGrade === selectedGrade) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0) {
                    if (sectionsGrid) sectionsGrid.style.display = 'none';
                    if (noResults) noResults.classList.remove('hidden');
                } else {
                    if (sectionsGrid) sectionsGrid.style.display = 'grid';
                    if (noResults) noResults.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>