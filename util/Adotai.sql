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

CREATE TABLE Usuario (
	idUsu INT PRIMARY KEY AUTO_INCREMENT,
    nomeUsu VARCHAR(80) NOT NULL,
    dataNascimentoUsu DATE NOT NULL,
    cepUsu VARCHAR(9) NOT NULL,
    complementoUsu VARCHAR(50),
    senhaUsu TEXT NOT NULL,
    telefoneUsu VARCHAR(15) NOT NULL,
    tipoUsu ENUM("c", "a") NOT NULL,
    tipoImagemPerfilUsu ENUM("c", "g") NOT NULL,
    banidoUsu BOOLEAN NOT NULL
);

INSERT INTO Usuario VALUES
(67, "Gustavo", "2008-05-02", "85869-720", "Apartamento 351", "$2y$10$KEkOS6Y.EwxRoEE9Qcde7e.Iluc3XTgzG3qmpZxabnoJ/22PTjORe", "(45) 99117-6904", "a", "g", false);

CREATE TABLE Pet (
	idPet INT PRIMARY KEY AUTO_INCREMENT,
    nomePet VARCHAR(80) NOT NULL,
    sexoPet ENUM("f", "m") NOT NULL,
    descricaoPet TEXT NOT NULL,
    temRacaPet BOOLEAN NOT NULL,
    idEsp INT NOT NULL,
    idTem INT NOT NULL,
    linkImagemPet TEXT NOT NULL,
    idUsu INT NOT NULL,
    FOREIGN KEY(idEsp) REFERENCES Especie(idEsp),
    FOREIGN KEY(idTem) REFERENCES Temperamento(idTem),
    FOREIGN KEY(idUsu) REFERENCES Usuario(idUsu)
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

INSERT INTO Pet VALUES
(1, "Rexstone", "m", "Carinhoso, brincalhão com as crianças. Vacinado e sadio.", false, 2, 2, "https://s2-g1.glbimg.com/TdPTg4jg3ZqtmZtyFnuHehXLgmk=/0x314:720x1073/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_59edd422c0c84a879bd37670ae4f538a/internal_photos/bs/2019/B/x/gU7r6UTvyFwLn5G5FlUg/whatsapp-image-2019-02-22-at-14.53.02.jpeg", 67),
(2, "Pedro", "m", "Extrovertido quando quer, contido. Não-vacinado e sadio.", false, 6, 4, "https://i.redd.it/6awu42gnlasc1.jpeg", 67),
(3, "Florinda", "f", "Bem arisca, foi vítima de maus-tratos. Vacinada, mas é bem raivosa e fraca.", true, 5, 3, "https://preview.redd.it/z1seq6b71d851.jpg?width=1080&crop=smart&auto=webp&s=a52fe92b54bb99e8d3ec15d0562c1437e7eb437c", 67),
(4, "Joaninha", "f", "uito carentinha, dócil, excelente companheira. Sadia e vacinada, é filhote de Pit Bull.", true, 1, 2, "https://www.chefbob.com.br/cdn/shop/articles/2020-05-08-como-cuidar-de-uma-cadelinha-no-cio_jpg.webp?v=1756847533", 67);