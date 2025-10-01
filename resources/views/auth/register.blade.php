<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h2>Register</h2>

<form id="registerForm">
    @csrf
    <label>Name:</label>
    <input type="text" name="name"><br><br>

    <label>Email:</label>
    <input type="email" name="email"><br><br>

    <label>Password:</label>
    <input type="password" name="password"><br><br>

    <label>Confirm Password:</label>
    <input type="password" name="password_confirmation"><br><br>

    <button type="submit">Register</button>
</form>

<div id="registerMsg"></div>

<script>
$("#registerForm").submit(function(e){
    e.preventDefault();

    $.ajax({
        url: "{{ route('register') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(res){
            $("#registerMsg").html("<p style='color:green;'>" + res.message + "</p>");
            setTimeout(()=> window.location.href="/home", 1000);
        },
        error: function(xhr){
            let errors = xhr.responseJSON.errors;
            let msg = "<ul style='color:red;'>";
            $.each(errors, function(key, val){
                msg += "<li>" + val[0] + "</li>";
            });
            msg += "</ul>";
            $("#registerMsg").html(msg);
        }
    });
});
</script>
</body>
</html>
