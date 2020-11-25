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
        public function add_comment($author, $author_id, $time_posted, $comment_text, $post_id){
            $sql = "INSERT INTO comments (author, author_id, time_posted, comment_text, post_id) VALUES ('$author', '$author_id','$time_posted', '$comment_text', '$post_id')";
            DB::run($sql);
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
        public function follow_user($follower, $following){
            $sql = "INSERT INTO followers (follower_id, following_id) VALUES ('$follower', '$following')";
            DB::run($sql);
        }
        public function unfollow_user($follower, $following){
            $sql = "DELETE FROM followers WHERE follower_id = '$follower' AND following_id = '$following'";
            DB::run($sql);
        }
    }
?>
