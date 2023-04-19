<?php
   
    if(file_exists("./required.php"))
        require_once("./required.php");
    else
        require_once("./php/required.php");
    if(isset($_POST)) {
        $tabdataform = $_POST;
        if(isset($tabdataform["srcPP_base64"]) && isset($tabdataform["srcPP_type"]) && isset($tabdataform["srcPP_username"]) ) {
            $PPid = db_selectColumns("user", ["ProfilPic"], ["Username" => ["LIKE", "'".$tabdataform["srcPP_username"]."'", "0"]])[0][0];
            if($PPid == 'M0'){
                $NewID = db_generateID("media");
                db_newRow("media", ["Base64" => $tabdataform["srcPP_base64"], "Type" => $tabdataform["srcPP_type"]]);
                db_updateColumns("user", ["ProfilPic" => $NewID]);
            }
            else{
                db_updateColumns("media", ["Base64" => $tabdataform["srcPP_base64"], "Type" => $tabdataform["srcPP_type"]], ["MediaID" => ["LIKE", "'".$PPid."'", "0"]]);
                echo "<script> window.location.replace('".ROOT.SETTINGS."') </script>"; //redirect malgré la taille de l'image
            }
        } 
        else if (
            isset($tabdataform["userName"]) && isset($tabdataform["name"]) && isset($tabdataform["firstName"]) && 
            ((isset($tabdataform["sex"]) && $tabdataform["sex"] === "Man") || 
            (isset($tabdataform["sex"]) && $tabdataform["sex"] === "Woman") || 
            (isset($tabdataform["sex"]) && $tabdataform["sex"] === "Other")) && 
            isset($tabdataform["birthDate"]) && isset($tabdataform["mail"]) && isset($tabdataform["country"]) && 
            isset($tabdataform["city"]) && isset($tabdataform["phoneNumber"])
        ){
            $User_id = db_selectColumns("user", ["UserID"], ["Username" => ["LIKE", "'".$tabdataform["src_username"]."'", "0"]])[0][0];
            echo $User_id;
            switch ($tabdataform["sex"]) {
                case 'Man':
                    $Sex = '1';
                    break;
                case 'Woman':
                    $Sex = '0';
                    break;
                case 'Other':
                    $Sex = '2';
                    break;
                default:
                    $Sex = '2';
                    break;
            }
            db_updateColumns("user", ["Username" => $tabdataform["userName"], "Name" => $tabdataform["name"], "Firstname" => $tabdataform["firstName"], 
            "Mail" => $tabdataform["mail"], "Country" => $tabdataform["country"], "City" => $tabdataform["city"], 
            "BirthDate" => $tabdataform["birthDate"], "PhoneNumber" => $tabdataform["phoneNumber"], "Sex" => $Sex], ["UserID" => ["LIKE", "'".$User_id."'", "0"]]);
        }

    } else {
        redirect(ROOT.SETTINGS);
    }
    redirect(ROOT.SETTINGS);
?>