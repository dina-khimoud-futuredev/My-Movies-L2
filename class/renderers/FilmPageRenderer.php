<?php

namespace renderers;

use mdb\Admin;

class FilmPageRenderer
{
    private $id;
    private $titre;
    private $tags;
    private $date_sortie;
    private $affiche;
    private $realisateur_nom;
    private $realisateur_photo;
    private $rating;
    private $type;
    private $acteurs_noms;
    private $acteurs_photos;
    private $synopsis;
    private $isVue;
    private $trailer;




    public function getHTML()
    {
        $tags = explode(',', $this->tags);
        $acteurs_noms = explode(',', $this->acteurs_noms);
        $acteurs_photos = explode(',', $this->acteurs_photos);
        $realisateur = (object) ['nom' => $this->realisateur_nom, 'photo' => $this->realisateur_photo];
        $trailer = str_replace("watch?v=", "embed/", $this->trailer);
        $admin = new Admin();
        $actors = $admin->getAllActors();
        $directors = $admin->getAllDirectors();
        $tagsEdit = $admin->getAllTags();

?>
        <!-- video trailer -->
        <?php if ($this->trailer) : ?>
            <section class="flex flex-col items-center space-y-4 justify-center">
                <p class="lg:text-4xl md:text-3xl text-2xl uppercase text-white">Trailer</p>
                <div class="relative rounded-sm border-2 border-secondary">
                    <iframe class="2xl:h-[480px] 2xl:w-[900px] w-[400px] h-[250px] md:w-[700px] md:h-[400px]" src="<?= $trailer ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </section>
        <?php endif; ?>

        <!-- movie details -->
        <section class="flex flex-col lg:flex-row justify-center items-center w-full p-10">
            <!-- movie poster -->
            <div class="lg:w-1/3 h-full rounded-sm">
                <img src="<?= \mdb\Film::getImage($this->affiche)  ?>" alt="movie poster" class="rounded-lg object-cover object-center h-96" />
            </div>
            <!-- movie details -->
            <div class="flex flex-col lg:w-2/3 space-y-4 lg:mx-8">
                <div class="flex py-4 lg:p-0 justify-between items-center">
                    <p class="text-3xl text-white"><?= $this->titre ?></p>
                    <form id="vues-form" method="POST" action="">
                        <input type="hidden" name="film_id" value="<?= $this->id; ?>">
                        <?php if (isset($_SESSION['userId'])) : ?>

                            <?php if ($this->isVue) : ?>
                                <input type="hidden" name="action" value="removefromvue">
                                <span class="text-green-500 font-bold mr-3">Vued </span>
                                <button type="submit" class="px-3 py-2 bg-secondary text-white cursor-pointer hover:animate-pulse rounded-md add-to-vues-btn">
                                    Remove from Vues <i class="fas fa-minus ml-3 text-white"></i>
                                </button>
                            <?php else : ?>
                                <input type="hidden" name="action" value="addtovue">
                                <span class="text-red-500 font-bold mr-3">Not Vued </span>
                                <button type="submit" class="px-3 py-2 bg-secondary text-white cursor-pointer hover:animate-pulse rounded-md add-to-vues-btn">
                                    Add to Vues <i class="fas fa-plus ml-3 text-white"></i>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="flex space-x-4 items-center text-white">
                    <div class="tags flex space-x-3 font-bold text-primary">
                        <?php foreach ($tags as $tag) : ?>
                            <a href="tag.php?name=<?= $tag ?>"> <span class="tag bg-white px-2 py-1 rounded-lg"><?= $tag ?></span>
                            <?php endforeach; ?>
                    </div>

                </div>
                <div class="flex space-x-4 items-center text-white">
                    <div class="date">
                        <i class="fas fa-calendar mr-1"></i>
                        <span><?= $this->date_sortie ?></span>
                    </div>
                    <div class="type uppercase">
                        <i class="fas fa-tags mr-1"></i>
                        <span><?= $this->type ?></span>
                    </div>
                    <div class="rating">
                        <i class="fas fa-star mr-1"></i>
                        <span><?= $this->rating ?></span>
                    </div>
                </div>
                <div class="description w-full">
                    <p class="text-white"><?= $this->synopsis ?></p>
                </div>
                <!-- other details -->
                <div class="flex flex-col  text-white font-bold">
                    <p>Country : <span class="font-normal country">United States</span></p>
                    <p>Genre : <span class="font-normal genre"><?= implode(', ', $tags) ?></span></p>
                    <p>Release date : <span class="font-normal release-date"><?= $this->date_sortie ?></span></p>
                    <p>Production : <span class="font-normal production">AMC studio</span></p>
                </div>
            </div>
        </section>

        <!-- cast -->
        <section class="w-full text-white py-10">
            <div class="flex flex-col justify-center items-center w-10/12 mx-auto relative uppercase px-1">
                <p class="lg:text-4xl md:text-3xl text-2xl tracking-widest font-normal">Actors</p>
                <i class="fas fa-circle mb-16 mt-3 text-yellow-400"></i>
                <div class="custom-scrollbar pb-5 flex w-full space-x-6 overflow-x-auto flex-nowrap">
                    <?php for ($i = 0; $i < count($acteurs_noms); $i++) : ?>
                        <a href="actor.php?name=<?= urlencode($acteurs_noms[$i]) ?>">
                            <div class="flex flex-col space-y-2 flex-shrink-0 pb-3 flex-grow-0 justify-center items-center shadow-md shadow-gray-700">
                                <img src="<?= \mdb\Film::getImage($acteurs_photos[$i]) ?>" alt="<?= $acteurs_noms[$i] ?>" class="lg:w-60 lg:h-60 w-40 h-40 object-cover">
                                <p class="actor-name"><?= $acteurs_noms[$i] ?></p>
                            </div>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

        <!-- director -->
        <section class="w-10/12 mx-auto flex flex-col justify-center items-center text-white py-10 uppercase">
            <p class="lg:text-4xl md:text-3xl text-2xl tracking-widest font-normal mb-16">
                <i class="fas fa-star text-yellow-400"></i> Director <i class="fas fa-star text-yellow-400"></i>
            </p>
            <a href="director.php?name=<?= urlencode($realisateur->nom) ?> ">
                <div class="flex flex-col space-y-2 pb-3 w-[300px] h-[300px] justify-center items-center shadow-inner shadow-yellow-400">
                    <img src="<?= \mdb\Film::getImage($realisateur->photo) ?>" alt="<?= $realisateur->nom ?>" class="lg:h-60 w-[290px] h-40 object-cover">
                    <p class="actor-name"><?= $realisateur->nom ?></p>
                </div>
            </a>
        </section>
        <?php if ($_SESSION['role'] == 'admin') : ?>
            <div class="flex justify-center items-cente uppercase ">
                <form action="" method="post">
                    <input type="hidden" name="film_id" value="<?= $this->id ?>">
                    <button type="submit" name="deleteFilm" class="px-3 mb-4 py-2 bg-secondary text-white cursor-pointer hover:animate-pulse rounded-md add-to-vues-btn">
                        Delete Film <i class="fas fa-trash ml-3 text-white"></i>
                    </button>
                </form>
                <button type="submit" name="EditFilm" class="px-3 mb-4 ml-10 py-2 bg-green-500 text-white cursor-pointer hover:animate-pulse rounded-md add-to-vues-btn">
                    Edit Film <i class="fas fa-pen-to-square ml-3 text-white"></i>
                </button>
            </div>
        <?php endif; ?>


        <!-- edit pop up -->
        <div id="EditActorPopup" class="flex text-primary fixed z-50 top-0 left-0 right-0 bg-black bg-opacity-80 hidden justify-center items-center w-screen h-screen">
            <form id="film-form" method="POST" enctype="multipart/form-data" class="w-10/12 mx-auto bg-white text-black flex flex-col overflow-y-auto items-center space-y-4 p-10">
                <div class="flex justify-center items-center ">
                    <div>
                        <label for="titre" class="block text-sm font-semibold text-black mb-2 ">Title</label>
                        <input required value="<?=$this->titre?>" type="text" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="titre" name="titre" aria-describedby="titre">
                    </div>
                    <div>
                        <label for="date_sortie" class="block text-sm font-semibold text-black mb-2 ">Release Date</label>
                        <input required type="date" value="<?=$this->date_sortie?>" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="date_sortie" name="date_sortie">
                    </div>

                </div>
                <div class="flex justify-center ">
                    <div>
                        <label for="realisateur_id" class="block text-sm font-semibold text-black mb-2 ">Director</label>
                        <select required id="realisateur_id" name="realisateur_id" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                            <?php foreach ($directors as $director) : ?>
                                <option value="<?= $director->id ?>" class="py-5 hover:bg-secondary hover:text-black"><?= htmlspecialchars($director->nom) ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div>
                        <label for="type" class="block text-sm font-semibold text-black mb-2">Type</label>
                        <select required id="type" name="type" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                            <option value="film">Film</option>
                            <option value="serie">Serie</option>
                        </select>
                    </div>

                </div>


                <div>
                    <label for="description" class="block text-sm font-semibold text-black mb-2 ">Description</label>
                    <input required  value="<?=$this->synopsis?>"  class="block w-[520px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="description" name="synopsis"></input>
                </div>
                <div class="flex justify-around items-center">
                    <div>
                        <div class="relative inline-block w-full">
                            <p class="text-sm font-semibold text-black mb-2 ">Actors</p>
                            <div id="addActorBtn" class=" flex justify-between items-center w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md cursor-pointer focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                                <p>Add actors</p>
                                <i id="actors-dropdown-icon" class="fas fa-caret-down"></i>
                            </div>
                            <div id="actors-dropdown" class="absolute z-90 hidden w-full mt-2 overflow-hidden bg-white border rounded-md shadow-lg max-h-32 overflow-y-auto">
                                <?php foreach ($actors as $actor) : ?>
                                    <div class="px-4 py-2 border-b hover:bg-secondary hover:text-black  ">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="actors[]" value="<?= $actor->id ?>" class="form-checkbox">
                                            <span class="ml-2"><?= htmlspecialchars($actor->nom) ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                    <div>
                        <div class="relative inline-block w-full">
                            <p class="text-sm font-semibold text-black mb-2 ">Tags</p>
                            <div id="addTagBtn" class=" flex justify-between items-center w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md cursor-pointer focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                                <p>Add Tags</p>
                                <i id="tags-dropdown-icon" class="fas fa-caret-down"></i>
                            </div>
                            <div id="tags-dropdown" class="absolute z-90 hidden w-full mt-2 overflow-hidden bg-white border rounded-md shadow-lg max-h-32 overflow-y-auto">
                                <?php foreach ($tagsEdit as $tag) : ?>
                                    <div class="px-4 py-2 border-b  hover:bg-secondary hover:text-black">
                                        <label class="inline-flex items-center ">
                                            <input type="checkbox" name="tags[]" value="<?= $tag->id ?>" class="form-checkbox">
                                            <span class="ml-2"><?= htmlspecialchars($tag->nom) ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- ayoub was here -->
                <div>
                    <label for="trailer" class="block text-sm font-semibold text-black mb-2 ">Trailer Link</label>
                    <input required  value="<?=$this->trailer?>"   class="block w-[520px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="trailer" name="trailerLink"></input>
                </div>
                <!-- ayoub was here -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-black mb-2 ">Image</label>
                    <input required type="file" class="block w-[520px] px-4 py-2 mt-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40 mb-4" id="affiche" name="affiche" accept="image/png, image/gif, image/jpeg">
                    <div id="preview-container" class=" flex justify-center rounded-md">
                        <img id="preview-image" src="<?= \mdb\Film::getImage($this->affiche) ?>" class="object-cover max-h-[500px] max-w-[600px]">
                    </div>
                </div>


                <div class="flex space-x-7 text-xl items-center pt-7">
                    <button type="submit" class="px-4 py-2 text-white l rounded-md bg-green-600 focus:outline-none focus:bg-blue-600">Edit</button>
                    <button type="reset" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">Reset</button>
                </div>
            </form>
            <i class="fas close-btn fa-xmark text-secondary hover:scale-150  absolute top-2 right-4 cursor-pointer text-4xl p-2"></i>
        </div>
        <script>
            const EditActorPopup = document.getElementById('EditActorPopup');
            const EditActorBtn = document.querySelector('button[name="EditFilm"]');
            const closeEditActorPopup = document.querySelector(".close-btn");
            EditActorBtn.addEventListener('click', () => {
                EditActorPopup.classList.remove('hidden');
            });
            closeEditActorPopup.addEventListener('click', () => {
                EditActorPopup.classList.add('hidden');
            });

            const preview = document.querySelector(".ActorImg");
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
            }

