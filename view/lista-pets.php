<?php

include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/acoes/adquirir-informacoes-dos-pets.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");

?>
<title>Adotaí | Lista de usuários</title>
</head>

<body>
  <?php
  include_once(__DIR__ . "/componentes/navbar.html");

  if (!$pets):
    echo "<h1>Sem pets!</h1>";

    return;
  endif;
  ?>
  <div class="container">
    <h4><a href="/adotai/view/pagina-principal.php" class="text-black text-decoration-none"><i class="bi bi-caret-left-fill"></i>Voltar</a></h4>
    <div class="table-responsive mt-5">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>É de raça?</th>
            <th>Espécie</th>
            <th>Temperamento</th>
            <th>Descrição</th>
            <th>Link da imagem</th>
            <th>Acolhedor</th>
            <th class="text-danger">Excluir</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($pets as $pet):
          ?>
            <tr>
              <td><?= $pet->getIdPet() ?></td>
              <td><?= $pet->getNomePet() ?></td>
              <td><?= $pet->getSexoPet() === "m" ? "Masculino" : "Feminino" ?></td>
              <td><?= $pet->getTemRacaPet() ? "Sim" : "Não" ?></td>
              <td><?= $pet->getEspecie()->listarEspecie() ?></td>
              <td><?= $pet->getTemperamento()->listarTemperamento() ?></td>
              <td><?= $pet->getDescricaoPet() ?></td>
              <td><a href="<?= $pet->getLinkImagemPet() ?>" class="text-decoration-none" target="_blank">Imagem do pet</a></td>
              <td><a class="text-decoration-none" href="/adotai/view/pagina-usuario.php/?idUsu=<?= $pet->getAcolhedor()->getIdUsu() ?>" target="_blank">Página do acolhedor</a></td>
              <td>
                <a class="text-white text-decoration-none bg-danger fs-3 ps-1 pe-1 rounded-3" href="/adotai/view/acoes/deletar-pet.php/?idPet=<?= $pet->getIdPet() ?>" onclick="return confirm('Deseja mesmo deletar o pet <?= $pet->getNomePet() ?>?')">
                  <i class="bi bi-x-octagon"></i>
                </a>
              </td>
            </tr>
          <?php
          endforeach;
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>