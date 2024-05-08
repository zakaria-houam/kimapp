<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form action="/admin/login" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
