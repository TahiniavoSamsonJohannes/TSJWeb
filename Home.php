<?php
include('actions/SecurityAction.php');
require_once('database.php');

$postError = '';
$postText = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['publish'])) {
    $postText = trim($_POST['post_text'] ?? '');
    $image = $_FILES['post_image'] ?? null;

    if ($postText === '' && (!$image || $image['error'] === UPLOAD_ERR_NO_FILE)) {
        $postError = 'Add text or an image to your post.';
    } elseif (mb_strlen($postText) > 5000) {
        $postError = 'The text cannot exceed 5,000 characters.';
    } elseif ($image && $image['error'] !== UPLOAD_ERR_NO_FILE && $image['error'] !== UPLOAD_ERR_OK) {
        $postError = 'Image upload failed.';
    } elseif ($image && $image['error'] === UPLOAD_ERR_OK && $image['size'] > 5 * 1024 * 1024) {
        $postError = 'The image cannot be larger than 5 MB.';
    } else {
        $imagePath = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($image['tmp_name']);
            $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
            if (!isset($allowedTypes[$mimeType])) {
                $postError = 'Choose a JPG, PNG, GIF, or WebP image.';
            } else {
                $uploadDirectory = __DIR__ . '/uploads/posts';
                if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true)) {
                    $postError = 'The image folder could not be created.';
                } else {
                    $fileName = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$mimeType];
                    if (!move_uploaded_file($image['tmp_name'], $uploadDirectory . '/' . $fileName)) {
                        $postError = 'The image could not be saved.';
                    } else {
                        $imagePath = 'uploads/posts/' . $fileName;
                    }
                }
            }
        }

        if ($postError === '') {
            $insertPost = $database->prepare('INSERT INTO posts (user_id, content, image_path) VALUES (?, ?, ?)');
            $insertPost->execute([(int)$_SESSION['id'], $postText, $imagePath]);
            header('Location: Home.php');
            exit();
        }
    }
}

$postsQuery = $database->query('SELECT posts.id, posts.content, posts.image_path, posts.created_at, users.firstname, users.lastname
    FROM posts INNER JOIN users ON users.id = posts.user_id ORDER BY posts.created_at DESC, posts.id DESC');
$posts = $postsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <?php include("head.php"); ?>
<body>
    <?php include("navbar.php"); ?>

    <main class="container-body home-layout">
        <aside class="sidebar-left home-sidebar">
            <div class="links"><img src="images/newspaper.png" alt=""><a href="#fil-actualite">News Feed</a></div>
            <div class="links"><img src="images/web-development.png" alt=""><a href="#">Web Development</a></div>
            <div class="links"><img src="images/usa-flag.png" alt=""><a href="#">English Course</a></div>
            <div class="links"><img src="images/sports.png" alt=""><a href="#">Sports</a></div>
            <div class="links"><img src="images/videos.png" alt=""><a href="#">Videos</a></div>
            <hr>
            <div class="links"><img src="images/carnet.png" alt=""><a href="#">Notepad</a></div>
        </aside>

        <section class="home-feed" id="fil-actualite" aria-label="News feed">
            <form class="post-composer" method="POST" enctype="multipart/form-data">
                <h1>Share a post</h1>
                <textarea name="post_text" maxlength="5000" placeholder="What’s new?" aria-label="Post text"><?= htmlspecialchars($postText, ENT_QUOTES, 'UTF-8') ?></textarea>
                <?php if ($postError !== ''): ?><p class="post-error" role="alert"><?= htmlspecialchars($postError, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
                <div class="composer-actions">
                    <label class="image-picker" for="post-image"><img src="images/add-image.png" alt=""> Add an image</label>
                    <input id="post-image" type="file" name="post_image" accept="image/jpeg,image/png,image/gif,image/webp">
                    <button type="submit" name="publish" value="1">Post</button>
                </div>
                <span class="selected-image" id="selected-image"></span>
            </form>

            <?php if (!$posts): ?>
                <div class="empty-feed"><h2>Welcome to your news feed</h2><p>Community posts will appear here. Share the first one!</p></div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <article class="post-card">
                        <header class="post-header">
                            <img src="images/profil-blue.png" alt="" class="post-avatar">
                            <div><strong><?= htmlspecialchars($post['firstname'] . ' ' . $post['lastname'], ENT_QUOTES, 'UTF-8') ?></strong>
                                <time datetime="<?= htmlspecialchars(date(DATE_ATOM, strtotime($post['created_at'])), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(date('m/d/Y \a\t g:i A', strtotime($post['created_at'])), ENT_QUOTES, 'UTF-8') ?></time>
                            </div>
                        </header>
                        <?php if ($post['content'] !== ''): ?><p class="post-content"><?= nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')) ?></p><?php endif; ?>
                        <?php if ($post['image_path']): ?><img class="post-image" src="<?= htmlspecialchars($post['image_path'], ENT_QUOTES, 'UTF-8') ?>" alt="Image posted by <?= htmlspecialchars($post['firstname'] . ' ' . $post['lastname'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy"><?php endif; ?>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <aside class="sidebar-right home-info"><div class="members"><img src="images/member.png" alt=""><span>TSJWeb Community</span></div><p>Share your ideas, projects, and discoveries with other members.</p></aside>
    </main>

    <script src="jQuery-3.7.js"></script>
    <script src="slide_menu.js"></script>
    <script>
        document.getElementById('post-image').addEventListener('change', function () {
            document.getElementById('selected-image').textContent = this.files.length ? this.files[0].name : '';
        });
    </script>
</body>
</html>
