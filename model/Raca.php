<?php 

require_once(__DIR__ . "/Especie.php");

class Raca implements JsonSerializable{

    private ?int $idRaca;
    private ?string $nomeRaca;

   public function __construct($idRaca, $nomeRaca) {
        $this->idRaca = $idRaca;
        $this->nomeRaca = $nomeRaca;
    }

    public function jsonSerialize(): array{
        return array("id" => $this->idRaca,
                     "nome" => $this->nomeRaca);
    }
    
    public function __toString(){
        return $this->nomeRaca;
    }

    /**
     * Get the value of id
     */
    public function getIdRaca(): ?int
    {
        return $this->idRaca;
    }

    /**
     * Set the value of id
     */
    public function setIdRaca(int $idRaca): self
    {
        $this->idRaca = $idRaca;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNomeRaca(): ?string
    {
        return $this->nomeRaca;
    }

    /**
     * Set the value of nome
     */
    public function setNomeRaca(?string $nomeRaca): self
    {
        $this->nomeRaca = $nomeRaca;

        return $this;
    }
}