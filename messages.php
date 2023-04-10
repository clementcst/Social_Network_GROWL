<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Social Network </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/messages.css">
</head>

    <body>

        <?php 
            require_once("./php/constant.php");
            include_once(HEADER); 
        ?> 
        
        <main class="main">

            <!-- Left Content -->
            <?php include_once(ASIDE);  ?>
            <!-- Middle Content -->
            <main class="middle-content middle-message">
                <div class="box_message">

                    <div class="title_message">
                        <div class="username_receiver_message">
                            <h3>Fabien Cerf</h3>
                        </div>
                        <div class="date_last_message">
                            <span>Jeudi 26 mars 11h24</span>
                        </div>
                    </div>

                    <div class="conv_message">

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
                        <input type="text" class="form-control" placeholder="Write message...">
                        <div class="send_icon_message">
                            <ion-icon name="send-outline"></ion-icon>
                        </div>
                    </div>
                </div>        
            </main>
            
            <!-- Right Content -->
            <div class="right-content right-message">

                <div class="close-friends">
                    <b>Discussion</b>
                    <div class="close-f selected_friends">
                        <img src="images/user-2-pic.jpg">
                        <div>
                            <p>Fabien Cerf</p>
                        </div>
                        <div class="close-message">
                            <ion-icon name="paper-plane"></ion-icon>
                        </div>
                    </div>
 
                    <div class="close-f">
                        <img src="images/user-4-pic.jpg">
                        <div>
                            <p>Adam Bouhrara</p>
                        </div>
                        <div class="close-message">
                            <ion-icon name="paper-plane"></ion-icon>
                        </div>
                    </div>
                    <div class="close-f">
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
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>
