<x-app-layout>
<div class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">{{ $quiz->title }}</h1>
        @if(!is_null($remainingQuizSeconds))
            <div>Time left: <span id="quiz-timer">{{ $remainingQuizSeconds }}</span>s</div>
        @endif
    </div>

    <form id="submit-form" method="POST" action="{{ route('student.quizzes.submit',$attempt) }}">
        @csrf
        <button class="px-4 py-2 bg-green-600 text-white rounded mb-4">Submit</button>
    </form>

    @foreach($questions as $idx => $q)
        @php $answered = $answers->get($q->id) @endphp
        <div class="border rounded p-4 mb-4">
            <div class="flex justify-between">
                <p class="font-semibold">{{ $idx+1 }}. {{ $q->question_text }}</p>
                @if($q->time_limit_seconds)
                    <span class="text-sm">Per Q: {{ $q->time_limit_seconds }}s</span>
                @endif
            </div>
            <div class="mt-2 space-y-2">
                @foreach($q->shuffled_options as $opt)
                    <label class="flex items-center gap-2">
                        <input type="radio"
                               name="q{{ $q->id }}"
                               value="{{ $opt->id }}"
                               @checked(optional($answered)->option_id == $opt->id)
                               onchange="saveAnswer({{ $q->id }}, {{ $opt->id }})">
                        <span>{{ $opt->option_text }}</span>
                    </label>
                @endforeach
            </div>
            <div id="msg-{{ $q->id }}" class="text-sm mt-2 text-gray-500"></div>
        </div>
    @endforeach
</div>

<script>
async function saveAnswer(questionId, optionId) {
    const res = await fetch("{{ route('student.quizzes.answer',$attempt) }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ question_id: questionId, option_id: optionId })
    });
    const data = await res.json();
    const el = document.getElementById('msg-'+questionId);
    if (data.ok) {
        el.textContent = 'Saved.';
    } else {
        el.textContent = 'Error saving.';
    }
}

// quiz timer (if present)
const timerEl = document.getElementById('quiz-timer');
if (timerEl) {
    let secs = parseInt(timerEl.textContent, 10);
    const t = setInterval(() => {
        secs--; timerEl.textContent = secs;
        if (secs <= 0) {
            clearInterval(t);
            document.getElementById('submit-form').submit();
        }
    }, 1000);
}
</script>
</x-app-layout>
