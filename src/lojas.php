<?php
  include_once("classes.php");

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
  $lista_lojas = [];
  $lojas = [];



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

    // salvar lojas no array das lojas
    foreach($produto['lojas'] as $loja){
      if(!in_array($loja['loja'], $lista_lojas)){
        array_push($lista_lojas, trim($loja['loja']));

        $parse_url = parse_url($loja['link']);
        $link_loja = $parse_url['scheme'] . '://' . $parse_url['host'];
        $nova_loja = new Loja($loja['loja'], $link_loja, $loja['icone']);

        array_push($lojas, $nova_loja);
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="global.css">
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peça Fácil</title>
</head>
<body class="bg-light">
<div class="content-wraper">
  <div class="d-flex flex-row justify-content-between align-items-center pt-2">
  <a href="index.php"><h3>Peça Fácil</h3></a>
    <div class="d-flex flex-row">
      <form action="" method="POST">
        <input type="text" name="busca" class="rounded-start border py-2 search-input" autofocus placeholder="Digite o que procura...">
        
        <button class="rounded-end border-0 px-2">
          <img src="./assets/icons/magnifying-glass-solid.svg" class="icon botao-pesquisar" alt="">
        </button>
      </form>

    </div>
    <div class="d-flex flex-row gap-2">
      <img src="./assets/icons/heart-regular.svg" class="icon" alt="">
      <img src="./assets/icons/bell-regular.svg" class="icon" alt="">

      <a href="login.html">
          <div class="botao-entrar d-flex flex-row">
            <img src="./assets/icons/user-regular.svg" class="icon" alt="">
            <span>Entrar ou fazer cadastro</span>
          </div>
      </a>     
    </div>

  </div>
  <div class="d-flex flex-row justify-content-around gap-2 my-4">

    <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

    <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <a href="#">Ofertas</a>
    <a href="#">Cupons</a>
    <a href="lojas.php">Lojas Parceiras</a>
  </div>
  
  <h2>Lojas Parceiras</h2>
  <div class="d-flex flex-row flex-wrap gap-2 my-2 justify-content-center">
  <?php
  // mostar cada loja no array lojas
    foreach ($lojas as $loja) {
        echo "<a href='{$loja->link}' target='_blank'>
          <h2>{$loja->nome}</h2>
          <img src='{$loja->icone}' alt='Icone da loja'>
        </a>";
      
    }  
  ?>
  </div>
  <footer></footer>  
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>