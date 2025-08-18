<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-red-100 to-red-200 flex items-center justify-center">
        <div class="bg-white shadow-xl rounded-2xl border-4 border-red-300 p-8 w-full max-w-md">
            <h1 class="text-3xl font-bold text-red-800 mb-6 text-center">Join a Subject</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('subjects.join') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="join_code" class="block font-semibold mb-1">Join Code</label>
                    <input type="text" name="join_code" id="join_code"
                           class="w-full border border-gray-300 rounded p-2 uppercase focus:outline-none focus:ring-2 focus:ring-red-400"
                           placeholder="Enter Code (e.g. AB12CD)" required>
                </div>

                <button type="submit"
                        class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded-xl transition duration-200">
                    Join Subject
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
