<?php
    require_once("./manage_form.php");
    require_once("./database.php");
    session_start();
    
    if(isset($_POST["submitRegistration"]))
    {
        $errorNumber = checkingForm("registration", $_POST);
        java_log($errorNumber);
        if($errorNumber === 0)
        {
            $tabDataForm = $_POST;
            // if(is_array(1) && 1 !== [] && array_sum(array()) === 0)
            // {    
                java_log("c bon");    
                // $passwordHash = password_hash($tabDataForm["password"], PASSWORD_DEFAULT);
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
                    header('Location: ../createAccount.php', true, 301);
                }
                
                // header('Location: ../index.php', true, 301);
                exit;
        }
        else
        {
            java_log("ici");
            // header('Location: ../createAccount.php', true, 301);
            exit;
        }
    }
    else
    {
        java_log("là");
        $_SESSION['errorMessageRegistration']['submitRegistration'] = "Veuillez envoyer le formulaire d'inscription.";
        // header('Location: ../createAccount.php', true, 301);
        exit;
    }


//     session_start();
//    function verify_login(string $mail, string $password) {
//       $filter = array( "Mail" => array("=", "'".$mail."'", "0"));
//       $result_id = db_selectColumns("user", ['UserID'], $filter);
//       if(count($result_id) != 1){
//          java_log('erreur');
//       } else {
//          $filter = array( "UserID" => array("LIKE", "'".$result_id[0][0]."'", "0"));
//          $result_pwd = db_selectColumns("password", ["EncrPwd"], $filter);
//          if(password_verify($password ,$result_pwd[0][0])) {
//             $SESSION['connnected'] = $result_id[0][0];
//             java_log($SESSION['connnected']);
//          }
            
//       }
//    }

?>