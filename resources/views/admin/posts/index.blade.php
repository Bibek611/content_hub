<x-layout>
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline text-sm">
            ← Go back to your dashboard
        </a>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Posts</h1>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Posts Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Author</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr class="border-t hover:bg-slate-50">
                        <td class="px-4 py-3">{{ $post->id }}</td>
                        <td class="px-4 py-3">{{ $post->title }}</td>
                        <td class="px-4 py-3">{{ $post->user->name ?? 'Unknown' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3">
                                <a href="{{ route('admin.posts.edit', $post) }}"
                                   class="text-blue-600 hover:underline text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.posts.destroy', $post) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this post?')">
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
        {{ $posts->links() }}
    </div>
</x-layout>