CREATE DATABASE Adotai;
USE Adotai;

CREATE TABLE Temperamento (
	idTem INT PRIMARY KEY,
    tipoTem VARCHAR(20),
    energiaTem ENUM("b", "m", "a")
);

CREATE TABLE Especie (
	idEsp INT PRIMARY KEY,
    nomeEsp VARCHAR(20) NOT NULL,
    porteEsp ENUM("p", "m", "g")
);

CREATE TABLE Pet (
	idPet VARCHAR(36) PRIMARY KEY,
    nomePet VARCHAR(80) NOT NULL,
    sexoPet ENUM("f", "m") NOT NULL,
    descricaoPet TEXT NOT NULL,
    temRacaPet BOOLEAN NOT NULL,
    idEsp INT,
    idTem INT,
    FOREIGN KEY(idEsp) REFERENCES Especie(idEsp),
    FOREIGN KEY(idTem) REFERENCES Temperamento(idTem)
);

CREATE TABLE Usuario (
	idUsu VARCHAR(36) PRIMARY KEY,
    nomeUsu VARCHAR(80) NOT NULL,
    dataNascimentoUsu DATE NOT NULL,
    cepUsu VARCHAR(9) NOT NULL,
    complementoUsu VARCHAR(50),
    senhaUsu TEXT NOT NULL,
    telefoneUsu VARCHAR(15) NOT NULL,
    tipoUsu ENUM("c", "a") NOT NULL
);

INSERT INTO Especie VALUES
(1, "Cão", "p"),
(2, "Cão", "m"),
(3, "Cão", "g"),
(4, "Gato", "p"),
(5, "Gato", "m"),
(6, "Gato", "g");

INSERT INTO Temperamento VALUES
(1, "Introvertido", "m"),
(2, "Extrovertido", "a"),
(3, "Arisco", "m"),
(4, "Calmo", "b");