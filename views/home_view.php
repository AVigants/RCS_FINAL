<?php

class Home_view
{
    private $posts;
    private $comments;
    public function __construct($data = [], $comments = [])
    {
        $this->posts = $data;
        $this->comments = $comments;
    }
    public function html()
    {


?>
        <!-- CARDS -->
        <div class="container text-muted">
            <div class="row mb-5" id="cards">
                <?php foreach ($this->posts as $post) { ?>
                    <div class="col-md-6 col-lg-3 my-3">
                        <div class="card text-center">
                            <a href="/RCS_FINAL/?page=home&view=post&post_id=<?= $post['id'] ?>">
                                <img src="<?= $post['img'] ?>" class="can_be_clicked cards img-top img-fluid">
                            </a>
                            <div class="card-block p-1">
                                <p class="mt-2"><?= $post['about'] ?></p>
                                <hr>
                                <span class="col-2"><?= $post['num_comments'] ?? '0' ?></span>
                                <form action="" method="POST" class="d-inline">
                                    <a href="/RCS_FINAL/?page=home&view=post&post_id=<?= $post['id'] ?>" type="button" class=" btn btn-primary far fa-comment fa-lg col-3"></a>
                                    <?php if (!$post['is_liked']) { ?>
                                        <button type="submit" class="btn btn-danger fas fa-thumbs-up fa-lg col-3" name="like"></button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-dark fas fa-thumbs-up fa-lg col-3" name="unlike"></button>
                                    <?php } ?>
                                    <input type="hidden" value="<?= $post['id'] ?>" name="post_id">
                                </form>
                                <span class="col-2"><?= $post['num_likes'] ?? '0' ?></span>
                                <br>
                                <a href="/RCS_FINAL/?page=home&view=profile&user_id=<?= $post['author_id'] ?>" class="d-block my-2">@<?= $post['author'] ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php
    }
    public function single_post_html()
    {
    ?>
        <div class="container text-muted">
            <div class="row mt-2 mb-5">
                <div class="col-sm-10 col-md-11 col-lg-8 my-2 mx-auto">
                    <div class="card bg-light">
                        <div>
                            <img src="<?= $this->posts['img'] ?>" alt="" class="card-img-top">
                        </div>

                        <div class="card-block pb-2 text-center my-3">
                            <div>
                                <a href="/RCS_FINAL/?page=home&view=profile&user_id=<?= $this->posts['author_id'] ?>" class="d-block mb-1">@<?= $this->posts['author'] ?></a>
                                <p class=""><?= $this->posts['about'] ?></p>
                                <hr>
                                <span class="col-2"><?= $this->posts['num_comments'] ?></span>
                                <button type="button" class=" btn btn-primary far fa-comment fa-lg col-4" id="comment_btn"></button>
                                <form action="" method="POST" class="d-inline">
                                    <?php if (!($this->posts['is_liked'])) { ?>
                                        <button type="submit" class="btn btn-danger fas fa-thumbs-up fa-lg col-4" name="like"></button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-dark fas fa-thumbs-up fa-lg col-4" name="unlike"></button>
                                    <?php } ?>
                                    <input type="hidden" name="post_id" value="<?= $this->posts['id'] ?>">
                                </form>
                                <span class="col-2"><?= $this->posts['num_likes'] ?></span>
                                <div id="comment_textarea">
                                    <form action="" method="POST">
                                        <textarea id="edit_post_text" class="text-center col-11 my-2 form-control mx-auto" placeholder="Add a public comment..." name="comment"></textarea>
                                        <button class="btn btn-warning col-5 m-1" name="submit_comment">Comment</button>
                                        <button class="btn btn-dark cancel_btn col-5 m-1" id="cancel_comment_btn">Cancel</button>
                                    </form>
                                </div>
                                <hr>
                            </div>
                            <?php foreach ($this->comments as $comment) { ?>
                                <div class="text-justify mx-3">
                                    <a href="/RCS_FINAL/?page=home&view=profile&user_id=<?= $comment['author_id'] ?>">@<?= $comment['author'] ?></a>
                                    <span class="text-dark font-italic"><?= $comment['time_posted'] ?></span> <br>
                                    <p><?= $comment['comment_text'] ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>
</body>

</html>