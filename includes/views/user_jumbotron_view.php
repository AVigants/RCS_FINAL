<?php
// $profile_pic = $_SESSION['user']['profile_pic'];
// var_dump($_SESSION['user']);

// $about = $_SESSION['about'];
// $profile_pic = $_SESSION['profile_pic'];
class User_jumbotron_view
{
    public function user_jumbotron_html($profile_pic){
?>
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

                    <h1 class="display-1">Welcome back, <span class="text-lowercase text-capitalize"><?= $_SESSION['fname'] ?? '' ?></span></h1>
                    <p class="lead">"May the force be ever in your favor"</p>
                    <p class="font-italic">/<?= $_SESSION['username'] ?? 'Dumbledore' ?>/</p>
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
<?php }
} ?>