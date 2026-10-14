<?php
require __DIR__ . '/../database.php';

@$toUserId = $_POST['memberId'];

//Vérification si toUserId a été dans l'URL et n'est pas vide
if(!empty($toUserId)){

    //Récupérer le prénom et nom de l'user correspondant l'id toUserId déclarer dans l'URL
    $selectUser = $database->prepare("SELECT firstname, lastname FROM users WHERE id = ?");
    $selectUser->execute(array($toUserId));
    $User = $selectUser->fetch();
    ?>
        <img src="images/profil-blue.png">
    <?php
        //Afficher le prénom et nom de l'user
        echo $User["firstname"] . " " . $User["lastname"];

}else{
    echo 'Messages';
}

?>