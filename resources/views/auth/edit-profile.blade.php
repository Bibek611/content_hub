
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 15px auto;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 12px;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Edit Profile</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Profile Form --}}
    <form action="{{ route('profile.update') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        {{-- Name --}}
        <label for="name">Name</label>

        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $user->name) }}"
            required
        >

        {{-- Email --}}
        <label for="email">Email</label>

        <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email', $user->email) }}"
            required
        >

        {{-- New Password --}}
        <label for="password">New Password</label>

        <input
            type="password"
            name="password"
            id="password"
            placeholder="Leave blank to keep current password"
        >

        {{-- Confirm Password --}}
        <label for="password_confirmation">
            Confirm Password
        </label>

        <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            placeholder="Confirm new password"
        >

        {{-- Profile Image --}}
        <label for="avatar">Profile Image</label>

        @if($user->avatar)
            <img
                src="{{ asset('storage/' . $user->avatar) }}"
                alt="Profile Image"
                class="avatar"
            >
        @else
            <p>No profile image uploaded.</p>
        @endif

        <input
            type="file"
            name="avatar"
            id="avatar"
            accept="image/jpeg,image/png,image/gif"
        >

        {{-- Submit Button --}}
        <button type="submit">
            Update Profile
        </button>

    </form>

    <a href="{{ route('dashboard') }}" class="back-link">
        Back to Dashboard
    </a>

</div>

</body>
</html>