<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Social Network </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/conversations.css">
    <script rel="stylesheet" src="js/script_ajaxRequest.js"></script>
</head>

    <body>

        <?php 
            require_once("./php/constant.php");
            include_once(HEADER); 
            if(!s_isConnected())
                redirect(INDEX);

            $friends_id = db_order_lastConversation($_SESSION['connected']);
            $last_communicate_friend = db_getUserData($friends_id[0]);
            $conversation = db_getConversation($friends_id[0],$_SESSION['connected']);
            $number_message = count($conversation);
        ?>
        
        <main class="main">

            <!-- Left Content -->
                <?php include_once(ASIDE) ?>
            <!-- Middle Content -->
            
             <div class="middle-content middle-message">
                <div class="box_message">
                <?php $taille_conversation = count($conversation);?>

                    <div class="title_message">
                        <div class="username_receiver_message">
                            <h3 id="current_speaking"><?= $last_communicate_friend[0]; ?></h3>
                        </div>
                        <div class="date_last_message">
                            <span id="current_speaking_date_last_message"><script>changeFormatDate('<?=$conversation[$number_message-1][5]?>', 'current_speaking_date_last_message', '1')</script></span>
                        </div>
                    </div>

                    <div id="conv" class="conv_message">

                    <?php for($i=$taille_conversation-1;$i>=0; $i--){?>
                    <div>
                        <div class=" <?php 
                            if($i>0){echo "my-empty-conv";}?>">                            
                        </div>
                        <div class="bulle <?php 
                            if($conversation[$i][1]==$_SESSION['connected']){echo "my_bulle_message";}
                            else{echo "friend_bulle_message";}?>">
                            <span class=" <?php 
                                if($conversation[$i][1]==$_SESSION['connected']){echo "message_info";}
                                else{echo "message_info friend_name_message";}?>">
                                <?php 
                                if($conversation[$i][1]==$_SESSION['connected']){echo "Moi";}
                                else{echo $last_communicate_friend[0];}?>
                            </span>
                            <span class="text_message"><?=$conversation[$i][3]?></span>
                            <span id="<?=$i;?>" class="message_info date_message" ><script>changeFormatDate('<?=$conversation[$i][5]?>', '<?=$i?>', '1')</script></span>  
                        </div>
                    </div>
                    <?php } ?>                              

                    </div>

                    <div class="send_menu_message">
                        <div class="message_image_file">
                            <input type="file" id="hiddenfile" onchange="displayFile()" style="display:none"/>
                            <ion-icon name='images' onclick="getfile()" ></ion-icon>
                        </div>
                        <input id="actual_writen_message" type="text" class="form-control" placeholder="Write message..."  onkeypress="if (event.keyCode == 13) sendMessage()">
                        <div class="send_icon_message" onclick="sendMessage()">
                            <ion-icon name="send"></ion-icon>
                        </div>
                    </div>
                </div>        
            </div>
            <!-- Right Content -->
            <div class="right-content-message">
            <div class="close-friends">
                    <b>Discussion</b>
            <?php
                for($i=0; $i<count($friends_id); $i++){
                    $user_data = db_getUserData($friends_id[$i]);
                    ?>
                    <div name="<?=$user_data[0]?>" id="friend<?=$i+1?>" class="friends_list <?php if($i==0){echo 'selected_friends';}?>" onclick="selectDiscussion(this.id)">
                        <img src= "<?= $user_data[9] ?>"  alt=<?= $user_data[9] ?>>
                        <div>
                            <p id="username_friend<?=$i+1?>"><?=$user_data[0]?></p>
                        </div>
                        <div class="close-message">
                            <ion-icon name="paper-plane"></ion-icon>
                        </div>
                    </div><?php
                }
                
            ?>
                </div>
            </div>
        </div>


        </main>

        <?php include_once(FOOTER); ?> 
        
    </body>
    <script rel="stylesheet" src="js/conversations.js"></script>
    <!-- les autres script on été déplacé dans le footer adam, si jamais tu te pose la question -->
</html>
