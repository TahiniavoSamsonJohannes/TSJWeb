<?php
session_start();
require('database.php');

@$toUserId = $_POST['memberId'];




$Allmessages = $database->prepare("SELECT fromUser, toUser, messages FROM chatbox WHERE 
(fromUser = ? AND toUser = ?) OR (fromUser = ? AND toUser= ?) ORDER BY id ASC");

$Allmessages->execute(array($_SESSION['id'], $toUserId, $toUserId, $_SESSION['id']));

//Afficher tous les messages
while($messages = $Allmessages->fetch()){
    if($messages['fromUser'] == $_SESSION['id'] AND $messages['toUser'] == $toUserId){
    ?>
    <div class="myMessage">
        <span><?= $messages['messages'] ?></span>
    </div>

    <?php 
    }elseif($messages['fromUser'] == $toUserId AND $messages['toUser'] == $_SESSION['id']){
    ?>
    <div class="hisOrherMessage">
        <span><?= $messages['messages'] ?></span>
    </div>
    
    <?php
    }
}


?>