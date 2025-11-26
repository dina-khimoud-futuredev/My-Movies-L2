<?php

namespace renderers\adminForms;

use mdb\Admin;

class AddCategory {
    private $admin;

    public function __construct()
    {
        $this->admin = new Admin();
    }
    public function generateForm()
    {
?>
        <form id="actor-form" method="POST" enctype="multipart/form-data" class="w-10/12 mx-auto text-black flex flex-col h-[500px] overflow-y-hidden items-center space-y-4 p-10">
            <div>
                <label for="nom" class="block text-sm font-semibold text-white mb-2">Nom</label>
                <input required type="text" class="block w-[250px] h-[60px] mx-3 p-2 bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="nom" name="CategoryNom" aria-describedby="nom">
            </div>
          <!--  -->
            <div class="flex space-x-7 text-xl items-center pt-7">
                <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-md focus:outline-none focus:bg-blue-600">Add</button>
                <button type="reset" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">Reset</button>
            </div> 
        </form>
<?php
    }
    public function createCategory($nom){
        $this->admin->createTag($nom);
        header('Location: search.php?content=categories');
        exit();
    }
}
?>