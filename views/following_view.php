<?php
class Following_view
{
    private $posts;
    public function __construct($data = [], $usernames = [])
    {
        $this->posts = $data;
        $this->usernames = $usernames;
    }
    public function html()
    {


?>
        <!-- CARDS -->
        
        <div class="container text-muted">
            <div class="row mb-5" id="cards">
                <?php foreach ($this->posts as $post) { ?>
                    <div class="col-md-6 col-lg-3 my-2">
                        <div class="card text-center">
                            <a href="/be_project_mvc/?page=home&view=post&post_id=<?= $post['id'] ?>">
                                <img src="<?= $post['img'] ?>" class="card-img-top img-fluid can_be_clicked">
                            </a>
                            <div class="card-block">
                                <p class="mt-2"><?= $post['about'] ?></p>
                                <hr>
                                <span class="col-2"><?= $post['num_comments'] ?? '0' ?></span>
                                <form action="" method="POST" class="d-inline">
                                    <a href="/be_project_mvc/?page=home&view=post&post_id=<?= $post['id'] ?>" type="button" class=" btn btn-primary far fa-comment fa-lg col-3"></a>
                                    <?php if(!$post['is_liked']){ ?>
                                        <button type="submit" class="btn btn-danger fas fa-thumbs-up fa-lg col-3" name="like"></button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-dark fas fa-thumbs-up fa-lg col-3" name="unlike"></button>
                                    <?php } ?>
                                    <input type="hidden" value="<?= $post['id'] ?>" name="post_id">

                                    
                                </form>
                                <span class="col-2"><?= $post['num_likes'] ?? '0' ?></span>
                                <br>
                                <a href="/be_project_mvc/?page=home&view=profile&user_id=<?= $post['author_id'] ?>" class="d-block my-2">@<?= $post['author'] ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="container">
        <ul class="list-group text-center col-6 mx-auto mb-5">
        <?php foreach($this->usernames as $username){ ?>
            <a href="/be_project_mvc/?page=home&view=profile&user_id=<?= $username['id'] ?>" class="list-group-item">@<?= $username['username'] ?></a>
        <?php } ?>
        </ul>
        </div>


        <?php
    }
}
        ?>
        </body>
        </html>