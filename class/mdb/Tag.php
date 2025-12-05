<?php

namespace mdb;

use mdb\MoviesDB;

class Tag {
    private $mdb;

    public function __construct() {
        $this->mdb = new MoviesDB();
    }
    public function getFilmsByTag($tag_name) {
        $query = "
            SELECT f.* 
            FROM films f
            JOIN film_tag ft ON f.id = ft.film_id
            JOIN tags t ON ft.tag_id = t.id
            WHERE t.nom = ?
        ";
        $params = [$tag_name];
        return $this->mdb->exec($query, $params, 'renderers\NewFilmRenderer'); 
    }
    public function getTagInfo($tag_name) {
        $query = "SELECT * FROM tags WHERE nom = ?";
        $params = [$tag_name];
        $result = $this->mdb->exec($query, $params);
        
        if (!$result) {
            error_log("No tag found with name: $tag_name");
            return null;
        } else {
            error_log("Tag found: " . print_r($result, true));
            return $result[0];
        }
    }
    public function DeleteTag($tag_id) {
        

        $query = "DELETE FROM film_tag WHERE tag_id = ?";
        $params = [$tag_id];
        $this->mdb->exec($query, $params);
        $query = "DELETE FROM tags WHERE id = ?";
        $params = [$tag_id];
        return $this->mdb->exec($query, $params);
    }

    public function EditTag($tag_id, $nom) {
        $query = "UPDATE tags SET nom = ? WHERE id = ?";
        $params = [$nom, $tag_id];
        return $this->mdb->exec($query, $params);
    }


    
    
}
