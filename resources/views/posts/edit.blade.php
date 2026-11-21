<x-layout>
    <a href="{{ route('dashboard') }}" class="block mb-2 text-xs text-blue-500">
        &larr; Go back to your dashboard
    </a>

    <div class="card">
        <h2 class="font-bold mb-4 text-xl">
            Update your post
        </h2>
        
        <form action="{{ route('posts.update' , $post)}}" method="post" 
        enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Post Title --}}
            <div class="mb-4">
                <label for="title">Post Title</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                    class="input @error('title') ring-red-500 @enderror">
                @error('title')
                    <p class="error text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Post Body --}}
            <div class="mb-4">
                <label for="body">Post Content</label>
                <textarea name="body" rows="5"
                    class="input @error('body') ring-red-500 @enderror">{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <p class="error text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

             {{-- Current Featured Photo with Controlled Sizing --}}
            @if ($post->image)
                <div class="mb-4">
                    <span class="block text-sm font-medium mb-1">Current featured photo</span>
                    <div class="h-48 rounded-md w-full overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Current post image" class="w-full h-full object-contain">
                    </div>
                </div>
            @endif

            {{-- Upload New Photo --}}
            <div class="mb-6">
                <label for="image">Upload New Photo (Optional)</label>
                <input type="file" name="image" id="image" class="input mt-1">
                @error('image')
                    <p class="error text-red-500 text-sm mt-1">{{ $message }}</p>
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

            <button type="submit" class="btn">Update</button>
        </form>
    </div>
</x-layout>