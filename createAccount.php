<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
require_once("./php/database.php");
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
    
<form  id="form-registration" onsubmit="return (checkingForm('registration'))" action="./php/processCreateAccount.php" method="post">
        <div id="formulaire">    
            <h1>Inscription</h1>
            <table>
                <tr>
                <td>
                        <div class="input_label">
                            <label for="userName">Nom d'utilisateur</label>
                            <input type="text" name="userName" id="userName" required placeholder="Nom d'utilisateur" size="32" value="<?php if(isset($tabCorrectInput["userName"])){echo $tabCorrectInput["userName"];}else{echo "";} ?>">
                            <p id="errorMessage-registration-userName" class="errorMessage"><?php if(isset($tabErrorMessage["userName"])){echo $tabErrorMessage["userName"];}else{echo "";} ?></p>
                        </div> 
                    </td>
                    <td>
                        <div class="input_label">
                            <label for="name">Nom</label>
                            <input type="text" name="name" id="name" required placeholder="Nom" size="32" value="<?php if(isset($tabCorrectInput["name"])){echo $tabCorrectInput["name"];}else{echo "";} ?>">
                            <p id="errorMessage-registration-name" class="errorMessage"><?php if(isset($tabErrorMessage["name"])){echo $tabErrorMessage["name"];}else{echo "";} ?></p>
                        </div> 
                    </td>
                    <td>
                        <div class="input_label">
                            <label for="firstName">Prénom</label>
                            <input type="text" name="firstName" id="firstName" required placeholder="Prénom" size="32" value="<?php if(isset($tabCorrectInput["firstName"])){echo $tabCorrectInput["firstName"];}else{echo "";} ?>">
                            <p id="errorMessage-registration-firstName" class="errorMessage"><?php if(isset($tabErrorMessage["firstName"])){echo $tabErrorMessage["firstName"];}else{echo "";} ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="1">
                        <div class="input_label">
                            <label for="sexChoice">Sexe</label> 
                            <div id="sexChoice">
                                <input type="radio" id="sexMan"  name="sex" value="Man" <?php if(isset($tabCorrectInput["sex"]) && $tabCorrectInput["sex"] === "Man"){echo "checked";}else{echo "";} ?>>
                                <label for="sexMan">Homme</label>
                            
                                <input type="radio" id="sexWoman" name="sex" value="Woman" <?php if(isset($tabCorrectInput["sex"]) && $tabCorrectInput["sex"] === "Woman"){echo "checked";}else{echo "";} ?>>
                                <label for="sexWoman">Femme</label>

                                <input type="radio" id="sexOther" name="sex" value="Other" <?php if(isset($tabCorrectInput["sex"]) && $tabCorrectInput["sex"] === "Other"){echo "checked";}else{echo "";} ?>>
                                <label for="sexOther">Autre</label>
                            </div>  
                            <p id="errorMessage-registration-sex" class="errorMessage"><?php if(isset($tabErrorMessage["sex"])){echo $tabErrorMessage["sex"];}else{echo "";} ?></p>
                        </div>
                    </td>
                    <td>
                        <div class="input_label">
                            <label for="birthDate">Date de naissance</label>
                            <input type="date" name="birthDate" id="birthDate"  required value="<?php if(isset($tabCorrectInput["birthDate"])){echo $tabCorrectInput["birthDate"];}else{echo "";} ?>">
                            <p id="errorMessage-registration-birthDate" class="errorMessage"><?php if(isset($tabErrorMessage["birthDate"])){echo $tabErrorMessage["birthDate"];}else{echo "";} ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input_label">
                            <label for="mail">Adresse mail</label>
                            <input type="email" name="mail" id="mail"  placeholder="Adresse mail" required size="25" value="<?php if(isset($tabCorrectInput["mail"])){echo $tabCorrectInput["mail"];}else{echo "";} ?>">
                            <p id="errorMessage-registration-mail" class="errorMessage"><?php if(isset($tabErrorMessage["mail"])){echo $tabErrorMessage["mail"];}else{echo "";} ?></p>
                        </div>
                    </td>
                    <td>
                        <div class="input_label">
                            <label for="confirmationMail">Confirmation mail</label>
                            <input type="email" name="confirmationMail" id="confirmationMail" onpaste="return false;" required placeholder="Adresse mail" size="25" value="<?php if(isset($tabCorrectInput["confirmationMail"])){echo $tabCorrectInput["confirmationMail"];}else{echo "";} ?>">
                            <p id="errorMessage-registration-confirmationMail" class="errorMessage"><?php if(isset($tabErrorMessage["confirmationMail"])){echo $tabErrorMessage["confirmationMail"];}else{echo "";} ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input_label">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" id="password"  required placeholder="Mot de passe">
                            <p id="errorMessage-registration-password" class="errorMessage"><?php if(isset($tabErrorMessage["password"])){echo $tabErrorMessage["password"];}else{echo "";} ?></p>
                        </div>
                    </td>
                    <td>
                        <div class="input_label">
                            <label for="confirmationPassword">Confirmation mot de passe</label>
                            <input type="password" name="confirmationPassword" id="confirmationPassword" onpaste="return false;" required placeholder="Mot de passe">
                            <p id="errorMessage-registration-confirmationPassword" class="errorMessage"><?php if(isset($tabErrorMessage["confirmationPassword"])){echo $tabErrorMessage["confirmationPassword"];}else{echo "";} ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="input_label">
                            <label for="country">Pays</label>
                            <input class="country" name="country" id="country" placeholder="Pays" required rows="3" value="<?php if(isset($tabCorrectInput["country"])){echo $tabCorrectInput["country"];}else{echo "";} ?>">
                            <p id="errorMessage-registration-country" class="errorMessage"><?php if(isset($tabErrorMessage["country"])){echo $tabErrorMessage["country"];}else{echo "";} ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input_label">
                            <label for="city">Ville</label>
                            <input type="text" name="city" id="city" placeholder="Ville" required value="<?php if(isset($tabCorrectInput["city"])){echo $tabCorrectInput["city"];}else{echo "";} ?>">
                            <p id="errorMessage-registration-city" class="errorMessage"><?php if(isset($tabErrorMessage["city"])){echo $tabErrorMessage["city"];}else{echo "";} ?></p>
                        </div>
                    </td>
                    <td>
                        <div class="input_label">
                            <label for="phoneNumber">Numéro de Téléphone</label>
                            <input type="tel" name="phoneNumber" id="phoneNumber"  required placeholder="Téléphone" value="<?php if(isset($tabCorrectInput["phoneNumber"])){echo $tabCorrectInput["phoneNumber"];}else{echo "";} ?>">
                            <p id="errorMessage-registration-phoneNumber" class="errorMessage"><?php if(isset($tabErrorMessage["phoneNumber"])){echo $tabErrorMessage["phoneNumber"];}else{echo "";} ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="but_link" name="submitRegistration" value="Valider inscription">
                    </td>    
                    <td colspan="2">
                        <input type="reset" class="but_link" name="Reset" value="Annuler">
                    </td>
                </tr>
            </table>
        </div>
    </form>
   <br>
    <fieldset><form id = "submit_Login" action="./php/loginProcess.php" method="post">
        <legend>Se connecter</legend>
        <table>
            <tr>
                <td>
                    <div class="input_label">
                        <label for="identifiant">Identifiant</label>
                        <input type="text" name="identifiant" id="identifiant" required placeholder="Nom d'utilisateur/adresse mail" size="32" value="<?php if(isset($_SESSION['conservedLogin'])){echo $_SESSION['conservedLogin'];unset($_SESSION['conservedLogin']);}else{echo "";} ?>">
                        <p id="errorMessage-registration-log" class="errorMessage"><?php if(isset($tab_errorMessage_log["log"])){echo $tab_errorMessage_log["log"];}else{echo "";} ?></p>
                    </div> 
                </td>
                <td>
                    <div class="input_label">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password_log" id="password_log"  required placeholder="Mot de passe">
                        <p id="errorMessage-registration-passwordLog" class="errorMessage"><?php if(isset($tab_errorMessage_log["passwordLog"])){echo $tab_errorMessage_log["passwordLog"];}else{echo "";} ?></p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" class="but_link" name="submitLogin" value="Connexion">
                </td>    
                <td colspan="2">
                    <input type="reset" class="but_link" name="Reset" value="Annuler">
                </td>
            </tr>
        </table>
    </form>
    </fieldset>


</body>
<script type="text/javascript" src="./js/manage_form.js"></script>
</html>