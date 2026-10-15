<?php
session_start();
require("database.php");

@$firstname = htmlspecialchars($_POST['firstname']);
@$lastname = htmlspecialchars($_POST['lastname']);
@$birthday = $_POST['birthday'];
@$sex = htmlspecialchars($_POST['sex']);
@$pass = $_POST['pass'];
@$repass = $_POST['repass'];
@$profileImage = basename((string)($_POST['profile_image'] ?? 'cat.png'));
@$submit = $_POST['submit'];

if(isset($submit)){
    //Vérifier si les champs ne sont pas vides
    if(!empty($lastname) AND !empty($firstname) AND !empty($birthday) 
    AND !empty($sex) AND !empty($pass)){

        $allowedProfileImages = ['cat.png','fox.png','lion.png','owl.png','panda.png','penguin.png','rabbit.png'];
        if (!in_array($profileImage, $allowedProfileImages, true)) $profileImage = 'cat.png';

        //Vérifier si les mots de passe sont identiques
        if($pass != $repass){
            $error = "*Passwords do not match.";
        }else{

            $checkIfUserExists = $database->prepare("SELECT * FROM users WHERE firstname = ? AND lastname = ?");
            $checkIfUserExists->execute(array($firstname, $lastname));
            $UserInfos = $checkIfUserExists->fetchAll();

            //Vérifier si l'utilisateur existe déjà            
            if($checkIfUserExists->rowCount() > 0){
                $error = "*This account already exists.";
            }else{

                //Insérer l'utilisateur dans la base de donnée
                // Laisser MySQL générer id grâce à AUTO_INCREMENT.
                $insertUserInfos = $database->prepare(
                    "INSERT INTO users (firstname, lastname, birthday, sex, password, profile_image) VALUES (?, ?, ?, ?, ?, ?)"
                );
                $insertUserInfos->execute([$firstname, $lastname, $birthday, $sex, md5($pass), $profileImage]);

                header("Location:Login.php");
                exit();
            
            }

        }
    }else{
        $error = "*Please complete all fields.";
    }
}

?>
