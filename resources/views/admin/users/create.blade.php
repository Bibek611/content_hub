<x-layout>
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline text-sm">
            ← Back to users
        </a>
    </div>

    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Add New User</h1>

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block mb-1 font-medium">Name</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block mb-1 font-medium">Email</label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500"
                       required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block mb-1 font-medium">Password</label>
                <input type="password"
                       name="password"
                       id="password"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500"
                       required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="block mb-1 font-medium">Confirm Password</label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500"
                       required>
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label for="role" class="block mb-1 font-medium">Role</label>
                <select name="role"
                        id="role"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Avatar --}}
            <div class="mb-6">
                <label for="avatar" class="block mb-1 font-medium">Avatar</label>
                <input type="file"
                       name="avatar"
                       id="avatar"
                       accept="image/*"
                       class="w-full border border-gray-300 rounded px-3 py-2">
                @error('avatar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full bg-slate-800 hover:bg-slate-700 text-white py-2.5 rounded-md font-medium transition">
                Create User
            </button>
        </form>
    </div>
</x-layout>