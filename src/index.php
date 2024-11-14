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
    <h3>Peça Fácil</h3>
    <div class="d-flex flex-row">
      <input type="text" class="rounded-start border py-2 search-input">
      <button class="rounded-end border-0 px-2">
          <img src="./assets/icons/magnifying-glass-solid.svg" class="icon botao-pesquisar" alt="">
      </button>
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
    <a href="#">Hardware</a>
    <a href="#">Periféricos</a>
    <a href="#">Ofertas</a>
    <a href="#">Cupons</a>
    <a href="#">Lojas Parceiras</a>
  </div>
  
  <h2>Produtos em destaque</h2>
  <div class="d-flex flex-row flex-wrap gap-2 my-2 justify-content-center">
  <?php
    $json = file_get_contents("produtos.json");

    if ($json === false) {
      die("Erro ao ler o json");
    }

    $json_data = json_decode($json, true);
    if ($json_data === null){
      die("Erro ao decodificar json_data");
    }

    foreach($json_data as $produto){
      echo "<a href='produto.html'>
      <div class='product-card bg-white d-flex flex-column rounded p-2'>
        <img class='imagem rounded' src='{$produto['imagem']}' alt='imagem do produto'>
        <span class='fw-bold'>{$produto['nome']}</span>
        <span>R$1,00</span>
      </div>
    </a>";
    }

  ?>
  </div>

  <footer></footer>
  
  
</body>
</html>