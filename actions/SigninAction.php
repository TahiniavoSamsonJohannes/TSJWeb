<?php
session_start();
require("database.php");

@$firstname = htmlspecialchars($_POST['firstname']);
@$lastname = htmlspecialchars($_POST['lastname']);
@$birthday = $_POST['birthday'];
@$sex = htmlspecialchars($_POST['sex']);
@$pass = $_POST['pass'];
@$repass = $_POST['repass'];
@$submit = $_POST['submit'];

if(isset($submit)){
    //Vérifier si les champs ne sont pas vides
    if(!empty($lastname) AND !empty($firstname) AND !empty($birthday) 
    AND !empty($sex) AND !empty($pass)){

        //Vérifier si les mots de passe sont identiques
        if($pass != $repass){
            $error = "*Passwords are not the same!";
        }else{

            $checkIfUserExists = $database->prepare("SELECT * FROM users WHERE firstname = ? AND lastname = ?");
            $checkIfUserExists->execute(array($firstname, $lastname));
            $UserInfos = $checkIfUserExists->fetchAll();

            //Vérifier si l'utilisateur existe déjà            
            if($checkIfUserExists->rowCount() > 0){
                $error = "*This user already exists...";
            }else{

                //Insérer l'utilisateur dans la base de donnée
                $insertUserInfos = $database->prepare("INSERT INTO users(firstname, lastname, birthday, sex, password)
                VALUES (?, ?, ?, ?, ?)");
                $insertUserInfos->execute(array($firstname,$lastname,$birthday,$sex,md5($pass)));

                header("Location:Login.php");
            
            }

        }
    }else{
        $error = "*Please complete all the fields...";
    }
}

?>