<?php
    require_once __DIR__ . "/../config/db_config.php";
    require_once __DIR__ . "/../components/login_form.php";
    
    //declaring variables to prevent errors
    $fname = '';
    $lname = '';
    $email = '';
    $pass = '';
    $cpass = '';
    $date = '';
    $err_arr = [];
    $log_err_arr = [];
    $fpass_err_arr = [];
    //register submit event
    if (isset($_POST['reg_submit'])) {
        $fname = $_POST['reg_fname'];
        $fname = strip_tags($fname);
        $fname = ucfirst(strtolower($fname));
        $fname = str_replace(' ', '', $fname);
        $fname = htmlspecialchars($fname);
        $_SESSION['reg_fname'] = $fname;

        $lname = $_POST['reg_lname'];
        $lname = strip_tags($lname);
        $lname = ucfirst(strtolower($lname));
        $lname = str_replace(' ', '', $lname);
        $lname = htmlspecialchars($lname);
        $_SESSION['reg_lname'] = $lname;

        $email = $_POST['reg_email'];
        $email = strip_tags($email);
        $email = strtolower($email);
        $email = str_replace(' ', '', $email);
        $email = htmlspecialchars($email);
        $_SESSION['reg_email'] = $email;

        $fname = $_POST['reg_fname'];
        $fname = strip_tags($fname);
        $fname = ucfirst(strtolower($fname));
        $fname = str_replace(' ', '', $fname);
        $fname = htmlspecialchars($fname);
        $_SESSION['reg_fname'] = $fname;

        $pass = strip_tags($_POST['reg_pass']);
        $pass = htmlspecialchars($pass);
        $pass = str_replace(' ', '', $pass);

        $cpass = strip_tags($_POST['reg_cpass']);
        $cpass = htmlspecialchars($cpass);
        $cpass = str_replace(' ', '', $cpass);

        $signup_date = date("Y-m-d");
        echo"
        <script>
        $(function(){
            $('#loginFormWrapper').hide();
            $('#registerFormWrapper').show();
        })
        </script>
        ";
        //$err_arr checks for registering
        if (!preg_match('/^[a-zA-Z]{2,25}$/', $fname)) {
            $err_arr[] = 'Name can only contain English letters, must be between 2 and 25 characters long <br>';
        }
        if (!preg_match('/^[a-zA-Z]{2,25}$/', $lname)) {
            $err_arr[] = 'Name can only contain English letters, must be between 2 and 25 characters long <br>';
        }
        if (!preg_match('/^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/', $email)) {
            $err_arr[] = 'Email must be a valid address, e.g. me@mydomain.com <br>';
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $response = DB::run($sql);
            if (!($response->num_rows === 0)) {
                $err_arr[] =  'Email is already in use! <br>';
            }
        }
        if (!preg_match('/^[\w@-]{8,25}$/', $pass)) {
            $err_arr[] = 'Password must be between 8 and 25 characters long<br>';
        }
        if ($pass != $cpass) {
            $err_arr[] = 'Passwords must match<br>';
        }
        if ($err_arr) {
            print_r($err_arr);
        } else {
            $salt = "o#A*&1*71^0'}[m";
            $pass = $pass . $salt;
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (fname, lname, email, pass, signup_date) VALUES ('$fname','$lname','$email','$pass','$signup_date')";
            DB::run($sql);
            $_SESSION['reg_fname'] = '';
            $_SESSION['reg_lname'] = '';
            $_SESSION['reg_email'] = '';
            echo "
            <script>
                $(function(){
                    $('#registerFormWrapper').fadeOut(200);
                    setTimeout(() => {
                        $('#loginFormWrapper').fadeIn(200);
                    }, 200);
                })
            </script>
            ";
        }
    } //end of register submit event

    //start of login submit event
    if (isset($_POST['log_submit'])) {
        $email = $_POST['log_email'];
        $email = strip_tags($email);
        $email = strtolower($email);
        $email = str_replace(' ', '', $email);
        $email = htmlspecialchars($email);

        $pass = strip_tags($_POST['log_pass']);
        $pass = htmlspecialchars($pass);
        $pass = str_replace(' ', '', $pass);

        echo"
        <script>
        $(function(){
            $('#loginFormWrapper').show();
            $('#registerFormWrapper').hide();
        })
        </script>
        ";
        //$log_err_arr checks
        if (!preg_match('/^[\w@-]{8,25}$/', $pass)) {
            $log_err_arr[] = 'Password must be between 8 and 25 characters long<br>';
        }
        if (!preg_match('/^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/', $email)) {
            $log_err_arr[] = 'Email must be a valid address, e.g. me@mydomain.com <br>';
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $response = DB::run($sql)->fetch_assoc();
            if ($response) {
                $salt = "o#A*&1*71^0'}[m";
                $pass = $pass . $salt;
                $is_pass_correct = password_verify($pass, $response['pass']);
                if($is_pass_correct){
                    $sql = "UPDATE users SET logged_in = 1 WHERE email = '$email'";
                    DB::run($sql);
                    $_SESSION['user'] = $response['email'];
                    Header('Location: /be_project_mvc/?page=home');
                } else{
                    $log_err_arr[] = "Incorrect Password! <br>";
                }
            } else {
                $log_err_arr[] =  "Email doesn't exist! <br>";
            }
        }
        if ($log_err_arr) {
            print_r($log_err_arr);
        }
    } //end of login submit event

    // start of forgot password submit event:
    if (isset($_POST['fpass_submit'])){
        $fpass_email = $_POST['fpass_email'];
        if (filter_var($fpass_email, FILTER_VALIDATE_EMAIL)) {
            $email = filter_var($fpass_email, FILTER_VALIDATE_EMAIL);
            $sql = "SELECT * FROM users WHERE email = '$fpass_email'";
            $response = DB::run($sql);
            if (!($response->num_rows === 0)) {
                // $recovery = new Pass_recovery();
                $recovery->send_pass_to_fpass_email($fpass_email);
            } else {
                $fpass_err_arr[] =  'Email not found! <br>';
            }
        } else {
            $fpass_err_arr[] =  'Email must be a valid address, e.g. me@mydomain.com';
        }
        if ($fpass_err_arr) {
            print_r($fpass_err_arr);
        }
    } //end of forgot password submit event


    $form = new Login_form();
    $form->html();
?>
