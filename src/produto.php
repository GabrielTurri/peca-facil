<?php
// Verificar se o parâmetro 'id' foi passado na URL
if (!isset($_GET['id'])) {
    die('ID do produto não especificado.');
}

// Obter o ID do produto da URL
$id_produto = $_GET['id'];

// Carregar o arquivo JSON
$json = file_get_contents('produtos.json');

// Decodificar o JSON em um array PHP
$produtos = json_decode($json, true);

// Verificar se a decodificação foi bem-sucedida
if ($produtos === null) {
    die('Erro ao ler o arquivo JSON');
}

// Procurar o produto pelo ID
$produto = null;
$tipos_hardwares = [];
$tipos_perifericos = [];
$lista_lojas = [];
$lojas = [];


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

    if ($produto['id'] == $id_produto) {
        $produto_selecionado = $produto;
    }
}

// Se o produto_selecionado não for encontrado, exibir uma mensagem de erro
if ($produto_selecionado === null) {
    die('Produto não encontrado.');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="global.css">
  <link rel="stylesheet" href="./styles/produto.css">

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
    <a class="menu-item" href="#">Ofertas</a>
    <div class="linha-vertical"> </div>
    <a class="menu-item" href="#">Cupons</a>
    <div class="linha-vertical"> </div>
    <a class="menu-item" href="lojas.php">Lojas Parceiras</a>
  </div>
<div class="content-wraper">
  <div class="produto-container">

  <a href="./index.php" class="botao-voltar">
    Voltar ao início
  </a>
  <div class="d-flex flex-row produto-info">
    <?php
      echo "<img class='imagem' src='{$produto_selecionado['imagem']}' alt='imagem do produto'>";
      echo "<div class='d-flex flex-column'>";
      echo "<span class='title'>{$produto_selecionado['nome']}</span>";
      
      $menor_preco = 99999;
      $loja_menor_preco = ""; 
      $link_loja = "";

      foreach($produto_selecionado['lojas'] as $loja){
        if($loja['preco'] < $menor_preco){
          $menor_preco = $loja['preco'];
          $loja_menor_preco = $loja['loja'];
          $link_loja = $loja['link'];

        }
      }
      echo "
        <span class='sm-text'>Melhor oferta:</span>
        <span class='preco'>R$".$menor_preco."</span>
        <span class='sm-text'>em <a href='{$link_loja}' target='_blank'>{$loja_menor_preco}</a></span>
      ";
      echo "</div></div>";
      echo "<h3>Descrição do produto:</h3>";
      foreach($produto_selecionado['descricao'] as $descricao){
          echo "<p>{$descricao}</p>";
      }
    ?>
  
  <div class="lista-lojas d-flex flex-column">  
    <?php
      echo "<h2>Ofertas nas lojas</h2>";
      foreach($produto_selecionado['lojas'] as $loja){
        echo "
        <div class='d-flex flex-row oferta'>
          <div class='d-flex flex-row'>
            <img class='logo-loja' src='{$loja['icone']}' alt='logo da loja'>
            <div class='d-flex flex-column'>
              <span class='title'>{$loja['loja']}</span>
              <span class='preco'>R$"."{$loja['preco']}</span>
            </div>
          </div>
          <a href='{$loja['link']}' target='_blank'>
            <button class='botao-produto'>Ir à loja</button>
          </a>
            </div>
        ";
      }     
    ?>
    </div>
  </div>
</div>
  

  <footer></footer>  
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>