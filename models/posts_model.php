<?php
    class Posts_model {

        public function get_all_posts() {
            $sql = "SELECT * FROM posts WHERE is_visible = 1 ORDER BY date_posted DESC LIMIT 16";
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function get_all_current_user_posts(){
            $user = $_SESSION['user'];
            $sql = "SELECT * FROM posts WHERE author = '$user' ORDER BY date_posted DESC";
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function delete_post($id) {
            $user = $_SESSION['user'];
            $sql = "DELETE FROM posts WHERE id='$id' AND author = '$user'";
            DB::run($sql);
        }

        public function update_post($id, $about) {
            $user = $_SESSION['user'];
            $sql = "UPDATE posts SET about = '$about' WHERE id='$id' AND author = '$user'";
            DB::run($sql);
        }
        public function update_is_visible($id, $is_visible) {
            $user = $_SESSION['user'];
            $sql = "UPDATE posts SET is_visible = '$is_visible' WHERE id='$id' AND author = '$user'";
            DB::run($sql);
        }
        public function add_new_post($user, $user_id, $path, $about, $date_posted) {
            $sql = "INSERT INTO posts (author, author_id, img, about, date_posted) VALUES ('$user', '$user_id', '$path', '$about', '$date_posted')";
            DB::run($sql);
        }
        public function get_posts_by_user_id($id){
            $sql = "SELECT * FROM posts WHERE author_id = '$id' AND is_visible = 1 ORDER BY date_posted DESC";
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function get_post_by_id($id){
            $sql = "SELECT * FROM posts WHERE id = '$id' AND is_visible = 1";
            $response = DB::run($sql)->fetch_assoc();
            return $response;
        }
        public function get_comments_by_post_id($id){
            $sql = "SELECT * FROM comments WHERE post_id='$id'";
            $response = DB::run($sql);
            return $response;
        }

        // private function get_num_likes($post_id){
        //     $sql = "SELECT COUNT(id) AS num_likes FROM likes WHERE post_id = '$post_id'";
        //     $response = DB::run($sql);
        //     return $response;
        // }
        public function add_comment($author, $author_id, $time_posted, $comment_text, $post_id){
            $sql = "INSERT INTO comments (author, author_id, time_posted, comment_text, post_id) VALUES ('$author', '$author_id','$time_posted', '$comment_text', '$post_id')";
            DB::run($sql);
            $sql_get_num_comments = "SELECT COUNT(id) AS num_comments FROM comments WHERE post_id = '$post_id'";
            $response = DB::run($sql_get_num_comments)->fetch_assoc();
            $num_comments = $response['num_comments'];
            $sql_update_num_comments_in_posts = "UPDATE posts SET num_comments = '$num_comments' WHERE id = '$post_id'";
            DB::run($sql_update_num_comments_in_posts);
        }
        //make these 2 blocks of code below take in arrays. We're going to store all the likes in an array and when the user logs out then the likes will get actually submitted. Or when an action takes place. So it doesnt refresh the page every single time we click on 'like' for now Ill leave it as is
        public function like($user_id, $post_id){
            $sql = "INSERT INTO likes (user_id, post_id) VALUES ('$user_id', '$post_id')";
            DB::run($sql);
            $sql_get_num_likes = "SELECT COUNT(id) AS num_likes FROM likes WHERE post_id = '$post_id'";
            $response = DB::run($sql_get_num_likes)->fetch_assoc();
            $num_likes = $response['num_likes'];
            $sql_update_num_likes_in_posts = "UPDATE posts SET num_likes = '$num_likes' WHERE id = '$post_id'";
            DB::run($sql_update_num_likes_in_posts);
        }
        //can I make these 2 ^ \/ blocks of code not repeat themselves?
        public function unlike($user_id, $post_id){
            $sql = "DELETE FROM likes WHERE user_id = '$user_id' AND post_id = '$post_id'";
            DB::run($sql);
            $sql_get_num_likes = "SELECT COUNT(id) AS num_likes FROM likes WHERE post_id = '$post_id'";
            $response = DB::run($sql_get_num_likes)->fetch_assoc();
            $num_likes = $response['num_likes'];
            $sql_update_num_likes_in_posts = "UPDATE posts SET num_likes = '$num_likes' WHERE id = '$post_id'";
            DB::run($sql_update_num_likes_in_posts);
        }
        
        public function get_user_by_id($id){
            $sql = "SELECT username, about, profile_pic FROM users WHERE id = '$id'";
            $response = DB::run($sql)->fetch_assoc();
            return $response;
        }
                // todo sql attacks might be possible here - better make sure the data thats fed here is legit
        public function get_follower_status($follower, $following){
            $sql = "SELECT * FROM followers WHERE follower_id = '$follower' AND following_id = '$following'";
            $response = DB::run($sql);
            if ($response->num_rows === 0) {
                return false;
            } else {
                return true;
            }
        }
        public function get_is_liked($user_id, $post_id){
            $sql = "SELECT * FROM likes WHERE user_id = '$user_id' AND post_id ='$post_id'";
            $response = DB::run($sql);
            if ($response->num_rows === 0) {
                return false;
            } else {
                return true;
            }
        }
        public function follow_user($follower, $following){
            $sql = "INSERT INTO followers (follower_id, following_id) VALUES ('$follower', '$following')";
            DB::run($sql);
        }
        public function unfollow_user($follower, $following){
            $sql = "DELETE FROM followers WHERE follower_id = '$follower' AND following_id = '$following'";
            DB::run($sql);
        }
        public function get_search_results($search_text){
            $sql_posts = "SELECT *
            FROM posts
            WHERE is_visible = 1 AND about LIKE '%$search_text%' or author LIKE '%$search_text%'";
            $response = DB::run($sql_posts)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
    }
?>
