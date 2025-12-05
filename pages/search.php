<?php
require_once "../config.php";
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();

use mdb\Search;
use renderers\filterForms\FilmFilter;
use renderers\filterForms\OthersFilter;

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
$filmFilter = new FilmFilter();
$content = $_GET['content'];

$search = new Search();
//filter films

if (!empty($_GET['type'])) {
    $from_date = isset($_GET['from_date']) ? htmlspecialchars($_GET['from_date']) : '';
    $to_date = isset($_GET['to_date']) ? htmlspecialchars($_GET['to_date']) : '';
    $visibility = isset($_GET['vu']) ? htmlspecialchars($_GET['vu']) : 'both';
    $type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
    $min_rating = isset($_GET['min_rating']) ? (int)$_GET['min_rating'] : 0;
    $max_rating = isset($_GET['max_rating']) ? (int)$_GET['max_rating'] : 10;
    $directors = isset($_GET['directors']) ? array_map('htmlspecialchars', $_GET['directors']) : [];

    $actors = isset($_GET['actors']) ? array_map('htmlspecialchars', $_GET['actors']) : [];
    $tags = isset($_GET['tags']) ? array_map('htmlspecialchars', $_GET['tags']) : [];

    $films = $search->filterFilm($from_date, $to_date, $type, $min_rating, $max_rating, $actors, $directors, $tags, $visibility, $userId);
} else {
    $films = $search->getAllFilms();
}
//filter others
if (!empty($_GET['films'])) {
    $filmsResult = isset($_GET['films']) ? array_map('htmlspecialchars', $_GET['films']) : [];
    if($content === "actors")
    $actors = $search->filterActorsByFilms($filmsResult);
    if($content === "directors")
    $directors = $search->filterDirectorsByFilms($filmsResult);
    if($content === "categories")
    $categories = $search->filterTagsByFilms($filmsResult);
} else {
    $actors = $search->getAllActors();
    $directors = $search->getAllDirectors();
    $categories = $search->getAllTags();
}



