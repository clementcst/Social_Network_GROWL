<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Social Network </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/conversations.css">
</head>

    <body>

        <?php 
            require_once("./php/constant.php");
            include_once(HEADER);  
        ?>
        
        <div class="main">

            <!-- Left Content -->
            <div class="left-content">

                <div class="nav-laterral">
                    <div class="nav-close" id="nav-button">
                        <ion-icon name="close"></ion-icon>
                    </div>
                        <div class="nav-links">
                            <div class="nav-link">
                                <ion-icon name="home"></ion-icon>Home
                            </div>
                            <div class="nav-link">
                                <ion-icon name="person"></ion-icon>Account
                            </div>
                            <div class="nav-link">
                                <ion-icon name="paper-plane"></ion-icon>Messages
                            </div>
                            <div class="nav-link">
                                <ion-icon name="settings"></ion-icon>Settings
                            </div>
                            <hr>
                            <small>About us</small>
                        </div>
                </div>

                <nav class="lateral">
                    <div class="nav-open" id="nav-button">
                        <ion-icon name="reorder-three"></ion-icon>
                    </div>
                </nav>
            

            </div>
            <!-- Middle Content -->
            <div class="middle-content middle-message">
                <div class="box_message">

                    <div class="title_message">
                        <div class="username_receiver_message">
                            <h3>Fabien Cerf</h3>
                        </div>
                        <div class="date_last_message">
                            <span>Jeudi 26 mars 11h24</span>
                        </div>
                    </div>

                    <div id="conv" class="conv_message">

                        <div class="bulle friend_bulle_message">
                            <span class="message_info friend_name_message">Fabien Cerf</span>
                            <span class="text_message">La réponse de l'ami qui est surement tresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstressssssss</span>
                            <span class="message_info date_message">11:47 - 23 mars</span>
                        </div>
                        <div>
                            <div class="my-empty-conv"></div>
                            <div class="bulle my_bulle_message">
                                <span class="text_message">Un messa</span>
                                <span class="message_info date_message">11:47 - 23 mars</span>
                            </div>
                        </div>
                        <div class="bulle friend_bulle_message">
                            <span class="message_info friend_name_message">Fabien Cerf</span>
                            <span class="text_message">La réponse de l'ami qui est surement tresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstressssssss</span>
                            <span class="message_info date_message">11:47 - 23 mars</span>
                        </div>
                        <div class="bulle friend_bulle_message">
                            <span class="message_info friend_name_message">Fabien Cerf</span>
                            <span class="text_message">La réponse de l'ami qui est surement tresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstressssssss</span>
                            <span class="message_info date_message">11:47 - 23 mars</span>
                        </div>
                        <div>
                            <div class="my-empty-conv"></div>
                            <div class="bulle my_bulle_message">
                                <span class="text_message">Un message de ma part en reponsereponsereponsereponsereponsereponsereponsereponsereponse</span>
                                <span class="message_info date_message">11:47 - 23 mars</span>
                            </div>
                        </div>
                        <div>
                            <div class="my-empty-conv"></div>
                            <div class="bulle my_bulle_message">
                                <span class="text_message">Un message de ma part en reponsereponsereponsereponsereponsereponsereponsereponsereponse</span>
                                <span class="message_info date_message">11:47 - 23 mars</span>
                            </div>
                        </div>
                        <div>
                            <div class="my-empty-conv"></div>
                            <div class="bulle my_bulle_message">
                                <span class="text_message">Un message de ma part en reponsereponsereponsereponsereponsereponsereponsereponsereponse</span>
                                <span class="message_info date_message">11:47 - 23 mars</span>
                            </div>
                        </div>
                        <div class="bulle friend_bulle_message">
                            <span class="message_info friend_name_message">Fabien Cerf</span>
                            <span class="text_message">La réponse de l'ami qui est surement tresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstresssssssstressssssss</span>
                            <span class="message_info date_message">11:47 - 23 mars</span>
                        </div>
                        <div>
                            <div class="my-empty-conv"></div>
                            <div class="bulle my_bulle_message">
                                <span class="text_message">Un message de ma part en reponsereponsereponsereponsereponsereponsereponsereponsereponse</span>
                                <span class="message_info date_message">11:47 - 23 mars</span>
                            </div>
                        </div>

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
                    <div id="friend1" class="friends_list selected_friends" onclick="selectDiscussion(this.id)">
                        <img src="images/user-2-pic.jpg">
                        <div>
                            <p>Fabien Cerf</p>
                        </div>
                        <div class="close-message">
                            <ion-icon name="paper-plane"></ion-icon>
                        </div>
                    </div>
 
                    <div id="friend2" class="friends_list" onclick="selectDiscussion(this.id)">
                        <img src="images/user-4-pic.jpg">
                        <div>
                            <p>Adam Bouhrara</p>
                        </div>
                        <div class="close-message">
                            <ion-icon name="paper-plane"></ion-icon>
                        </div>
                    </div>
                    <div id="friend3" class="friends_list" onclick="selectDiscussion(this.id)">
                        <img src="images/user-2-pic.jpg">
                        <div>
                            <p>Fabien Cerf</p>
                        </div>
                        <div class="close-message">
                            <ion-icon name="paper-plane"></ion-icon>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <?php include_once(FOOTER); ?> 
        
    </body>
    
    <script rel="stylesheet" src="js/index.js"></script>
    <script rel="stylesheet" src="js/conversations.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>
