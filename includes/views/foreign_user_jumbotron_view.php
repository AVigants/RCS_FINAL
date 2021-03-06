<?php
class Foreign_user_jumbotron_view
{
    public function foreign_user_jumbotron_html($foreign_user, $is_following)
    { ?>
        <div class="jumbotron jumbotron-fluid text-white pt-4 pb-4" style="background: deeppink;">
            <div class="flex-column flex-md-row d-flex">
                <div class="flex-shrink-0 col-lg-5 col-md-5">
                    <form action="" method="POST" enctype="multipart/form-data" class="text-center">
                        <label for="profile_pic_input" id="profile_pic_label">
                            <img src="<?= $foreign_user['profile_pic'] ?? 'https://picsum.photos/300' ?>" alt="" style="vertical-align: middle; width: 250px; height: 250px; border-radius: 50%; object-fit: cover">
                        </label>
                    </form>
                </div>
                <div class="flex-shrink-0 col-lg-7 col-md-7 text-center text-md-left">
                    <h1 class="display-1">
                        <span class="text-lowercase text-capitalize text-dark">@<?= $foreign_user['username'] ?></span>
                    </h1>
                    <?php if($foreign_user['about']){ ?>
                        <p class="lead">"<?= $foreign_user['about'] ?>"</p>
                        <p class="font-italic">/<?= $foreign_user['username'] ?>/</p>
                   <?php } else{ ?>
                    <p class="lead">"May the force be ever in your favor"</p>
                    <p class="font-italic">/Dumbledore/</p>
                   <?php } ?>
                    <?php if ($_SESSION['user_id'] !== $_GET['user_id']) {
                        if (!$is_following) {
                    ?>
                            <form method="POST">
                                <button type="submit" class="btn btn-warning m-0 col-sm-12  col-md-10 col-lg-7" name="follow_btn" id="follow_btn">Follow</button>
                            </form>
                        <?php } else {
                        ?>
                            <form method="POST">
                                <button type="submit" class="btn btn-dark m-0 col-sm-12  col-md-10 col-lg-7" name="unfollow_btn" id="follow_btn">Unfollow</button>
                            </form>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
<?php }
} ?>