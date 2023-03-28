<link rel="stylesheet" href="css/header.css">

<header>
   
    <?php
        require_once("./php/required.php");
        if(!s_isConnected()){
            redirect(ACCOUNT);
        }
        else
            $userData = db_getUserData($_SESSION['connected']);
    ?>
   
    <nav>
        <div class="left">
            <a href=<?=INDEX?> ><img src="images/logo.png" class="logo"></a>
        </div>

        <div class="right">
            <div class="search-bar">
                <ion-icon name="search-outline"></ion-icon>
                <input type="text" placeholder="Search">
            </div>
            <div class="nav-user online">
                <img src="<?= $userData[9] ?>" onclick="settingMenuOpen()">
            </div>
        </div>

    <!-- Settings User Menu-->
        <div class="setting-menu" id="close">
            <div class="setting-menu-top">
                <div class="user-profil-setting-menu">
                    <div class="setting-menu-profil-top">
                        <img src="<?= $userData[9] ?>">
                        <p><?= $userData[0] ?></p>
                    </div>
                    <div class="your-profil">
                        <a href=<?=PROFIL?>>See your Profil</a>
                    </div>
                </div>
            </div>

            <div class="settings-items">
                <div class="circle">
                    <ion-icon name="moon"></ion-icon>
                </div>
                <div class="settings-items-description">
                    <p>Change Theme</p>
                </div>
                <div id="dark-mode-btn" >
                    <span></span>
                </div>
            </div> 
            <div class="settings-items">
                <a href=<?=SETTINGS?>><div class="circle">
                    <ion-icon name="settings"></ion-icon>
                </div>
                <div class="settings-items-description">
                    <p>Settings</p>
                </div></a>
            </div> 
            <div class="settings-items">
                <a href="#"><div class="circle">
                    <ion-icon name="help-outline"></ion-icon>
                </div>
                <div class="settings-items-description">
                    <p>Need Help</p>
                </div></a>
            </div> 
            <div class="settings-items">
                <form action=<?=PHP.SESSION?> method="get">
                    <button class="button" type="submit" style="border:none;background-color:white;">
                        <a href="#"><div class="circle">
                            <ion-icon name="log-out"></ion-icon>
                            </div>
                            <div class="settings-items-description">
                                <p>Logout</p>
                            </div>
                            <input type="hidden" name="action" value="disconnection">
                        </a>
                    </button>
                </form>
            </div> 

        </div> 
    </nav>
</header>
                
