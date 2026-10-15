<?php
require __DIR__ . '/../database.php';

@$toUserId = filter_var($_POST['memberId'] ?? null, FILTER_VALIDATE_INT);

//Vérification si toUserId a été dans l'URL et n'est pas vide
if(!empty($toUserId)){

    //Récupérer le prénom et nom de l'user correspondant l'id toUserId déclarer dans l'URL
    $selectUser = $database->prepare("SELECT firstname, lastname, profile_image, last_seen IS NOT NULL AS has_last_seen, TIMESTAMPDIFF(SECOND,last_seen,NOW()) AS elapsed_seconds FROM users WHERE id = ?");
    $selectUser->execute(array($toUserId));
    $User = $selectUser->fetch();
    ?>
        <button type="button" class="chat-back" aria-label="Back to friends">‹</button>
        <img class="chat-avatar" src="images/profile/<?= htmlspecialchars($User['profile_image'] ?: 'cat.png',ENT_QUOTES,'UTF-8') ?>" alt="">
        <span class="chat-user-details"><strong title="<?= htmlspecialchars($User['firstname'].' '.$User['lastname'],ENT_QUOTES,'UTF-8') ?>"><?= htmlspecialchars($User['firstname'].' '.$User['lastname'],ENT_QUOTES,'UTF-8') ?></strong>
        <?php if ($User['has_last_seen']):
            $seconds = max(0, (int)$User['elapsed_seconds']);
            if ($seconds < 45): ?><small class="online-status">en ligne</small><?php elseif ($seconds < 60): ?><small>à l’instant</small><?php else:
                $units = [[31536000,'an'],[2592000,'mois'],[604800,'sem'],[86400,'j'],[3600,'h'],[60,'min']];
                foreach ($units as [$unitSeconds,$unitName]) { if ($seconds >= $unitSeconds) { $elapsed = (int)floor($seconds/$unitSeconds); $unit=$unitName; break; } }
            ?><small>Vu il y a <?= (int)$elapsed . $unit ?></small><?php endif; endif; ?></span>
    <?php
        //Afficher le prénom et nom de l'user

}else{
    echo 'Select a member';
}

?>
