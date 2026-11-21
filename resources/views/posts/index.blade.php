<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME', 'Simple CRM') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-layout>
        <h1 class="title">Latest Posts</h1>

        <div class="grid grid-cols-2 gap-6">
            @foreach ($posts as $post)
                <x-postCard :post="$post">
                    @can('modify', $post)
                        <a href="{{ route('posts.edit', $post) }}" class="bg-green-500 text-white px-2 py-1 text-xs rounded">
                            Update
                        </a>

                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 text-xs rounded">
                                Delete
                            </button>
                        </form>
                    @endcan
                </x-postCard>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </x-layout>
</body>
</html>