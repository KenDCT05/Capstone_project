<!-- resources/views/admin/register-student.blade.php -->

<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Register New Student</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.register.student.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="name" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Birthday</label>
                <input type="date" name="birthday" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" class="w-full mt-1 p-2 border rounded" required>
                    <option value="">Select...</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Grade Level</label>
                <input type="text" name="grade_level" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Section</label>
                <input type="text" name="section" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Student Email</label>
                <input type="email" name="email" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Parent/Guardian Name</label>
                <input type="text" name="guardian_name" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Guardian Email</label>
                <input type="email" name="guardian_email" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Guardian Contact Number</label>
                <input type="text" name="guardian_contact" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Register Student
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
