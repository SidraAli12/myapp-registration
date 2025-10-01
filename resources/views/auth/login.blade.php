<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h2>Login</h2>

<form id="loginForm">
    @csrf
    <label>Email:</label>
    <input type="email" name="email"><br><br>

    <label>Password:</label>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
</form>

<div id="loginMsg"></div>

<script>
$("#loginForm").submit(function(e){
    e.preventDefault();

    $.ajax({
        url: "{{ route('login') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(res){
            $("#loginMsg").html("<p style='color:green;'>" + res.message + "</p>");
            setTimeout(()=> window.location.href="/home", 1000);
        },
        error: function(xhr){
            let msg = "Something went wrong!";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            $("#loginMsg").html("<p style='color:red;'>" + msg + "</p>");
        }
    });
});
</script>
</body>
</html>
