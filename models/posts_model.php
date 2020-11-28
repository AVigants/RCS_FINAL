<?php

    class Posts_model {
        private $user_id;
        private $fname;
        private $username;
        // private $email;
        public function __construct($user_id, $fname, $username){
            $this->user_id = $user_id;
            $this->fname = $fname;
            $this->username = $username;
            // $this->email = $email;
        }

        public function get_user_by_id(){
            $sql = "SELECT id, fname, username, about, profile_pic FROM users WHERE id = '$this->user_id'";
            $response = DB::run($sql)->fetch_assoc();
            return $response;
        }
        public function get_foreign_user_by_id($foreign_user_id){
            $sql = "SELECT username, about, profile_pic FROM users WHERE id = '$foreign_user_id'";
            $response = DB::run($sql)->fetch_assoc();
            return $response;
        }
        public function get_profile_pic(){
            $sql = "SELECT profile_pic FROM users WHERE id = '$this->user_id'";
            $response = DB::run($sql)->fetch_assoc();
            return $response['profile_pic'];
        }

        public function get_all_posts() {
            $sql = "SELECT * FROM posts WHERE is_visible = 1 ORDER BY date_posted DESC LIMIT 16";
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function get_all_current_user_posts(){
            $sql = "SELECT * FROM posts WHERE author = '$this->username' ORDER BY date_posted DESC";
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function delete_post($post_id) {
            $sql = "DELETE FROM posts WHERE id='$post_id' AND author = '$this->username'";
            DB::run($sql);
        }

        public function update_post($id, $about) {
            $sql = "UPDATE posts SET about = '$about' WHERE id='$id' AND author = '$this->username'";
            DB::run($sql);
        }
        public function update_is_visible($post_id, $is_visible) {
            $sql = "UPDATE posts SET is_visible = '$is_visible' WHERE id='$post_id' AND author = '$this->username'";
            DB::run($sql);
        }
        public function add_new_post($about, $date_posted, $imageFileType) {
            $sql_phase_one = "INSERT INTO posts (author, author_id, about, date_posted, img) VALUES ('$this->username', '$this->user_id', '$about', '$date_posted', 'placeholder')";
            DB::run($sql_phase_one);
            $sql_get_id = "SELECT id FROM posts WHERE author_id = '$this->user_id' AND img = 'placeholder'";
            $response = DB::run($sql_get_id)->fetch_assoc();
    
            $path = 'assets/images/' . $response['id'] . '.' . $imageFileType;
            $sql_phase_two = "UPDATE posts SET img = '$path' WHERE img = 'placeholder' AND author_id = '$this->user_id'";
            DB::run($sql_phase_two);
            return $response['id'];
        }
        public function add_new_profile_pic($imageFileType){
            $path = "./assets/profile_pics/" . $this->user_id . '.' . $imageFileType;
            $sql = "UPDATE users SET profile_pic = '$path' WHERE id = '$this->user_id'";
            DB::run($sql);
        }
        public function get_posts_by_foreign_user_id($foreign_user_id){
            $sql = "SELECT * FROM posts WHERE author_id = '$foreign_user_id' AND is_visible = 1 ORDER BY date_posted DESC";
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function get_post_by_id($post_id){
            $sql = "SELECT * FROM posts WHERE id = '$post_id' AND is_visible = 1";
            $response = DB::run($sql)->fetch_assoc();
            return $response;
        }
        public function get_comments_by_post_id($post_id){
            $sql = "SELECT * FROM comments WHERE post_id='$post_id'";
            $response = DB::run($sql);
            return $response;
        }

        // private function get_num_likes($post_id){
        //     $sql = "SELECT COUNT(id) AS num_likes FROM likes WHERE post_id = '$post_id'";
        //     $response = DB::run($sql);
        //     return $response;
        // }
        public function add_comment($time_posted, $comment_text, $post_id){
            $sql = "INSERT INTO comments (author, author_id, time_posted, comment_text, post_id) VALUES ('$this->username', '$this->user_id','$time_posted', '$comment_text', '$post_id')";
            DB::run($sql);
            $sql_get_num_comments = "SELECT COUNT(id) AS num_comments FROM comments WHERE post_id = '$post_id'";
            $response = DB::run($sql_get_num_comments)->fetch_assoc();
            $num_comments = $response['num_comments'];
            $sql_update_num_comments_in_posts = "UPDATE posts SET num_comments = '$num_comments' WHERE id = '$post_id'";
            DB::run($sql_update_num_comments_in_posts);
        }
        //make these 2 blocks of code below take in arrays. We're going to store all the likes in an array and when the user logs out then the likes will get actually submitted. Or when an action takes place. So it doesnt refresh the page every single time we click on 'like' for now Ill leave it as is
        public function like($post_id){
            $sql = "INSERT INTO likes (user_id, post_id) VALUES ('$this->user_id', '$post_id')";
            DB::run($sql);
            $sql_get_num_likes = "SELECT COUNT(id) AS num_likes FROM likes WHERE post_id = '$post_id'";
            $response = DB::run($sql_get_num_likes)->fetch_assoc();
            $num_likes = $response['num_likes'];
            $sql_update_num_likes_in_posts = "UPDATE posts SET num_likes = '$num_likes' WHERE id = '$post_id'";
            DB::run($sql_update_num_likes_in_posts);
        }
        //can I make these 2 ^ \/ blocks of code not repeat themselves?
        public function unlike($post_id){
            $sql = "DELETE FROM likes WHERE user_id = '$this->user_id' AND post_id = '$post_id'";
            DB::run($sql);
            $sql_get_num_likes = "SELECT COUNT(id) AS num_likes FROM likes WHERE post_id = '$post_id'";
            $response = DB::run($sql_get_num_likes)->fetch_assoc();
            $num_likes = $response['num_likes'];
            $sql_update_num_likes_in_posts = "UPDATE posts SET num_likes = '$num_likes' WHERE id = '$post_id'";
            DB::run($sql_update_num_likes_in_posts);
        }
        
                // todo sql attacks might be possible here - better make sure the data thats fed here is legit
        public function get_follower_status($foreign_user_id){
            $sql = "SELECT * FROM followers WHERE follower_id = '$this->user_id' AND following_id = '$foreign_user_id'";
            $response = DB::run($sql);
            if ($response->num_rows === 0) {
                return false;
            } else {
                return true;
            }
        }
        public function get_is_liked($post_id){
            $sql = "SELECT * FROM likes WHERE user_id = '$this->user_id' AND post_id ='$post_id'";
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

        public function logout(){
            $sql = "UPDATE users SET logged_in = 0 WHERE id = '$this->user_id'";
            DB::run($sql);
        }
    };
?>
