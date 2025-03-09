CREATE DATABASE smarttech_db;
CREATE USER 'smarttech_user'@'localhost' IDENTIFIED BY 'motdepassefort';
GRANT ALL PRIVILEGES ON smarttech_db.* TO 'smarttech_user'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE employes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    poste VARCHAR(50)
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    entreprise VARCHAR(100)
);

CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    chemin VARCHAR(100),
    date_telechargement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    proprietaire VARCHAR(100),
);
