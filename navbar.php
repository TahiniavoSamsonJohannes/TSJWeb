<nav>
    <div class="nav-left">
        <img src="images/TSJWeb-logo.png" class="logo" alt="TSJWeb">
        <ul>
            <li><a href="Home.php" aria-label="Home"><img src="images/home-light.png" alt=""></a></li>
            <li><a href="Chatbox.php" aria-label="Messages"><img src="images/message.png" alt=""></a></li>
            <li><a href="Notification.php" aria-label="Notifications"><img src="images/notification.png" alt=""></a></li>
        </ul>
    </div>

    <div class="nav-right">
    <?php
    //Afficher le prénom et nom de l'user courant dans le nav droit
    if($_SESSION['firstname'] AND $_SESSION['lastname']){
        echo $_SESSION['firstname']." ". $_SESSION['lastname'];
    }
    ?>
    <img src="images/profil.png" class="user-img" alt="Account menu" title="Account menu">
    </div>
    <div class="slide_menu">
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
