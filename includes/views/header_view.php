<?php
class Header_view
{
    public function header_html()
    { ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="./scripts/app.js"></script>
            <link rel="stylesheet" href="./assets/index.css">
            <title>RCS Final Project</title>
        </head>

        <body>
            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-sm py-2 sticky-top navbar-dark" id="navbar">
                <button class="navbar-toggler" type="button" data-toggle="collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse">

                    <div class="navbar-nav container nav-fill w-100">

                        <li class="mx-auto">
                            <a href="?page=home" class="text-white btn btn-link">
                                <i class="fas fa-home text-white fa-lg"></i>
                                Home
                            </a>
                        </li>
                        <li class="mx-auto">
                            <a href="?page=profile" class="text-white btn btn-link">
                                <i class="fas fa-user text-white fa-lg"></i>
                                Profile
                            </a>
                        </li>
                        <li class="mx-auto">
                            <button class="text-white btn btn-link" id="add_post">
                                <i class="fas fa-plus-square text-success fa-lg"></i>
                                <span class="text-nowrap">Add Post</span>
                            </button>
                        </li>
                        <li class="mx-auto">
                            <a href="?page=following" class="text-white btn btn-link">
                                <i class="fas fa-users text-white fa-lg"></i>
                                Following
                            </a>
                        </li>
                        <li class="mx-auto">
                            <form action="" method="POST" name="logout_submit" class="d-inline">
                                <button class="text-white btn btn-link" type="submit" name="logout_btn">
                                    <i class="fas fa-sign-out-alt text-danger fa-lg"></i>
                                    <span class="text-nowrap">Log Out</span>
                                </button>
                            </form>
                        </li>
                    </div>
            </nav>

            <!-- ADD POST -->
            <div id="add_post_form_bg" class="position-fixed">
            </div>
            <div class="position-fixed w-50 h-75" id="add_post_form">
                <form action="" method="POST" class=" mt-4 mx-none" enctype="multipart/form-data">

                    <div class="text-muted">
                        <div class="row mt-5">
                            <div class="card bg-light mx-2">
                                <div class="p-1">
                                    <label for="post_pic">
                                        <img src="https://i0.wp.com/www.rich-hansen.com/wp-content/uploads/2018/11/Screen-Shot-2018-11-28-at-1.18.54-PM.png?fit=1464%2C856" alt="" class="card-img-top img-fluid can_be_clicked">
                                    </label>
                                    <input type="file" id="post_pic" class="d-none" name="post_pic">
                                </div>

                                <div class="card-block pb-2 text-center">

                                    <textarea placeholder="About..." class="text-center col-11 my-2 form-control mx-auto" name="post_text"></textarea>
                                    <div>
                                        <button type="submit" class="btn btn-warning col-4" name="submit_post">Submit</button>
                                        <button class="btn btn-dark col-4" id="add_post_form_close_btn">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    <?php }
} ?>