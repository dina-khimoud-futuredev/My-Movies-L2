<?php

namespace renderers\searchRenderers;

class DirectorRenderer
{
    private $nom;
    private $photo;


    public function getHTML()
    {
?>
        <a href="director.php?name=<?= urlencode($this->nom) ?>">  
        <article class="flex flex-col space-y-2 pb-3 w-[300px] h-[300px] justify-center items-center shadow-inner shadow-yellow-400">
            <img src="<?= \mdb\Film::getImage($this->photo) ?>" alt="<?= $this->nom ?>" class="lg:h-60 w-[290px] h-40 object-cover">
            <p class="director-name"><?= $this->nom ?></p>
        </article>
        </a>
<?php }
}
