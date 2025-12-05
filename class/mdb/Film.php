<?php

namespace mdb;

use mdb\MoviesDB;

class Film {
    private $mdb;

    public function __construct() {
        $this->mdb = new MoviesDB();
    }
    public function getTrending() {
        $result = $this->mdb->exec(
            "SELECT films.*, GROUP_CONCAT(tags.nom) AS tags
             FROM films
             LEFT JOIN film_tag ON films.id = film_tag.film_id
             LEFT JOIN tags ON film_tag.tag_id = tags.id
             GROUP BY films.id
             ORDER BY films.rating DESC",
            null,
            'renderers\TrendingRenderer'
        );
        return $result ? $result : []; 
    }
    

    public function getRecent() {
        $result = $this->mdb->exec(
            "SELECT * FROM films ORDER BY date_sortie DESC",
            null,
            'renderers\RecentRenderer'
        );
        return $result ? $result : []; 
    }

    public function getNewFilms() {
        $result = $this->mdb->exec(
            "SELECT * FROM films WHERE type = 'film' ORDER BY date_sortie DESC LIMIT 3",
            null,
            'renderers\NewFilmRenderer'
        );
        return $result ? $result : []; 
    }
    public function getNewSeries() {
        $result = $this->mdb->exec(
            "SELECT * FROM films WHERE type = 'serie' ORDER BY date_sortie DESC LIMIT 3",
            null,
            'renderers\NewFilmRenderer'
        );
        return $result ? $result : []; 
    }
    public function getFilm($name, $userId = null) {
        $query = "
        SELECT 
            f.id, f.titre, f.date_sortie, f.affiche, f.synopsis,f.trailer, 
            r.nom as realisateur_nom, r.photo as realisateur_photo,
            GROUP_CONCAT(DISTINCT t.nom) as tags,
            GROUP_CONCAT(DISTINCT a.nom ORDER BY a.nom) as acteurs_noms,
            GROUP_CONCAT(DISTINCT a.photo ORDER BY a.nom) as acteurs_photos,
            f.rating, f.type,
            (CASE WHEN v.id IS NULL THEN 0 ELSE 1 END) as isVue
        FROM films f
        LEFT JOIN realisateurs r ON f.realisateur_id = r.id
        LEFT JOIN film_tag ft ON f.id = ft.film_id
        LEFT JOIN tags t ON ft.tag_id = t.id
        LEFT JOIN film_acteur fa ON f.id = fa.film_id
        LEFT JOIN acteurs a ON fa.acteur_id = a.id
        LEFT JOIN vues v ON f.id = v.film_id AND v.user_id = ?
        WHERE f.titre = ?
        GROUP BY f.id, r.nom, r.photo
    ";
        $params = [$userId, $name];
        $result = $this->mdb->exec($query, $params, 'renderers\FilmPageRenderer');
        return $result ? $result[0] : null; 
    }

    // vue functions
    public function toggleVue($action,$filmId, $userId) {
        echo $action . $filmId . $userId;
      if($action == "addtovue"){
        $query = "INSERT INTO vues (film_id, user_id) VALUES (?, ?)";
        }else{
            $query = "DELETE FROM vues WHERE film_id = ? AND user_id = ?";
        }
        $params = [$filmId, $userId];
        $this->mdb->exec($query, $params);
    }
    public function getVuedFilms($userId) {
        $query = "SELECT * FROM films
                    JOIN vues ON films.id = vues.film_id
                    WHERE vues.user_id = ?";

        $params = [$userId];
        $result = $this->mdb->exec($query, $params, 'renderers\NewFilmRenderer');
        return $result ? $result : []; 
    }
    public function DeleteFilm($filmId) {
        $query = "DELETE FROM film_tag WHERE film_id = ?";
        $params = [$filmId];
        $this->mdb->exec($query, $params);
        $query = "DELETE FROM film_acteur WHERE film_id = ?";
        $params = [$filmId];
        $this->mdb->exec($query, $params);
        $query = "DELETE FROM films WHERE id = ?";
        $params = [$filmId];
        return $this->mdb->exec($query, $params);
    }







public static function getImage($image){
    return str_contains($image, "http") ? $image : $GLOBALS['DOCUMENT_DIR'] . "../uploads/" . $image;    
}
    
}

