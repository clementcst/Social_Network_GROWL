<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Social Network </title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/settings.css">
    </head>

    <body>
        <?php 
            require_once("./php/constant.php");
            include_once(HEADER);
            if(!s_isConnected()){
                redirect(ACCOUNT);
            }
        ?>
        <script rel="stylesheet" src="js/header.js"></script>
        <?php 
        session_start();
        if(!empty($_SESSION['errorMessageRegistration']))
        {   
            $tabErrorMessage = [];
            foreach($_SESSION['errorMessageRegistration'] as $errorKey => $error) {
                $tabErrorMessage[$errorKey] = $error;
            }
            unset($_SESSION['errorMessageRegistration']);
        }

        if(!empty($_SESSION["correctInputRegistration"]))
        {
            $tabCorrectInput = [];
            foreach($_SESSION['correctInputRegistration'] as $inputName => $input) {
                $tabCorrectInput[$inputName] = $input;
            }
            unset($_SESSION["correctInputRegistration"]);
        }
        if(!empty($_SESSION['errorMessageLogin']))
        {
            $tab_errorMessage_log = [];
            foreach($_SESSION['errorMessageLogin'] as $errorKey => $error) {
                $tab_errorMessage_log[$errorKey] = $error;
            }
            unset($_SESSION['errorMessageLogin']);
        }
        ?>

        <div class="main">
            <!-- Left Content -->
            <?php include_once(ASIDE); ?>
            <div class="left-content"></div>
            <script rel="stylesheet" src="js/aside.js"></script>
            <!-- Middle Content -->
            <div class="middle-content">
                <!--Section modification profil (username, photo de profil,  name, prénom, sexe, date de naissance, mail, password, pays, ville, telephone) -->
                <div class="settings-list" id="profile" name="Closed">
                    <ion-icon name="person-circle-outline"></ion-icon> Profile Settings<div class="menu-arrow"><ion-icon id="menu-arrow-profile" name="chevron-forward-outline"></ion-icon></div>
                </div>
                <div class="profile-disclosed">
                    <?php 
                        $user = db_getUserData($_SESSION['connected']);
                    ?>
                    <form  id="form-registration" onsubmit="return (checkingForm('registration'))" action="./php/processCreateAccount.php" method="post">
                    <div id="formulaire">
                        <table>
                            <tr>
                                <td>
                                    <div class="input_label">
                                        <label for="userName">Username</label>
                                        <input type="text" name="userName" id="userName" required placeholder=<?php echo json_encode($user[0]);?> size="32" value="<?php if(isset($tabCorrectInput["userName"])){echo $tabCorrectInput["userName"];}else{echo "";} ?>">
                                        <p id="errorMessage-registration-userName" class="errorMessage"><?php if(isset($tabErrorMessage["userName"])){echo $tabErrorMessage["userName"];}else{echo "";} ?></p>
                                    </div> 
                                </td>
                                <td>
                                    <div class="input_label">
                                        <label for="profilePicture">Profile Picture</label>
                                        <img id="profilePicture" src="<?= $userData[9]?>">
                                        <input type="file" name="profilePicture">
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input_label">
                                        <label for="name">Last Name</label>
                                        <input type="text" name="name" id="name" required placeholder=<?php echo json_encode($user[1]);?> size="32" value="<?php if(isset($tabCorrectInput["name"])){echo $tabCorrectInput["name"];}else{echo "";} ?>">
                                        <p id="errorMessage-registration-name" class="errorMessage"><?php if(isset($tabErrorMessage["name"])){echo $tabErrorMessage["name"];}else{echo "";} ?></p>
                                    </div> 
                                </td>
                                <td>
                                    <div class="input_label">
                                        <label for="firstName">First Name</label><br>
                                        <input type="text" name="firstName" id="firstName" required placeholder=<?php echo json_encode($user[2]);?> size="32" value="<?php if(isset($tabCorrectInput["firstName"])){echo $tabCorrectInput["firstName"];}else{echo "";} ?>">
                                        <p id="errorMessage-registration-firstName" class="errorMessage"><?php if(isset($tabErrorMessage["firstName"])){echo $tabErrorMessage["firstName"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1">
                                    <div class="input_label">
                                        <label for="sexChoice">Sex</label> 
                                        <div id="sexChoice">
                                            <input type="radio" id="sexMan" <?php if(json_encode($user[8], JSON_NUMERIC_CHECK) == 1){echo "checked";}?> name="sex" value="Man" <?php if(isset($tabCorrectInput["sex"]) && $tabCorrectInput["sex"] === "Man"){echo "checked";}else{echo "";} ?>>
                                            <label for="sexMan">Man</label>
                                            <br>
                                            <input type="radio" id="sexWoman" <?php if(json_encode($user[8], JSON_NUMERIC_CHECK) == 0){echo "checked";}?> name="sex" value="Woman" <?php if(isset($tabCorrectInput["sex"]) && $tabCorrectInput["sex"] === "Woman"){echo "checked";}else{echo "";} ?>>
                                            <label for="sexWoman">Woman</label>
                                            <br>
                                            <input type="radio" id="sexOther" <?php if(json_encode($user[8], JSON_NUMERIC_CHECK) == 2){echo "checked";}?> name="sex" value="Other" <?php if(isset($tabCorrectInput["sex"]) && $tabCorrectInput["sex"] === "Other"){echo "checked";}else{echo "";} ?>>
                                            <label for="sexOther">Other</label>
                                        </div>  
                                        <p id="errorMessage-registration-sex" class="errorMessage"><?php if(isset($tabErrorMessage["sex"])){echo $tabErrorMessage["sex"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="input_label">
                                        <label for="birthDate">Birth Date</label><br>
                                        <input type="date" name="birthDate" id="birthDate" placeholder=<?php echo json_encode($user[6]);?> required value="<?php if(isset($tabCorrectInput["birthDate"])){echo $tabCorrectInput["birthDate"];}else{echo "";} ?>">
                                        <p id="errorMessage-registration-birthDate" class="errorMessage"><?php if(isset($tabErrorMessage["birthDate"])){echo $tabErrorMessage["birthDate"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input_label">
                                        <label for="mail">Email Adress</label>
                                        <input type="email" name="mail" id="mail"  placeholder=<?php echo json_encode($user[3]);?> required size="25" value="<?php if(isset($tabCorrectInput["mail"])){echo $tabCorrectInput["mail"];}else{echo "";} ?>">
                                        <p id="errorMessage-registration-mail" class="errorMessage"><?php if(isset($tabErrorMessage["mail"])){echo $tabErrorMessage["mail"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="input_label">
                                        <label for="confirmationMail">Email Confirmation</label>
                                        <input type="email" name="confirmationMail" id="confirmationMail" onpaste="return false;" required placeholder=<?php echo json_encode($user[3]);?> size="25" value="<?php if(isset($tabCorrectInput["confirmationMail"])){echo $tabCorrectInput["confirmationMail"];}else{echo "";} ?>">
                                        <p id="errorMessage-registration-confirmationMail" class="errorMessage"><?php if(isset($tabErrorMessage["confirmationMail"])){echo $tabErrorMessage["confirmationMail"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input_label">
                                        <label for="password">Old Password</label>
                                        <input type="password" name="password" id="password"  required placeholder="Old Password">
                                        <p id="errorMessage-registration-password" class="errorMessage"><?php if(isset($tabErrorMessage["password"])){echo $tabErrorMessage["password"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="input_label">
                                        <label for="confirmationPassword">New Password</label>
                                        <input type="password" name="confirmationPassword" id="confirmationPassword" onpaste="return false;" required placeholder="New Password">
                                        <p id="errorMessage-registration-confirmationPassword" class="errorMessage"><?php if(isset($tabErrorMessage["confirmationPassword"])){echo $tabErrorMessage["confirmationPassword"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="input_label">
                                        <label for="country">Country</label><br>
                                        <input class="country" name="country" id="country" placeholder=<?php echo json_encode($user[4]);?> required rows="3" value="<?php if(isset($tabCorrectInput["country"])){echo $tabCorrectInput["country"];}else{echo "";} ?>">
                                        <p id="errorMessage-registration-country" class="errorMessage"><?php if(isset($tabErrorMessage["country"])){echo $tabErrorMessage["country"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input_label">
                                        <label for="city">City</label><br>
                                        <input type="text" name="city" id="city" placeholder=<?php echo json_encode($user[5]);?> required value="<?php if(isset($tabCorrectInput["city"])){echo $tabCorrectInput["city"];}else{echo "";} ?>">
                                        <p id="errorMessage-registration-city" class="errorMessage"><?php if(isset($tabErrorMessage["city"])){echo $tabErrorMessage["city"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="input_label">
                                        <label for="phoneNumber">Phone Number</label>
                                        <input type="tel" name="phoneNumber" id="phoneNumber"  required placeholder=<?php echo json_encode($user[7]);?> value="<?php if(isset($tabCorrectInput["phoneNumber"])){echo $tabCorrectInput["phoneNumber"];}else{echo "";} ?>">
                                        <p id="errorMessage-registration-phoneNumber" class="errorMessage"><?php if(isset($tabErrorMessage["phoneNumber"])){echo $tabErrorMessage["phoneNumber"];}else{echo "";} ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" class="but_link" id="confirm" name="submitRegistration" value="Confirm changes">
                                </td>    
                                <td>
                                    <input type="reset" class="but_link" id="cancel" name="Reset" value="Cancel">
                                </td>
                            </tr>
                        </table>
                    </div>
                    </form>
                </div>
                <!--Thème-->
                <div class="settings-list" id="theme" name="Closed">
                    <ion-icon name="color-palette-outline"></ion-icon> Theme Settings<div class="menu-arrow"><ion-icon id="menu-arrow-theme" name="chevron-forward-outline"></ion-icon></div>
                </div>
                <div class="theme-disclosed">
                    <form action="">
                        <label for="theme-select">Select your color theme</label>
                        <select id="theme-select">
                            <option value="" disabled selected>Select your theme</option>
                            <option value="theme1">Light</option>
                        </select>
                    </form>
                </div>
                <!--Niveau de confidentialité (profil/posts)-->
                <div class="settings-list" id="privacy" name="Closed">
                    <ion-icon name="bug-outline"></ion-icon> Privacy Settings<div class="menu-arrow"><ion-icon id="menu-arrow-privacy" name="chevron-forward-outline"></ion-icon></div>
                </div>
                <div class="privacy-disclosed">
                    <form action="">
                        <label for="">Who can see your profile?</label>
                        <select id="">
                            <option value="" disabled selected><?php if(json_encode($user[10], JSON_NUMERIC_CHECK) == 0){echo "Everyone";}elseif(json_encode($user[10], JSON_NUMERIC_CHECK) == 1){echo "Friends";}elseif(json_encode($user[10], JSON_NUMERIC_CHECK) == 2){echo "Nobody";}?></option>
                            <option value="">Everyone</option>
                            <option value="">Friends</option>
                            <option value="">Nobody</option>
                        </select>
                        <br>
                        <label for="">Who can see your posts?</label>
                        <select id="">
                            <option value="" disabled selected><?php if(json_encode($user[10], JSON_NUMERIC_CHECK) == 0){echo "Everyone";}elseif(json_encode($user[10], JSON_NUMERIC_CHECK) == 1){echo "Friends";}elseif(json_encode($user[10], JSON_NUMERIC_CHECK) == 2){echo "Nobody";}?></option>
                            <option value="">Everyone</option>
                            <option value="">Friends</option>
                            <option value="">Nobody</option>
                        </select>
                    </form>
                </div>
                <!--Supprimer le compte-->
                <div class="settings-list" id="delete" name="Closed">
                    <ion-icon name="trash-outline"></ion-icon> Delete Account<div class="menu-arrow"><ion-icon id="menu-arrow-delete" name="chevron-forward-outline"></ion-icon></div>
                </div>
                <div class="delete-disclosed">
                    <form action="">
                        <label for="delete-account">Do you want to delete your account?</label>
                        <input type="button" name="delete-account" value="Delete" id="delete-account" onclick="delete_account()">
                    </form>
                </div>
            </div>
            <div class="right-content">
                    Friends settings?
            </div>
        </div>
    </body>

    <script rel="stylesheet" src="js/settings.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>
