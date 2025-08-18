<!-- resources/views/admin/register-teacher.blade.php -->

<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Register Teacher</h2>

        @if (session('success'))
            <div class="mb-4 p-3 text-green-800 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.register.teacher.submit') }}">
            @csrf

            <!-- Full Name -->
            <div class="mb-4">
                <label for="name" class="block font-medium text-sm text-gray-700">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full p-2 border border-gray-300 rounded">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full p-2 border border-gray-300 rounded">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Birthday -->
            <div class="mb-4">
                <label for="birthday" class="block font-medium text-sm text-gray-700">Birthday</label>
                <input type="date" name="birthday" id="birthday" value="{{ old('birthday') }}" required
                       class="w-full p-2 border border-gray-300 rounded">
                @error('birthday') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Contact Number -->
            <div class="mb-4">
                <label for="contact_number" class="block font-medium text-sm text-gray-700">Contact Number</label>
                <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" required
                       class="w-full p-2 border border-gray-300 rounded">
                @error('contact_number') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                    Register Teacher
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