ob_start()
?>
<div class="text-white w-10/12 mx-auto">
    <p class="text-6xl text-center font-bold mb-16">Welcome To Our Mystery Search</p>
    <ul class="flex space-x-20 justify-center uppercase" id="options">
        <a href="search.php?content=films">
            <li id="films" class="flex space-x-2  px-4 py-2  justify-center items-center border-b-2 border-secondary shadow-lg cursor-pointer shadow-gray-700">
                <i class="fas fa-film text-2xl"></i>
                <p class="text-lg">Our films</p>
            </li>
        </a>
        <a href="search.php?content=actors">
            <li id="actors" class="flex space-x-2  px-4 py-2 justify-center items-center border-b-2 border-secondary shadow-lg cursor-pointer shadow-gray-700">
                <i class="fas fa-user text-2xl"></i>
                <p class="text-lg">Our actors</p>
            </li>
        </a>
        <a href="search.php?content=directors">
            <li id="directors" class="flex space-x-2  px-4 py-2 justify-center items-center border-b-2 border-secondary shadow-lg cursor-pointer shadow-gray-700">
                <i class="fas fa-user-tie text-2xl"></i>
                <p class="text-lg">Our directors</p>
            </li>
        </a>
        <a href="search.php?content=categories">
            <li id="categories" class="flex space-x-2  px-4 py-2 justify-center items-center border-b-2 border-secondary shadow-lg cursor-pointer shadow-gray-700">
                <i class="fas fa-tags text-2xl"></i>
                <p class="text-lg">Our categories</p>
            </li>
        </a>
    </ul>
    <div class="flex justify-center items-center mt-10 space-x-3">
        <!-- filterbtn to toggle filter popup-->
        <div class="flex px-5 space-x-2 lg:space-x-4 py-3 rounded-full shadow-md shadow-primary-light bg-white items-center text-black">
            <input type="text" id="search" placeholder="Search " class="lg:pr-8 lg:mr-2 xl:pr-24 xl:mr-5 outline-none capitalize bg-white text-lg tracking-widest placeholder-primary-light" />
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <button id="filterbtn" class="flex justify-center items-center bg-green-500 text-white px-10 py-3 rounded-full uppercase">
            <i class="fas fa-filter"></i>
            <p class="ml-2">Filter</p>
        </button>
        <a href="search.php?content=films"><button id="clear" class="flex justify-center items-center bg-red-500 text-white px-10 py-3 rounded-full uppercase">
                <i class="fas fa-times"></i>
                <p class="ml-2">Clear</p>
            </button></a>
    </div>
    <!-- Filter popup -->
    <div id="filterPopup" class="flex  fixed z-50 top-0 left-0 right-0 bg-black bg-opacity-80 hidden justify-center items-center w-screen h-screen">
        <div class="xl:w-7/12 w-11/12  relative  bg-white shadow-sm ">
            <?php if ($content === "films") : ?>
                <?= $filmFilter->generateForm(); ?>
            <?php else :
           
                $othersFilter = new OthersFilter($content);
            ?>

                <?= $othersFilter->generateForm(); ?>
            <?php endif; ?>
        </div>
        <i class="fas fa-xmark text-secondary hover:scale-150  absolute top-2 right-4 cursor-pointer text-4xl p-2"></i>
    </div>
    <div class=" w-10/12 mx-auto p-10 mt-16 transition-all delay-150" id="views">
        <section id="films" class="view flex flex-wrap justify-around">
            <?php if (!empty($films)) : ?>
                <?php foreach ($films as $f) : ?>
                    <?= $f->getHTML(); ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No films films found.</p>
            <?php endif; ?>
        </section>
        <section id="actors" class="view flex flex-wrap justify-around">
            <?php if (!empty($actors)) : ?>
                <?php foreach ($actors as $a) : ?>
                    <?= $a->getHTML(); ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No actors found.</p>
            <?php endif; ?>
        </section>
        <section id="directors" class="view flex flex-wrap justify-around">
            <?php if (!empty($directors)) : ?>
                <?php foreach ($directors as $d) : ?>
                    <?= $d->getHTML(); ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No directors found.</p>
            <?php endif; ?>
        </section>
        <section id="categories" class="view flex flex-wrap justify-around">
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $c) : ?>
                    <?= $c->getHTML(); ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No categories found.</p>
            <?php endif; ?>
        </section>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get URL content parameter
        const urlParams = new URLSearchParams(window.location.search);
        const content = urlParams.get("content");
        const views = document.querySelectorAll("#views section.view");
        const options = document.querySelectorAll("#options li");
        const filterPopup = document.getElementById("filterPopup");
        const filterBtn = document.getElementById("filterbtn");
        const closeFilter = document.querySelector("#filterPopup i.fa-xmark");
        const Search = document.getElementById("search");
        const ActiveCards = document.querySelectorAll(`#${content} article`);
        console.log(ActiveCards);
        const displayContent = (content) => {
            views.forEach(view => {
                if (view.id === content) {
                    view.classList.remove("hidden");
                } else {
                    view.classList.add("hidden");
                }
            });
            options.forEach(option => {
                if (option.id === content) {
                    option.classList.add("selected");
                } else {
                    option.classList.remove("selected");
                }
            });
        };

        if (content) {
            displayContent(content);
        } else {
            displayContent("films");
        }

        function toggleFilterPopup() {
            filterPopup.classList.toggle("hidden");
        }
        filterBtn.addEventListener("click", () => toggleFilterPopup());
        closeFilter.addEventListener("click", () => toggleFilterPopup());

        //live search using display non in order to keep only ActiveCards that have the input text
        Search.addEventListener('input', () => {
            // console.log(Search.value);
            if (Search.value == "") {
                ActiveCards.forEach((c) => {
                    c.style.display = "flex";
                })
            }
            ActiveCards.forEach((c) => {
                if (!c.innerText.toLowerCase().includes(Search.value.toLowerCase())) {
                    c.style.display = "none";
                } else {
                    c.style.display = "flex";
                }

            })
        })
    });
</script>

<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>