<?php

namespace renderers\filterForms;

use mdb\Admin;

class OthersFilter
{
    private $admin;
    private $filter;
    public function __construct($filter)
    {
        $this->filter = $filter;

        $this->admin = new Admin();
    }

    public function generateForm()
    {
        $Films = $this->admin->getAllFilms();
?>



        <form id="others-filter" method="GET" enctype="multipart/form-data" class="w-10/12 mx-auto text-black flex flex-col h-[300px] items-center  p-10">
            <input type="hidden" name="content" value="<?=$this->filter ?>">


            <div class="flex justify-around items-center">

                <div>
                    <div class="relative inline-block w-full">
                        <p class="text-sm font-semibold text-primary mb-2 ">Filter By Films</p>
                        <div id="addFilmBtn" class=" flex justify-between items-center w-[250px] h-[60px] mx-3 p-2  bg-white border rounded-md cursor-pointer focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40">
                            <p>Select Films</p>
                            <i id="Films-dropdown-icon" class="fas fa-caret-down"></i>
                        </div>
                        <div id="Films-dropdown" class="absolute z-90 hidden w-full mt-2 overflow-hidden bg-white border rounded-md shadow-lg max-h-32 overflow-y-auto">

                            <?php foreach ($Films as $Film) : ?>
                                <div class="px-4 py-2 border-b hover:bg-secondary hover:text-white ">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="films[]" value="<?= $Film->id ?>" class="form-checkbox">
                                        <span class="ml-2"><?= htmlspecialchars($Film->titre) ?></span>
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
                const addFilmBtn = document.getElementById("addFilmBtn");


                addFilmBtn.addEventListener("click", function() {
                    toggleDropdown("Films-dropdown");
                });


            });
        </script>
<?php
    }
}

?>