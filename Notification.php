<?php
include('actions/SecurityAction.php');
require_once 'database.php';
$requests = $database->prepare("SELECT f.user_id,u.firstname,u.lastname FROM friendships f
    JOIN users u ON u.id=f.user_id WHERE f.friend_id=? AND f.status='pending' ORDER BY f.created_at DESC");
$requests->execute([(int)$_SESSION['id']]);
$requests = $requests->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
    <?php include('navbar.php'); ?>
    <main class="notification-page">
        <section class="notification-empty" aria-live="polite">
            <h1>Friend requests</h1>
            <?php if (!$requests): ?><p>No pending friend requests.</p><?php else: ?>
                <div class="friend-requests">
                    <?php foreach ($requests as $request): ?>
                        <article class="friend-request">
                            <img src="images/profil-blue.png" alt="">
                            <strong><?= htmlspecialchars($request['firstname'].' '.$request['lastname'],ENT_QUOTES,'UTF-8') ?></strong>
                            <form method="post" action="actions/FriendAction.php">
                                <input type="hidden" name="userId" value="<?= (int)$request['user_id'] ?>">
                                <input type="hidden" name="returnTo" value="Notification.php">
                                <button name="action" value="accept" type="submit">Accept</button>
                                <button name="action" value="reject" type="submit" class="reject-request">Decline</button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <script src="jQuery-3.7.js"></script>
    <script src="slide_menu.js"></script>
</body>
</html>
