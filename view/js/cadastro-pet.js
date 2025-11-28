const selEspecie = document.querySelector("#select-especie-pet");
const selTemRaca = document.querySelector("#select-tem-raca-pet");
const selRaca = document.querySelector("#select-raca-pet");
const divErro = document.querySelector("#erros");

const URL_BASE = document.querySelector("#confUrlBase").dataset.urlBase;

selTemRaca.addEventListener("change", function () {
  const temRaca = this.value;

  if (temRaca === "1") {
    let idEspecie = selEspecie.value;

    const xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      URL_BASE + "/api/racas_por_especie.php?idEspecie=" + idEspecie,
      true
    );

    // Necessário para atualizar o select só com a mudança do campo "tem racça?".
    xhr.onload = function () {
      if (xhr.status === 200) {
        const racas = JSON.parse(xhr.responseText);
        racas.forEach((raca) => {
          const option = document.createElement("option");
          option.value = raca.id;
          option.text = raca.nome;
          selRaca.appendChild(option);
        });
      } else {
        console.error("Erro na requisição AJAX");
      }
    };

    xhr.send();

    const divPaiSelRaca = selRaca.parentElement;
    divPaiSelRaca.classList.remove("d-none");

    selEspecie.addEventListener("change", function () {
      idEspecie = this.value;

      // Limpa o select de raças
      selRaca.innerHTML = '<option value="">Escolha a raça...</option>';

      if (!idEspecie) return; // nada selecionado, sai

      // AJAX
      const xhr = new XMLHttpRequest();
      xhr.open(
        "GET",
        URL_BASE + "/api/racas_por_especie.php?idEspecie=" + idEspecie,
        true
      );

      xhr.onload = function () {
        if (xhr.status === 200) {
          const racas = JSON.parse(xhr.responseText);
          racas.forEach((raca) => {
            const option = document.createElement("option");
            option.value = raca.id;
            option.text = raca.nome;
            selRaca.appendChild(option);
          });
        } else {
          console.error("Erro na requisição AJAX");
        }
      };

      xhr.send();
    });
  } else {
    const divPaiSelRaca = selRaca.parentElement;
    divPaiSelRaca.classList.add("d-none");

    // Remover valores do select quando a raça for ignorada.
    selRaca.innerHTML = '<option value="">Escolha a raça...</option>';
  }
});

// Salvar com AJAX
function salvarPetAjax() {
  const nomePet = document.querySelector("#input-nome-pet").value;
  const sexoPet = document.querySelector("#select-sexo-pet").value;
  const especiePet = selEspecie.value;
  const temRacaPet = selTemRaca.value;
  const racaPet = selRaca.value;
  const temperamentoPet = document.querySelector(
    "#select-temperamento-pet"
  ).value;
  const linkImagemPet = document.querySelector("#input-imagem-pet").value;
  const descricaoPet = document.querySelector("#input-descricao-pet").value;

  let idUsu = null;
  let idPet = null;
  if (document.querySelector("#idDoUsuario")) {
    idUsu = document.querySelector("#idDoUsuario").dataset.idUsuario;
  } else {
    idPet = document.querySelector("#idDoPet").dataset.idPet;
  }

  const dados = new FormData();
  dados.append("nomePet", nomePet);
  dados.append("sexoPet", sexoPet);
  dados.append("especiePet", especiePet);
  dados.append("temRacaPet", temRacaPet);
  dados.append("temperamentoPet", temperamentoPet);
  dados.append("linkImagemPet", linkImagemPet);
  dados.append("descricaoPet", descricaoPet);

  // Possíveis nulos.
  dados.append("racaPet", racaPet);
  dados.append("idUsu", idUsu);
  dados.append("idPet", idPet);

  const xhttp = new XMLHttpRequest();

  if (idUsu) {
    xhttp.open("POST", URL_BASE + "/api/cadastrar_pet.php");
  } else {
    xhttp.open("POST", URL_BASE + "/api/atualizar_pet.php");
  }

  xhttp.onload = function () {
    const erros = xhttp.responseText;
    if (erros) {
      divErro.innerHTML = erros;
    } else {
      window.location = URL_BASE + "/view/pets-proprios.php";
    }
  };

  xhttp.send(dados);
}
