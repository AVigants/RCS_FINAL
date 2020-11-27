<?php
require_once "config/db_config.php";
require_once __DIR__ . "/../models/posts_model.php";
//declaring variables to prevent errors
$user = '';
$user_id = '';
$fname = '';
$username = '';
$profile_pic = '';
$model = '';
//make sure we are logged in as the correct user:
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $model = new Posts_model($user['id'], $user['fname'], $user['username'], $user['email']);

    $response = $model->get_user_by_id();
    // $sql = "SELECT * FROM users WHERE id = '$user_id'";
    // $response = DB::run($sql)->fetch_assoc();
    if ($response) {
        $user_id = $response['id'];
        $fname = $response['fname'];
        $username = $response['username'];
        $profile_pic = $response['profile_pic'];
        // todo declare these as global variables so I dont have to pass them in the function as params in jumbotron.php render_user_jumbotron()
    }
} else {
    Header('Location: /be_project_mvc/?page=login');
}
if (isset($_POST['logout_btn'])) {
    $model->logout();
    session_destroy();
    Header('Location: /be_project_mvc/?page=login');
}

//-----------------------uploading a new post----------------------------
$post_err_arr = [];
if (isset($_POST['submit_post'])) {
    if (isset($_FILES['post_pic']['name'])) {
        $target_dir = "./assets/images/";
        $basename = basename($_FILES['post_pic']['name']);
        $basename = str_replace(' ', '_', $basename);
        $basename = htmlspecialchars($basename); //just added this - check out later, if it doesnt work, tweak it
        $target_file = $target_dir . $basename;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // $check = getimagesize($_FILES["post_pic"]["tmp_name"]);
        // if ($check !== false) {
        //     $uploadOk = 1;
        // } else {
        //     $post_err_arr[] = 'File is not an image <br>';
        //     $uploadOk = 0;
        // }

        // todo: add a lorem picsum image if I submit with no image
        if ($_FILES["post_pic"]["size"] > 20971520) {
            $post_err_arr[] = "Sorry, your file is too large. Max: 20MB.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $post_err_arr[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($post_err_arr || $uploadOK = 0) {
            echo "Sorry, your file was not uploaded.<br>";
            print_r($post_err_arr);
        } else {
            $date_posted = date("Y-m-d");
            $about = $_POST['post_text'];
            $about = htmlspecialchars($about);
            $post_id = $model->add_new_post($about, $date_posted, $imageFileType);
            $target_file = $target_dir . $post_id . '.' . $imageFileType;
            if(!(file_exists($target_file))) {
                move_uploaded_file($_FILES["post_pic"]["tmp_name"], $target_file);
                echo 'file has been moved to designated server folder';
            }
            //todo: remove the image from the folder when I delete the image from the website/database
        }
    }
}
//why does the page automatically update correctly if I have a new picture posted??!_----------------------------------------------------------------!!!!!!!!!!!!!!!_--------------------------------------^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^THE PIC AUTOMATICALLY GETS UPDATED BECAUSE THE FILE TRANSFFER TO TO THE COMPUTER FOLDER IS INSTANT. THE DB NEEDS TO UPDATE THEN IT CAN FETCH THE DATA??

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./scripts/header.js"></script>
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
                    <button class="dropdown-toggle text-white btn btn-link" data-toggle="dropdown">
                        <i class="fas fa-cog text-white fa-lg"></i>
                        Settings
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" id="listViewBtn"><i class="fas fa-th-list"></i> List View</a>
                        <a class="dropdown-item" href="#" id="gridViewBtn"><i class="fas fa-th"></i> Grid View</a>
                        <a class="dropdown-item" href="#" id="clearArrayBtn"><i class="fas fa-info-circle"></i> About</a>
                    </div>
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
    <!-- //todo if this user then this jumbotron -->
    <?php include ("jumbotron.php") ?>
    <!-- // todo if foreign user then different jumbotron -->


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
                                <button type="submit" class="btn btn-warning col-4" name="submit_post">Submit</button>
                                <div class="btn btn-dark col-4" id="add_post_form_close_btn">
                                    Cancel
                                </div>
                                <!-- todo: add color to either bg of html, of cards, of add-card -->
                                <!-- todo: add the image right away to the card as a preview! -->
                                <!-- todo dont let the image be submitted if it has spaces in its name! -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>