            const fileInput = document.getElementById("affiche");
            fileInput.addEventListener('change', () => {
                let file = fileInput.files[0];
                if (file && file.type.split('/')[0] === "image") {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                }
            });

            // const EditImage = document.getElementById('editImage');
            // const ImageInput = document.getElementById('ActorImage');
            // EditImage.addEventListener('click', () => {
            //     ImageInput.classList.remove('hidden');

            // });


            function toggleDropdown(dropdownId) {
                    var dropdown = document.getElementById(dropdownId);
                    var DropIcon = document.getElementById(dropdownId + "-icon");
                    dropdown.classList.toggle("hidden");
                    if (dropdown.classList.contains("hidden")) {
                        DropIcon.classList.remove("fa-caret-up");
                        DropIcon.classList.add("fa-caret-down");
                    } else {
                        DropIcon.classList.remove("fa-caret-down");
                        DropIcon.classList.add("fa-caret-up");
                    }
                }
                const addActorBtn = document.getElementById("addActorBtn");
                const addTagBtn = document.getElementById("addTagBtn");

                addActorBtn.addEventListener("click", function() {
                    toggleDropdown("actors-dropdown");
                });
                addTagBtn.addEventListener("click", function() {
                    toggleDropdown("tags-dropdown");
                });
        </script>
<?php
    }
}
