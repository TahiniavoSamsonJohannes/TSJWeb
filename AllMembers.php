<?php
require("database.php");

//Recuperer les informations de tous les users sauf la mienne
$selectAllUsers = $database->prepare("SELECT id, firstname, lastname FROM users WHERE id != ?");
$selectAllUsers->execute(array($_SESSION["id"]));

//Afficher les prénoms et noms de tous les users
while($User = $selectAllUsers->fetch()){
    ?>
    <!-- <a href="?toUserId=< $User['id']; >"> -->
    
        <div class="member" data-member-id="<?= (int)$User['id']; ?>">
            
            <img src="images/profil-blue.png">
            <?php echo $User['firstname']." ". $User['lastname']; ?>
        </div>
        
    <!-- </a> -->
    <?php
    //Récuperer l'id de l'user destinataire du message
    /* @$_SESSION['toUserId']= $_GET['toUserId']; */

}
?>