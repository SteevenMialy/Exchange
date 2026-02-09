/* ===============================
   BASE DE DONNÉES
================================ */
DROP DATABASE IF EXISTS AgenceL;
CREATE DATABASE AgenceL;
USE AgenceL;

/* ===============================
   TABLES DE BASE
================================ */

/* Véhicules */
CREATE TABLE Ag_vehicule (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomvehicule VARCHAR(100),
    cout_journalier DECIMAL(10,2)
);

/* Livreurs */
CREATE TABLE Ag_livreur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomlivreur VARCHAR(250),
    salaire_journalier DECIMAL(10,2)
);

/* Zones de livraison */
CREATE TABLE Ag_zonelivraison ( 
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomzone VARCHAR(250)
);

/* Entrepôts */
CREATE TABLE Ag_entrepot (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomzone VARCHAR(250)
);

/* Statuts */
CREATE TABLE Ag_status (
    id INT PRIMARY KEY AUTO_INCREMENT,
    stat VARCHAR(250)
);

/* Colis */
CREATE TABLE Ag_colis (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomcolis VARCHAR(250),
    pu DECIMAL(10,2),
    poid DECIMAL(10,2)
);

/* ===============================
   LIVRAISON
================================ */
CREATE TABLE Ag_livraison (
    id INT PRIMARY KEY AUTO_INCREMENT,
    datylivraison DATE,
    idvehicule INT,
    idlivreur INT,
    idzonelivraison INT,
    identrepot INT,
    idcolis INT,
    idstatus INT,

    CONSTRAINT fk_livraison_vehicule
        FOREIGN KEY (idvehicule) REFERENCES Ag_vehicule(id),
    CONSTRAINT fk_livraison_livreur
        FOREIGN KEY (idlivreur) REFERENCES Ag_livreur(id),
    CONSTRAINT fk_livraison_zonelivraison
        FOREIGN KEY (idzonelivraison) REFERENCES Ag_zonelivraison(id),
    CONSTRAINT fk_livraison_entrepot
        FOREIGN KEY (identrepot) REFERENCES Ag_entrepot(id),
    CONSTRAINT fk_livraison_colis
        FOREIGN KEY (idcolis) REFERENCES Ag_colis(id),
    CONSTRAINT fk_livraison_status
        FOREIGN KEY (idstatus) REFERENCES Ag_status(id)
);

/* ===============================
   TABLES MÉTIER
================================ */

/* Colis par livraison */
CREATE TABLE Ag_livraison_colis (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idlivraison INT,
    idcolis INT,
    quantite INT,
    prixkg DECIMAL(10,2),

    FOREIGN KEY (idlivraison) REFERENCES Ag_livraison(id),
    FOREIGN KEY (idcolis) REFERENCES Ag_colis(id)
);

/* Paramètres de livraison */
CREATE TABLE Ag_livraison_param (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idlivraison INT,
    libelle VARCHAR(100),
    montant DECIMAL(10,2),

    FOREIGN KEY (idlivraison) REFERENCES Ag_livraison(id)
);

/* ===============================
   DONNÉES
================================ */

/* Véhicules */
INSERT INTO Ag_vehicule (nomvehicule, cout_journalier) VALUES
('Camion 5T', 80000),
('Camion 10T', 120000),
('Fourgonnette', 50000),
('Moto', 20000);

/* Livreurs */
INSERT INTO Ag_livreur (nomlivreur, salaire_journalier) VALUES
('Rakoto Jean', 50000),
('Rabe Paul', 45000),
('Andry Michel', 60000),
('Hery Solo', 40000);

/* Zones */
INSERT INTO Ag_zonelivraison (nomzone) VALUES
('Antananarivo'),
('Toamasina'),
('Fianarantsoa'),
('Mahajanga');

/* Entrepôts */
INSERT INTO Ag_entrepot (nomzone) VALUES
('Entrepot Tana');

/* Statuts */
INSERT INTO Ag_status (stat) VALUES
('En attente'),
('Livré'),
('Annulé');

/* Colis */
INSERT INTO Ag_colis (nomcolis, pu, poid) VALUES
('Ordinateur portable', 1500000, 2.5),
('Téléphone', 800000, 0.8),
('Sac de riz', 120000, 25),
('Télévision', 2000000, 12);

/* Livraisons */
INSERT INTO Ag_livraison
(datylivraison, idvehicule, idlivreur, idzonelivraison, identrepot, idcolis, idstatus)
VALUES
('2025-12-01', 1, 1, 1, 1, 1, 1),
('2025-12-02', 2, 2, 2, 1, 2, 2),
('2025-12-03', 3, 3, 3, 1, 3, 3),
('2025-12-04', 4, 4, 4, 1, 4, 2);

/* Colis par livraison */
INSERT INTO Ag_livraison_colis (idlivraison, idcolis, quantite, prixkg) VALUES
(1, 1, 2, 3000),
(1, 2, 5, 2500),
(2, 3, 1, 1500),
(3, 4, 1, 4000),
(3, 2, 3, 2500),
(4, 1, 1, 3000);

/* Paramètres */
INSERT INTO Ag_livraison_param (idlivraison, libelle, montant) VALUES
(1, 'Carburant', 30000),
(1, 'Péage', 10000),
(2, 'Carburant', 45000),
(3, 'Carburant', 25000),
(3, 'Maintenance', 15000);

/* ===============================
   REQUÊTE DE CONTRÔLE
================================ */
SELECT
    l.id,
    l.datylivraison,
    liv.nomlivreur,
    v.nomvehicule,
    s.stat,
    SUM(lc.quantite * c.poid * lc.prixkg) AS cout_colis
FROM Ag_livraison l
JOIN Ag_livreur liv ON l.idlivreur = liv.id
JOIN Ag_vehicule v ON l.idvehicule = v.id
JOIN Ag_status s ON l.idstatus = s.id
LEFT JOIN Ag_livraison_colis lc ON l.id = lc.idlivraison
LEFT JOIN Ag_colis c ON lc.idcolis = c.id
GROUP BY l.id;
