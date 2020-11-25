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
        $post = $model->get_post_by_id($_GET["post_id"]);
        $comments = $model->get_comments_by_post_id($_GET['post_id']);
        $view = new Home_view($post, $comments);
        $view->post_html();
        // todo: if I click on an image while its vis is 0 then I get a bunch of errors
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

if(isset($_POST['submit_comment'])){
    if(isset($_POST['comment'])){
        $comment = $_POST['comment'];
        $comment = htmlspecialchars($comment);
        $time_posted = date("Y-m-d H:i:s");
        $post_id = $_GET['post_id'];
        $model->add_comment($user, $user_id, $time_posted, $comment, $post_id);
    }
}


// if(isset($_POST['like'])){
//     echo'lmao yes';
// }
?>