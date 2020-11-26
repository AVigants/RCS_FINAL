<?php
$search_results = [];
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
    render_user_jumbotron($profile_pic, $username);
}

if (isset($_POST['follow_btn'])) {
    $model = new Posts_model();
    $model->follow_user($user_id, $_GET['user_id']);
}
if (isset($_POST['unfollow_btn'])) {
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

if (isset($_POST['search_btn'])) {
    if ((isset($_POST['search_text'])) && $_POST['search_text']) {
        $search_text = $_POST['search_text'];
        $search_text = htmlspecialchars($search_text);
        $model = new Posts_model();
        $search_results = $model->get_search_results($search_text);
    }
}
?>

<!-- USER JUMBOTRON -->
<?php function render_user_jumbotron($profile_pic, $username)
{ ?>
    <div class="jumbotron jumbotron-fluid text-white pt-4 pb-4" style="background: #73a2ba;">
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
            <div class="container text-center">

                <h1 class="display-1">Welcome back, <span class="text-lowercase text-capitalize"><?= $username ?? '' ?></span></h1>
                <p class="lead">"May the force be ever in your favor"</p>
                <p class="font-italic">/Dumbledore/</p>

                <form action="" method="POST">
                    <div class="input-group col-5 mx-auto">
                        <input class="form-control py-2 rounded-pill mr-1 pr-5 d-inline" type="search" placeholder="Search" id="search_input_field" name="search_text">
                        <span class="input-group-append">
                            <button class="btn rounded-pill border-0 ml-n5" type="submit" name="search_btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
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
                <h1 class="display-3">
                    <span class="text-lowercase text-capitalize">@<?= $foreign_user['username'] ?></span>
                </h1>

                <p class="lead">"May the force be ever in your favor"</p>
                <p class="font-italic">/'Dumbledore'/</p>
                <?php if (!($user_id == $_GET['user_id'])) {
                    if (!$is_following) {
                ?>
                        <form method="POST">
                            <button type="submit" class="btn btn-warning m-0 col-5" name="follow_btn" id="follow_btn">Follow</button>
                        </form>
                    <?php } else {
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