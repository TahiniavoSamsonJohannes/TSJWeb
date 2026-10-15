<?php
include 'actions/SecurityAction.php';
require_once 'database.php';
$userId = (int)$_SESSION['id'];
$error = '';
$success = '';
$statement = $database->prepare('SELECT firstname,lastname,birthday,sex,password,profile_image FROM users WHERE id=?');
$statement->execute([$userId]);
$profile = $statement->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim((string)($_POST['firstname'] ?? ''));
    $lastname = trim((string)($_POST['lastname'] ?? ''));
    $birthday = (string)($_POST['birthday'] ?? '');
    $sex = trim((string)($_POST['sex'] ?? ''));
    $newPassword = (string)($_POST['new_password'] ?? '');
    $repeatPassword = (string)($_POST['repeat_password'] ?? '');
    $currentPassword = (string)($_POST['current_password'] ?? '');
    $profileImage = basename((string)($_POST['profile_image'] ?? ($profile['profile_image'] ?? 'cat.png')));
    $allowedProfileImages = ['cat.png','fox.png','lion.png','owl.png','panda.png','penguin.png','rabbit.png'];
    if (!in_array($profileImage, $allowedProfileImages, true)) $profileImage = 'cat.png';
    if ($firstname === '' || $lastname === '' || $birthday === '' || $sex === '') {
        $error = 'Please complete all profile fields.';
    } elseif (strlen($sex) > 20) {
        $error = 'The sex field cannot exceed 20 characters.';
    } elseif (!DateTime::createFromFormat('!Y-m-d', $birthday) || DateTime::createFromFormat('!Y-m-d', $birthday)->format('Y-m-d') !== $birthday) {
        $error = 'Enter a valid birthday.';
    } elseif ($newPassword !== '' && md5($currentPassword) !== $profile['password']) {
        $error = 'Your current password is incorrect.';
    } elseif ($newPassword !== '' && ($newPassword !== $repeatPassword || strlen($newPassword) < 6)) {
        $error = $newPassword !== $repeatPassword ? 'The new passwords do not match.' : 'The password must contain at least 6 characters.';
    } else {
        $duplicate = $database->prepare('SELECT id FROM users WHERE firstname=? AND lastname=? AND id<>?');
        $duplicate->execute([$firstname,$lastname,$userId]);
        if ($duplicate->fetch()) {
            $error = 'This name is already used by another account.';
        } else {
            if ($newPassword !== '') {
                $update = $database->prepare('UPDATE users SET firstname=?,lastname=?,birthday=?,sex=?,password=?,profile_image=? WHERE id=?');
                $update->execute([$firstname,$lastname,$birthday,$sex,md5($newPassword),$profileImage,$userId]);
            } else {
                $update = $database->prepare('UPDATE users SET firstname=?,lastname=?,birthday=?,sex=?,profile_image=? WHERE id=?');
                $update->execute([$firstname,$lastname,$birthday,$sex,$profileImage,$userId]);
            }
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['profile_image'] = $profileImage;
            $profile = ['firstname'=>$firstname,'lastname'=>$lastname,'birthday'=>$birthday,'sex'=>$sex,'password'=>$newPassword !== '' ? md5($newPassword) : $profile['password'],'profile_image'=>$profileImage];
            $success = 'Your profile has been updated.';
        }
    }
    if ($error !== '') $profile = ['firstname'=>$firstname,'lastname'=>$lastname,'birthday'=>$birthday,'sex'=>$sex];
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
    <?php include 'navbar.php'; ?>
    <main class="profile-page">
        <section class="profile-card">
            <h1>My profile</h1>
            <?php if ($error !== ''): ?><p class="post-error" role="alert"><?= htmlspecialchars($error,ENT_QUOTES,'UTF-8') ?></p><?php endif; ?>
            <?php if ($success !== ''): ?><p class="profile-success" role="status"><?= htmlspecialchars($success,ENT_QUOTES,'UTF-8') ?></p><?php endif; ?>
            <form method="post">
                <label>First name<input name="firstname" maxlength="100" required value="<?= htmlspecialchars($profile['firstname'] ?? '',ENT_QUOTES,'UTF-8') ?>"></label>
                <label>Last name<input name="lastname" maxlength="100" required value="<?= htmlspecialchars($profile['lastname'] ?? '',ENT_QUOTES,'UTF-8') ?>"></label>
                <label>Birthday<input type="date" name="birthday" required value="<?= htmlspecialchars($profile['birthday'] ?? '',ENT_QUOTES,'UTF-8') ?>"></label>
                <label>Sex<input name="sex" maxlength="20" required value="<?= htmlspecialchars($profile['sex'] ?? '',ENT_QUOTES,'UTF-8') ?>"></label>
                <fieldset class="profile-image-choices"><legend>Profile picture</legend><?php foreach (['cat.png','fox.png','lion.png','owl.png','panda.png','penguin.png','rabbit.png'] as $image): ?><label><input type="radio" name="profile_image" value="<?= $image ?>" <?= (($profile['profile_image'] ?? 'cat.png') === $image) ? 'checked' : '' ?>><img src="images/profile/<?= $image ?>" alt="<?= pathinfo($image, PATHINFO_FILENAME) ?>"></label><?php endforeach; ?></fieldset>
                <h2>Change password (optional)</h2>
                <label>Current password<input type="password" name="current_password" autocomplete="current-password"></label>
                <label>New password<input type="password" name="new_password" minlength="6" autocomplete="new-password"></label>
                <label>Repeat new password<input type="password" name="repeat_password" minlength="6" autocomplete="new-password"></label>
                <button type="submit">Save changes</button>
            </form>
        </section>
    </main>
    <script src="jQuery-3.7.js"></script><script src="slide_menu.js"></script>
</body>
</html>
