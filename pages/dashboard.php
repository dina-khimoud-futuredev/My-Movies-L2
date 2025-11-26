<?php
require_once "../config.php";
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();


use mdb\Admin;
use renderers\adminForms\AddCategory;
use renderers\adminForms\AddFilm;

$admin = new Admin();
$AddFilm = new AddFilm();
ob_start()
?>
<p class="lg:text-4xl md:text-3xl text-2xl uppercase text-white text-center mb-4">Dashboard</p>
<div class="w-10/12 flex space-x-4 justify-center  mx-auto">
    <!-- options -->
    <div class="flex flex-col space-y-10 uppercase text-white w-2/12 ">
        <div class="px-4 py-2 bg-white text-primary text-center shadow-lg cursor-pointer shadow-gray-700">
            Options
        </div>
        <ul class="flex flex-col space-y-4" id="options">
            <!-- users -->
            <li class="selected flex flex-col space-y-2 justify-center items-center border-b-2 border-secondary shadow-lg cursor-pointer shadow-gray-700">
                <i class="fas fa-users text-2xl"></i>
                <p class="text-lg">Users</p>
            </li>
            <!-- add film -->
            <li  class="flex flex-col space-y-2 justify-center items-center border-b-2 border-secondary shadow-lg cursor-pointer shadow-gray-700">
                <i class="fas fa-film text-2xl"></i>
                <p class="text-lg">Add Film</p>
            </li>
            <!-- add category -->
            <li  id="op-3" class="flex flex-col space-y-2 justify-center items-center border-b-2 border-secondary shadow-lg cursor-pointer shadow-gray-700">
                <i class="fas fa-tags text-2xl"></i>
                <p class="text-lg">Add category</p>
            </li>
            <!-- add actor -->
            <li id="op-4" class="flex flex-col space-y-2 justify-center items-center border-b-2 border-secondary shadow-lg cursor-pointer shadow-gray-700">
                <i class="fas fa-user text-2xl"></i>
                <p class="text-lg">Add actor</p>
            </li>
            <!-- add director -->
            <li id="op-5" class="flex flex-col space-y-2 justify-center items-center border-b-2 border-secondary shadow-lg cursor-pointer shadow-gray-700">
                <i class="fas fa-user-tie text-2xl"></i>
                <p class="text-lg">Add director</p>
            </li>
        </ul>
    </div>
    <!-- views -->
    <div id="views" class="w-10/12 justify-center items-center text-white overflow-y-auto">
        <div id="1" class=" view">
            <section class="pt-16 pb-10 w-full">
                <div class="flex flex-col justify-center items-center  w-10/12  mx-auto relative ">
                    <p class="lg:text-4xl md:text-3xl self-start text-2xl tracking-widest font-normal mb-16">
                        Users
                    </p>
                    <div class="flex flex-wrap justify-around w-full ">
                        <?php 
                        $users=$admin->getAllUsers();
                        if (!empty($users)) : ?>
                            <?php foreach ($users as $n) : ?>
                                <?= $n->getHTML(); ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No New Release Movies films found.</p>
                        <?php endif; ?>
                    </div>

                </div>
            </section>
        </div>
        <div id="2" class="hidden view">
        <section class="pt-16 pb-10 w-full">
                <div class="flex flex-col justify-center items-center  w-10/12  mx-auto relative ">
                    <p class=" lg:text-4xl md:text-3xl self-start text-2xl tracking-widest font-normal">
                        add film
                    </p>
                    <?php
                     if(empty($_POST['titre'])){
                        $AddFilm->generateForm() ;
                    }else{
                        $imgFile = isset($_FILES['affiche']) ? $_FILES['affiche'] : null ;
                        $tags = isset($_POST['tags']) ? $_POST['tags'] : [] ;
                        $actors = isset($_POST['actors']) ? $_POST['actors'] : [] ;
                        $AddFilm->createFilm($_POST['titre'], $_POST['date_sortie'], $_POST['realisateur_id'], $_POST['type'], $_POST['synopsis'],$_POST['trailerLink'], $imgFile, $actors, $tags);
                    }
                    ?>
                </div>
            </section>

        </div>
        <div id="3" class="hidden view">
            <section class="pt-16 pb-10 w-full">
                <div class="flex flex-col justify-center items-center w-10/12 mx-auto relative">
                    <p class="lg:text-4xl md:text-3xl self-start text-2xl tracking-widest font-normal">
                        Add Category
                    </p>
                    <?php
                    use renderers\adminForms\AddActor;
                    $addCategory = new AddCategory();
                    if (empty($_POST['CategoryNom'])) {
                        $addCategory->generateForm();
                    } else {
                        $addCategory->createCategory($_POST['CategoryNom']);
                    }
                    ?>
                </div>
            </section>
        </div>
        <div id="4" class="hidden view">
    <section class="pt-16 pb-10 w-full">
        <div class="flex flex-col justify-center items-center w-10/12 mx-auto relative">
            <p class="lg:text-4xl md:text-3xl self-start text-2xl tracking-widest font-normal">
                Add Actor
            </p>
            <?php
            $addActor = new AddActor();
            if (empty($_POST['nom'])) {
                $addActor->generateForm();
            } else {
                $imgFile = isset($_FILES['image']) ? $_FILES['image'] : null;
                $addActor->createActor($_POST['nom'], $imgFile);
            }
            ?>
        </div>
    </section>
</div>

        <div id="5" class="hidden view">
        <section class="pt-16 pb-10 w-full">
        <div class="flex flex-col justify-center items-center w-10/12 mx-auto relative">
            <p class="lg:text-4xl md:text-3xl self-start text-2xl tracking-widest font-normal">
                Add Director
            </p>
            <?php
             use renderers\adminForms\AddDirector;
            $addDirector = new AddDirector();
            if (empty($_POST['DirectorNom'])) {
                $addDirector->generateForm();
            } else {
                $imgFile = isset($_FILES['DirectorImage']) ? $_FILES['DirectorImage'] : null;
                $addDirector->createDirector($_POST['DirectorNom'], $imgFile);
            }
            ?>
        </div>
    </section>
        </div>
    </div>


</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // get all options
        const options = document.querySelectorAll("#options li");
        // get all views
        const views = document.querySelectorAll("#views div.view");
        // loop through options
        options.forEach((option, index) => {
            // add click event listener
            option.addEventListener("click", function() {
                // remove selected class from all options
                options.forEach(option => option.classList.remove("selected"));
                // add selected class to clicked option
                option.classList.add("selected");
                // hide all views
                views.forEach(view => view.classList.add("hidden"));
                // show view with same index as clicked option
                views[index].classList.remove("hidden");
            });
        });

    });
</script>
<?php $content = ob_get_clean() ?>
<?php Template::render($content) ?>