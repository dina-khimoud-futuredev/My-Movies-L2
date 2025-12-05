<?php
require_once "../config.php";
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();

use mdb\Film;

$film = new Film();
$trending = $film->getTrending();
$recent = $film->getRecent();
$newFilms = $film->getNewFilms();
$newSeries = $film->getNewSeries();
ob_start()
?>
<!-- crousel -->
<section>
  <div class="w-full bg-primary 2xl:h-[600px] xl:h-[500px] md:h-[400px] h-[300px]">
    <div class="flex justify-between w-full h-5/6">
      <img class="object-cover h-full xl:w-2/12 w-1/12 opacity-30" id="prevSlide" src="" alt="">
      <div class="h-full hidden lg:flex items-center w-1/12 justify-center">
        <div id="prevButton" class="group h-14 w-14 hover:bg-secondary hover:border-transparent cursor-pointer rounded-full border border-white flex justify-center items-center">
          <i class="fas fa-chevron-left text-xl text-secondary group-hover:text-white"></i>
        </div>
      </div>
      <img class="object-cover xl:w-6/12 lg:w-8/12 w-9/12 shadow-lg shadow-secondary" id="mainSlide" src="" alt="">
      <div class="h-full hidden lg:flex items-center w-1/12 justify-center">
        <div id="nextButton" class="group h-14 w-14 hover:bg-secondary hover:border-transparent cursor-pointer rounded-full border border-white flex justify-center items-center">
          <i class="fas fa-chevron-right text-xl text-secondary group-hover:text-white"></i>
        </div>
      </div>
      <img class="object-cover xl:w-2/12 w-1/12 opacity-30" id="nextSlide" src="" alt="">
    </div>
    <!-- <div class="h-1/6 hidden lg:flex justify-center items-center text-xl lg:text-lg 2xl:space-x-24 xl:space-x-16 lg:space-x-6 pt-5">
          <div class="flex items-center">
            <i class="fas fa-gift text-secondary px-2 border-r border-white h-5 w-5"></i>
            <p class="hover:text-secondary text-white px-2 cursor-pointer">Emballage cadeau 1€</p>
          </div>
          <div class="flex items-center">
            <i class="fas fa-truck text-secondary px-2 border-r border-white h-5 w-5"></i>
            <p class="hover:text-secondary text-white px-2 cursor-pointer">Livraison offerte</p>
          </div>
          <div class="flex items-center">
            <i class="fas fa-percent text-secondary px-2 border-r border-white h-5 w-5"></i>
            <p class="hover:text-secondary text-white px-2 cursor-pointer">5% Remise sur votre prochaine commande</p>
          </div>
          <div class="flex items-center">
            <i class="fas fa-lock text-secondary px-2 border-r border-white h-5 w-5"></i>
            <p class="hover:text-secondary text-white px-2 cursor-pointer">Paiements sécurisés</p>
          </div>
        </div> -->
  </div>
</section>
<!-- main -->
<main class=" w-10/12 mx-auto text-white">
  <!-- recent movies -->
  <section class="pt-16 pb-10  w-full">
    <div class="flex flex-col justify-center items-center  w-10/12  mx-auto relative uppercase">
      <p class="lg:text-4xl md:text-3xl self-start text-2xl tracking-widest font-normal mb-16">
        recent movies
      </p>
      <div class="custom-scrollbar pb-5 flex w-full space-x-4 overflow-x-auto flex-nowrap">
        <?php if (!empty($recent)) : ?>
          <?php foreach ($recent as $r) : ?>
            <?= $r->getHTML(); ?>
          <?php endforeach; ?>
        <?php else : ?>
          <p>No recent films found.</p>
        <?php endif; ?>
      </div>
      <a href="search.php?content=films"><span class="px-3 py-2 sm:absolute static sm:top-0 mt-10 sm:m-0 sm:right-0 border-2 border-white cursor-pointer hover:bg-white rounded-md hover:text-primary hover:border-transparent">Voir
        <i class="fas fa-plus ml-3 text-secondary"></i>
      </span></a>
    </div>
  </section>

  <!-- popular movies -->
  <section class="pt-16 pb-10 w-full">
    <div class="flex flex-col justify-center items-center  w-10/12  mx-auto relative uppercase">
      <p class="lg:text-4xl md:text-3xl self-start text-2xl tracking-widest font-normal mb-16">
        Trending
      </p>
      <div class="flex flex-wrap justify-around ">
        <?php if (!empty($trending)) : ?>
          <?php foreach ($trending as $t) : ?>
          <?= $t->getHTML(); ?>
        <?php endforeach; ?>
        <?php else : ?>
          <p>No trending films found.</p>
        <?php endif; ?>

      </div>

    </div>
  </section>

  <!-- new release movies -->
  <section class="pt-16 pb-10 w-full">
    <div class="flex flex-col justify-center items-center  w-10/12  mx-auto relative ">
      <p class="lg:text-4xl md:text-3xl self-start  tracking-widest font-normal mb-16 uppercase">
        New Release - Movies
      </p>
      <div class="flex flex-wrap justify-around w-full">
        <?php if (!empty($newFilms)) : ?>
          <?php foreach ($newFilms as $n) : ?>
          <?= $n->getHTML(); ?>
        <?php endforeach; ?>
        <?php else : ?>
          <p>No New Release Movies films found.</p>
        <?php endif; ?>
      </div>

    </div>
  </section>

  <!-- new release series -->
  <section class="pt-16 pb-10 w-full">
    <div class="flex flex-col justify-center items-center  w-10/12  mx-auto relative ">
      <p class="lg:text-4xl md:text-3xl self-start  tracking-widest font-normal mb-16 uppercase">
        New Release - Series
      </p>
      <div class="flex flex-wrap justify-around w-full ">
        <?php if (!empty($newSeries)) : ?>
          <?php foreach ($newSeries as $n) : ?>
          <?= $n->getHTML(); ?>
        <?php endforeach; ?>
        <?php else : ?>
          <p>No New Release Series found.</p>
        <?php endif; ?>

      </div>

    </div>
  </section>
</main>
<script src="../crousel/crousel.js"></script>
<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>