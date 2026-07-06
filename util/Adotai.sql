CREATE TYPE energia_tem AS ENUM ('b', 'm', 'a');
CREATE TYPE porte_esp AS ENUM ('p', 'm', 'g');
CREATE TYPE sexo_pet AS ENUM ('f', 'm');
CREATE TYPE tipo_usu AS ENUM ('c', 'a');
CREATE TYPE tipo_imagem_perfil AS ENUM ('c', 'g');

CREATE TABLE Temperamento (
    idTem INT PRIMARY KEY,
    tipoTem VARCHAR(20),
    energiaTem energia_tem
);

CREATE TABLE Especie (
    idEsp INT PRIMARY KEY,
    nomeEsp VARCHAR(20) NOT NULL,
    porteEsp porte_esp
);

CREATE TABLE Raca (
    idRaca INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nomeRaca VARCHAR(50) NOT NULL,
    idEsp INT NOT NULL REFERENCES Especie(idEsp)
);

CREATE TABLE Usuario (
    idUsu INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nomeUsu VARCHAR(80) NOT NULL,
    dataNascimentoUsu DATE NOT NULL,
    cepUsu VARCHAR(9) NOT NULL,
    complementoUsu VARCHAR(50),
    senhaUsu TEXT NOT NULL,
    telefoneUsu VARCHAR(15) NOT NULL,
    tipoUsu tipo_usu NOT NULL,
    tipoImagemPerfilUsu tipo_imagem_perfil NOT NULL,
    banidoUsu BOOLEAN NOT NULL
);

INSERT INTO Usuario (
    nomeUsu,
    dataNascimentoUsu,
    cepUsu,
    complementoUsu,
    senhaUsu,
    telefoneUsu,
    tipoUsu,
    tipoImagemPerfilUsu,
    banidoUsu
) VALUES (
    'Gustavo',
    '2008-05-02',
    '85869-720',
    'Apartamento 351',
    '$2y$10$KEkOS6Y.EwxRoEE9Qcde7e.Iluc3XTgzG3qmpZxabnoJ/22PTjORe',
    '(45) 99117-6904',
    'a',
    'g',
    FALSE
);

CREATE TABLE Pet (
    idPet INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nomePet VARCHAR(80) NOT NULL,
    sexoPet sexo_pet NOT NULL,
    descricaoPet TEXT NOT NULL,
    idEsp INT NOT NULL REFERENCES Especie(idEsp),
    idTem INT NOT NULL REFERENCES Temperamento(idTem),
    linkImagemPet TEXT NOT NULL,
    idUsu INT NOT NULL REFERENCES Usuario(idUsu),
    idRaca INT REFERENCES Raca(idRaca)
);

INSERT INTO Especie VALUES
(1, 'Cão', 'p'),
(2, 'Cão', 'm'),
(3, 'Cão', 'g'),
(4, 'Gato', 'p'),
(5, 'Gato', 'm'),
(6, 'Gato', 'g');

INSERT INTO Temperamento VALUES
(1, 'Introvertido', 'm'),
(2, 'Extrovertido', 'a'),
(3, 'Arisco', 'm'),
(4, 'Calmo', 'b');

-- Cães de pequeno porte
INSERT INTO Raca (nomeRaca, idEsp) VALUES
('Poodle', 1),
('Shih Tzu', 1),
('Lhasa Apso', 1),
('Yorkshire', 1);

-- Cães de médio porte
INSERT INTO Raca (nomeRaca, idEsp) VALUES
('Beagle', 2),
('Bulldog', 2),
('Cocker Spaniel', 2),
('Schnauzer', 2);

-- Cães de grande porte
INSERT INTO Raca (nomeRaca, idEsp) VALUES
('Pastor Alemão', 3),
('Golden Retriever', 3),
('Rottweiler', 3),
('Doberman', 3);

-- Gatos de pequeno porte
INSERT INTO Raca (nomeRaca, idEsp) VALUES
('Singapura', 4),
('Munchkin', 4);

-- Gatos de médio porte
INSERT INTO Raca (nomeRaca, idEsp) VALUES
('Siamês', 5),
('Persa', 5),
('Bengal', 5);

-- Gatos de grande porte
INSERT INTO Raca (nomeRaca, idEsp) VALUES
('Exótico', 6),
('Ragdoll', 6),
('Maine Coon', 6);

INSERT INTO Pet (
    nomePet,
    sexoPet,
    descricaoPet,
    idEsp,
    idTem,
    linkImagemPet,
    idUsu,
    idRaca
) VALUES
(
    'Rexstone',
    'm',
    'Carinhoso, brincalhão com as crianças. Vacinado e sadio.',
    2,
    2,
    'https://s2-g1.glbimg.com/TdPTg4jg3ZqtmZtyFnuHehXLgmk=/0x314:720x1073/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_59edd422c0c84a879bd37670ae4f538a/internal_photos/bs/2019/B/x/gU7r6UTvyFwLn5G5FlUg/whatsapp-image-2019-02-22-at-14.53.02.jpeg',
    1,
    NULL
),
(
    'Pedro',
    'm',
    'Extrovertido quando quer, contido. Não-vacinado e sadio.',
    6,
    4,
    'https://i.redd.it/6awu42gnlasc1.jpeg',
    1,
    NULL
),
(
    'Florinda',
    'f',
    'Bem arisca, foi vítima de maus-tratos. Vacinada, mas é bem raivosa e fraca.',
    5,
    3,
    'https://preview.redd.it/z1seq6b71d851.jpg?width=1080&crop=smart&auto=webp&s=a52fe92b54bb99e8d3ec15d0562c1437e7eb437c',
    1,
    NULL
),
(
    'Joaninha',
    'f',
    'Muito carentinha, dócil, excelente companheira. Sadia e vacinada, é filhote de Bulldog.',
    1,
    2,
    'https://www.chefbob.com.br/cdn/shop/articles/2020-05-08-como-cuidar-de-uma-cadelinha-no-cio_jpg.webp?v=1756847533',
    1,
    6
);
