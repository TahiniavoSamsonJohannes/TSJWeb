<nav>
    <div class="nav-left">
        <img src="images/TSJWeb-logo.png" class="logo">
        <ul>
            <li><a href="Home.php"><img src="images/home-light.png"></a></li>
            <li><a href="Chatbox.php"><img src="images/message.png"></a></li>
            <li><a href="Notification.php"><img src="images/notification.png"></a></li>
        </ul>
    </div>

    <div class="nav-right">
    <?php
    //Afficher le prénom et nom de l'user courant dans le nav droit
    if($_SESSION['firstname'] AND $_SESSION['lastname']){
        echo $_SESSION['firstname']." ". $_SESSION['lastname'];
    }
    ?>
    <img src="images/profil.png" class="user-img">
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