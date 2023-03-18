<?php
    require_once("./constant.php");
    require_once(M_FORMS);
    require_once(MISC);
    require_once(DATABASE);
    require_once(SESSION);
    
    if(isset($_POST["submitRegistration"]))
    {
        $errorNumber = checkingForm("registration", $_POST);
        if($errorNumber === 0)
        {
            $tabDataForm = $_POST;
                switch($tabDataForm["sex"]){
                    case "Man" :
                        $tabDataForm["sex"] = 1;
                        break;
                    case "Woman" :
                        $tabDataForm["sex"] = 0;
                        break;
                    case "Other" :
                        $tabDataForm["sex"] = 2;
                        break;
                    default :
                        $tabDataForm["sex"] = -1;
                        break;
                }

                $passwordHash = password_hash($tabDataForm["password"], PASSWORD_DEFAULT);
                $newUserTab = array("Username" => $tabDataForm["userName"],
                                    "Name" => $tabDataForm["name"],
                                    "Firstname" => $tabDataForm["firstName"],                                    
                                    "Sex" => $tabDataForm["sex"],
                                    "BirthDate" => $tabDataForm["birthDate"],
                                    "Mail" => $tabDataForm["mail"],
                                    "Country" => $tabDataForm["country"],
                                    "City" => $tabDataForm["city"],
                                    "PhoneNumber" => $tabDataForm["phoneNumber"],
                                );                
                $dbUser = db_newUser($newUserTab, $passwordHash);
                if($dbUser != 1) {
                    switch ($dbUser) {
                        case 'mail':
                            $err = "Cette adresse mail existe déjà."; break;
                        case 'userName':
                            $err = "Ce nom d'utilisateur est déjà pris."; break;
                        default : $err = "erreur"; break;
                    }                    
                    unset($_SESSION["errorMessageRegistration"]);
                    $_SESSION['errorMessageRegistration'][$dbUser] = $err;
                   redirect(ROOT.ACCOUNT);
                }
                
                s_connect(db_selectColumns('user', ['UserID'], ['Username' => ['=', "'".$tabDataForm["userName"]."'", "0"]])[0][0]);
                redirect(ROOT.INDEX);
        }
        else
        {
            java_log("ici"); 
            redirect(ROOT.ACCOUNT);
        }
    }
    else
    {
        java_log("là");
        $_SESSION['errorMessageRegistration']['submitRegistration'] = "Veuillez envoyer le formulaire d'inscription.";
        redirect(ROOT.ACCOUNT);
    }
?>