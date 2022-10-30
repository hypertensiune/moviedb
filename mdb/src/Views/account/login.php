<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MDB</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <?php include 'src/Views/header.php'; ?>

    <div id="login-container">
        <div id="login-wrapper">
            <h2>Login to your account</h2>
            <p>If you don't have an account, create one <a href="/mdb/register">here.</a></p>
            <form id="theform" method="POST">
                <label>Username</label>
                <input id="username" type="text" name="username">
                <label>Password</label>
                <input id="password" type="password" name="password">
                <span id="error-msg">Invalid username or password. Try again.</span>
                <div>
                    <input type="submit" value="Login">
                    <a>Reset password</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $("#theform").submit(function(e){
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "/mdb/login_register_controller?",
                data: {username: $("#username").val(), password: $("#password").val(), action: "login"},
                success: function(res){
                    if(!res){
                        $("#error-msg").toggleClass("on");
                        $("#theform input:text, input:password").val("");
                        $("#theform input:text, input:password").on("input", function(){
                            $("#error-msg").removeClass("on");
                        });
                    }
                    else
                        window.location.href = res;
                }
            });
        });
    </script>

    <?php include 'src/Views/footer.html'; ?>
</body>
</html>