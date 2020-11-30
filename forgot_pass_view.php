<?php
    require_once "config/db_config.php";
    if(!isset($_GET['code'])){
        exit("Page not found! :(");
    }
    $err_arr = [];
    $code = $_GET['code'];
    $sql = "SELECT email FROM reset_passwords WHERE code = '$code'";
    $response = DB::run($sql)->fetch_assoc();
    if($response){
        $email = $response['email'];
        if(isset($_POST['npass'])){
            $npass = $_POST['npass'];
            $npass = strip_tags($_POST['npass']);
            $npass = str_replace(' ', '', $npass);
            $npass = htmlspecialchars($npass);
            if (!preg_match('/^[\w@-]{8,25}$/', $npass)) {
                $err_arr[] = 'Password must be between 8 and 25 characters long<br>';
            } 
            if($err_arr){
                print_r($err_arr);
            } else{
                $err_arr = [];
                $salt = "o#A*&1*71^0'}[m";
                $npass = $npass . $salt;
                $npass = password_hash($npass, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET pass = '$npass' WHERE email = '$email'";
                DB::run($sql);
                $sql = "DELETE FROM reset_passwords WHERE code = '$code'";
                DB::run($sql);
                exit("            <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
                <div class='jumbotron jumbotron-fluid text-white text-center' style='background: #73a2ba;'>
                <h1 class='display-1'>All Set!</h1>
                <a href='index.php' class='display-4'>Return to the login page!</p>
                    </div>");
            }
        }
    } else exit("Page not found! :(");
    
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="./scripts/header.js"></script>
            <link rel="stylesheet" href="./assets/header.css">
            <title>BE_project_mvc</title>
<body>
<div class="jumbotron jumbotron-fluid text-white text-center" style="background: #73a2ba;">
<h1 class="display-1">Hello</h1>
<p class="display-4">Please submit your new password!</p>
    </div>
    <div class="container text-center">
    <form action="" method="POST">
        <input type="password" name="npass" placeholder="New Password..." class="p-1 col-4 text-center"> <br>
        <button type="submit" name="npass_submit" class="btn btn-warning my-3 col-4">Update Password!</button>
    </form>
    </div>
    
    
</body>
</html>
<!-- todo: set a timeout that destroys the link/code in 5 minutes in case the user changes his mind about reseting his/her pass -->