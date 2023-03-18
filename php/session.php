<?php
    session_start();

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
?>