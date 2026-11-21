@props(['post', 'full' => false])

<div class="card">

    {{-- Post Title --}}
    <h2 class="font-bold text-xl">
        @if (!$full)
            <a href="{{ route('posts.show', $post) }}"
               class="hover:text-blue-500 hover:underline">
                {{ $post->title }}
            </a>
        @else
            {{ $post->title }}
        @endif
    </h2>

    {{-- Featured Image with Controlled Sizing --}}
    @if ($post->image)
        <div class="h-48 rounded-md my-4 w-full overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Featured Image" class="w-full h-full object-contain">
        </div>
    @endif

    {{-- Author and Date --}}
    <div class="text-xs mb-2">
        <span>
            Posted {{ $post->created_at->diffForHumans() }} by
        </span>

        <a href="{{ route('posts.user', $post) }}"
           class="text-blue-500 font-medium">
            {{ $post->user->name }}
        </a>
    </div>

    {{-- Post Body --}}
    <div class="text-sm">
        @if ($full)
            <p>{{ $post->body }}</p>
        @else
            <p>{{ Str::words($post->body, 15) }}</p>

            <a href="{{ route('posts.show', $post) }}"
               class="text-blue-500">
                Read more &rarr;
            </a>
        @endif
    </div>

    <div class="flex items-center justify-end gap-4 mt-6">
        {{ $slot }}
    </div>

</div>