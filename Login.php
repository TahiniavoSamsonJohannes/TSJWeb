<?php
    include("actions/LoginAction.php");
?>

<!DOCTYPE html>
<html lang="en">

    <?php include("head.php"); ?>

<body onLoad="load_focus()">
    <div class="container">
        <div class="auth-logo-wrap"><img class="auth-logo" src="images/TSJWeb-logo.png" alt="TSJWeb"></div>
        <span>Log in</span>
        <div class="error">
            <?php if(isset($error)){ echo $error; } ?>
        </div>
        <form method="POST">
            <input type="text" name="id" id="identifier" placeholder="Identifier" autocomplete="off" value="<?php echo $id; ?>">
            <input type="password" name="pass" placeholder="Password" value="<?php echo $pass; ?>">
            <input type="submit" name="submit" value="Log in">
            <a href="Signin.php">Create an account</a>
        </form>
    </div>
    
    <script>
        function load_focus(){
            document.getElementById("identifier").focus();
        }
    </script>
</body>
</html>
