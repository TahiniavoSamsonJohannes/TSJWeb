<?php
    include("actions/SigninAction.php");
?>

<!DOCTYPE html>
<html lang="en">

    <?php include("head.php"); ?>

<body onLoad="load_focus()">
    <div class="container">
        <span>Sign in</span>
        <div class="error">
            <?php if(isset($error)){ echo $error; } ?>
        </div>
        <div class="success">
            <?php if(isset($success)){ echo $success; } ?>
        </div>
        <form method="POST">
            <input type="text" name="lastname" id="lastname" placeholder="Lastname" autocomplete="off" value="<?php echo $lastname; ?>">
            <input type="text" name="firstname" placeholder="Firstname (identifier)" autocomplete="off" value="<?php echo $firstname; ?>">
            <input type="text" name="birthday" placeholder="Birthday" value="<?php echo $birthday; ?>">
            <input type="text" name="sex" placeholder="Sex" value="<?php echo $sex; ?>">
            <input type="password" name="pass" placeholder="Password" value="<?php echo $pass; ?>">
            <input type="password" name="repass" placeholder="Confirm your password" value="<?php echo $repass; ?>">
            <input type="submit" name="submit" value="Signin">
            <a href="Login.php">Login to your account</a>
        </form>
    </div>
    
    <script>
        function load_focus(){
            document.getElementById("lastname").focus();
        }
    </script>
</body>
</html>