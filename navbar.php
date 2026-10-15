<?php
$currentPage = basename($_SERVER['SCRIPT_NAME'] ?? '');
$navigationIcons = [
    'Home.php' => ['home.png', 'home-fill.png'],
    'Chatbox.php' => ['message.png', 'message-fill.png'],
    'Notification.php' => ['notification.png', 'notification-fill.png'],
];
?>
<nav>
    <div class="nav-left">
        <img src="images/TSJWeb-logo.png" class="logo" alt="TSJWeb">
        <ul>
            <?php foreach ($navigationIcons as $page => [$icon, $activeIcon]): ?>
                <?php $isActive = $currentPage === $page; ?>
                <li><a href="<?= htmlspecialchars($page, ENT_QUOTES, 'UTF-8') ?>" aria-label="<?= htmlspecialchars(pathinfo($page, PATHINFO_FILENAME), ENT_QUOTES, 'UTF-8') ?>"<?= $isActive ? ' aria-current="page"' : '' ?>><img src="images/<?= $isActive ? $activeIcon : $icon ?>" alt=""></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="nav-right">
    <?php
    //Afficher le prénom et nom de l'user courant dans le nav droit
    if($_SESSION['firstname'] AND $_SESSION['lastname']){
        echo $_SESSION['firstname']." ". $_SESSION['lastname'];
    }
    ?>
    <img src="images/profile/<?= htmlspecialchars($_SESSION['profile_image'] ?? 'cat.png', ENT_QUOTES, 'UTF-8') ?>" class="user-img" alt="Account menu" title="Account menu">
    </div>
    <div class="slide_menu">
        <a href="Profile.php">
            <div class="slide-element-container">
                <div class="slide-element">
                    <img src="images/profile/<?= htmlspecialchars($_SESSION['profile_image'] ?? 'cat.png', ENT_QUOTES, 'UTF-8') ?>" class="settings" alt="">
                    <span>Profile</span>
                </div>
                <img src="images/arrow.png" class="arrow" alt="">
            </div>
        </a>
        <a href="#">
            <div class="slide-element-container">
                <div class="slide-element">
                    <img src="images/setting.png" class="settings">
                    <span>Settings</span>
                </div>
                <img src="images/arrow.png" class="arrow">
            </div>
        </a>
        <a href="actions/LogoutAction.php">
            <div class="slide-element-container">
                <div class="slide-element">
                    <img src="images/logout.png" class="logout">
                    <span>Log out</span>
                </div>
                <img src="images/arrow.png" class="arrow">
            </div>
        </a>
    </div>

</nav>
<script>
    if (window.fetch) {
        window.fetch('actions/HeartbeatAction.php', {method:'POST', credentials:'same-origin'});
        window.setInterval(function(){ window.fetch('actions/HeartbeatAction.php', {method:'POST', credentials:'same-origin'}); }, 30000);
    }
</script>
