<?php
require_once "../config.php";
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newComment = [
        'photo' => '../images/Elon_Musk_Royal_Society.jpg', // Replace with the actual user photo path
        'user' => 'Vous',
        'date' => date('d/m/Y'),
        'text' => htmlspecialchars($_POST['comment-text'])
    ];

    // Store the comment in the session
    if (!isset($_SESSION['comments'])) {
        $_SESSION['comments'] = [];
    }
    array_unshift($_SESSION['comments'], $newComment); // Add the new comment to the beginning
}

// Fetch comments from session
$comments = $_SESSION['comments'] ?? [];

ob_start();
?>
<div id="comment-section" class="max-w-2xl mx-auto">
    <!-- Comment Form -->
    <div class="flex items-start mb-5">
        <div class="comment-photo w-20 h-20 mr-4">
            <img src="../images/Elon_Musk_Royal_Society.jpg" alt="Commenter Photo" class="w-full h-full rounded-full object-cover">
        </div>
        
        <form id="comment-form" class="flex-1" method="POST" action="">
            <p class="comment-text w-full mb-2 text-white">Vous</p>
            <textarea name="comment-text" id="comment-text" class="w-full h-16 p-2 border rounded" placeholder="écrire un commentaire..." required></textarea>
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Publier</button>
        </form>
    </div>
    <!-- Comments -->
    <?php foreach ($comments as $comment): ?>
    <div class="comment p-2 border-b border-gray-300 flex">
        <div class="comment-photo w-20 h-20 mr-4">
            <img src="<?php echo htmlspecialchars($comment['photo']); ?>" alt="Commenter Photo" class="w-full h-full rounded-full object-cover">
        </div>
        <div class="comment-content flex-1">
            <p class="comment-text w-full mb-2 text-white"><?php echo htmlspecialchars($comment['user']); ?></p>
            <p class="comment-text w-full mb-2 text-white"><?php echo htmlspecialchars($comment['date']); ?></p>
            <p class="comment-text w-full mb-2 text-white"><?php echo htmlspecialchars($comment['text']); ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>
