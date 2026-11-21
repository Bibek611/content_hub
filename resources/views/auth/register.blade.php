<x-layout>
    <div class="max-w-md mx-auto card mt-8">
        <h1 class="title text-center">Register</h1>

        <form action="{{ route('register') }}" method="POST">
            @csrf            

            {{-- Name --}}
            <div class="mb-4">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="input" required>
                @error('name') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="input" required>
                @error('email') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="input" required>
                @error('password')   
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="input" required>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
</x-layout>