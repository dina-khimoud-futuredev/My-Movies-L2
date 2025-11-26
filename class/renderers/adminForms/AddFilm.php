<?php

namespace renderers\adminForms;

use mdb\Admin;

class AddFilm
{
    private $admin;

    public function __construct()
    {
        $this->admin = new Admin();
    }

    public function generateForm()
    {
        $directors = $this->admin->getAllDirectors();
        $actors = $this->admin->getAllActors();
        $tags = $this->admin->getAllTags();
?>


        <div id="error" class="hidden w-10/12 mx-auto bg-red-200 text-lg py-1 font-semibold text-center mt-10">
            <p class="text-red-600 text-center">you must select one tag and one actor as minimum </p>
        </div>
        <form id="film-form" method="POST" enctype="multipart/form-data" class="w-10/12 mx-auto text-black flex flex-col h-[500px] overflow-y-auto items-center space-y-4 p-10">
            <div class="flex justify-center items-center">
                <div>
                    <label for="titre" class="block text-sm font-semibold text-white mb-2 ">Title</label>
                    <input required type="text" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="titre" name="titre" aria-describedby="titre">
                </div>
                <div>
                    <label for="date_sortie" class="block text-sm font-semibold text-white mb-2 ">Release Date</label>
                    <input required type="date" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="date_sortie" name="date_sortie">
                </div>

            </div>
            <div class="flex justify-center ">
                <div>
                    <label for="realisateur_id" class="block text-sm font-semibold text-white mb-2 ">Director</label>
                    <select required id="realisateur_id" name="realisateur_id" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                        <?php foreach ($directors as $director) : ?>
                            <option value="<?= $director->id ?>" class="py-5 hover:bg-secondary hover:text-white"><?= htmlspecialchars($director->nom) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button id="addDirector" type="submit" class="text-green-500 ml-4 cursor-pointer ">
                        Add Director Now!
                    </button>
                </div>
                <div>
                    <label for="type" class="block text-sm font-semibold text-white mb-2">Type</label>
                    <select required id="type" name="type" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                        <option value="film">Film</option>
                        <option value="serie">Serie</option>
                    </select>
                </div>

            </div>


            <div>
                <label for="description" class="block text-sm font-semibold text-white mb-2 ">Description</label>
                <textarea required class="block w-[520px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="description" name="synopsis"></textarea>
            </div>
            <div class="flex justify-around items-center">
                <div>
                    <div class="relative inline-block w-full">
                        <p class="text-sm font-semibold text-white mb-2 ">Actors</p>
                        <div id="addActorBtn" class=" flex justify-between items-center w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md cursor-pointer focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                            <p>Add actors</p>
                            <i id="actors-dropdown-icon" class="fas fa-caret-down"></i>
                        </div>
                        <div id="actors-dropdown" class="absolute z-90 hidden w-full mt-2 overflow-hidden bg-white border rounded-md shadow-lg max-h-32 overflow-y-auto">
                            <?php foreach ($actors as $actor) : ?>
                                <div class="px-4 py-2 border-b hover:bg-secondary hover:text-white  ">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="actors[]" value="<?= $actor->id ?>" class="form-checkbox">
                                        <span class="ml-2"><?= htmlspecialchars($actor->nom) ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button id="addActor" type="submit" class="text-green-500 ml-4 cursor-pointer ">
                            Add Actor Now!
                        </button>
                    </div>
                </div>
                <div>
                    <div class="relative inline-block w-full">
                        <p class="text-sm font-semibold text-white mb-2 ">Tags</p>
                        <div id="addTagBtn" class=" flex justify-between items-center w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md cursor-pointer focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                            <p>Add Tags</p>
                            <i id="tags-dropdown-icon" class="fas fa-caret-down"></i>
                        </div>
                        <div id="tags-dropdown" class="absolute z-90 hidden w-full mt-2 overflow-hidden bg-white border rounded-md shadow-lg max-h-32 overflow-y-auto">
                            <?php foreach ($tags as $tag) : ?>
                                <div class="px-4 py-2 border-b  hover:bg-secondary hover:text-white">
                                    <label class="inline-flex items-center ">
                                        <input type="checkbox" name="tags[]" value="<?= $tag->id ?>" class="form-checkbox">
                                        <span class="ml-2"><?= htmlspecialchars($tag->nom) ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button id="addTag" type="submit" class="text-green-500 ml-4 cursor-pointer ">
                            Add Tag Now!
                        </button>
                    </div>
                </div>

            </div>
            <!-- ayoub was here -->
            <div>
                <label for="trailer" class="block text-sm font-semibold text-white mb-2 ">Trailer Link</label>
                <input required class="block w-[520px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="trailer" name="trailerLink"></input>
            </div>
            <!-- ayoub was here -->
            <div>
                <label for="image" class="block text-sm font-semibold text-white mb-2 ">Image</label>
                <input required type="file" class="block w-[520px] px-4 py-2 mt-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40 mb-4" id="affiche" name="affiche" accept="image/png, image/gif, image/jpeg">
                <div id="preview-container" class=" flex justify-center rounded-md">
                    <img id="preview-image" src="" class="object-cover max-h-[500px] max-w-[600px]">
                </div>
            </div>


            <div class="flex space-x-7 text-xl items-center pt-7">
                <button type="submit" class="px-4 py-2 text-white l rounded-md bg-green-600 focus:outline-none focus:bg-blue-600">Add</button>
                <button type="reset" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">Reset</button>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const error = document.getElementById("error");
                const actorInput = document.querySelectorAll('input[name="actors[]"]');
                const tagInput = document.querySelectorAll('input[name="tags[]"]');
                let actorChecked = false;
                let tagChecked = false;

                // Image preview
                const preview = document.getElementById("preview-image");
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

                // Form validation
                let form = document.getElementById("film-form");
                let titre = document.getElementById("titre");
                form.addEventListener('submit', (ev) => {
                    actorInput.forEach(input => {
                        if (input.checked) {
                            actorChecked = true;
                        }
                    });
                    tagInput.forEach(input => {
                        if (input.checked) {
                            tagChecked = true;
                        }
                    });
                    if (titre.value == "") {
                        titre.classList.add("border-red-500");
                        ev.preventDefault();

                    }
                    if (!actorChecked || !tagChecked) {
                        error.classList.remove("hidden");
                        ev.preventDefault();

                    } else {
                        error.classList.add("hidden");
                    }

                });
                titre.addEventListener('keydown', () => {
                    titre.classList.remove("border-red-500");
                });

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



                // go to add entities 
                const addDirector = document.getElementById("addDirector");
                const addActor = document.getElementById("addActor");
                const addTag = document.getElementById("addTag");
                const views = document.querySelectorAll("#views div.view");
                const options = document.querySelectorAll("#options li");
                const goToView = (id) => {
                    views.forEach(view => {
                        view.classList.add("hidden");
                    });
                    options.forEach(option => {
                        option.classList.remove("selected");
                    });
                    const SelectedView = document.getElementById(id);
                    const SelectedOption = document.getElementById("op-" + id);
                    SelectedView.classList.remove("hidden");
                    SelectedOption.classList.add("selected");
                }
                addDirector.addEventListener("click", function() {
                    goToView(5);
                });
                addActor.addEventListener("click", function() {
                    goToView(4);
                });
                addTag.addEventListener("click", function() {
                    goToView(3);
                });

            });
        </script>
<?php
    }

    public function createFilm($titre, $date_sortie, $realisateur_id, $type, $description = null ,$trailer=null, $imgFile = null, $actors = [], $tags = [])
    {
        $film_id = $this->admin->createFilm($titre, $date_sortie, $realisateur_id, $type, $description,$trailer, $imgFile);

        // Add actors to the film
        foreach ($actors as $actor_id) {
            $this->admin->addActorToFilm($film_id, $actor_id);
        }

        // Add tags to the film
        foreach ($tags as $tag_id) {
            $this->admin->addTagToFilm($film_id, $tag_id);
        }
        header('Location: search.php?content=films');
        exit();
    }
}

?>