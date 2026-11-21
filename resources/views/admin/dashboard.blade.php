
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h1 {
            text-align: center;
            color: #1f2937;
        }

        .welcome {
            text-align: center;
            color: #666;
            margin-bottom: 35px;
        }

        .dashboard {
            display: flex;
            gap: 25px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 30px;
            width: 300px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            color: #2563eb;
        }

        .card p {
            color: #666;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Admin Dashboard</h1>

    <p class="welcome">
        Welcome to the Administration Panel.
        Manage your users and posts from here.
    </p>

    <div class="dashboard">

        {{-- Manage Users --}}
        <div class="card">
            <h2>Manage Users</h2>

            <p>
                View all registered users, create new accounts,
                update user information and delete users.
            </p>

            <a href="{{ route('admin.users.index') }}" class="btn">
                Manage Users
            </a>
        </div>

        {{-- Manage Posts --}}
        <div class="card">
            <h2>Manage Posts</h2>

            <p>
                View all published posts, edit post information
                and delete posts.
            </p>

            <a href="{{ route('admin.posts.index') }}" class="btn">
                Manage Posts
            </a>
        </div>

    </div>

    <a href="{{ route('dashboard') }}" class="back">
        Back to Main Dashboard
    </a>

</div>

</body>
</html>