<?php
session_start();
require("database.php");

@$id = htmlspecialchars($_POST['id']);
@$pass = $_POST['pass'];
@$submit = $_POST['submit'];

if(isset($submit)){
    //Vérification si les champs ne sont pas vides
    if(!empty($id) AND !empty($pass)){

        //Vérification si les données entrées par l'user existent dans la table user de la BD
        $checkIfUserExists = $database->prepare("SELECT * FROM users WHERE firstname = ? AND password = ? ");
        $checkIfUserExists->execute(array($id, md5($pass)));
        $UserInfos = $checkIfUserExists->fetch();

        if($checkIfUserExists->rowCount() == 0){
            $error = "*Your identifier or password is incorrect.";
        }else{
            
            //Récupérer les données de l'user
            $_SESSION['id'] = $UserInfos['id'];
            $_SESSION['firstname'] = $UserInfos['firstname'];
            $_SESSION['lastname'] = $UserInfos['lastname'];
            $_SESSION['profile_image'] = $UserInfos['profile_image'] ?: 'cat.png';
            $_SESSION['auth'] = true;
            $touch = $database->prepare('UPDATE users SET last_seen=NOW() WHERE id=?');
            $touch->execute([(int)$UserInfos['id']]);

            //Redirection vers la page Home
            header("Location:Home.php");
            
        }

    }else{
        $error = "*Please complete all fields.";
    }
}



?>
