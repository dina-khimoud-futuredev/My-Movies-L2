<?php

namespace mdb;

use mdb\MoviesDB;

class Search {
    private $mdb;

    public function __construct() {
        $this->mdb = new MoviesDB();
    }


    public function getAllFilms(){
        $result = $this->mdb->exec(
            "SELECT * FROM films ORDER BY date_sortie DESC",
            null,
            'renderers\NewFilmRenderer'
        );
        return $result ? $result : []; 
    }
    public function getAllActors(){
        $result = $this->mdb->exec(
            "SELECT * FROM acteurs ORDER BY nom DESC",
            null,
            'renderers\searchRenderers\ActorRenderer'
        );
        return $result ? $result : [];
    }
    public function getAllDirectors(){
        $result = $this->mdb->exec(
            "SELECT * FROM realisateurs ORDER BY nom DESC",
            null,
            'renderers\searchRenderers\DirectorRenderer'
        );
        return $result ? $result : [];
    }
    public function getAllTags(){
        $result = $this->mdb->exec(
            "SELECT * FROM tags ORDER BY nom DESC",
            null,
            'renderers\searchRenderers\TagRenderer'
        );
        return $result ? $result : [];
    }
    function debugQuery($query, $params) {
        $keys = array();
        $values = array();
    
        // If the parameters are associative (named placeholders)
        foreach ($params as $key => $value) {
            $keys[] = is_string($key) ? $key : '?';
            $values[] = is_numeric($value) ? $value : "'$value'";
        }
    
        // Replace named placeholders
        $query = str_replace($keys, $values, $query);
    
        // Replace unnamed placeholders sequentially
        foreach ($values as $value) {
            $query = preg_replace('/\?/', $value, $query, 1);
        }
    
        return $query;
    }
    public function filterFilm($fromDate = null, $toDate = null, $type = null, $minRate = null, $maxRate = null, $actors = [], $directors = [], $tags = [],$visibility = 'both', $userId = null) {
        $query = "SELECT films.*, GROUP_CONCAT(tags.nom) AS tags
                  FROM films
                  LEFT JOIN film_tag ON films.id = film_tag.film_id
                  LEFT JOIN tags ON film_tag.tag_id = tags.id
                  LEFT JOIN film_acteur ON films.id = film_acteur.film_id
                  LEFT JOIN acteurs ON film_acteur.acteur_id = acteurs.id
                  LEFT JOIN vues ON films.id = vues.film_id AND vues.user_id = :userId
                  WHERE 1=1";
    
        $params = [];
        $params = [':userId' => $userId];
        if ($fromDate) {
            $query .= " AND films.date_sortie >= :fromDate";
            $params[':fromDate'] = $fromDate;
        }
        if ($toDate) {
            $query .= " AND films.date_sortie <= :toDate";
            $params[':toDate'] = $toDate;
        }
        if ($type !== "All") {
            $query .= " AND films.type = :type";
            $params[':type'] = $type;
        }
        if ($minRate) {
            $query .= " AND films.rating >= :minRate";
            $params[':minRate'] = $minRate;
        }
        if ($maxRate) {
            $query .= " AND films.rating <= :maxRate";
            $params[':maxRate'] = $maxRate;
        }
        if ($actors) {
            $query .= " AND acteurs.id IN (" . implode(',', $actors) . ")";
       
        }
        if ($directors) {
            $query .= " AND films.realisateur_id IN (" . implode(',', $directors) . ")";

        }
        if ($tags) {
            $query .= " AND tags.id IN (" . implode(',', $tags) . ")";
        }
        if ($visibility === 'vu') {
            $query .= " AND vues.film_id IS NOT NULL";
        } elseif ($visibility === 'nonvu') {
            $query .= " AND vues.film_id IS NULL";
        }
    
        $query .= " GROUP BY films.id";
    
        // Debug the query with parameters
        // echo $this->debugQuery($query, $params);

        $result = $this->mdb->exec($query,$params, 'renderers\NewFilmRenderer');
        
        return $result ? $result : [];

    }
    public function filterActorsByFilms($films) {
        $query = "SELECT acteurs.*, GROUP_CONCAT(DISTINCT films.titre) as films
                  FROM acteurs
                  LEFT JOIN film_acteur ON acteurs.id = film_acteur.acteur_id
                  LEFT JOIN films ON film_acteur.film_id = films.id
                  WHERE films.id IN (" . implode(',', $films) . ")
                  GROUP BY acteurs.id";
        $result = $this->mdb->exec($query, null, 'renderers\searchRenderers\ActorRenderer');
        return $result ? $result : [];
    }
    public function filterDirectorsByFilms($films) {
        $query = "SELECT realisateurs.*, GROUP_CONCAT(DISTINCT films.titre) as films
                  FROM realisateurs
                  LEFT JOIN films ON realisateurs.id = films.realisateur_id
                  WHERE films.id IN (" . implode(',', $films) . ")
                  GROUP BY realisateurs.id";
        $result = $this->mdb->exec($query, null, 'renderers\searchRenderers\DirectorRenderer');
        return $result ? $result : [];
    }
    public function filterTagsByFilms($films) {
        $query = "SELECT tags.*, GROUP_CONCAT(DISTINCT films.titre) as films
                  FROM tags
                  LEFT JOIN film_tag ON tags.id = film_tag.tag_id
                  LEFT JOIN films ON film_tag.film_id = films.id
                  WHERE films.id IN (" . implode(',', $films) . ")
                  GROUP BY tags.id";
        $result = $this->mdb->exec($query, null, 'renderers\searchRenderers\TagRenderer');
        return $result ? $result : [];
    }

}
