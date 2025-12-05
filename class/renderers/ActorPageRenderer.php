<?php 

namespace renderers\searchRenderers;

class ActorPageRenderer {
    private $name;
    private $photo;
    private $films;

    public function __construct($name, $photo, $films) {
        $this->name = $name;
        $this->photo = $photo;
        $this->films = $films;
    }

    public function getHTML() {
        ?>
        <div class="actor-page">
            <h1><?php echo $this->name; ?></h1>
            <img src="<?php echo $this->photo; ?>" alt="<?php echo $this->name; ?>">
            <h2>Films</h2>
            <ul>
                <?php foreach ($this->films as $film) { ?>
                    <li><a href="film.php?titre=<?php echo urlencode($film->titre); ?>"><?php echo $film->titre; ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <?php
    }
}
