<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require 'database.php';
$viewerId = (int)($_SESSION['id'] ?? 0);
$term = trim((string)($_GET['q'] ?? ''));
if ($viewerId < 1) { return; }

function renderMemberRow(array $person, bool $isFriend = false, int $viewerId = 0): void {
    $name = htmlspecialchars($person['firstname'].' '.$person['lastname'], ENT_QUOTES, 'UTF-8');
    $avatar = htmlspecialchars('images/profile/'.($person['profile_image'] ?: 'cat.png'), ENT_QUOTES, 'UTF-8');
    ?>
    <div class="member-result<?= $isFriend ? ' friend-member-row' : '' ?>">
      <div class="member<?= $isFriend ? ' friend-member' : '' ?>" data-member-id="<?= (int)$person['id'] ?>"><img src="<?= $avatar ?>" alt=""><span><?= $name ?></span></div>
      <?php if ($isFriend): ?>
        <button type="button" class="friend-action" data-action="remove" data-user-id="<?= (int)$person['id'] ?>">Remove friend</button>
      <?php else:
        $status = $person['friendship_status'] ?? null;
        $incoming = $status === 'pending' && (int)($person['request_from'] ?? 0) !== $viewerId;
        if ($incoming): ?><button type="button" class="friend-action" data-action="accept" data-user-id="<?= (int)$person['id'] ?>">Accept request</button>
        <?php elseif ($status === 'pending'): ?><span class="friend-state">Request sent</span>
        <?php elseif ($status === 'removed'): ?><button type="button" class="friend-action" data-action="request" data-user-id="<?= (int)$person['id'] ?>">Add friend</button>
        <?php else: ?><button type="button" class="friend-action" data-action="request" data-user-id="<?= (int)$person['id'] ?>">Add friend</button><?php endif;
      endif; ?>
    </div>
    <?php
}

if ($term !== '') {
    $search = $database->prepare("SELECT u.id,u.firstname,u.lastname,u.profile_image,
      f.status AS friendship_status, f.user_id AS request_from
      FROM users u LEFT JOIN friendships f ON
        ((f.user_id=? AND f.friend_id=u.id) OR (f.friend_id=? AND f.user_id=u.id))
      WHERE u.id<>? AND (u.firstname LIKE ? OR u.lastname LIKE ?) AND (f.status IS NULL OR f.status<>'accepted')
      ORDER BY u.firstname,u.lastname LIMIT 30");
    $like = '%'.$term.'%';
    $search->execute([$viewerId,$viewerId,$viewerId,$like,$like]);
    foreach ($search as $person) renderMemberRow($person, $person['friendship_status'] === 'accepted', $viewerId);
    return;
}

$friendsQuery = $database->prepare("SELECT u.id,u.firstname,u.lastname,u.profile_image FROM users u JOIN friendships f ON
  ((f.user_id=? AND f.friend_id=u.id) OR (f.friend_id=? AND f.user_id=u.id))
  WHERE f.status='accepted' ORDER BY u.firstname,u.lastname");
$friendsQuery->execute([$viewerId,$viewerId]);
$friends = $friendsQuery->fetchAll(PDO::FETCH_ASSOC);
if (($_GET['section'] ?? '') === 'friends') {
    if (!$friends) { ?><p class="member-list-empty">You have no friends yet.</p><?php }
    else { foreach ($friends as $friend) renderMemberRow($friend, true, $viewerId); }
    return;
}
?>
<section class="member-group" aria-labelledby="friends-heading">
  <h2 class="member-group-label" id="friends-heading">Friends</h2>
  <div id="friend-list">
    <?php foreach ($friends as $friend) renderMemberRow($friend, true, $viewerId); ?>
    <?php if (!$friends): ?><p class="member-list-empty">You have no friends yet.</p><?php endif; ?>
  </div>
</section>
