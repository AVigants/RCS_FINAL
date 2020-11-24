<?php

class Home_form{
    public function html(){
        
?>
<!-- CARDS -->

<div class="container text-muted">
    <div class="row" id="cards">
        <?php foreach ($posts as $post) { ?>
            <div class="col-md-6 col-lg-3 my-2">
                <div class="card text-center">
                    <img src="<?= $post['img'] ?>" class="card-img-top img-fluid">
                    <div class="card-block">
                        <p class="mt-2"><?= $post['about'] ?></p>
                        <hr>
                        <span class="col-2"><?= $post['num_comments'] ?? '0' ?></span>
                        <form action="" method="POST" class="d-inline">
                            <a href="?page=?post_id=" type="button" class=" btn btn-primary far fa-comment fa-lg col-3"></a>
                            <button type="submit" class="btn btn-danger fas fa-thumbs-up fa-lg col-3" name="like"></button>
                        </form>
                        <span class="col-2"><?= $post['num_likes'] ?? '0' ?></span>
                        <br>
                        <a href="" class="d-block my-2"><?= $post['author'] ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- TABLE -->

<!-- <div class="container">
        <table class="table" id="table">
            
            </tbody>
        </table>
    </div> -->
</body>

</html>
<?php
    }
}
?>