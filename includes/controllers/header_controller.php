<?php

require_once __DIR__ . "/../../config/db_config.php";
require_once __DIR__ . "/../../models/posts_model.php";
require_once __DIR__ . "/../views/header_view.php";
//declaring variables to prevent errors
$user = '';
$user_id = '';
$fname = '';
$username = '';
$profile_pic = '';
$model = '';
    if (isset($_SESSION['user_id'])) {
        if(!(isset($_SESSION['username']))){
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT fname, username FROM users WHERE id = '$user_id'";
            $response = DB::run($sql)->fetch_assoc();
            if($response){
                $_SESSION['fname'] = $response['fname'];
                $_SESSION['username'] = $response['username'];
                // $sql = "SELECT * FROM users WHERE id = '$user_id'";
                // $response = DB::run($sql)->fetch_assoc();
            }
        }
    } else {
        Header('Location: /be_project_mvc/?page=login');
    }
    $model = new Posts_model($_SESSION['user_id'], $_SESSION['fname'], $_SESSION['username']);
    if (isset($_POST['logout_btn'])) {
        $model->logout();
        session_destroy();
        Header('Location: /be_project_mvc/?page=login');
    }



//this isnt effective: it doesnt work fully when i try to access the prof pic in the jumbotron page

//-----------------------uploading a new post----------------------------
// $post_err_arr = [];
$post_err='';
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
            // $post_err_arr[] = "File is too large. Max: 20MB.";
            echo "<div class='text-center display-4 text-danger bg-dark py-2'>File is too large. Max: 20MB.</div>";
            $post_err = 'File is too large. Max: 20MB';
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            // $post_err_arr[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
            echo "<div class='text-center display-4 text-danger bg-dark py-2'>Only JPG, JPEG, PNG & GIF files are allowed.</div>";
            $uploadOk = 0;
        }
        if ($uploadOk !== 0) {
            $date_posted = date("Y-m-d H:i:s");
            $about = $_POST['post_text'];
            $about = htmlspecialchars($about);
            $post_id = $model->add_new_post($about, $date_posted, $imageFileType);
            $target_file = $target_dir . $post_id . '.' . $imageFileType;
            if (!(file_exists($target_file))) {
                move_uploaded_file($_FILES["post_pic"]["tmp_name"], $target_file);
            }
            //todo: remove the image from the folder when I delete the image from the website/database
        }
    }

}
$view = new Header_view();
$view->header_html();
?>
