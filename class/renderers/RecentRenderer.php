<?php

namespace renderers;
class RecentRenderer
{
    private $titre;
    private $date_sortie;
    private $affiche;
    
    public function getHTML(){ ?>
    <a href="film.php?titre=<?= $this->titre ?>">
        <article class="flex  flex-shrink-0 flex-grow-0 w-[400px] justify-between items-center shadow-md shadow-gray-700 hover:scale-105 transition-all duration-300 ease-in-out">
            <img src="<?= \mdb\Film::getImage($this->affiche)?>" alt="" class="w-60 h-40 object-cover object-center rounded-l-lg">
            <div class="px-4 ">
              <p class="text-white"><?= $this->titre ?></p>
              <p class="text-white"><?= $this->date_sortie ?></p>
            </div>
          </article>
          </a>
    <?php }

}