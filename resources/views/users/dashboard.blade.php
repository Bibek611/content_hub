<x-layout>
    <h1 class="title">Hello {{ auth()->user()->name }}, 
        you have {{ $posts->total() }} posts
    </h1>
    <p class="mb-6">Welcome to your dashboard!</p>

    {{-- Create Post Form --}}
    <div class="max-w-2xl mx-auto card">
        <h2 class="title text-center mb-6">Create a New Post</h2>

        {{-- Session Messages --}}
        @if (session('success'))
        <x-flashMsg msg="{{ session('success') }}" />
        @elseif (session('delete'))
        <x-flashMsg msg="{{ session('delete') }}" bg="bg-red-500" />
        @endif

        <form action="{{ route('posts.store') }}" method="POST"
         enctype="multipart/form-data">
            @csrf

            {{-- Post Title --}}
            <div class="mb-4">
                <label for="title">Post Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title') }}"
                    class="input @error('title') border-red-500 @enderror"
                >

                @error('title')
                    <p class="error text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Post Body --}}
            <div class="mb-6">
                <label for="body">Post Content</label>
                <textarea
                    name="body"
                    id="body"
                    rows="5"
                    class="input @error('body') border-red-500 @enderror"
                >{{ old('body') }}</textarea>

                @error('body')
                    <p class="error text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- post image --}}
            <div class="mb-6">
                <label for="image">Featured Image</label>
                <input
                    type="file"
                    name="image"
                    id="image"
                    class="
                    file:mr-4
                    file:py-2
                    file:px-4
                    file: text-sm file:font-semibold
                    file:bg-gray-200
                    hover:file:bg-blue-100 "
                >

                @error('image')
                    <p class="error text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn">Create</button>
        </form>
    </div>

    {{-- User Posts --}}
    <h2 class="font-bold mb-4">Your Latest Posts</h2>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)

            <x-postCard :post="$post">
                {{-- update --}}
                <a href="{{route('posts.edit', $post)}}"  class="bg-green-500 text-white 
                px-2 py-1 text-xs rounded-md">Update</a>

                
                {{-- delete --}}
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-2 py-1 text-xs rounded-md">Delete</button>
                </form>
            </x-postCard>

        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $posts->links() }}
    </div>

</x-layout>