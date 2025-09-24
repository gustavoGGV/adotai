<?php

require_once(__DIR__ . "/../util/Conexao.php");
require_once(__DIR__ . "/../model/Pet.php");
require_once(__DIR__ . "/../model/Especie.php");
require_once(__DIR__ . "/../model/Temperamento.php");

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
      $sql = "SELECT p.*, e.nomeEsp, e.porteEsp, t.tipoTem, t.energiaTem, u.nomeUsu FROM Pet p JOIN Especie e ON (e.idEsp = p.idEsp) JOIN Temperamento t ON (t.idTem = p.idTem) JOIN Usuario u ON (u.idUsu = p.idUsu) ORDER BY RAND()";
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
      $sql = "SELECT p.*, e.nomeEsp, e.porteEsp, t.tipoTem, t.energiaTem FROM Pet p JOIN Especie e ON (e.idEsp = p.idEsp) JOIN Temperamento t ON (t.idTem = p.idTem) WHERE idUsu = ?";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$idUsu]);
      $petsEncontrados = $stm->fetchAll();

      $petsEncontradosMapeados = null;
      if ($petsEncontrados) {
        $petsEncontradosMapeados = $this->mapearPets($petsEncontrados, false);
      }

      return $petsEncontradosMapeados;
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function inserirPet(Pet $pet)
  {
    try {
      $sql = "INSERT INTO Pet (idPet, nomePet, sexoPet, descricaoPet, temRacaPet, idEsp, idTem, linkImagemPet, idUsu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$pet->getIdPet(), $pet->getNomePet(), $pet->getSexoPet(), $pet->getDescricaoPet(), $pet->getTemRacaPet() ? 1 : 0, $pet->getEspecie()->getIdEsp(), $pet->getTemperamento()->getIdTem(), $pet->getLinkImagemPet(), $pet->getAcolhedor()->getIdUsu()]);

      return null;
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function buscarPetPorId(string $idPet)
  {
    try {
      $sql = "SELECT p.*, e.nomeEsp, e.porteEsp, t.tipoTem, t.energiaTem FROM Pet p JOIN Especie e ON (e.idEsp = p.idEsp) JOIN Temperamento t ON (t.idTem = p.idTem) WHERE idPet = ?";
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
      $sql = "UPDATE Pet SET nomePet = ?, sexoPet = ?, descricaoPet = ?, temRacaPet = ?, idEsp = ?, idTem = ?, linkImagemPet = ? WHERE idPet = ?";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$pet->getNomePet(), $pet->getSexoPet(), $pet->getDescricaoPet(), $pet->getTemRacaPet() ? 1 : 0, $pet->getEspecie()->getIdEsp(), $pet->getTemperamento()->getIdTem(), $pet->getLinkImagemPet(), $pet->getIdPet()]);

      return null;
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function deletarPetPorId(string $idPet)
  {
    try {
      $sql = "DELETE FROM Pet WHERE idPet = ?";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$idPet]);

      return null;
    } catch (PDOException $e) {
      return $e;
    }
  }

  private function mapearPets(array $pets, bool $precisaDeAcolhedor = true)
  {
    $petsMapeados = array();

    foreach ($pets as $pet) {
      $especie = new Especie($pet["idEsp"], $pet["nomeEsp"], $pet["porteEsp"]);
      $temperamento = new Temperamento($pet["idTem"], $pet["tipoTem"], $pet["energiaTem"]);

      // Somente o nome e id são necessários para a página principal.
      if ($precisaDeAcolhedor) {
        $acolhedor = new Usuario($pet["idUsu"], $pet["nomeUsu"], null, null, null, null, null, null, null, null, null, null);
        $petMapeado = new Pet($pet["idPet"], $pet["nomePet"], $pet["sexoPet"], $pet["descricaoPet"], $pet["temRacaPet"], $especie, $temperamento, $pet["linkImagemPet"], $acolhedor);
      } else {
        $petMapeado = new Pet($pet["idPet"], $pet["nomePet"], $pet["sexoPet"], $pet["descricaoPet"], $pet["temRacaPet"], $especie, $temperamento, $pet["linkImagemPet"], null);
      }

      array_push($petsMapeados, $petMapeado);
    }

    return $petsMapeados;
  }
}
