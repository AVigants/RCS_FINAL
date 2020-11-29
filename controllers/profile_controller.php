<?php
    require_once __DIR__ . "/../includes/controllers/jumbotron_controller.php";
    require_once __DIR__ . "/../views/profile_view.php";
$posts = [];


//declaring variables to prevents errors
// $sql = "SELECT * FROM posts WHERE author = '$user' ORDER BY date_posted DESC";
// $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
// if ($response) {
//     $posts = $response;
// }
// else{
//     if(count($posts) == 0){
//         echo 'nothing to show, my guy';
//         //todo: add an image if the profile is emtpy - suggest adding a new post!
//     }
// }
if (isset($_POST['del_btn'])) {
    $model->delete_post($_POST['post_id']);
}
if (isset($_POST['is_visible_btn'])) {
    $is_visible = $_POST['post_is_visible'];
    if($is_visible){
        $is_visible = 0;
    } else{
        $is_visible = 1;
    }
    $model->update_is_visible($_POST['post_id'], $is_visible);
    
}

if(isset($_POST['save_post'])){
    $about = $_POST['edit_post_text'];
    $about = htmlspecialchars($about);
    $model->update_post($_POST['post_id'], $about);
}

$model = new Posts_model($_SESSION['user_id'], $_SESSION['fname'], $_SESSION['username']);
$posts = $model->get_all_current_user_posts();
if ((isset($_POST['search_btn']) && $search_results)){ //filter results
    $view = new Profile_view($search_results);
    $view->html();
} else{
    $view = new Profile_view($posts);
    $view->html();
}
