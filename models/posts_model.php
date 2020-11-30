<?php

    class Posts_model {
        private $user_id;
        private $fname;
        private $username;
        public function __construct($user_id, $fname, $username){
            $this->user_id = $user_id;
            $this->fname = $fname;
            $this->username = $username;
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
        public function get_user_about(){
            $sql = "SELECT about FROM users WHERE id = '$this->user_id'";
            $response = DB::run($sql)->fetch_assoc();
            return $response;
        }
        public function get_following_user_ids(){
            $sql = "SELECT following_id FROM followers WHERE follower_id = '$this->user_id'";
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            if($response){
                return $response;
            }
        }
        public function get_username_handles($following_user_ids_arr){
            $sql = "SELECT id, username FROM users WHERE id IN (";
            foreach ($following_user_ids_arr as $following_id){
                $sql_chain = $following_id['following_id'] . ', ';
                $sql = $sql . $sql_chain;
            }
            $sql = substr($sql, 0, -2);
            $sql = $sql . ')';
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function get_posts_from_following($following_id_arr){
            $sql = "SELECT * FROM posts WHERE is_visible = 1 AND author_id IN (";
            foreach ($following_id_arr as $following_id){
                $sql_chain = $following_id['following_id'] . ', ';
                $sql = $sql . $sql_chain;
            }
            $sql = substr($sql, 0, -2);
            $sql = $sql . ') ORDER BY date_posted DESC';
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }

        public function get_all_posts() {
            $sql = "SELECT * FROM posts WHERE is_visible = 1 ORDER BY date_posted DESC LIMIT 50";
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
            $about = DB::escape_string($about);
            $sql = "UPDATE posts SET about = '$about' WHERE id='$id' AND author = '$this->username'";
            DB::run($sql);
        }
        public function update_is_visible($post_id, $is_visible) {
            $sql = "UPDATE posts SET is_visible = '$is_visible' WHERE id='$post_id' AND author = '$this->username'";
            DB::run($sql);
        }
        public function add_new_post($about, $date_posted, $imageFileType) {
            $about = DB::escape_string($about);
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
        public function update_user_about($text){
            $text = DB::escape_string($text);
            $sql = "UPDATE users SET about = '$text' WHERE id = '$this->user_id'";
            DB::run($sql);
        }
        public function get_posts_by_foreign_user_id($foreign_user_id){
            $sql = "SELECT * FROM posts WHERE author_id = '$foreign_user_id' AND is_visible = 1 ORDER BY date_posted DESC";
            $response = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function get_post_by_id($post_id){
            $sql = "SELECT * FROM posts WHERE id = '$post_id'";
            $response = DB::run($sql)->fetch_assoc();
            return $response;
        }
        public function get_comments_by_post_id($post_id){
            $sql = "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY time_posted ASC";
            $response = DB::run($sql);
            return $response;
        }
        public function add_comment($time_posted, $comment_text, $post_id){
            $comment_text = DB::escape_string($comment_text);
            $sql = "INSERT INTO comments (author, author_id, time_posted, comment_text, post_id) VALUES ('$this->username', '$this->user_id','$time_posted', '$comment_text', '$post_id')";
            DB::run($sql);
            $sql_get_num_comments = "SELECT COUNT(id) AS num_comments FROM comments WHERE post_id = '$post_id'";
            $response = DB::run($sql_get_num_comments)->fetch_assoc();
            $num_comments = $response['num_comments'];
            $sql_update_num_comments_in_posts = "UPDATE posts SET num_comments = '$num_comments' WHERE id = '$post_id'";
            DB::run($sql_update_num_comments_in_posts);
        }
        public function like($post_id){
            $sql = "INSERT INTO likes (user_id, post_id) VALUES ('$this->user_id', '$post_id')";
            DB::run($sql);
            $sql_get_num_likes = "SELECT COUNT(id) AS num_likes FROM likes WHERE post_id = '$post_id'";
            $response = DB::run($sql_get_num_likes)->fetch_assoc();
            $num_likes = $response['num_likes'];
            $sql_update_num_likes_in_posts = "UPDATE posts SET num_likes = '$num_likes' WHERE id = '$post_id'";
            DB::run($sql_update_num_likes_in_posts);
        }
        public function unlike($post_id){
            $sql = "DELETE FROM likes WHERE user_id = '$this->user_id' AND post_id = '$post_id'";
            DB::run($sql);
            $sql_get_num_likes = "SELECT COUNT(id) AS num_likes FROM likes WHERE post_id = '$post_id'";
            $response = DB::run($sql_get_num_likes)->fetch_assoc();
            $num_likes = $response['num_likes'];
            $sql_update_num_likes_in_posts = "UPDATE posts SET num_likes = '$num_likes' WHERE id = '$post_id'";
            DB::run($sql_update_num_likes_in_posts);
        }
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
            WHERE is_visible = 1 AND about LIKE '%$search_text%' or author LIKE '%$search_text%' ORDER BY date_posted DESC";
            $response = DB::run($sql_posts)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function get_search_results_by_session_user($search_text){
            $sql_posts = "SELECT *
            FROM posts
            WHERE author_id = '$this->user_id' AND about LIKE '%$search_text%' ORDER BY date_posted DESC";
            $response = DB::run($sql_posts)->fetch_all(MYSQLI_ASSOC);
            return $response;
        }
        public function logout(){
            $sql = "UPDATE users SET logged_in = 0 WHERE id = '$this->user_id'";
            DB::run($sql);
        }
    };
?>
