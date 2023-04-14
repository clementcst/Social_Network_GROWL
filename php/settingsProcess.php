<?php
   
    if(file_exists("./required.php"))
        require_once("./required.php");
    else
        require_once("./php/required.php");
    
    
    if(isset($_POST)) {
        java_log(json_encode($_POST));
        $tabdataform = $_POST;
        if(!isset($tabdataform["srcPP_base64"]) || !isset($tabdataform["srcPP_type"]) || !isset($tabdataform["srcPP_username"]) ) {
            redirect(ROOT.SETTINGS);
        }
        else{
            $PPid = db_selectColumns("user", ["ProfilPic"], ["Username" => ["LIKE", "'".$tabdataform["srcPP_username"]."'", "0"]])[0][0];
            db_updateColumns("media", ["Base64" => $tabdataform["srcPP_base64"], "Type" => $tabdataform["srcPP_type"]], ["MediaID" => ["LIKE", "'".$PPid."'", "0"]]);
            redirect(ROOT.SETTINGS);
        }

    } else {
        redirect(ROOT.SETTINGS);
    }
?>