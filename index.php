<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Social Network </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php 
          require_once("./php/constant.php");
          include_once(HEADER); 
    ?> 
        
        <div class="main">

            <!-- Left Content -->
            <aside class="left-content">

                <div class="nav-laterral">
                    <div class="nav-close" id="nav-button">
                        <ion-icon name="close"></ion-icon>
                    </div>
                        <div class="nav-links">
                            
                            <a href=<?=INDEX?>><div class="nav-link" >
                                <ion-icon name="home"></ion-icon>Home
                            </div></a>
                            <a href=<?=PROFIL?>><div class="nav-link">
                                <ion-icon name="person"></ion-icon>Account
                            </div></a>
                            <a href=<?=CONVERSATION?>><div class="nav-link">
                                <ion-icon name="paper-plane"></ion-icon>Messages
                            </div></a>
                            <a href=<?=SETTINGS?>><div class="nav-link">
                                <ion-icon name="settings"></ion-icon>Settings
                            </div></a>
                            <hr>
                            <small>About us</small>
                        </div>
                </div>

                <nav class="lateral">
                    <div class="nav-open" id="nav-button">
                        <ion-icon name="reorder-three"></ion-icon>
                    </div>
                </nav>
            

    </aside>
            <!-- Middle Content -->
            <div class="middle-content">

                <div class="write-post">
                    
                    <div class="user-profil">
                        <img src="images/user-1-pic.jpg">
                        <div>
                            <p>Jordan Gautier</p>
                            <small>Date, Place </small>
                        </div>
                    </div>
                    <div class="post-input">

                    <div class="content-input">
                    <textarea placeholder="What do you want to tell about today ?"></textarea>
                        <div class="add-post">
                        <img id="displayfile" src="">
                    </div>    
  
                        <input type="file" id="hiddenfile" onchange="displayFile()" style="display:none"/>
                        <ion-icon name='camera' onclick="getfile()" ></ion-icon>Add Photos/Videos
                        </div>
                    </div>

                </div>

                
                <div class="post-container">
                    
                    <div class="user-profil">
                        <img src="images/user-3-pic.jpg">
                        <div>
                            <p>Joan Legrand</p>
                            <span>January, 11, 2023, 12:34 AM</span>
                        </div>
                    </div>
                    <p class="post-text">Voici mon premier post sur le nouveaux réseau social qui va détronner Instagram, Twitter, Facebook, et tous les autres ! Vous voulez savoir pourquoi ? Parce que il y a rien de nouveau hehe... ;) <a href="#">#ClaquezAuSol</a></p>
                    <div class="post-media">
                        <img src="images/feed-image-1.png" class="post-img">
                        <div class="post-reactions">

                            <div><ion-icon name="heart" onclick="AddHeart()"></ion-icon><small>26</small></div>

                            <div> <!--Le php devra créer un menu{i} pour chaque nouveau post-->
                                <ion-icon id="menu1" name="chatbox-ellipses" onclick="CommentSectionOpen(this.id)"></ion-icon><small>23</small>
                                <!-- Comment Menu-->
                                <div class="comment-menu" id="close1">

                                    <div class="comments-list">
                                        <div class="user-profil comment-box">
                                            <img src="images/user-1-pic.jpg">
                                            <div class="">
                                                <div class="comment-pseudo-text">
                                                    <a class="comment-pseudo">Jordan Gautier</a>
                                                    <p class="comment-text">Voici le commentaire. Je vais essayer de faire un vrai comment avec des mots avec des espaces entre chaque oui voilà c'est parfait comme ca!</p>
                                                </div>
                                                <div class="comment-reaction">
                                                    <p class="comment-react comment-info">Répondre</p>
                                                    <p class="comment-react comment-info">Aimer</p>
                                                    <p class="comment-info">06-01-2002</p>
                                                </div>
                                            </div>
                                            
                                            <div class="comment-number-like">
                                                <p><ion-icon name="heart"></ion-icon><small>26</small></p>
                                            </div>
                                        </div>
                                        <div class="load-comments">
                                            <div class="comments-bar"></div>
                                            <span class="show-more-comments">Afficher les 4 réponses</span>
                                        </div>
                                    </div>

                                    <div class="comments-list">
                                        <div class="user-profil comment-box">
                                            <img src="images/user-1-pic.jpg">
                                            <div class="">
                                                <div class="comment-pseudo-text">
                                                    <a class="comment-pseudo">Jordan Gautier</a>
                                                    <p class="comment-text">Voici le commentaire. Je vais essayer de faire un vrai comment avec des mots avec des espaces entre chaque oui voilà c'est parfait comme ca!</p>
                                                </div>
                                                <div class="comment-reaction">
                                                    <p class="comment-react comment-info">Répondre</p>
                                                    <p class="comment-react comment-info">Aimer</p>
                                                    <p class="comment-info">06-01-2002</p>
                                                </div>
                                            </div>
                                            <div class="comment-number-like">
                                                <p><ion-icon name="heart"></ion-icon><small>26</small></p>
                                            </div>
                                        </div>
                                        <div class="load-comments">
                                            <div class="comments-bar"></div>
                                            <span class="show-more-comments">Afficher les 4 réponses</span>
                                        </div>
                                    </div>

                                    <div class="comments-list">
                                        <div class="user-profil comment-box">
                                            <img src="images/user-1-pic.jpg">
                                            <div class="">
                                                <div class="comment-pseudo-text">
                                                    <a class="comment-pseudo">Jordan Gautier</a>
                                                    <p class="comment-text">Voici le commentaire. Je vais essayer de faire un vrai comment avec des mots avec des espaces entre chaque oui voilà c'est parfait comme ca!</p>
                                                </div>
                                                <div class="comment-reaction">
                                                    <p class="comment-react comment-info">Répondre</p>
                                                    <p class="comment-react comment-info">Aimer</p>
                                                    <p class="comment-info">06-01-2002</p>
                                                </div>
                                            </div>
                                            <div class="comment-number-like">
                                                <p><ion-icon name="heart"></ion-icon><small>26</small></p>
                                            </div>
                                        </div>
                                        <div class="load-comments">
                                            <div class="comments-bar"></div>
                                            <span class="show-more-comments">Afficher les 4 réponses</span>
                                        </div>
                                    </div>

                                </div> 
                            </div>

                            <div><ion-icon name="share-social"></ion-icon><small>18</small></div>

                        </div>
                    </div>
                </div>


                <div class="post-container">
                    
                    <div class="user-profil">
                        <img src="images/user-2-pic.jpg">
                        <div>
                            <p>Fabien Cerf</p>
                            <span>September, 12, 2022, 12:34 AM</span>
                        </div>
                    </div>
                    <p class="post-text">Bravo à <a>#CyTech</a> pour sa super 16ème place volée au classement de l'étudiant. Bravo à tous pour ce vol !!</p>
                    <div class="post-media">
                        <img src="images/feed-image-2.png" class="post-img">
                        <div class="post-reactions">

                            <div><ion-icon name="heart"></ion-icon><small>26</small></div>

                            <div>
                                <ion-icon id="menu2" onclick="CommentSectionOpen(this.id)" name="chatbox-ellipses"></ion-icon><small>8</small>
                                <!-- Comment Menu-->
                                <div class="comment-menu" id="close2">
                                    <div class="comments-list">
                                        <div class="user-profil comment-box">
                                            <img src="images/user-1-pic.jpg">
                                            <div class="">
                                                <div class="comment-pseudo-text">
                                                    <a class="comment-pseudo">Jordan Gautier</a>
                                                    <p class="comment-text">Voici le commentaire. Je vais essayer de faire un vrai comment avec des mots avec des espaces entre chaque oui voilà c'est parfait comme ca!</p>
                                                </div>
                                                <div class="comment-reaction">
                                                    <p class="comment-react comment-info">Répondre</p>
                                                    <p class="comment-react comment-info">Aimer</p>
                                                    <p class="comment-info">06-01-2002</p>
                                                </div>
                                            </div>
                                            <div class="comment-number-like">
                                                <p><ion-icon name="heart"></ion-icon><small>26</small></p>
                                            </div>
                                        </div>
                                        <div class="load-comments">
                                            <div class="comments-bar"></div>
                                            <span class="show-more-comments">Afficher les 4 réponses</span>
                                        </div>
                                    </div>
                                    <div class="comments-list">
                                        <div class="user-profil comment-box">
                                            <img src="images/user-1-pic.jpg">
                                            <div class="">
                                                <div class="comment-pseudo-text">
                                                    <a class="comment-pseudo">Jordan Gautier</a>
                                                    <p class="comment-text">Voici le commentaire. Je vais essayer de faire un vrai comment avec des mots avec des espaces entre chaque oui voilà c'est parfait comme ca!</p>
                                                </div>
                                                <div class="comment-reaction">
                                                    <p class="comment-react comment-info">Répondre</p>
                                                    <p class="comment-react comment-info">Aimer</p>
                                                    <p class="comment-info">06-01-2002</p>
                                                </div>
                                            </div>
                                            <div class="comment-number-like">
                                                <p><ion-icon name="heart"></ion-icon><small>26</small></p>
                                            </div>
                                        </div>
                                        <div class="load-comments">
                                            <div class="comments-bar"></div>
                                            <span class="show-more-comments">Afficher les 4 réponses</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div><ion-icon name="share-social"></ion-icon><small>45</small></div>
                            
                        </div>
                    </div>
                </div>

                <div><button tyupe="button" class="load-more-btn">Load More</button></div>

            </div>
            
            <!-- Right Content -->
            <div class="right-content">

                <div class="close-friends">
                    <b>Close Friends</b>
                    <div class="close-f">
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
</html>
