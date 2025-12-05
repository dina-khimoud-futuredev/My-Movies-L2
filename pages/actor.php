<?php
require_once "../config.php";
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();

use mdb\Actor;

// Check if the actor's name is provided in the URL parameter
if (isset($_GET['name'])) {
  $actorName = $_GET['name']; // Get the actor's name from the URL

  // Fetch actor's details from the database based on the name
  $actor = new Actor();
  $actorDetails = $actor->getActorInfo($actorName);

  // Check if actor details are found
  if ($actorDetails) {
    $actorPhoto = $actorDetails->photo; // Get the actor's photo URL
    $films = $actor->getFilmsByActor($actorName); // Get the films by the actor
  } else {
    // Actor details not found, handle error or display default image
    $actorPhoto = ""; // Default to empty string or provide a default image URL
    $films = []; // No films
  }
}

if (isset($_POST['deleteActor'])) {
  $actor_id = $actorDetails->id;
  $actor->DeleteActor($actor_id);
  header("Location: search.php?content=actors");
}
ob_start();
?>

<div class="w-full 2xl:w-9/12 xl:w-10/12 text-white mx-auto space-y-4 flex flex-col justify-center items-center">
  <!-- Display the actor's name -->
  <h1 class=" text-2xl font-bold"><?php echo htmlspecialchars($actorName); ?></h1>
  <!-- Display the actor's image -->
  <?php if (!empty($actorPhoto)) : ?>
    <img src="<?= \mdb\Film::getImage($actorPhoto); ?>" alt="<?= htmlspecialchars($actorName); ?>" class="w-40 h-40 rounded-full object-cover">
  <?php else : ?>
    <p class="text-red-500">No image available</p>
  <?php endif; ?>

  <section class="pt-16 pb-10 w-full ">
    <div class="flex flex-col justify-center items-center  w-10/12  mx-auto relative ">
      <p class="lg:text-4xl md:text-3xl  tracking-widest font-normal mb-16 uppercase">
        Films
      </p>
      <div class="flex flex-wrap justify-around w-full">
        <?php if (!empty($films)) : ?>
          <?php foreach ($films as $n) : ?>
            <?= $n->getHTML(); ?>
          <?php endforeach; ?>
        <?php else : ?>
          <p>No films found.</p>
        <?php endif; ?>
      </div>

    </div>
  </section>
  <?php if ($_SESSION['role'] == 'admin') : ?>
  <div class="flex justify-center items-cente uppercase ">
    <form action="" method="post">
      <button type="submit" name="deleteActor" class="px-3 mb-4 py-2 bg-secondary text-white cursor-pointer hover:animate-pulse rounded-md add-to-vues-btn">
        Delete Actor <i class="fas fa-trash ml-3 text-white"></i>
      </button>
    </form>
    <button type="submit" name="EditFilm" class="px-3 mb-4 ml-10 py-2 bg-green-500 text-white cursor-pointer hover:animate-pulse rounded-md add-to-vues-btn">
      Edit Actor <i class="fas fa-pen-to-square ml-3 text-white"></i>
    </button>
  </div>
  <?php endif; ?>
</div>



<!-- edit pop up -->
<div id="EditActorPopup" class="flex text-primary fixed z-50 top-0 left-0 right-0 bg-black bg-opacity-80 hidden justify-center items-center w-screen h-screen">
    <form id="actor-form" method="POST" action="../Edits/EditActor.php" enctype="multipart/form-data" class="w-1/2 mx-auto text-black bg-white flex flex-col  overflow-y-hidden items-center space-y-4 p-10">
    <p class="text-4xl mb-3">Edit Actor</p>
      <input type="hidden" name="id" value="<?=$actorDetails->id ?>">
    <div>
        <label for="nom"  class="block text-sm font-semibold  mb-2">Nom</label>
        <input required value="<?= $actorName?>" type="text" class="block w-[250px] h-[60px] mx-3 p-2 bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40" id="nom" name="nom" aria-describedby="nom">
      </div>
      <div>
        
        <label for="image" class="block text-sm font-semibold text-center mb-2">Image <span class="ml-2 cursor-pointer text-green-500" id="editImage">Edit image </span></label>
        <input  type="file" value="null" class=" hidden block w-full px-4 py-2 mt-2 bg-white border rounded-md focus:border-secondary focus:ring-secondary focus:outline-none focus:ring focus:ring-opacity-40 mb-4" id="ActorImage" name="image" accept="image/png, image/gif, image/jpeg">
        <div id="preview-container" class="flex justify-center rounded-md">
          <img id="preview-image" src="<?= \mdb\Film::getImage($actorPhoto); ?>" class="ActorImg object-cover max-h-[500px] max-w-[600px]">
        </div>
      </div>
      <div class="flex space-x-7 text-xl items-center pt-7">
        <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-md focus:outline-none focus:bg-blue-600">Edit Now</button>
        <button type="reset" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">Reset</button>
      </div>
    </form>
  <i class="fas fa-xmark text-secondary hover:scale-150  absolute top-2 right-4 cursor-pointer text-4xl p-2"></i>
</div>

<script>
  const EditActorPopup = document.getElementById('EditActorPopup');
  const EditActorBtn = document.querySelector('button[name="EditFilm"]');
  const closeEditActorPopup = EditActorPopup.querySelector('i');

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

  const fileInput = document.getElementById("ActorImage");
  fileInput.addEventListener('change', () => {
    let file = fileInput.files[0];
    if (file && file.type.split('/')[0] === "image") {
      reader.readAsDataURL(file);
    } else {
      preview.src = "";
    }
  });

  const EditImage = document.getElementById('editImage');
  const ImageInput = document.getElementById('ActorImage');
  EditImage.addEventListener('click', () => {
    ImageInput.classList.remove('hidden');
   
  });
</script>

<?php $content = ob_get_clean(); ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content); ?>