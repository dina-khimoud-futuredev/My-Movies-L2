<?php

namespace mdb;

use mdb\MoviesDB;

class Admin {
    private $mdb;
    public const UPLOAD_DIR = "uploads/" ;
    public function __construct() {
        $this->mdb = new MoviesDB();
    }

    public function getAllUsers(){
        $result = $this->mdb->exec(
            "SELECT * FROM users",
            null,
            'renderers\UserRenderer'
        );
        return $result ? $result : []; 
    }
    // Create a new film in the database
    public function createFilm($titre, $date_sortie, $realisateur_id, $type, $description = null,$trailer=null, $imgFile = null)
    {
        $titre = htmlspecialchars($titre);
        $description = htmlspecialchars($description);
        $imgName = null;

        if ($imgFile != null) {
            $tmpName = $imgFile['tmp_name'];
            $imgName = $imgFile['name'];
            $imgName = urlencode(htmlspecialchars($imgName));

            $dirname = $GLOBALS['PHP_DIR'] . self::UPLOAD_DIR;
            if (!is_dir($dirname)) mkdir($dirname);
            $uploaded = move_uploaded_file($tmpName, $dirname . $imgName);
            if (!$uploaded) die("FILE NOT UPLOADED");
        } else {
            echo "NO IMAGE !!!!";
        }
        $query = 'INSERT INTO films (titre, date_sortie, affiche, synopsis, realisateur_id, rating, type,trailer) 
                  VALUES (:titre, :date_sortie, :affiche, :synopsis, :realisateur_id, :rating, :type,:trailer)';
        $params = [
            'titre' => $titre,
            'date_sortie' => $date_sortie,
            'affiche' => $imgName,
            'synopsis' => $description,
            'realisateur_id' => $realisateur_id,
            'rating' => 0,
            'type' => $type,
            'trailer' => $trailer
        ];

        $result = $this->mdb->exec($query, $params);
        
        return $result;
    }

    public function addActorToFilm($film_id, $actor_id)
    {
        $query = 'INSERT INTO film_acteur (film_id, acteur_id) VALUES (:film_id, :acteur_id)';
        $params = [
            'film_id' => $film_id,
            'acteur_id' => $actor_id
        ];
        return $this->mdb->exec($query, $params);
    }

    public function addTagToFilm($film_id, $tag_id)
    {
        $query = 'INSERT INTO film_tag (film_id, tag_id) VALUES (:film_id, :tag_id)';
        $params = [
            'film_id' => $film_id,
            'tag_id' => $tag_id
        ];
        return $this->mdb->exec($query, $params);
    }

    public function getAllDirectors()
    {
        $result = $this->mdb->exec(
            "SELECT id, nom FROM realisateurs",
            null,
        );
        return $result ? $result : []; 
    }
    public function getAllActors()
    {
        $result = $this->mdb->exec(
            "SELECT id, nom FROM acteurs",
            null,
        );
        return $result ? $result : []; 
    }
    public function getAllTags()
    {
        $result = $this->mdb->exec(
            "SELECT id, nom FROM tags",
            null,
        );
        return $result ? $result : []; 
    }
    public function getAllFilms()
    {
        $result = $this->mdb->exec(
            "SELECT * FROM films",
            null,
        );
        return $result ? $result : []; 
    }

    public function createActor($nom, $imgName)
{
    $nom = htmlspecialchars($nom);
    $query = 'INSERT INTO acteurs (nom, photo) VALUES (:nom, :image)';
    $params = [
        'nom' => $nom,
        'image' => $imgName,
    ];

    $result = $this->mdb->exec($query, $params);
    return $result;
}
public function createTag($nom)
{
    $nom = htmlspecialchars($nom);
    $query = 'INSERT INTO tags(nom) VALUES (:nom)';
    $params=[
        'nom' => $nom
    ];
    $result = $this->mdb->exec($query, $params);
    return $result;
}

public function createRealisateur($nom, $imgName)
{
    $nom = htmlspecialchars($nom);
    $query = 'INSERT INTO realisateurs (nom, photo) VALUES (:nom, :image)';
    $params = [
        'nom' => $nom,
        'image' => $imgName,
    ];

    $result = $this->mdb->exec($query, $params);
    return $result;
}



}

