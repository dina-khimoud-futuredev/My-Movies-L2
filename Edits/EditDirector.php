<?php
require __DIR__."/../config.php" ;
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();


use mdb\Director;
$Director=new Director();
if (isset($_POST['nom'])) {
    $Director_id = $_POST['id'];
    $imgFile = isset($_FILES['image']) ? $_FILES['image'] : null ;
    $imgName = null;

    if ($imgFile != null && !$imgFile['name']=="") {

        $tmpName = $imgFile['tmp_name'];
        $imgName = $imgFile['name'];
        $imgName = urlencode(htmlspecialchars($imgName));

        $dirname = $GLOBALS['PHP_DIR'] ."uploads/";
 
        $uploaded = move_uploaded_file($tmpName, $dirname . $imgName);
        if (!$uploaded) die("FILE NOT UPLOADED");
    } else {
        echo "NO IMAGE !!!!";
    } 
    echo $Director_id ." ". $_POST['nom']. " ". $imgName;
    $Director->EditDirector($Director_id ,$_POST['nom'], $imgName);
    header("Location: ../pages/director.php?name=".$_POST['nom']);
}

?>