<?php
require_once "config/db_config.php";
require_once __DIR__ . "/../models/posts_model.php";
//declaring variables to prevent errors
$user = '';
$user_id = '';
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    //add the fname to the jumbotron ffs
    $sql = "SELECT * FROM users WHERE email = '$user'";
    $response = DB::run($sql)->fetch_assoc();
    if ($response) {
        $user_id = $response['id'];
        $fname_with_comma = ', ' . $response['fname'];
        $profile_pic = $response['profile_pic'];
    }
} else {
    Header('Location: /be_project_mvc/?page=login');
}
if (isset($_POST['logout_btn'])) {
    $sql = "UPDATE users SET logged_in = 0 WHERE email = '$user'";
    DB::run($sql);
    session_destroy();
    Header('Location: /be_project_mvc/?page=login');
}
//--------------uploading a profile image--------------
$profile_pic_err_arr = [];
if (isset($_POST['profile_pic_submit'])) {
    if (isset($_FILES['profile_pic_input']['name'])) {
        $target_dir = "./assets/profile_pics/";
        $target_file = $target_dir . basename($_FILES["profile_pic_input"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["profile_pic_input"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $profile_pic_err_arr[] = 'File is not an image <br>';
            $uploadOk = 0;
        }
        if ($_FILES["profile_pic_input"]["size"] > 500000) {
            $profile_pic_err_arr[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $profile_pic_err_arr[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($profile_pic_err_arr) {
            echo "Sorry, your file was not uploaded.<br>";
            print_r($profile_pic_err_arr);
        } else {
            if (!(file_exists($target_file))) {
                move_uploaded_file($_FILES["profile_pic_input"]["tmp_name"], $target_file);
                echo 'file has been moved to designated server folder';
            }
            $path = 'assets/profile_pics/' . $_FILES["profile_pic_input"]["name"];

            $sql = "UPDATE users SET profile_pic='$path' WHERE email='$user'";
            DB::run($sql);
            //todo: update the image automatically w//out having to reload the page
        }
    }
}
//-----------------------uploading a new post----------------------------
$post_err_arr = [];
if (isset($_POST['submit_post'])) {
    if (isset($_FILES['post_pic']['name'])) { //doesnt work - if its empty it still submits the thing
        $target_dir = "./assets/images/";
        $target_file = $target_dir . basename($_FILES["post_pic"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["post_pic"]["tmp_name"]); //todo: solve this problem when i click on subm and its empty x2
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $post_err_arr[] = 'File is not an image <br>';
            $uploadOk = 0;
        }
        if ($_FILES["post_pic"]["size"] > 20971520) {
            $post_err_arr[] = "Sorry, your file is too large. Max: 20MB.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $post_err_arr[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($post_err_arr) {
            echo "Sorry, your file was not uploaded.<br>";
            print_r($post_err_arr);
        } else {
            if (!(file_exists($target_file))) {
                move_uploaded_file($_FILES["post_pic"]["tmp_name"], $target_file);
                echo 'file has been moved to designated server folder';
            }
            $date_posted = date("Y-m-d");
            $about = $_POST['post_text'];
            $about = htmlspecialchars($about);
            $path = 'assets/images/' . $_FILES["post_pic"]["name"]; //path needs to be fixed since im in a new folder
            $model = new Posts_model();
            $model->add_new_post($user, $user_id, $path, $about, $date_posted);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./scripts/profile.js"></script>
    <link rel="stylesheet" href="./assets/header.css">
    <script>
        // $(function() {
        //     $("input[id='new_profile_pic_btn']").click(function() {
        //         $("input[id='new_profile_pic']").click();
        //     });
        //     $("input[id='add_post_img_btn']").click(function() {
        //         $("input[id='add_post_img']").click();
        //     });

        // });
    </script>
    <title>BE Project INDEX</title>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg py-3 sticky-top" style="background: #333;">

        <div class="navbar-nav mx-auto">
            <li class="mx-5">
                <a href="?page=home" class="text-white btn btn-link">
                    <i class="fas fa-home text-white fa-lg"></i>
                    Home
                </a>
            </li>
            <li class="mx-5">
                <a href="?page=profile" class="text-white btn btn-link">
                    <i class="fas fa-user text-white fa-lg"></i>
                    Profile
                </a>
            </li>
            <li class="mx-5">
                <button class="text-white btn btn-link" id="add_post">
                    <i class="fas fa-plus-square text-success fa-lg"></i>
                    Add Post
                </button>
                <!-- bugfix: when I refresh the page - another sql statement gets sent to the db resulting in another new post -->
            </li>
            <li class="mx-5">
                <form action="" method="POST" name="following_form" class="d-inline">
                    <button class="text-white btn btn-link" type="submit" name="following_btn">
                        <i class="fas fa-users text-white fa-lg"></i>
                        Following
                    </button>
                </form>
            </li>
            <li class="dropdown mx-5">
                <form action="" class="d-inline" name="">
                    <button class="dropdown-toggle text-white btn btn-link" id="dropdownMenuButton" data-toggle="dropdown">
                        <i class="fas fa-cog text-white fa-lg"></i>
                        Settings
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" id="listViewBtn"><i class="fas fa-th-list"></i> List View</a>
                        <a class="dropdown-item" href="#" id="gridViewBtn"><i class="fas fa-th"></i> Grid View</a>
                        <a class="dropdown-item" href="#" id="clearArrayBtn"><i class="fas fa-info-circle"></i> About</a>
                    </div>
                </form>
            </li>
            <li class="mx-5">
                <form action="" method="POST" name="logout_submit" class="d-inline">
                    <button class="text-white btn btn-link" type="submit" name="logout_btn">
                        <i class="fas fa-sign-out-alt text-danger fa-lg"></i>
                        Log Out
                    </button>
                </form>
            </li>
            <!-- todo: remove submit btn and add a follow btn when I click on a user profile. Remove submit btn from home if its my acc -->
        </div>
    </nav>
    <!-- JUMBOTRON -->
    <div class="jumbotron jumbotron-fluid text-white text-center" style="background: #73a2ba;">
        <div class="container">
            <div class="float-left">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="circle">
                        <label for="profile_pic_input" id="profile_pic_label">
                            <img src="<?= $profile_pic ?? 'https://picsum.photos/300' ?>" alt="" class="can_be_clicked">
                        </label>
                        <input type="file" id="profile_pic_input" class="d-none" name="profile_pic_input">
                    </div>
                    <input type="submit" class="btn btn-warning mt-1" name="profile_pic_submit" id="profile_pic_submit" style="display: none;">
                </form>
            </div>
            <div class="">
                <h1 class="display-1">Welcome back<span class="text-lowercase text-capitalize"><?= $fname_with_comma ?? '' ?></span></h1>
                <p class="lead">"May the force be ever in your favor"</p>
                <p class="font-italic">/Dumbledore/</p>
            </div>
        </div>
    </div>    
    <!-- todo: remove the like button if its posted by the logged in user -->

    <!-- ADD POST -->

    <form action="" method="POST" class=" mt-4 mx-none" enctype="multipart/form-data" id="add_post_form" style="display:none">

        <div class="container text-muted">
            <div class="row mt-5">
                <div class="col-8 mx-auto">
                    <div class="card bg-light">
                        <div>
                            <label for="post_pic">
                                <img src="https://i0.wp.com/www.rich-hansen.com/wp-content/uploads/2018/11/Screen-Shot-2018-11-28-at-1.18.54-PM.png?fit=1464%2C856" alt="" class="card-img-top img-fluid can_be_clicked">
                            </label>
                            <input type="file" id="post_pic" class="d-none" name="post_pic">
                        </div>

                        <div class="card-block pb-2 text-center">

                            <textarea placeholder="About..." class="text-center col-11 my-2 form-control mx-auto" name="post_text"></textarea>
                            <div>
                                <button type="submit" class="btn btn-info col-4" name="submit_post">Submit</button>
                                <div class="btn btn-danger col-4" id="add_post_form_close_btn">
                                    Cancel
                                </div>
                                <!-- todo: add color to either bg of html, of cards, of add-card -->
                                <!-- todo: add the image right away to the card as a preview! -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>