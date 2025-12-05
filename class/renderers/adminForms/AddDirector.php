<?php

namespace renderers\adminForms;

use mdb\Admin;

class AddDirector
{
    private $admin;

    public function __construct()
    {
        $this->admin = new Admin();
    }

    public function generateForm()
    {
?>
        <form id="director-form" method="POST" enctype="multipart/form-data" class="w-10/12 mx-auto text-black flex flex-col h-[500px] overflow-y-hidden items-center space-y-4 p-10">
            <div>
                <label for="nom" class="block text-sm font-semibold text-white mb-2">Nom</label>
                <input required type="text" class="block w-[250px] h-[60px] mx-3 p-2 bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="DirectorNom" name="DirectorNom" aria-describedby="DirectorNom">
            </div>
            <div>
                <label for="image" class="block text-sm font-semibold text-white mb-2">Image</label>
                <input required type="file" class="block w-full px-4 py-2 mt-2 bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40 mb-4" id="DirectorImg" name="DirectorImage" accept="image/png, image/gif, image/jpeg">
                <div id="preview-container" class="flex justify-center rounded-md">
                    <img id="preview-image" src="" class="DirectorImg object-cover max-h-[500px] max-w-[600px]">
                </div>
            </div>
            <div class="flex space-x-7 text-xl items-center pt-7">
                <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-md focus:outline-none focus:bg-blue-600">Add</button>
                <button type="reset" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">Reset</button>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById("director-form");
                const preview = document.querySelector(".DirectorImg");
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                }

                const fileInput = document.getElementById("DirectorImg");
                fileInput.addEventListener('change', () => {
                    let file = fileInput.files[0];
                    if (file && file.type.split('/')[0] === "image") {
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = "";
                    }
                });
            });
        </script>
<?php
    }



    public function createDirector($nom, $imgFile)
    {
         $imgName = null;

        if ($imgFile != null) {
            $tmpName = $imgFile['tmp_name'];
            $imgName = $imgFile['name'];
            $imgName = urlencode(htmlspecialchars($imgName));

            $dirname = $GLOBALS['PHP_DIR'] . Admin::UPLOAD_DIR;
            if (!is_dir($dirname)) mkdir($dirname);
            $uploaded = move_uploaded_file($tmpName, $dirname . $imgName);
            if (!$uploaded) die("FILE NOT UPLOADED");
        } else {
            echo "NO IMAGE !!!!";
        } 

        $this->admin->createRealisateur($nom, $imgName);
        header('Location: search.php?content=directors');
        exit();
    }
}
?>
