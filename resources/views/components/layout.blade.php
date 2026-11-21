<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME', 'Simple CRM') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 text-slate-900 m-0">

    <header class="bg-slate-900 shadow-md">
        <nav class="flex justify-between items-center px-6 py-3">

            {{-- Left side --}}
            <a href="{{ route('home') }}" class="nav-link text-white">
                Home
            </a>

            {{-- Right side --}}
            <div>
                @auth
                    <div class="relative" x-data="{ open: false }">

                        {{-- Profile Button --}}
                        <button @click="open = !open" type="button"
                            class="round-btn w-10 h-10 rounded-full overflow-hidden">
                            @if (auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                     alt="Profile"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-500 text-white flex items-center justify-center font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open"
                             @click.outside="open = false"
                             x-transition
                             class="bg-white shadow-lg absolute top-12 right-0 rounded-lg overflow-hidden font-light min-w-[180px] z-50">

                            <p class="px-4 py-2 text-sm text-gray-700 border-b text-center font-semibold">
                                {{ auth()->user()->name }}
                            </p>

                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                   class="block hover:bg-slate-100 px-4 py-2">
                                    Admin Panel
                                </a>
                            @endif

                            <a href="{{ route('dashboard') }}"
                               class="block hover:bg-slate-100 px-4 py-2">
                                Dashboard
                            </a>

                            <a href="{{ route('profile.edit') }}"
                               class="block hover:bg-slate-100 px-4 py-2">
                                Edit Profile
                            </a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-left px-4 py-2 hover:bg-slate-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="nav-link text-white">Login</a>
                        <a href="{{ route('register') }}" class="nav-link text-white">Register</a>
                    </div>
                @endguest
            </div>
        </nav>
    </header>

    <main class="py-8 px-4 mx-auto max-w-screen-lg">
        {{ $slot }}
    </main>

</body>
</html>