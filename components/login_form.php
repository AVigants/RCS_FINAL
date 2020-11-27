<?php
class Login_form{
    public function html(){
    ?>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./scripts/app.js"></script>
    <link rel="stylesheet" href="assets/styles.css">
    <title>MVC IN PROGRESS</title>
</head>
<body>
    <div id="outerDiv">
        <div id="middleDiv">
            <i class="fas fa-window-close fa-3x" id="close"></i>
            <div id="innerDiv">
                <p>Thank You For Registering, <span id="registeredUserSpan" class="text-lowercase text-capitalize"></span></p>
                <p>You can now Log in!</p>
                <img src="https://www.flaticon.com/svg/static/icons/svg/25/25297.svg" id="thumbsup">
            </div>
        </div>
    </div>
    <div class="login-form" id="loginFormWrapper">
        <!-- LOGIN FORM -->
        <form class="card" id="loginForm" method="POST">
            <div class="avatar"> <img src="https://picsum.photos/200" alt=""></div>
            <h2 class="text-center my-4">Log In</h2>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" required="required" id="loginEmail" name="log_email" autofocus>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required="required" id="loginPass" name="log_pass">
                <p>Invalid email or password</p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" name="log_submit">Log In</button>
            </div>
            <div class="clearfix">
                <label class="float-left form-check-label"><input type="checkbox" id="rememberMe" value="rememberMe"> Remember me</label>
                <a href="#" class="float-right">Forgot Password?</a>
        </form>
        <!-- PASSWORD RESET -->
        <form id="passResetForm" class="card" method="POST">
            <div class="form-group" id="passResetFormGroup">
                <label id="passResetEmailLabel">Submit your email to reset password!
                    <input type="email" class="form-control" placeholder="Email" id="passResetEmail" name="fpass_email" autocomplete="off" required>
                    <p>Email not found...</p>
                </label>
                <button type="submit" class="btn btn-primary btn-block bg-warning" name="fpass_submit" id="passResetBtn">Reset Password</button>
            </div>
        </form>
        <br>
        <hr>
        <p class="text-center my-0">Don't have an account? <br><a href="#" id="registerHref">Create an Account!</a></p>
    </div>
    </div>

    <div class="login-form" id="registerFormWrapper">
        <!-- REGISTER FORM -->
        <form class="card" id="registerForm" method="POST" action="">
            <div class="avatar"> <img src="https://picsum.photos/200?random=00" alt=""></div>
            <h2 class="text-center my-4">Register</h2>
            <div class="form-group" method="POST">
                <input type="text" class="form-control" placeholder="First Name" required="required" name="reg_fname" value="<?= $_SESSION['reg_fname'] ?? '' ?>">
                <p>Name can only contain English letters, must be between 2 and 25 characters long</p>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" required="required" name="reg_username" value="<?= $_SESSION['reg_username'] ?? '' ?>">
                <p>Name can only contain English letters, must be between 2 and 25 characters long</p>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" required="required" name="reg_email" value="<?= $_SESSION['reg_email'] ?? '' ?>">
                <p>email must be a valid address, e.g. me@mydomain.com or email is already in use</p>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required="required" name="reg_pass">
                <p>password bust be alphanumeric (@ _ and - are allowed) and be 8-25 characters long</p>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm Password" required="required" name="reg_cpass">
                <p>passwords must match</p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" name="reg_submit">Register</button>
            </div>
            <div class="clearfix">
                <hr>
                <p class="text-center my-0">Already have an account? <br><a href="#" id="loginHref">Sign in!</a></p>
            </div>
        </form>
    </div>
    <?php
    }
}
?>
</body>
</html>
