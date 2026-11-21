<x-layout>
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline text-sm">
            ← Go back to your dashboard
        </a>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Users</h1>

        <a href="{{ route('admin.users.create') }}"
           class="bg-slate-800 hover:bg-slate-700 text-white px-5 py-2.5 rounded-md text-sm font-medium transition">
            + Add New User
        </a>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Users Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-4 py-3 text-left">Username</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Avatar</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t hover:bg-slate-50">
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3 capitalize">{{ $user->role }}</td>
                        <td class="px-4 py-3">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}"
                                     alt="Avatar"
                                     class="w-10 h-10 rounded-full object-cover">
                            @else
                                <span class="text-gray-400 text-sm">No Avatar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="text-blue-600 hover:underline text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</x-layout>