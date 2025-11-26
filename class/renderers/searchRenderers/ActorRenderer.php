<?php

namespace renderers\searchRenderers;

class ActorRenderer
{
    private $nom;
    private $photo;


    public function getHTML()
    {
?>       <a href="actor.php?name=<?= urlencode($this->nom) ?>">  
        <article class="flex flex-col space-y-2 flex-shrink-0 pb-3 mb-4 flex-grow-0 justify-center items-center shadow-md shadow-gray-700">
            <img src="<?= \mdb\Film::getImage($this->photo) ?>" alt="<?= $this->nom ?>" class="lg:w-60 lg:h-60 w-40 h-40 object-cover">
            <p class="actor-name"><?= $this->nom ?></p>
        </article>
        </a>
<?php }
}
