﻿<?php include("header.php"); ?>
<?php include("menu.php"); ?>
    <header class="intro-header" style="background-image: url('img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <?php
                            $query = "SELECT * FROM `header` LIMIT 1";
                            $result = $mysqli->query($query);
                            if ($result) {
                                foreach ($result as $item) {
                                    echo '<h1>'.$item['name'].'</h1>
                                    <hr class="small">
                                    <span class="subheading">'.$item['text'].'</span>';
                                }
                            }
                            else {
                                echo '<h1>Blogs</h1>
                                    <hr class="small">
                                    <span class="subheading">A Clean Blog Theme by Start Bootstrap</span>';
                            }
                            function get_user_full_name($user) {
                                $id = (int) $user;
                                global $mysqli;
                                $author = "SELECT `name`,`surname` FROM `users` WHERE `id`=".$id."";
                                $author_result = $mysqli->query($author);
                                foreach ($author_result as $key) {
                                    $name = $key['name']." ".$key['surname'];
                                    return $name;
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php
                    $news_list = "SELECT * FROM `article`";
                    $news_result = $mysqli->query($news_list);
                    foreach ($news_result as $item) {
                        echo '
                          <div class="post-preview">
                                <a href="post.php?post_id='.$item['id'].'&csrftoken=Wt9eeWt9eeJop5Vb3OJop5VWtWt9eeJop5Vb3O9eeJWt9eeJop5Wt9eeJop5Vb3OVb3Oop5Vb3Ob3OmeNTvWt9eeJop5Vb3Oogegckm1pVM5MD">
                                    <h2 class="post-title">'.$item['title'].'</h2>
                                    <h3 class="post-subtitle">'.$item['sub_title'].'</h3>
                                </a>
                                <p class="post-meta">Posted by <a href="#">'.get_user_full_name($item['author_id']).'</a> on '.date('F j Y', strtotime($item['publish_date'])).'</p>
                            </div>
                            <hr>
                        ';
                    }
                ?>
                <!--<div class="post-preview">
                    <a href="post.html">
                        <h2 class="post-title">
                            Man must explore, and this is exploration at its greatest
                        </h2>
                        <h3 class="post-subtitle">
                            Problems look mighty small from 150 miles up
                        </h3>
                    </a>
                    <p class="post-meta">Posted by <a href="#">Start Bootstrap</a> on September 24, 2014</p>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="post.html">
                        <h2 class="post-title">
                            I believe every human has a finite number of heartbeats. I don't intend to waste any of mine.
                        </h2>
                    </a>
                    <p class="post-meta">Posted by <a href="#">Start Bootstrap</a> on September 18, 2014</p>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="post.html">
                        <h2 class="post-title">
                            Science has not yet mastered prophecy
                        </h2>
                        <h3 class="post-subtitle">
                            We predict too much for the next year and yet far too little for the next ten.
                        </h3>
                    </a>
                    <p class="post-meta">Posted by <a href="#">Start Bootstrap</a> on August 24, 2014</p>
                </div>
                <hr>
                <div class="post-preview">
                    <a href="post.html">
                        <h2 class="post-title">
                            Failure is not an option
                        </h2>
                        <h3 class="post-subtitle">
                            Many say exploration is part of our destiny, but it’s actually our duty to future generations.
                        </h3>
                    </a>
                    <p class="post-meta">Posted by <a href="#">Start Bootstrap</a> on July 8, 2014</p>
                </div>
                <hr>-->
                <!-- Pager -->

            </div>
        </div>
    </div>

    <hr>
<?php include("footer.php"); ?>