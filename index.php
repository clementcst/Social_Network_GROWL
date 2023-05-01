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
                <form method="post" name="new-post-form" action="<?= PHP.POST_PRO ?>">

                    <div class="post-input">
                        <div class="content-input">
                            <input class="text-area" type="textarea" name="text_input"
                                placeholder="What do you want to tell about today ?" />

                            <div class="add-post">
                                <div id="new-post-images">

                                </div>
                            </div>
                            <div class="bottom-input">
                                <div> <input type="file" name="picture" id="hiddenfile" onchange="previewPicture(this)"style="display:none" multiple>
                                <ion-icon name='camera' onclick="getfile()"></ion-icon>Add Photos/Videos</div>
                                <input id="submit-post" type="submit" value="Submit" />
                                </div>
                            </div>
                            
                    </div>
                </form>
              </div>
        <!-- Posts -->
        <?php 
            $posts = db_selectColumns('post', ['*']); // changer ici pour la politique de confidentialité des posts
            for ($i=count($posts)-1 ; $i >=0  ; $i--) {
                $postData = $posts[$i]; 
                $postUserData = db_getUserData($postData[7]);
                $postData[6] = urldecode($postData[6]);
                $postData[5] = urldecode($postData[5]);
                if($postData[4] > 0 && $postData[4] < 5){
                    $postMediasSrc = db_getPostMedias($postData[0]);
                }                
        ?>
        <div class="post-container">
            <div class="user-profil">
                <img src="<?= $postUserData[9] ?>">
                <div>
                    <p id = "userName_Post"><?= $postUserData[0] ?></p>
                    <span><?= $postData[1] ?></span>
                </div>
            </div>
            <p class="post-text"><?= $postData[6] ?></p>
            <div class="post-media">
                <div class="post-images">
                    <?php if($postData[4] > 0 && $postData[4] < 5) {
                        for($k = 0; $k < count($postMediasSrc); $k++){ ?>                        
                            <img src="<?= $postMediasSrc[$k] ?>" alt="Img Media <?=$k?>" class="post-img" 
                            <?php if($postData[4] == 1) { ?>
                                style="width: 200%; height:auto"
                            <?php } ?>
                            >
                        <?php } 
                    } ?>
                </div>
                <div class="post-reactions">
                    <div>
                        <ion-icon name="heart" onclick="LikePost('<?= $postData[0] ?>', this, <?=$i?>)"
                            <?php if(count(db_selectColumns("liked_post", ["*"], ["UserID" => ["LIKE", "'".$_SESSION["connected"]."'", "1"],
                                                                                  "PostID" => ["LIKE", "'".$postData[0]."'", "0"]]))
                                     > 0) {
                                        ?> style = "color: red" <?php
                                     }
                            ?>
                        >
                        </ion-icon>
                        <small id="likeCount<?=$i?>"><?= $postData[2] ?></small>
                    </div>
                    <?php 
                        $postComments = db_selectColumns('comment', ['*'], ['ReplyTo_PostID' => ['=', "'".$postData[0]."'", '0']]);
                        $nbComments = count($postComments);                            
                    ?>
                   <div>
                        <ion-icon id="CommentSection<?=$postData[0]?>" name="chatbox-ellipses" onclick="CommentSectionCall(this.id)">
                        </ion-icon>
                        <small><?= $nbComments ?></small>
                    </div>
                    <!-- Comments. Ils sont générés en ajax ici -->
                    
                    <div>
                        <ion-icon name="share-social" onclick="shareSocial(this)"></ion-icon>
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
<script rel="stylesheet" src="js/ajaxRequest.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</html>
