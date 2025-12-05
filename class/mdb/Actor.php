<?php

namespace mdb;

use mdb\MoviesDB;

class Actor
{
    private $mdb;

    public function __construct()
    {
        $this->mdb = new MoviesDB();
    }


    public function getFilmsByActor($actor_name)
    {
        $query = "
            SELECT f.* 
            FROM films f
            JOIN film_acteur fa ON f.id = fa.film_id
            JOIN acteurs a ON fa.acteur_id = a.id
            WHERE a.nom = ?
        ";
        $params = [$actor_name];
        return $this->mdb->exec($query, $params, 'renderers\NewFilmRenderer');
    }
    public function getActorInfo($actor_name)
    {
        $query = "SELECT * FROM acteurs WHERE nom = ?";
        $params = [$actor_name];
        $result = $this->mdb->exec($query, $params);

        if (!$result) {
            error_log("No actor found with name: $actor_name");
            return null;  // Return null if no actor is found
        } else {
            error_log("Actor found: " . print_r($result, true));
            return $result[0];  // Return the first result (should be the actor's details)
        }
    }
    public function DeleteActor($actor_id)
    {
        $query = "DELETE FROM film_acteur WHERE acteur_id = ?";
        $params = [$actor_id];
        $this->mdb->exec($query, $params);
        $query = "DELETE FROM acteurs WHERE id = ?";
        $params = [$actor_id];
        return $this->mdb->exec($query, $params);
    }
    public function EditActor($actor_id, $actor_name, $actor_photo)
    {
        if ($actor_photo != null) {
            $query = "UPDATE acteurs SET nom = ?, photo = ? WHERE id = ?";
            $params = [$actor_name, $actor_photo, $actor_id];
        } else {
            $query = "UPDATE acteurs SET nom = ? WHERE id = ?";
            $params = [$actor_name, $actor_id];
        }
        return $this->mdb->exec($query, $params);
    }
}
