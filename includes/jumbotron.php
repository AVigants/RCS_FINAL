<?php
//--------------uploading a profile image--------------
$profile_pic_err_arr = [];
if (isset($_GET["view"]) && $_GET["view"] === "profile") {
    if (isset($_GET["user_id"])) {
        $model = new Posts_model();
        $foreign_user = $model->get_user_by_id($_GET['user_id']);
        $is_following = $model->get_follower_status($user_id, $_GET['user_id']);
        render_foreign_user_jumbotron($foreign_user, $user_id, $is_following);
    } else {
        echo 'something went wrong';
    }
} else {
    render_user_jumbotron($profile_pic, $fname_with_comma);
}

if(isset($_POST['follow_btn'])){
    $model = new Posts_model();
    $model->follow_user($user_id, $_GET['user_id']);
}
if(isset($_POST['unfollow_btn'])){
    $model = new Posts_model();
    $model->unfollow_user($user_id, $_GET['user_id']);
}

if (isset($_POST['profile_pic_submit'])) {
    if (isset($_FILES['profile_pic_input']['name'])) {
        $target_dir = "./assets/profile_pics/";
        $target_file = $target_dir . basename($_FILES["profile_pic_input"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["profile_pic_input"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $profile_pic_err_arr[] = 'File is not an image <br>';
            $uploadOk = 0;
        }
        if ($_FILES["profile_pic_input"]["size"] > 500000) {
            $profile_pic_err_arr[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $profile_pic_err_arr[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($profile_pic_err_arr) {
            echo "Sorry, your file was not uploaded.<br>";
            print_r($profile_pic_err_arr);
        } else {
            if (!(file_exists($target_file))) {
                move_uploaded_file($_FILES["profile_pic_input"]["tmp_name"], $target_file);
                echo 'file has been moved to designated server folder';
            }
            $path = 'assets/profile_pics/' . $_FILES["profile_pic_input"]["name"];

            $sql = "UPDATE users SET profile_pic='$path' WHERE email='$user'";
            DB::run($sql);
            //todo: update the image automatically w//out having to reload the page
        }
    }
}

?>

<!-- USER JUMBOTRON -->
<?php function render_user_jumbotron($profile_pic, $fname_with_comma)
{ ?>
    <div class="jumbotron jumbotron-fluid text-white text-center pt-4 pb-4" style="background: #73a2ba;">
        <div class="container">
            <div class="float-left">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="circle">
                        <label for="profile_pic_input" id="profile_pic_label">
                            <img src="<?= $profile_pic ?? 'https://picsum.photos/300' ?>" alt="" class="can_be_clicked">
                        </label>
                        <input type="file" id="profile_pic_input" class="d-none" name="profile_pic_input">
                    </div>
                    <input type="submit" class="btn btn-warning" name="profile_pic_submit" id="profile_pic_submit" style="display: none;" value="Submit Profile Picture">
                </form>
            </div>
            <div class="">
                <h1 class="display-1">Welcome back<span class="text-lowercase text-capitalize"><?= $fname_with_comma ?? '' ?></span></h1>
                <p class="lead">"May the force be ever in your favor"</p>
                <p class="font-italic">/Dumbledore/</p>
                <input type="text" class="p-1 col-5 text-center" placeholder="Search"> 
                <!-- todo remove this when viewing a single post or leave it for the comments....-->
                <select name="" id="">
                <option value="">Date ↓</option>
                <option value="">Date ↑</option>
                <option value="">Likes ↓</option>
                <option value="">Likes ↑</option>
                <option value="">Comments ↓</option>
                <option value="">Comments ↑</option>
                </select>
            </div>
        </div>
    </div>
<?php } ?>

<!-- FOREIGN USER JUMBOTRON -->

<?php function render_foreign_user_jumbotron($foreign_user, $user_id, $is_following)
{ ?>
    <div class="jumbotron jumbotron-fluid text-white text-center py-4 pb-4" style="background: deeppink;">
        <div class="container">
            <div class="float-left">
                <div class="circle">
                    <label for="">
                        <!-- todo: I left this label because if I remove it then the circle pic moves by 2 pixels and I dont like that -->
                        <img src="<?= $foreign_user['profile_pic'] ?? 'https://picsum.photos/300' ?>" alt="">
                    </label>
                </div>
            </div>
            <div>
                <h1 class="display-1">
                    <span class="text-lowercase text-capitalize">@<?= $foreign_user['username'] ?? 'Welcome!' ?></span>
                </h1>
                
                <p class="lead">"May the force be ever in your favor"</p>
                <p class="font-italic">/<?= $foreign_user['username'] ?? 'Dumbledore' ?>/</p>
                <?php if(!($user_id == $_GET['user_id'])){ 
                    if(!$is_following){
                    ?>
                <form method="POST">
                    <button type="submit" class="btn btn-warning m-0 col-5" name="follow_btn" id="follow_btn">Follow</button>
                </form>
                <?php } else{
                    ?>
                    <form method="POST">
                        <button type="submit" class="btn btn-dark m-0 col-5" name="unfollow_btn" id="follow_btn">Unfollow</button>
                    </form>
                    <?php
                }
                }
                 ?>
            </div>
        </div>
    </div>
<?php } ?>
<!-- todo: remove the like button if its posted by the logged in user -->