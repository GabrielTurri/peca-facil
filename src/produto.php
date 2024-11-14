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
foreach ($produtos as $a) {
    if ($a['id'] == $id_produto) {
        $produto = $a;
        break;
    }
}

// Se o produto não for encontrado, exibir uma mensagem de erro
if ($produto === null) {
    die('Produto não encontrado.');
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
  <?php
    echo "<h1>{$produto['nome']}</h1>";
    echo "<img src='{$produto['imagem']}' alt='imagem do produto'>";
    
    // Achar preço médio do produto nas lojas que possuem ele
    $soma_preco = 0;
    $preco_medio = 0;
    $qtde_lojas = 0;

    foreach($produto['lojas'] as $loja){

        $soma_preco += $loja['preco'];
        $qtde_lojas +=1;
    }
    $preco_medio = round($soma_preco/$qtde_lojas,2);
    echo "<h4>Preço médio do produto nas lojas: R$".$preco_medio."</h4>";

    echo "<h3>Descrição do produto:</h3>";
    foreach($produto['descricao'] as $descricao){
        echo "<p>{$descricao}</p>";
    }

    echo "<h4>Ofertas nas lojas</h4>";
    foreach($produto['lojas'] as $loja){
        echo "<div><a href='{$loja['link']}' target='_blank'>
                <h3>{$loja['loja']}</h3>
                <h4>Preço: {$loja['preco']}</h4>
                <h5>Clique para ir para a loja!!!</h5>
            </a></div>";
    }     
  ?>
  </div>
  

  <footer></footer>  
</body>
</html>