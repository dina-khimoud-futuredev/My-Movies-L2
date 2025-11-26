<?php
require __DIR__."/../config.php" ;
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();


use mdb\Tag;
$Tag=new Tag();
if (isset($_POST['nom'])) {
    $Tag_id = $_POST['id'];
    $Tag->EditTag($Tag_id ,$_POST['nom']);
    header("Location: ../pages/tag.php?name=".$_POST['nom']);
}

?>