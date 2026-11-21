<x-layout>
    <div class="max-w-md mx-auto card mt-8">
        <h1 class="title text-center">Welcome Back</h1>

        <form action="{{ route('login') }}" method="POST">
            @csrf            

            {{-- Email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="input" required>
                @error('email') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-6">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="input" required>
                @error('password')   
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            {{-- Remember Checkbox  --}}
            <div class="mb-6">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label  for="remember">Remember Me</label>
            </div>

            @error('failed')
                <p class="error">{{ $message }}</p>
            @enderror

            {{-- Submit Button --}}
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</x-layout>