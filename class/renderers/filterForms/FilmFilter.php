<?php

namespace renderers\filterForms;

use mdb\Admin;

class FilmFilter
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



        <form id="film-filter" method="GET" enctype="multipart/form-data" class="w-10/12 mx-auto text-black flex flex-col h-[600px] items-center  p-10">
            <input type="hidden" name="content" value="films">
            <div class="flex justify-center items-center">
                <div>
                    <label for="from_date" class="block text-sm font-semibold text-primary mb-2 ">From Date</label>
                    <input type="date" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="from_date" name="from_date">
                </div>
                <div>
                    <label for="to_date" class="block text-sm font-semibold text-primary mb-2 ">To Date</label>
                    <input type="date" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="to_date" name="to_date">
                </div>

                <?php if (isset($_SESSION['userId'])) : ?>
                <div class="relative inline-block w-full">
                    <p class="text-sm font-semibold text-primary mb-2">Visibility</p>
                    <div class="flex justify-between items-center w-[250px] h-[60px] mx-3 p-2 bg-white border rounded-md cursor-pointer focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                        <input type="radio" value="vu" id="vu" name="vu"> Seen
                        <input type="radio" value="nonvu" id="nonvu" name="vu"> Non Seen
                        <input type="radio" value="both" id="both" name="vu" checked> Both
                    </div>
                </div>
                <?php endif; ?>

            </div>
            <div class="flex justify-center items-center my-8">
                <div>
                    <label for="type" class="block text-sm font-semibold text-primary mb-2 ">Type</label>
                    <select id="type" name="type" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                        <option value="All">All</option>
                        <option value="film">Film</option>
                        <option value="serie">Serie</option>
                    </select>
                </div>
                <div>
                    <label for="min_rating" class="block text-sm font-semibold text-primary mb-2 ">Minimum rating</label>
                    <input min="0" max="9" value="0" type="number" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="min_rating" name="min_rating">
                </div>
                <div>
                    <label for="max_rating" class="block text-sm font-semibold text-primary mb-2 ">Maximum rating</label>
                    <input min="1" max="10" value="10" type="number" class="block w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="max_rating" name="max_rating">
                </div>

            </div>
            <div class="flex justify-around items-center">
                <div>
                    <div class="relative inline-block w-full">
                        <p class="text-sm font-semibold text-primary mb-2 ">With Directors</p>
                        <div id="addDirectorBtn" class=" flex justify-between items-center w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md cursor-pointer focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                            <p>Select Directors</p>
                            <i id="directors-dropdown-icon" class="fas fa-caret-down"></i>
                        </div>
                        <div id="directors-dropdown" class="absolute z-90 hidden w-full mt-2 overflow-hidden bg-white border rounded-md shadow-lg max-h-32 overflow-y-auto">

                            <?php foreach ($directors as $director) : ?>
                                <div class="px-4 py-2 border-b hover:bg-secondary hover:text-white ">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="directors[]" value="<?= $director->id ?>" class="form-checkbox">
                                        <span class="ml-2"><?= htmlspecialchars($director->nom) ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
                <div>
                    <div class="relative inline-block w-full">
                        <p class="text-sm font-semibold text-primary mb-2 ">With Actors</p>
                        <div id="addActorBtn" class=" flex justify-between items-center w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md cursor-pointer focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                            <p>Select actors</p>
                            <i id="actors-dropdown-icon" class="fas fa-caret-down"></i>
                        </div>
                        <div id="actors-dropdown" class="absolute z-90 hidden w-full mt-2 overflow-hidden bg-white border rounded-md shadow-lg max-h-32 overflow-y-auto">

                            <?php foreach ($actors as $actor) : ?>
                                <div class="px-4 py-2 border-b hover:bg-secondary hover:text-white ">
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
                        <p class="text-sm font-semibold text-primary mb-2 ">With Tags</p>
                        <div id="addTagBtn" class=" flex justify-between items-center w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md cursor-pointer focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                            <p>Select Tags</p>
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
                    </div>
                </div>

            </div>
            <div class="flex space-x-7 text-xl items-center pt-7 mt-auto w-full justify-center ">
                <button type="submit" class="px-4 py-2 text-white l rounded-md bg-green-600 focus:outline-none focus:bg-blue-600">Apply Filters</button>
                <button type="reset" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">Reset</button>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
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
                const addDirector = document.getElementById("addDirectorBtn");

                addActorBtn.addEventListener("click", function() {
                    toggleDropdown("actors-dropdown");
                });
                addTagBtn.addEventListener("click", function() {
                    toggleDropdown("tags-dropdown");
                });
                addDirector.addEventListener("click", function() {
                    toggleDropdown("directors-dropdown");
                });


            });
        </script>
<?php
    }
}

?>