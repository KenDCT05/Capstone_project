<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-100 via-pink-50 to-red-200 py-8">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Header Section -->
<div class="bg-white rounded-3xl shadow-2xl border-4 border-red-200 mb-12 overflow-hidden">
    
    <!-- Header Section -->
    <div class="text-center bg-red-700 p-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-500 rounded-full mb-4 shadow-lg animate-bounce mx-auto">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <h1 class="text-5xl font-black text-white mb-2 drop-shadow-lg">My Classes! 🎒</h1>
        <p class="text-xl text-red-100 font-semibold">Let's learn something awesome today!</p>
    </div>

    <!-- Content Section -->
    <div class="p-6">
        <!-- Back to Dashboard Button -->
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center text-lg font-bold text-red-700 bg-red-50 border-2 border-red-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400 shadow-md hover:bg-red-100 transition-all duration-200 cursor-pointer">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>
    </div>

</div>


            <!-- Join Class Button -->
            <div class="text-center mb-12">
                <a href="{{ route('subjects.join') }}" 
                   class="group inline-flex items-center justify-center px-12 py-6 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-2xl font-black rounded-3xl shadow-2xl transform hover:scale-110 hover:-rotate-1 transition-all duration-300 border-4 border-red-400 hover:border-red-300">
                    <svg class="w-10 h-10 mr-4 group-hover:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="drop-shadow-lg">JOIN NEW CLASS! ✨</span>
                </a>
            </div>

            <!-- Subjects Grid -->
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($subjects as $subject)
                    <div class="group relative bg-white rounded-3xl p-8 shadow-2xl border-4 border-red-200 hover:border-red-400 transform hover:scale-105 hover:-rotate-1 transition-all duration-300 overflow-hidden">
                        <!-- Decorative Elements -->
                        <div class="absolute -top-2 -right-2 w-16 h-16 bg-red-400 rounded-full opacity-20 group-hover:animate-ping"></div>
                        <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-pink-300 rounded-full opacity-20"></div>
                        
                        <!-- Subject Icon -->
                        <div class="flex justify-center mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-red-400 to-red-500 rounded-full flex items-center justify-center shadow-lg group-hover:animate-bounce">
                                <span class="text-3xl">📚</span>
                            </div>
                        </div>

                        <!-- Subject Info -->
                        <div class="text-center relative z-10">
                            <h3 class="text-2xl font-black text-red-700 mb-4 leading-tight">
                                {{ $subject->name }}
                            </h3>
                            
                            <div class="bg-red-50 rounded-2xl p-4 mb-4 border-2 border-red-200">
                                <p class="text-lg text-red-600 font-semibold leading-relaxed">
                                    {{ $subject->description }}
                                </p>
                            </div>

                            <!-- Teacher Info -->
                            <div class="flex items-center justify-center bg-gradient-to-r from-pink-100 to-red-100 rounded-2xl p-4 border-2 border-pink-200">
                                <div class="w-12 h-12 bg-red-400 rounded-full flex items-center justify-center mr-3 shadow-md">
                                    <span class="text-xl">👨‍🏫</span>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-red-500 uppercase tracking-wide">Teacher</p>
                                    <p class="text-lg font-black text-red-700">
                                        {{ $subject->teacher->name ?? 'Coming Soon!' }}
                                    </p>
                                </div>
                            </div>
                        </div>



                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full text-center py-16">
                        <div class="inline-flex items-center justify-center w-32 h-32 bg-red-200 rounded-full mb-8 shadow-lg">
                            <span class="text-6xl">📖</span>
                        </div>
                        <h3 class="text-4xl font-black text-red-600 mb-4">No Classes Yet! 🤔</h3>
                        <p class="text-xl text-red-500 font-semibold mb-8 max-w-md mx-auto leading-relaxed">
                            Don't worry! Click the big red button above to join your first awesome class!
                        </p>
                        <div class="animate-bounce">
                            <span class="text-6xl">⬆️</span>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Fun Footer -->
            <div class="text-center mt-16 py-8">
                <div class="inline-flex items-center space-x-4 text-2xl">
                    <span class="animate-pulse">🌟</span>
                    <span class="text-xl font-black text-red-600">Ready to learn something amazing?</span>
                    <span class="animate-pulse">🌟</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Add some custom CSS for extra interactivity -->
    <style>
        @keyframes wiggle {
            0%, 7% { transform: rotateZ(0); }
            15% { transform: rotateZ(-15deg); }
            20% { transform: rotateZ(10deg); }
            25% { transform: rotateZ(-10deg); }
            30% { transform: rotateZ(6deg); }
            35% { transform: rotateZ(-4deg); }
            40%, 100% { transform: rotateZ(0); }
        }

        .group:hover .animate-wiggle {
            animation: wiggle 0.8s ease-in-out;
        }

        /* Fun hover effects */
        .group:hover {
            box-shadow: 0 25px 50px -12px rgba(239, 68, 68, 0.5);
        }

        /* Smooth transitions for all interactive elements */
        * {
            transition: all 0.2s ease-in-out;
        }
    </style>
</x-app-layout>