<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  // Redireciona para uma página dentro do mesmo site
  header("Location: index.php");
  exit;
  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="global.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peça Fácil</title>
</head>
<body>
<div class="content-wraper">
  <div class="d-flex flex-row header">
    <a href="index.php"><h3>Peça Fácil</h3></a>

      <form class="d-flex flex-row search-input" action="pesquisa.php" method="POST">
        <input type="text" name="busca" class="input-pesquisar" autofocus placeholder="Digite o que procura...">
        
        <button class="botao-pesquisar">
          <img src="./assets/icons/magnifying-glass-solid.svg" class="icon" alt="">
        </button>
      </form>

    <div class="d-flex flex-row gap-3">
      <img src="./assets/icons/heart-regular.svg" class="icon" alt="">
      <img src="./assets/icons/bell-regular.svg" class="icon" alt="">

      <a href="login.php">
          <div class="botao-entrar d-flex flex-row">
            <img src="./assets/icons/user-regular.svg" class="icon" alt="">
            <span>Entrar ou fazer cadastro</span>
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
    <a class="menu-item" href="./index.php">Ofertas</a>
    <div class="linha-vertical"> </div>
    <a class="menu-item" href="#">Cupons</a>
    <div class="linha-vertical"> </div>
    <a class="menu-item" href="lojas.php">Lojas Parceiras</a>
  </div>
</div>
<div class="content-wraper">

  <a href="./index.php" class="botao-voltar">
    Voltar ao início
  </a>
  <h2>Resultados da Pesquisa:</h2>
  <div class="d-flex flex-row flex-wrap gap-2 my-2 justify-content-center">
  <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $json = file_get_contents("produtos.json");

      if ($json === false) {
        die("Erro ao ler o json");
      }

      $valorProcurado = $_POST['busca'];

      $encontrado = 0;

      $produtos = json_decode($json, true);
                 
      // Verificar se a decodificação foi bem-sucedida
      if ($produtos === null) {
        die('Erro ao ler o arquivo JSON');
      }

      // Procurar o produto pelo nome
      foreach ($produtos as $produto) {
        $soma_preco = 0;
        $preco_medio = 0;
        $qtde_lojas = 0;
        $menor_preco = 99999;
        $loja_menor_preco = "";
        
        foreach($produto['lojas'] as $loja){
          $soma_preco += $loja['preco'];
          $qtde_lojas +=1;

          if($loja['preco'] < $menor_preco){
            $menor_preco = $loja['preco'];
            $loja_menor_preco = $loja['loja'];
          }
        }

        $preco_medio = round($soma_preco/$qtde_lojas,2);
        if(stripos($produto['nome'], $valorProcurado) !== false){
          echo "<a href='produto.php?id={$produto['id']}'>
            <div class='product-card bg-white d-flex flex-column rounded p-2'>
              <img class='imagem rounded' src='{$produto['imagem']}' alt='imagem do produto'>
              <span class='fw-bold'>{$produto['nome']}</span>
              <span>Menor preço via <i><strong>{$loja_menor_preco}!</strong></i></span>
              <span>Menro Preço - R$".$menor_preco."</span>
            </div>
          </a>";
          $encontrado += 1;
        } 
      }  
      if ($encontrado == 0){
        echo "<h3>Produto não encontrado!</h3>";
      }
    }
    else{
      header("Location: index.php");
      exit;
    }
  ?>
  </div>

  <footer></footer>  
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>