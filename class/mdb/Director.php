<?php

namespace mdb;

use mdb\MoviesDB;

class Director {
    private $mdb;

    public function __construct() {
        $this->mdb = new MoviesDB();
    }
    public function getDirectorInfo($director_name) {
        $query = "SELECT * FROM realisateurs WHERE nom = ?";
        $params = [$director_name];
        $result = $this->mdb->exec($query, $params);
        
        if (!$result) {
            error_log("No director found with name: $director_name");
            return null;
        } else {
            error_log("Director found: " . print_r($result, true));
            return $result[0];
        }
    }

    public function getFilmsByDirector($director_name) {
        $query = "
        SELECT f.* 
        FROM films f
        JOIN realisateurs r ON f.realisateur_id = r.id
        WHERE r.nom = ?
        ";
        $params = [$director_name];
        return $this->mdb->exec($query, $params, 'renderers\NewFilmRenderer'); 
    }
    public function DeleteDirector($director_id) {
        

        $query = "DELETE FROM realisateurs WHERE id = ?";
        $params = [$director_id];
        return $this->mdb->exec($query, $params);
    }
    public function EditDirector($director_id, $director_name, $director_photo)
    {
        if ($director_photo != null) {
            $query = "UPDATE realisateurs SET nom = ?, photo = ? WHERE id = ?";
            $params = [$director_name, $director_photo, $director_id];
        } else {
            $query = "UPDATE realisateurs SET nom = ? WHERE id = ?";
            $params = [$director_name, $director_id];
        }
        return $this->mdb->exec($query, $params);
    }
}
?>
