<?php

class Profile_view
{
    private $posts;
    public function __construct($data = [])
    {
        $this->posts = $data;
    }
    public function html()
    {


?>

        <!-- CARDS -->
        <div class="container text-muted">
            <div class="row" id="cards">
                <?php foreach ($this->posts as $post) { ?>
                    <div class="col-md-6 col-lg-3 my-3">
                        <div class="card text-center">
                            <a href="/be_project_mvc/?page=home&view=post&post_id=<?= $post['id'] ?>">
                                <img src="<?= $post['img'] ?>" <?php if (!$post['is_visible']) echo '0.5' ?>;" class="can_be_clicked img-top img-fluid cards">
                            </a>
                                <div class="card-block p-1">

                                    <form action="?page=profile" method="POST">
                                        <div class="default_card_id_<?= $post['id'] ?>">
                                            <p class="mt-2"><?= $post['about'] ?></p>
                                            <button class="btn btn-primary fas fa-edit fa-lg m-1 edit_btn col-3" id="<?= $post['id'] ?>"></button>
                                            <button type="submit" class="btn btn-danger fas fa-trash fa-lg m-1 col-3" name="del_btn"></button>
                                            <button type="submit" class="btn btn-light fas fa-eye<?php if ($post['is_visible']) echo '-slash' ?> fa-lg m-1 col-3" name="is_visible_btn"></button>
                                        </div>
                                        <div class="edit_card_id_<?= $post['id'] ?>" style="display:none">
                                            <textarea name="edit_post_text" id="edit_post_text" class="text-center col-11 my-2 form-control mx-auto"><?= $post['about'] ?></textarea>
                                            <button class="btn btn-warning col-5 m-1" name="save_post">Save</button>
                                            <button class="btn btn-dark cancel_btn col-5 m-1" id="<?= $post['id'] ?>">Cancel</button>
                                        </div>
                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                        <input type="hidden" name="post_is_visible" value="<?= $post['is_visible'] ?>">
                                    </form>
                                </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- <script src="../scripts/app.js"></script> -->
        </body>

        </html>
<?php
    }
}
?>