<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require 'database.php';
$viewerId = (int)($_SESSION['id'] ?? 0);
$term = trim((string)($_GET['q'] ?? ''));
if ($viewerId < 1) { return; }
$friends = $database->prepare("SELECT u.id,u.firstname,u.lastname FROM users u JOIN friendships f ON
  ((f.user_id=? AND f.friend_id=u.id) OR (f.friend_id=? AND f.user_id=u.id))
  WHERE f.status='accepted' ORDER BY u.firstname,u.lastname");
$friends->execute([$viewerId,$viewerId]);
if (!$term):
  foreach ($friends as $friend): ?>
    <div class="member-result friend-member-row">
      <div class="member friend-member" data-member-id="<?= (int)$friend['id'] ?>"><img src="images/profil-blue.png" alt=""><span><?= htmlspecialchars($friend['firstname'].' '.$friend['lastname'],ENT_QUOTES,'UTF-8') ?></span></div>
      <button type="button" class="friend-action" data-action="remove" data-user-id="<?= (int)$friend['id'] ?>">Remove friend</button>
    </div>
  <?php endforeach;
  return;
endif;
$query = $database->prepare("SELECT u.id,u.firstname,u.lastname,
  f.status AS friendship_status, f.user_id AS request_from
  FROM users u LEFT JOIN friendships f ON
    ((f.user_id = ? AND f.friend_id = u.id) OR (f.friend_id = ? AND f.user_id = u.id))
  WHERE u.id <> ? AND (u.firstname LIKE ? OR u.lastname LIKE ?) AND (f.status IS NULL OR f.status <> 'accepted')
  ORDER BY u.firstname,u.lastname LIMIT 30");
$like = '%' . $term . '%';
$query->execute([$viewerId,$viewerId,$viewerId,$like,$like]);
foreach ($query as $user):
  $status = $user['friendship_status'];
  $incoming = $status === 'pending' && (int)$user['request_from'] !== $viewerId;
?>
<div class="member-result">
  <div class="member" data-member-id="<?= (int)$user['id'] ?>"><img src="images/profil-blue.png" alt=""><span><?= htmlspecialchars($user['firstname'].' '.$user['lastname'],ENT_QUOTES,'UTF-8') ?></span></div>
  <?php if ($status === 'accepted'): ?><span class="friend-state">Friend</span>
  <?php elseif ($incoming): ?><button type="button" class="friend-action" data-action="accept" data-user-id="<?= (int)$user['id'] ?>">Accept request</button>
  <?php elseif ($status === 'pending'): ?><span class="friend-state">Request sent</span>
  <?php else: ?><button type="button" class="friend-action" data-action="request" data-user-id="<?= (int)$user['id'] ?>">Add friend</button><?php endif; ?>
</div>
<?php endforeach; ?>
