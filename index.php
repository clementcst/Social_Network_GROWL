<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Social Network </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <?php 
          require_once("./php/constant.php");
          include_once(HEADER);
    ?>

    <main>
        <!-- Left Content -->
        <?php include_once(ASIDE); ?>
        <!-- Middle Content -->

        <div class="middle-content">
            <div class="write-post">
                <div class="user-profil">
                    <img src="<?= $userData[9] ?>">
                    <div>
                        <p><?= $userData[0] ?></p>
                        <small><?php echo date('Y-m-d')." , ".$userData[5] ?></small>
                    </div>
                </div>
                <form method="post" name="new-post-form">

                    <div class="post-input">
                        <div class="content-input">
                            <input class="text-area" type="textarea"
                                placeholder="What do you want to tell about today ?" />

                            <div class="add-post">
                                <div id="new-post-images">

                                </div>
                            </div>

                            <input type="file" name="picture" id="hiddenfile" onchange="previewPicture(this)"
                                style="display:none" multiple>
                            <ion-icon name='camera' onclick="getfile()"></ion-icon>Add Photos/Videos
                            <input type="submit" value="Submit" />
                </form>
            </div>
        </div>
        </div>
        <!-- Posts -->
        <?php 
            $posts = db_selectColumns('post', ['*']);
            for ($i=0; $i < count($posts) ; $i++) {
                $postData = $posts[$i]; 
                $postUserData = db_getUserData($postData[7]);
                $postData[6] = urldecode($postData[6]);
                $postData[5] = urldecode($postData[5]);
        ?>
        <div class="post-container">
            <div class="user-profil">
                <img src="<?= $postUserData[9] ?>">
                <div>
                    <p><?= $postUserData[0] ?></p>
                    <span><?= $postData[1] ?></span>
                </div>
            </div>
            <p class="post-text"><?= $postData[6] ?></p>
            <div class="post-media">
                <img src="images/feed-image-1.png" class="post-img">

                <div class="post-reactions">
                    <div>
                        <ion-icon name="heart" onclick="AddHeart()"></ion-icon>
                        <small><?= $postData[2] ?></small>
                    </div>
                    <?php 
                        $postComments = db_selectColumns('comment', ['*'], ['ReplyTo_PostID' => ['=', "'".$postData[0]."'", '0']]);
                        $nbComments = count($postComments);                            
                    ?>
                    <div>
                        <ion-icon id="menu<?=$i+1?>" name="chatbox-ellipses" onclick="CommentSectionOpen(this.id)">
                        </ion-icon>
                        <small><?= $nbComments ?></small>
                    </div>
                    <!-- Comments -->
                    <?php 
                        for ($j=0; $j < $nbComments ; $j++) {
                            $postCommentData = $postComments[$j]; 
                            $postCommentData[2] = urldecode($postCommentData[2]);
                            $CommentUserData = db_getUserData($postCommentData[3]);
                    ?>
                    <div class="comment-menu" id="close<?=$i+1?>">
                        <div class="comments-list">
                            <div class="user-profil comment-box">
                                <img src="<?= $CommentUserData[9] ?>">
                                <div class="">
                                    <div class="comment-pseudo-text">
                                        <a class="comment-pseudo"><?= $CommentUserData[0] ?></a>
                                        <p class="comment-text"><?= $postCommentData[2] ?></p>
                                    </div>
                                    <div class="comment-reaction">
                                        <p id="db_id_commentaire" class="comment-react comment-info" onclick="CreateInputTexte(this.id)">Répondre</p>
                                        <!-- <p class="comment-react comment-info">Aimer</p> -->
                                        <p class="comment-info"><?= $postCommentData[1] ?></p>
                                    </div>
                                </div>
                                <!-- <div class="comment-number-like">
                                    <p>
                                        <ion-icon name="heart"></ion-icon><small>26</small>
                                    </p>
                                </div> -->

                            </div>
                            
                            <!-- <div class="load-comments">
                                <div class="comments-bar"></div>
                                <span class="show-more-comments">Afficher les 4 réponses</span>
                            </div> -->
                            <div id="db_id_commentaire_answer_section" class="answers_div"> <!-- Generer cette id avec concatenation de bd_id et "_answer_section"-->
                        </div>
                        
                            
                        </div>
                        <div class="send_menu_comment">
                            <input id="actual_writen_message" type="text" class="form-control comment-input" placeholder="Write your comment"  onkeypress="if (event.keyCode == 13) sendComment()">
                            <div class="send_icon_message" onclick="sendComment()">
                                <ion-icon name="send"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div>
                        <ion-icon name="share-social"></ion-icon>
                        <small><?= $postData[3] ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        </div>
        <!-- Right Content -->
        <?php define('CONVERSIONABLE','1'); 
        include_once(LISTFRIEND); ?>

    </main>

    <?php include_once(FOOTER); ?>

</body>
<script rel="stylesheet" src="js/index.js"></script>

</html>
