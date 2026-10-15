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
            <input type="text" name="birthday" placeholder="Date of birth" value="<?php echo $birthday; ?>">
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
