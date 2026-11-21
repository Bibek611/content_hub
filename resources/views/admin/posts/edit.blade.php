<x-layout>
    <div class="mb-4">
        <a href="{{ route('admin.posts.index') }}" class="text-blue-600 hover:underline text-sm">
            ← Go back to Manage Posts
        </a>
    </div>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Update Post</h1>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Post Title --}}
            <div class="mb-4">
                <label for="title" class="block mb-1 font-medium">Post Title</label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title', $post->title) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500"
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Post Content --}}
            <div class="mb-4">
                <label for="body" class="block mb-1 font-medium">Post Content</label>
                <textarea name="body"
                          id="body"
                          rows="6"
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500"
                          required>{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Featured Image --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Current Featured Image</label>
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}"
                         alt="Current Image"
                         class="w-40 h-40 object-cover rounded mt-2">
                @else
                    <p class="text-gray-500 text-sm mt-1">No image uploaded</p>
                @endif
            </div>

            {{-- Upload New Featured Image --}}
            <div class="mb-4">
                <label for="image" class="block mb-1 font-medium">Featured Image (leave empty to keep current)</label>
                <input type="file"
                       name="image"
                       id="image"
                       accept="image/*"
                       class="w-full border border-gray-300 rounded px-3 py-2">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Select Author --}}
            <div class="mb-6">
                <label for="user_id" class="block mb-1 font-medium">Author</label>
                <select name="user_id"
                        id="user_id"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full bg-slate-800 hover:bg-slate-700 text-white py-2.5 rounded-md font-medium transition">
                Update Post
            </button>
        </form>
    </div>
</x-layout>