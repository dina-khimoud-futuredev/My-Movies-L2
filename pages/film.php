<?php
require_once "../config.php";
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();

use mdb\Film;

$film = new Film();
$titre= $_GET['titre'];
$CurrentFilm = $film->getFilm($titre,$_SESSION['userId']);
if(isset($_POST['action'])){
 $film->toggleVue($_POST['action'],$_POST['film_id'] ,$_SESSION['userId']);
header("location:films_seen.php");

}
if (isset($_POST['deleteFilm'])) {
    $film_id = $_POST['film_id'];
    $film->DeleteFilm($film_id);
    header("Location: search.php?content=films");
}

ob_start()
?>


    <div class="w-full 2xl:w-9/12  xl:10/12 mx-auto space-y-4 flex flex-col justify-center items-center">
     <?php $CurrentFilm->getHTML()   ?>
    </div>

<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>