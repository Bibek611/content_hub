<x-layout>

    <h1 class="font-bold text-3xl mb-4">
        View Post
    </h1>

    {{-- Display the complete post using the reusable component --}}
    <x-postCard :post="$post" full="true" />

    <a href="{{ url()->previous() }}"
       class="text-blue-500 hover:underline mt-6 inline-block">
        &larr; Go Back
    </a>

</x-layout>