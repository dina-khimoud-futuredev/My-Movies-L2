-- Création de la base de données
CREATE DATABASE IF NOT EXISTS my_movies;
USE my_movies;

-- Table des réalisateurs
CREATE TABLE realisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NOT NULL
);

-- Table des films
CREATE TABLE films (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    date_sortie DATE NOT NULL,
    affiche VARCHAR(255) NOT NULL,
    synopsis TEXT NOT NULL,
    trailer TEXT NOT NULL,
    realisateur_id INT NOT NULL,
    type ENUM('film', 'serie') NOT NULL DEFAULT 'film',
    rating FLOAT NOT NULL DEFAULT 0,
    FOREIGN KEY (realisateur_id) REFERENCES realisateurs(id)
);

-- Table des acteurs
CREATE TABLE acteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NOT NULL
);

-- Table de liaison film-acteur
CREATE TABLE film_acteur (
    film_id INT NOT NULL,
    acteur_id INT NOT NULL,
    PRIMARY KEY (film_id, acteur_id),
    FOREIGN KEY (film_id) REFERENCES films(id),
    FOREIGN KEY (acteur_id) REFERENCES acteurs(id)
);

-- Table des tags
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Table de liaison film-tag
CREATE TABLE film_tag (
    film_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (film_id, tag_id),
    FOREIGN KEY (film_id) REFERENCES films(id),
    FOREIGN KEY (tag_id) REFERENCES tags(id)
);

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);
--Table des vues
CREATE TABLE vues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    film_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (film_id) REFERENCES films(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);




