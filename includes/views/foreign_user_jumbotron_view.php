<?php 
class Foreign_user_jumbotron_view
{
    public function foreign_user_jumbotron_html($foreign_user, $is_following)
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
                    <?php if ($_SESSION['user_id'] !== $_GET['user_id']) {
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
<?php }
} ?>