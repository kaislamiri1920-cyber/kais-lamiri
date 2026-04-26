-- Base de données SQL pour la page de commande freelance
-- Table : commandes_freelance

CREATE DATABASE IF NOT EXISTS freelance_orders;
USE freelance_orders;

CREATE TABLE IF NOT EXISTS commandes_freelance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_client VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(50),
    type_projet VARCHAR(100) NOT NULL,
    delai_souhaite VARCHAR(100),
    details TEXT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Exemple d'insertion :
-- INSERT INTO commandes_freelance (nom_client, email, telephone, type_projet, delai_souhaite, details)
-- VALUES ('Kais Lamiri', 'kais@example.com', '+33 6 00 00 00 00', 'Site web', '2 semaines', 'Création d\'un portfolio avec formulaire de contact.');
