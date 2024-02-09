CREATE DATABASE carta;
USE carta;

CREATE TABLE pais (
    idpais INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    bandera VARCHAR(255) NOT NULL
);

CREATE TABLE piloto (
    idpiloto INT AUTO_INCREMENT PRIMARY KEY,
    media VARCHAR(255),
    name VARCHAR(255) NOT NULL,
    exp INT,
    rac INT,
    awa INT,
    pac INT,
    photo VARCHAR(255),
    idpais INT,
    FOREIGN KEY (idpais) REFERENCES pais(idpais)
);
