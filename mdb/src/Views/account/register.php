<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MDB</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <?php include "src/Views/header.php"; ?>

    <div id="login-container">
        <div id="login-wrapper">
            <h2>Create a new account</h2>
            <p>If you already have an account, login <a href="/mdb/login">here.</a></p>
            <form id="theform" method="POST">
                <label>Username</label>
                <input id="username" type="text" name="username">
                <label>Password</label>
                <input id="password" type="password" name="password">
                <label>Password Confirm</label>
                <input id="password-confirm" type="password" name="password">
                <label>Email</label>
                <input id="email" type="text" name="email">
                <span id="error-msg">User or email already exists.</span>
                <div>
                    <input type="submit" value="Register">
                </div>
            </form>
        </div>
    </div>

    <script>
        $("#theform").submit(function(e){
            e.preventDefault();

            if($("#username").val() != "" && $("#password").val() != "" && $("#email").val() != ""){
                if($("#password").val() == $("#password-confirm").val()){
                    $.ajax({
                        type: "POST",
                        url: "/mdb/login_register_controller",
                        data: {username: $("#username").val(), email: $("#email").val(), password: $("#password").val(), action: "register"},
                        success: function(res){
                            console.log(res);
                            if(!res){
                                $("#error-msg").toggleClass("on");
                                $("#theform input:text, input:password").val("");
                                $("#theform input:text, input:password").on("input", function(){
                                    $("#error-msg").removeClass("on");
                                });
                            }
                            else
                                window.location.href = "/mdb/login";
                        }
                    });
                }
                else{
                    $("#error-msg").toggleClass("on").text("Passwords don't match");
                    $("#theform input:text, input:password").val("");
                    $("#theform input:text, input:password").on("input", function(){
                        $("#error-msg").removeClass("on");
                    });
                }
            }
            else{
                $("#error-msg").toggleClass("on").text("Complete all fields");
                $("#theform input:text, input:password").val("");
                $("#theform input:text, input:password").on("input", function(){
                    $("#error-msg").removeClass("on");
                });
            }
        });
    </script>


    <?php include "src/Views/footer.html"; ?>
</body>
</html>