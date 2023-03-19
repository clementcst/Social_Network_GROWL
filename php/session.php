<?php
    session_start();
    require_once("constant.php");
    require_once(MISC);

    function s_isConnected(){
        return isset($_SESSION['connected']);
    }

    function s_disconnect() {
        if(s_isConnected()) { //si l'utilisateur est connecté, on le déconnecte
            unset($_SESSION['connected']);
        }
    }

    function s_connect(string $userID) { //connecte l'utilisateur
        s_disconnect();
        $_SESSION['connected'] = $userID; 
    }    

    if(isset($_GET["action"]) && $_GET["action"] === "disconnection") {
        s_disconnect();
        redirect(ROOT.INDEX);
    }
    
?>