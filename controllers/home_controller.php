<?php
    require_once __DIR__ . "/../includes/controllers/jumbotron_controller.php";
    require_once __DIR__ . "/../views/home_view.php";

    $model = new Posts_model($_SESSION['user_id'], $_SESSION['fname'], $_SESSION['username']);

if (isset($_GET["view"]) && $_GET["view"] === "profile") { //foreign user profile
    if (isset($_GET["user_id"])) {
        if(isset($_POST['like'])){
            if(isset($_POST['post_id'])){
                $post_id = $_POST['post_id'];
                $model->like($post_id);
            }
        }
        if(isset($_POST['unlike'])){
            if(isset($_POST['post_id'])){
                $post_id = $_POST['post_id'];
                $model->unlike($post_id);
            }
        }
        $user_posts = $model->get_posts_by_foreign_user_id($_GET["user_id"]);
        $user_posts_with_is_liked = [];
        foreach ($user_posts as $post){
            $is_liked = $model->get_is_liked($post['id']);
            $post['is_liked'] = $is_liked;
            $user_posts_with_is_liked[] = $post;
        }
        $view = new Home_view($user_posts_with_is_liked);
        $view->html();
    }
    else{
        echo "<div class='text-center display-4 text-danger bg-dark py-2'>Something went wrong! :c</div>";
    }
} else if(isset($_GET["view"]) && $_GET["view"] === "post"){ //single post view
    if (isset($_GET["post_id"])) {
        if(isset($_POST['submit_comment'])){
            if(isset($_POST['comment'])){
                $comment = $_POST['comment'];
                $comment = htmlspecialchars($comment);
                $time_posted = date("Y-m-d H:i:s");
                $model->add_comment($time_posted, $comment, $_GET['post_id']);
            }
        }
        if(isset($_POST['like'])){
            if(isset($_POST['post_id'])){
                $post_id = $_POST['post_id'];
                $model->like($post_id);
            }
        }
        if(isset($_POST['unlike'])){
            if(isset($_POST['post_id'])){
                $post_id = $_POST['post_id'];
                $model->unlike($post_id);
            }
        }
        $post = $model->get_post_by_id($_GET["post_id"]);
        //check for visability
        if($post['author_id'] == $_SESSION['user_id'] || $post['is_visible']){
            $post_with_is_liked = [];
            $is_liked = $model->get_is_liked($post['id']);
            $post_with_is_liked = $post;
            $post_with_is_liked['is_liked'] = $is_liked;
            $comments = $model->get_comments_by_post_id($_GET['post_id']);
            $view = new Home_view($post_with_is_liked, $comments);
            $view->single_post_html();
        } else {
            echo "<div class='text-center display-4 text-danger bg-dark py-2'>Sorry, but this post has either been removed or is private! :c</div>";
        }
    }
    else{
        echo "<div class='text-center display-4 text-danger bg-dark py-2'>Something went wrong! :c</div>";
    }
} 
else if ((isset($_POST['search_btn']) && $search_results)){ //filter results
    $posts_with_is_liked = [];
    foreach ($search_results as $post){
        $is_liked = $model->get_is_liked($post['id']);
        $post['is_liked'] = $is_liked;
        $posts_with_is_liked[] = $post;
    }
    $view = new Home_view($posts_with_is_liked);
    $view->html();
}
else{
    if(isset($_POST['like'])){
        if(isset($_POST['post_id'])){
            $post_id = $_POST['post_id'];
            $model->like($post_id);
        } else {
            // todo: add smth here
        }
    }
    if(isset($_POST['unlike'])){
        if(isset($_POST['post_id'])){
            $post_id = $_POST['post_id'];
            $model->unlike($post_id);
        } else{
            // todo add smth here
        }
    }
    $posts = $model->get_all_posts();
    $posts_with_is_liked = [];
    foreach ($posts as $post){
        $is_liked = $model->get_is_liked($post['id']);
        $post['is_liked'] = $is_liked;
        $posts_with_is_liked[] = $post;
    }
    $view = new Home_view($posts_with_is_liked);
    $view->html();
}





