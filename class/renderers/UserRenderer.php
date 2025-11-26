<?php

namespace renderers;

class UserRenderer
{
  private $username;
  private $role;


  public function getHTML()
  {
?>
    <article class=" user-cart flex w-[200px] h-[80px] justify-between items-center shadow-md shadow-gray-700 hover:scale-105 transition-all duration-300 ease-in-out">
      <div class="w-1/3 h-full bg-secondary flex justify-center items-center rounded-l-lg">
      <?php if ($this->role == "admin") { ?>
          <i class="fas fa-user-tie text-5xl text-white"></i>
        <?php } else { ?>
          <i class="fas fa-user text-5xl text-white"></i>
        <?php } ?>
      </div>
      <div class="px-4 ">
        <p class="text-yellow-500 role"><?= $this->role ?></p>
        <p class="username"><?= $this->username ?></p>
      </div>
      <!-- delete -->
      <div class="flex justify-center items-center bg-white h-full px-2 rounded-r-lg cursor-pointer">
        <i class="fas fa-trash-alt text-2xl text-secondary"></i>
      </div>
    </article>
<?php }
}
