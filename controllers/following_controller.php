<?php
    require_once __DIR__ . "/../includes/controllers/jumbotron_controller.php";
    require_once __DIR__ . "/../views/following_view.php";
    $model = new Posts_model($_SESSION['user_id'], $_SESSION['fname'], $_SESSION['username']);

    if (isset($_GET["page"]) && $_GET["page"] === "following") {
        if(isset($_POST['like'])){
            if(isset($_POST['post_id'])){
                $model->like($_POST['post_id']);
            } else {
                echo "Something went wrong";
                //add smth here? todo
            }
        }
        if(isset($_POST['unlike'])){
            if(isset($_POST['post_id'])){
                $model->unlike($_POST['post_id']);
            } else{
                echo "Something went wrong";
            }
        }
        $following_user_ids_arr = $model->get_following_user_ids();
        if($following_user_ids_arr){
            $posts = $model->get_posts_from_following($following_user_ids_arr);
            if($posts){
                $posts_with_is_liked = [];
                foreach ($posts as $post){
                    $is_liked = $model->get_is_liked($post['id']);
                    $post['is_liked'] = $is_liked;
                    $posts_with_is_liked[] = $post;
                }
                $view = new Following_view($posts_with_is_liked);
                $view->html();
            } else{
                echo "You aren't following anyone!";
                Header('Location: /be_project_mvc/?page=home');
            }
        } else{
            echo "You aren't following anyone!";
            Header('Location: /be_project_mvc/?page=home');
        }
    }
?>