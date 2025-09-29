<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Register</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <label>Name:</label>
    <input type="text" name="name" value="{{ old('name') }}"><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}"><br><br>

    <label>Password:</label>
    <input type="password" name="password"><br><br>

    <label>Confirm Password:</label>
    <input type="password" name="password_confirmation"><br><br>

    <button type="submit">Register</button>
</form>
</body>
</html>
