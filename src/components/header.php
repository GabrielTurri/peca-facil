<?php
$json = file_get_contents("produtos.json");

if ($json === false) {
  die("Erro ao ler o json");
}

$produtos = json_decode($json, true);
if ($produtos === null){
  die("Erro ao decodificar produtos");
}

$tipos_hardwares = [];
$tipos_perifericos = [];

// Procurar o produto pela categoria
foreach ($produtos as $produto) { 
  if($produto['categoria'] == "hardware"){
    if(in_array($produto['tipo'], $tipos_hardwares)){
    } else{
      array_push($tipos_hardwares, $produto['tipo']);
    }
  } else if($produto['categoria'] == "periferico"){
    if(in_array($produto['tipo'], $tipos_perifericos)){
    } else{
      array_push($tipos_perifericos, $produto['tipo']);
    }
  }
}

?>

<div class="content-wraper">
  <div class="d-flex flex-row header">
    <a href="index.php"><h3>Peça Fácil</h3></a>

      <form class="d-flex flex-row search-input" action="pesquisa.php" method="POST">
        <input type="text" name="busca" class="input-pesquisar" autofocus placeholder="Digite o que procura...">
        
        <button class="botao-pesquisar icon">
          <img src="./assets/icons/magnifying-glass-solid.svg" alt="">
        </button>
      </form>

    <div class="d-flex flex-row gap-2 icones">
      <a href="./pages/favoritos.php" class="icon">
        <img src="./assets/icons/heart-regular.svg"  alt="">
      </a>
      <a href="./pages/alertas.php" class="icon">
        <img src="./assets/icons/bell-regular.svg" alt="">

      </a>

      <a href="login.php">
          <div class="botao-entrar d-flex flex-row icon">
            <img src="./assets/icons/user-regular.svg" alt="">
            <div class="d-flex flex-column">
              <span>Entrar ou</span>
              <span>fazer cadastro</span>
            </div>
          </div>
      </a>     
    </div>

  </div>
  <hr>

  <div class="d-flex flex-row navbar">

    <div class="dropdown">
      <button class="dropdown-button menu-item dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Hardware
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <?php
        foreach($tipos_hardwares as $hardware){
          echo "<a class='dropdown-item' href='categoria_produtos.php?categoria={$hardware}'>".ucfirst($hardware)."</a>";
        }
      ?>

      </div>
    </div>
    <div class="linha-vertical"> </div>

    <div class="dropdown">
      <button class="dropdown-button menu-item dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Periféricos
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <?php
        foreach($tipos_perifericos as $periferico){
          echo "<a class='dropdown-item' href='categoria_produtos.php?categoria={$periferico}'>".ucfirst($periferico)."</a>";
        }
      ?>

      </div>
    </div>
    <div class="linha-vertical"> </div>
    <a class="menu-item" href="#">Ofertas</a>
    <div class="linha-vertical"> </div>
    <a class="menu-item" href="#">Cupons</a>
    <div class="linha-vertical"> </div>
    <a class="menu-item" href="lojas.php">Lojas Parceiras</a>
  </div>
</div>