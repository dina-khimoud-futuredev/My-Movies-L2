<?php

namespace renderers\searchRenderers;

class TagRenderer
{
    private $nom;
    public function getHTML()
    {
?>       <a href="tag.php?name=<?= urlencode($this->nom) ?>">  
        <article class="flex  w-[300px] h-[100px] mb-6 justify-center items-center shadow-inner shadow-white bg-[url('../images/tag-bg.jpeg')] bg-contain">
            <p class="director-name text-4xl"><?= $this->nom ?></p>
        </article>
        </a>
<?php }
}
