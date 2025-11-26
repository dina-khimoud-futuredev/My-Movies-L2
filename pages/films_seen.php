<?php
require_once "../config.php";
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();

use mdb\Film;

$film = new Film();
$filmVued = $film->getVuedFilms($_SESSION['userId']);
ob_start()
?>


<section class="pt-16 pb-10 w-full text-white">
    <div class="flex flex-col justify-center items-center  w-10/12  mx-auto relative ">
      <p class="lg:text-4xl md:text-3xl   tracking-widest font-normal mb-16 uppercase">
        My seen Movies
      </p>
      <div class="flex flex-wrap justify-around w-full">
        <?php if (!empty($filmVued)) : ?>
          <?php foreach ($filmVued as $n) : ?>
          <?= $n->getHTML(); ?>
        <?php endforeach; ?>
        <?php else : ?>
            <div>
            <p>No seen Movies found.</p>
          <!-- add button to go to index with value go to watch movies-->
          <button class="px-5 py-2 rounded-md mt-10 bg-green-500 ">
            <a href="index.php">Go to watch movies</a>
          </button>
            </div>
         
        <?php endif; ?>
      </div>

    </div>
  </section>

<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>