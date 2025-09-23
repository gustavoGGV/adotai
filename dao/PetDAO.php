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
      $sql = "SELECT p.*, e.nomeEsp, e.porteEsp, t.tipoTem, t.energiaTem, u.nomeUsu FROM Pet p JOIN Especie e ON (e.idEsp = p.idEsp) JOIN Temperamento t ON (t.idTem = p.idTem) JOIN Usuario u ON (u.idUsu = p.idUsu)";
      $stm = $this->conexao->prepare($sql);
      $stm->execute();
      $pets = $stm->fetchAll();

      $petsMapeados = $this->mapearPets($pets);

      return $petsMapeados;
    } catch (PDOException $e) {
      return $e;
    }
  }

  private function mapearPets(array $pets)
  {
    $petsMapeados = array();

    foreach ($pets as $pet) {
      $especie = new Especie($pet["idEsp"], $pet["nomeEsp"], $pet["porteEsp"]);
      $temperamento = new Temperamento($pet["idTem"], $pet["tipoTem"], $pet["energiaTem"]);

      // Somente o nome e id são necessários para a página principal.
      $acolhedor = new Usuario($pet["idUsu"], $pet["nomeUsu"], null, null, null, null, null, null, null, null, null);

      $petMapeado = new Pet($pet["idPet"], $pet["nomePet"], $pet["sexoPet"], $pet["descricaoPet"], $pet["temRacaPet"], $especie, $temperamento, $pet["linkImagemPet"], $acolhedor);

      array_push($petsMapeados, $petMapeado);
    }

    return $petsMapeados;
  }
}
