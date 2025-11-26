<?php
require_once "../config.php";
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();

use mdb\Tag;

if (isset($_GET['name'])) {
    $tag_name = $_GET['name'];
    $tag = new Tag();
    $tagDetails = $tag->getTagInfo($tag_name);
    if ($tagDetails) {
        $films = $tag->getFilmsByTag($tag_name);
    } else {
        $films = [];
    }
}

if (isset($_POST['deleteTag'])) {
    $tag_id = $tagDetails->id;
    $tag->DeleteTag($tag_id);
    header("Location: search.php?content=categories");
}
ob_start();
?>
<div class="w-full 2xl:w-9/12 xl:w-10/12 text-white mx-auto space-y-4 flex flex-col justify-center items-center">
    <!-- Display the tag's name -->
    <h1 class="text-7xl text-secondary">#<?= htmlspecialchars($tag_name) ?></h1>
  
    <section class="pt-16 pb-10 w-full">
        <div class="flex flex-col justify-center items-center w-10/12 mx-auto relative">
            <p class="lg:text-4xl md:text-3xl tracking-widest font-normal mb-16 uppercase">Films</p>
            <div class="flex flex-wrap justify-around w-full">
                <?php if (!empty($films)): ?>
                    <?php foreach ($films as $n) : ?>
                        <?= $n->getHTML(); ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No films found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php if ($_SESSION['role'] == 'admin') : ?>
    <div class="flex justify-center items-center uppercase">
        <form action="" method="post">
            <button type="submit" name="deleteTag" class="px-3 mb-4 py-2 bg-secondary text-white cursor-pointer hover:animate-pulse rounded-md add-to-vues-btn">
                Delete Tag <i class="fas fa-trash ml-3 text-white"></i>
            </button>
        </form>
        <button type="button" name="EditTag" class="px-3 mb-4 ml-10 py-2 bg-green-500 text-white cursor-pointer hover:animate-pulse rounded-md add-to-vues-btn">
            Edit Tag <i class="fas fa-pen-to-square ml-3 text-white"></i>
        </button>
    </div>
    <?php endif; ?>
</div>

<!-- edit pop up -->
<div id="EditTagPopup" class="flex text-primary fixed z-50 top-0 left-0 right-0 bg-black bg-opacity-80 hidden justify-center items-center w-screen h-screen">
    <form id="tag-form" method="POST" action="../Edits/EditTag.php" enctype="multipart/form-data" class="w-1/2 mx-auto text-black bg-white flex flex-col overflow-y-hidden items-center space-y-4 p-10">
        <p class="text-4xl mb-3">Edit Tag</p>
        <input type="hidden" name="id" value="<?=$tagDetails->id ?>">
        <div>
            <label for="nom" class="block text-sm font-semibold mb-2">Name</label>
            <input required value="<?= htmlspecialchars($tag_name) ?>" type="text" class="block w-[250px] h-[60px] mx-3 p-2 bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="nom" name="nom" aria-describedby="nom">
        </div>
        <div class="flex space-x-7 text-xl items-center pt-7">
            <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-md focus:outline-none focus:bg-blue-600">Edit Now</button>
            <button type="reset" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">Reset</button>
        </div>
    </form>
    <i class="fas fa-xmark text-secondary hover:scale-150 absolute top-2 right-4 cursor-pointer text-4xl p-2"></i>
</div>

<script>
    const EditTagPopup = document.getElementById('EditTagPopup');
    const EditTagBtn = document.querySelector('button[name="EditTag"]');
    const closeEditTagPopup = EditTagPopup.querySelector('i');

    EditTagBtn.addEventListener('click', () => {
        EditTagPopup.classList.remove('hidden');
    });

    closeEditTagPopup.addEventListener('click', () => {
        EditTagPopup.classList.add('hidden');
    });
</script>

<?php $content = ob_get_clean(); ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content); ?>
