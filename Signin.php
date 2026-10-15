<?php
    include("actions/SigninAction.php");
?>

<!DOCTYPE html>
<html lang="en">

    <?php include("head.php"); ?>

<body onLoad="load_focus()">
    <div class="container">
        <div class="auth-logo-wrap"><img class="auth-logo" src="images/TSJWeb-logo.png" alt="TSJWeb"></div>
        <span>Create an account</span>
        <div class="error">
            <?php if(isset($error)){ echo $error; } ?>
        </div>
        <div class="success">
            <?php if(isset($success)){ echo $success; } ?>
        </div>
        <form method="POST">
            <input type="text" name="lastname" id="lastname" placeholder="Last name" autocomplete="off" value="<?php echo $lastname; ?>">
            <input type="text" name="firstname" placeholder="First name (identifier)" autocomplete="off" value="<?php echo $firstname; ?>">
            <label class="profile-choice-label">Date of birth<input type="date" name="birthday" value="<?= htmlspecialchars($birthday ?? '', ENT_QUOTES, 'UTF-8') ?>" required></label>
            <fieldset class="profile-image-choices"><legend>Choose a profile picture</legend><?php foreach (['cat.png','fox.png','lion.png','owl.png','panda.png','penguin.png','rabbit.png'] as $image): ?><label><input type="radio" name="profile_image" value="<?= $image ?>" <?= (($profileImage ?? 'cat.png') === $image) ? 'checked' : '' ?>><img src="images/profile/<?= $image ?>" alt="<?= pathinfo($image, PATHINFO_FILENAME) ?>"></label><?php endforeach; ?></fieldset>
            <input type="text" name="sex" placeholder="Gender" value="<?php echo $sex; ?>">
            <input type="password" name="pass" placeholder="Password" value="<?php echo $pass; ?>">
            <input type="password" name="repass" placeholder="Confirm password" value="<?php echo $repass; ?>">
            <input type="submit" name="submit" value="Create account">
            <a href="Login.php">I already have an account</a>
        </form>
    </div>
    
    <script>
        function load_focus(){
            document.getElementById("lastname").focus();
        }
    </script>
</body>
</html>
