<?php
require_once __DIR__ . "/header_controller.php";
require_once __DIR__ . "/../views/user_jumbotron_view.php";
require_once __DIR__ . "/../views/foreign_user_jumbotron_view.php";
$search_results = [];
$profile_pic_err_arr = [];
$model = new Posts_model($_SESSION['user_id'], $_SESSION['fname'], $_SESSION['username']);

if (isset($_POST['follow_btn'])) {
    $model->follow_user($_SESSION['user_id'], $_GET['user_id']);
}
if (isset($_POST['unfollow_btn'])) {
    $model->unfollow_user($_SESSION['user_id'], $_GET['user_id']);
}
//--------------uploading a new prof pic
if (isset($_POST['profile_pic_submit'])) {
    if (isset($_FILES['profile_pic_input']['name'])) {
        $target_dir = "./assets/profile_pics/";
        $basename = basename($_FILES['profile_pic_input']['name']);
        $basename = str_replace(' ', '_', $basename);
        $basename = htmlspecialchars($basename); // if it doesnt work, try removing or tweaking this
        $target_file = $target_dir . $basename;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // $check = getimagesize($_FILES["profile_pic_input"]["tmp_name"]);
        // if ($check !== false) {
        //     $uploadOk = 1;
        // } else {
        //     $profile_pic_err_arr[] = 'File is not an image <br>';
        //     $uploadOk = 0;
        // }
        if ($_FILES["profile_pic_input"]["size"] > 20971520) {
            $profile_pic_err_arr[] = "Sorry, your file is too large. Max allowed: 20MB";
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
            $model->add_new_profile_pic($imageFileType);
            $target_file = $target_dir . $_SESSION['user_id'] . '.' . $imageFileType;
            move_uploaded_file($_FILES["profile_pic_input"]["tmp_name"], $target_file);
            echo 'file has been moved to designated server folder';
            
            // if(!(file_exists($target_file))) {
            //     move_uploaded_file($_FILES["post_pic"]["tmp_name"], $target_file);
            //     echo 'file has been moved to designated server folder';
            // }
            //todo: update the image automatically w//out having to reload the page
        }
    }
}//end of upload profile picture
if (isset($_POST['search_btn'])) {
    if ((isset($_POST['search_text'])) && $_POST['search_text']) {
        $search_text = $_POST['search_text'];
        $search_text = htmlspecialchars($search_text);
        $search_results = $model->get_search_results($search_text);
        //todo render
    }
}
if (isset($_GET["view"]) && $_GET["view"] === "profile") {
    if (isset($_GET["user_id"])) {
        $foreign_user = $model->get_foreign_user_by_id($_GET['user_id']);
        $is_following = $model->get_follower_status($_GET['user_id']);
        $view = new Foreign_user_jumbotron_view();
        $view->foreign_user_jumbotron_html($foreign_user, $is_following);
    } else {
        echo 'something went wrong';
    }
} else {
    $view = new User_jumbotron_view();
    $profile_pic = $model->get_profile_pic();
    $view->user_jumbotron_html($profile_pic);
    //this shit doesnt work for some reaason again!!!!!!!!!!!!!!!!!!!!! whcih means for user also doesnt work..
}
?>