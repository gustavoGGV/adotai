<?php

require_once __DIR__ . "/../util/Conexao.php";
require_once __DIR__ . "/../model/Pet.php";
require_once __DIR__ . "/../model/Especie.php";
require_once __DIR__ . "/../model/Temperamento.php";
require_once __DIR__ . "/../model/Raca.php";

class PetDAO
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function dadosDeTodosOsPets()
    {
        try {
            $sql =
                "SELECT p.*, e.nomeesp, e.porteesp, t.tipotem, t.energiatem, u.nomeusu, r.nomeraca FROM pet p JOIN especie e ON (e.idesp = p.idesp) JOIN temperamento t ON (t.idtem = p.idtem) JOIN usuario u ON (u.idusu = p.idusu) LEFT JOIN raca r on (r.idraca = p.idraca) ORDER BY random()";
            $stm = $this->conexao->prepare($sql);
            $stm->execute();
            $pets = $stm->fetchAll();

            $petsMapeados = $this->mapearPets($pets);

            return $petsMapeados;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function buscarPetsPorIdDeUsuário(string $idUsu)
    {
        try {
            $sql =
                "SELECT p.*, e.nomeesp, e.porteesp, t.tipotem, t.energiatem, r.nomeraca FROM pet p JOIN especie e ON (e.idesp = p.idesp) JOIN temperamento t ON (t.idtem = p.idtem) LEFT JOIN raca r on (r.idraca = p.idraca) WHERE idusu = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$idUsu]);
            $petsEncontrados = $stm->fetchAll();

            $petsEncontradosMapeados = $this->mapearPets(
                $petsEncontrados,
                false,
            );

            return $petsEncontradosMapeados;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function inserirPet(Pet $pet)
    {
        try {
            $sql =
                "INSERT INTO pet (idpet, nomepet, sexopet, descricaopet, idesp, idtem, linkimagempet, idusu, idraca) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $pet->getIdPet(),
                $pet->getNomePet(),
                $pet->getSexoPet(),
                $pet->getDescricaoPet(),
                $pet->getEspecie()->getIdEsp(),
                $pet->getTemperamento()->getIdTem(),
                $pet->getLinkImagemPet(),
                $pet->getAcolhedor()->getIdUsu(),
                $pet->getRaca()->getIdRaca()
                    ? $pet->getRaca()->getIdRaca()
                    : null,
            ]);

            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function buscarPetPorId(string $idPet)
    {
        try {
            $sql =
                "SELECT p.*, e.nomeesp, e.porteesp, t.tipoTem, t.energiatem, r.nomeraca FROM pet p JOIN especie e ON (e.idesp = p.idesp) JOIN temperamento t ON (t.idtem = p.idtem) LEFT JOIN raca r on (r.idraca = p.idraca) WHERE idpet = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$idPet]);
            $pet = $stm->fetchAll();

            $petMapeado = null;
            if (count($pet) > 0 && count($pet) < 2) {
                $petMapeado = $this->mapearPets($pet, false);
            }

            return $petMapeado[0];
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function alterarInformacoesPet(Pet $pet)
    {
        try {
            $sql =
                "UPDATE pet SET nomepet = ?, sexopet = ?, descricaopet = ?, idesp = ?, idtem = ?, linkimagempet = ?, idraca = ? WHERE idpet = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $pet->getNomePet(),
                $pet->getSexoPet(),
                $pet->getDescricaoPet(),
                $pet->getEspecie()->getIdEsp(),
                $pet->getTemperamento()->getIdTem(),
                $pet->getLinkImagemPet(),
                $pet->getRaca()->getIdRaca(),
                $pet->getIdPet(),
            ]);

            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function deletarPetPorId(string $idPet)
    {
        try {
            $sql = "DELETE FROM pet WHERE idpet = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$idPet]);

            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    private function mapearPets(array $pets, bool $precisaDeAcolhedor = true)
    {
        $petsMapeados = [];

        foreach ($pets as $pet) {
            $especie = new Especie(
                $pet["idesp"],
                $pet["nomeesp"],
                $pet["porteesp"],
            );
            $temperamento = new Temperamento(
                $pet["idtem"],
                $pet["tipotem"],
                $pet["energiatem"],
            );
            $raca = $pet["idraca"]
                ? new Raca($pet["idraca"], $pet["nomeraca"])
                : null;

            // Somente o nome e id são necessários para a página principal.
            if ($precisaDeAcolhedor) {
                $acolhedor = new Usuario(
                    $pet["idusu"],
                    $pet["nomeusu"],
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                );
                $petMapeado = new Pet(
                    $pet["idpet"],
                    $pet["nomepet"],
                    $pet["sexopet"],
                    $pet["descricaopet"],
                    $especie,
                    $temperamento,
                    $pet["linkimagempet"],
                    $acolhedor,
                    $raca ? $raca : null,
                    null,
                );
            } else {
                $petMapeado = new Pet(
                    $pet["idpet"],
                    $pet["nomepet"],
                    $pet["sexopet"],
                    $pet["descricaopet"],
                    $especie,
                    $temperamento,
                    $pet["linkimagempet"],
                    null,
                    $raca ? $raca : null,
                    null,
                );
            }

            array_push($petsMapeados, $petMapeado);
        }

        return $petsMapeados;
    }
}
