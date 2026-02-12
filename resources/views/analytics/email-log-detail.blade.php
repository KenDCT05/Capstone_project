<x-app-layout>
    <div class="py-8 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-xl border border-blue-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        Email Log Details
                    </h1>
                </div>
                <div class="px-8 py-6">
                    <a href="{{ route('analytics.communication-logs') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>  
                        Back to Communication Logs
                    </a>
                </div>
            </div>

            <!-- Email Information -->
            <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-4">
                    <h2 class="text-xl font-bold text-white">Email Information</h2>
                </div>
                
                <div class="p-8 space-y-6">
                    <!-- Student & Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-bold text-gray-700 mb-2">Student</h3>
                            <p class="text-lg font-semibold text-gray-900">{{ $emailLog->student->name }}</p>
                            <p class="text-sm text-gray-600">ID: {{ $emailLog->student_id }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-bold text-gray-700 mb-2">Guardian Email</h3>
                            <p class="text-lg font-semibold text-gray-900 break-all">{{ $emailLog->guardian_email }}</p>
                        </div>
                    </div>

                    <!-- Email Subject -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h3 class="text-sm font-bold text-gray-700 mb-2">Subject</h3>
                        <p class="text-lg font-medium text-gray-900">{{ $emailLog->subject }}</p>
                    </div>

                    <!-- Risk Information -->
                    @if($emailLog->risk_severity)
                        <div class="bg-{{ $emailLog->risk_severity === 'critical' ? 'red' : ($emailLog->risk_severity === 'high' ? 'orange' : 'yellow') }}-50 p-4 rounded-lg border border-{{ $emailLog->risk_severity === 'critical' ? 'red' : ($emailLog->risk_severity === 'high' ? 'orange' : 'yellow') }}-200">
                            <h3 class="text-sm font-bold text-gray-700 mb-3">Risk Assessment</h3>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <span class="text-xs text-gray-600 block mb-1">Severity</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold uppercase
                                        {{ $emailLog->risk_severity === 'critical' ? 'bg-red-200 text-red-800' : 
                                           ($emailLog->risk_severity === 'high' ? 'bg-orange-200 text-orange-800' : 'bg-yellow-200 text-yellow-800') }}">
                                        {{ $emailLog->risk_severity }}
                                    </span>
                                </div>
                                
                                @if($emailLog->failed_count)
                                    <div>
                                        <span class="text-xs text-gray-600 block mb-1">Failed Assessments</span>
                                        <span class="text-lg font-bold text-red-700">{{ $emailLog->failed_count }}</span>
                                    </div>
                                @endif
                                
                                @if($emailLog->trend)
                                    <div>
                                        <span class="text-xs text-gray-600 block mb-1">Trend</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $emailLog->trend === 'improving' ? 'bg-green-100 text-green-800' : 
                                               ($emailLog->trend === 'declining' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                            @if($emailLog->trend === 'improving')
                                                ↗ Improving
                                            @elseif($emailLog->trend === 'declining')
                                                ↘ Declining
                                            @else
                                                → Stable
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Failed Scores -->
                    @if(count($failedScores) > 0)
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <h3 class="text-sm font-bold text-gray-700 mb-3">Failed Assessments Included in Email</h3>
                            <div class="space-y-2">
                                @foreach($failedScores as $score)
                                    <div class="bg-white p-3 rounded-lg border-l-3 border-red-500">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $score['label'] }}</p>
                                                <p class="text-sm text-gray-600">
                                                    Score: {{ $score['score'] }}/{{ $score['max_score'] }} 
                                                    ({{ $score['transmuted_grade'] }}% transmuted)
                                                </p>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $score['date'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Sent Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-bold text-gray-700 mb-2">Sent Information</h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-900">{{ $emailLog->sent_at->format('F d, Y \a\t h:i A') }}</p>
                                <p class="text-sm text-gray-600">{{ $emailLog->sent_at->diffForHumans() }}</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                ✓ Delivered
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Email Log #{{ $emailLog->id }}
                    </div>
                    <button onclick="window.print()" 
                            class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                        Print Record
                    </button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>