<?php
    require_once __DIR__ . "/../includes/header.php";
    require_once __DIR__ . "/../views/home_view.php";


$model = new Posts_model();
// $posts = $model->get_all_posts();

// $view = new Home_view($posts);
// $view->html();

if (isset($_GET["view"]) && $_GET["view"] === "profile") {
    if (isset($_GET["user_id"])) {
        $user_posts = $model->get_posts_by_user_id($_GET["user_id"]);
        $view = new Home_view($user_posts);
        $view->html();
    }
    else{
        echo 'something went wrong';
    }
} else if(isset($_GET["view"]) && $_GET["view"] === "post"){
    if (isset($_GET["post_id"])) {
        // $user_posts = $model->get_posts_by_user_id($_GET["user_id"]);
        // $view = new Home_view($user_posts);
        // $view->html();
    }
    else{
        echo 'something went wrong';
    }
} else{
    $model = new Posts_model();
    $posts = $model->get_all_posts();

    $view = new Home_view($posts);
    $view->html();
}


// if(isset($_POST['like'])){
//     echo'lmao yes';
// }
?>