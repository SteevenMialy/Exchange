-- Script d'insertion des catégories et objets d'échange avec images
-- Date: 2026-02-14

-- Drop des tables existantes
DROP TABLE IF EXISTS exch_pictures;
DROP TABLE IF EXISTS exch_object;
DROP TABLE IF EXISTS exch_category;

-- Création de la table exch_category
CREATE TABLE exch_category (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nomcategory VARCHAR(255),
    path_img VARCHAR(100),
    PRIMARY KEY (id)
);

-- Création de la table exch_object
CREATE TABLE exch_object (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_user INT(11),
    id_category INT(11),
    descript TEXT,
    prix DECIMAL(10,2),
    obj_name VARCHAR(50),
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES exch_user(id),
    FOREIGN KEY (id_category) REFERENCES exch_category(id)
);

-- Création de la table exch_pictures
CREATE TABLE exch_pictures (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_object INT(11),
    path_img VARCHAR(255),
    PRIMARY KEY (id),
    FOREIGN KEY (id_object) REFERENCES exch_object(id)
);

-- Insertion des catégories avec images
INSERT INTO exch_category (nomcategory, path_img) VALUES
('Électronique & Appareils Photo', 'cat-2.jpg'),
('Vêtements', 'cat-1.jpg'),
('Chaussures', 'cat-3.jpg'),
('Mobilier & Décoration', 'cat-4.jpg'),
('Beauté & Soins', 'cat-5.jpg'),
('Montres & Accessoires', 'cat-6.jpg');

-- Insertion d'objets d'échange avec images
-- Catégories: 1=Électronique, 2=Vêtements, 3=Chaussures, 4=Mobilier, 5=Beauté, 6=Montres

INSERT INTO exch_object (id_user, id_category, obj_name, descript, prix) VALUES
(5, 1, 'Appareil Photo Professionnel', 'Caméra DSLR avec objectif 24-70mm, excellente condition', 450.00),
(6, 2, 'Sweatshirt Bleu', 'Sweatshirt confortable, taille M, très bon état', 25.00),
(7, 4, 'Lampe de Table Design', 'Lampe de table classique avec abat-jour, en très bon état', 65.00),
(5, 3, 'Chaussures Nike Enfant', 'Baskets Nike taille 25, peu portées', 35.00),
(8, 1, 'Drone avec Caméra', 'Drone Phantom avec accessoires complets, bon fonctionnement', 350.00),
(9, 6, 'Montre Connectée', 'Montre intelligente avec bracelet milanais, batterie excellente', 120.00),
(5, 2, 'Blouse Noire Élégante', 'Blouse en dentelle noire, taille S, comme neuve', 40.00),
(6, 5, 'Kit Produits de Soin Curology', 'Kit complet: nettoyant + traitement + hydratant', 55.00),
(7, 4, 'Chaise de Bureau Ergonomique', 'Fauteuil de bureau couleur bleu, hauteur ajustable', 180.00),
(8, 2, 'T-Shirt Off-Shoulder', 'T-shirt tendance, taille M, couleur beige chiné', 18.00);

-- Association des images aux objets (juste le nom du fichier depuis images/img/)
INSERT INTO exch_pictures (id_object, path_img) VALUES
(1, 'product-1.jpg'),
(2, 'product-2.jpg'),
(3, 'product-3.jpg'),
(4, 'product-4.jpg'),
(5, 'product-5.jpg'),
(6, 'product-6.jpg'),
(7, 'product-7.jpg'),
(8, 'product-8.jpg'),
(9, 'product-9.jpg'),
(10, 'default.webp');
