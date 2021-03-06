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
if (isset($_POST['profile_pic_submit'])) {
    if (isset($_FILES['profile_pic_input']['name'])) {
        $target_dir = "./assets/profile_pics/";
        $basename = basename($_FILES['profile_pic_input']['name']);
        $basename = str_replace(' ', '_', $basename);
        $basename = htmlspecialchars($basename);
        $target_file = $target_dir . $basename;
        $uploadOk_prof_pic = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($_FILES["profile_pic_input"]["size"] > 20971520) {
            echo "<div class='text-center display-4 text-danger bg-dark py-2'>File is too large! Max allowed: 20MB.</div>";
            $uploadOk_prof_pic = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<div class='text-center display-4 text-danger bg-dark py-2'>Only JPG, JPEG, PNG & GIF files are allowed.</div>";
            $uploadOk_prof_pic = 0;
        }
        if ($uploadOk_prof_pic !== 0) {
            $model->add_new_profile_pic($imageFileType);
            $target_file = $target_dir . $_SESSION['user_id'] . '.' . $imageFileType;
            move_uploaded_file($_FILES["profile_pic_input"]["tmp_name"], $target_file);
        }
    }
}//end of upload profile picture
if(isset($_POST['about_submit'])){
    if(isset($_POST['about_text'])){
        $text = $_POST['about_text'];
        $text = htmlspecialchars($text);
        $model->update_user_about($text);
    }
}
if (isset($_POST['search_btn'])) {
    
    if ((isset($_POST['search_text'])) && $_POST['search_text']) {
        $search_text = $_POST['search_text'];
        $search_text = htmlspecialchars($search_text);
        if(isset($_GET['page']) && $_GET['page'] == 'profile'){
            $search_results = $model->get_search_results_by_session_user($search_text);
        } else{
            $search_results = $model->get_search_results($search_text);
        }
    }
}

if (isset($_GET["view"]) && $_GET["view"] === "profile") {
    if (isset($_GET["user_id"])) {
        $foreign_user = $model->get_foreign_user_by_id($_GET['user_id']);
        $is_following = $model->get_follower_status($_GET['user_id']);
        $view = new Foreign_user_jumbotron_view();
        $view->foreign_user_jumbotron_html($foreign_user, $is_following);
    } else {
        echo "<div class='text-center display-4 text-danger bg-dark py-2'>Something went wrong! :c</div>";
    }
} else {
    $view = new User_jumbotron_view();
    $profile_pic = $model->get_profile_pic();
    $about = $model->get_user_about();
    $view->user_jumbotron_html($profile_pic, $about['about']);
}
?>