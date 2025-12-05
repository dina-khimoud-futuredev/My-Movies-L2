<?php

namespace renderers;

class NewFilmRenderer
{
    private $titre;
    private $date_sortie;
    private $affiche;
    private $rating;

    public function getHTML()
    { ?>

        <article class="cart flex flex-col items-center  relative rounded-xl shadow-lg  pb-3 mb-10 w-[250px] hover:scale-105 transition-all duration-300 ease-in-out">
            <div class="relative group">
                <img src="<?= \mdb\Film::getImage($this->affiche) ?>" alt="Food Image" class=" w-[250px] h-[300px] rounded-t-xl object-cover object-center" />
                <div class="hidden group-hover:flex absolute bg-white top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-lg shadow-lg">

                    <div class="px-3 py-2 text-primary uppercase">
                        <a href="film.php?titre=<?= $this->titre ?> ">view <i class="fa-regular fa-eye w-3 h-3 ml-1 text-primary cursor-pointer"></i> </a>
                    </div>
                </div>
            </div>
            <div class="desc flex justify-between w-full text-sm">
                <p class="name text-pwhite font-bold py-2 "><?= $this->titre ?></p>
                <div class="resolution flex justify-center items-center space-x-1 ">
                    <span class="tag bg-secondary px-1  ">HD</span>
                    <span class="rating border border-secondary px-1"><i class="fas fa-star mr-1"></i><?= $this->rating ?> </span>
                </div>
            </div>
            <span class="absolute top-0 left-0 bg-red-500 text-white px-4 py-1 rounded-tl-xl rounded-br-xl"><?= $this->date_sortie ?></span>
        </article>

<?php }
}
