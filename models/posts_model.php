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
    }
?>
