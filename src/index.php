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

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="global.css">
  <link rel="stylesheet" href="./styles/header.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peça Fácil</title>
</head>
<body>

  <div class="page-container">
    <div class="content-wrap">
      <?php include_once('./components/header.php') ?>
      
      <h3>Produtos em destaque</h3>
      <div class="d-flex flex-row flex-wrap gap-2 my-2 justify-content-center align-items-start">
        <?php

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $valorProcurado = $_POST['busca'];

            $encontrado = 0;
                      
            // Verificar se a decodificação foi bem-sucedida
            if ($produtos === null) {
              die('Erro ao ler o arquivo JSON');
            }

            // Procurar o produto pelo nome
            foreach ($produtos as $produto) {
              $menor_preco = 99999;
              $loja_menor_preco = "";
              
              foreach($produto['lojas'] as $loja){
                if($loja['preco'] < $menor_preco){
                  $menor_preco = $loja['preco'];
                  $loja_menor_preco = $loja['loja'];
                }
              }

              $preco_medio = round($soma_preco/$qtde_lojas,2);
              if(stripos($produto['nome'], $valorProcurado) !== false){
                echo "
                <a href='produto.php?id={$produto['id']}'>
                  <div class='product-card shadow bg-white d-flex flex-column rounded p-2 h-100'>
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
            
            // criar o card de cada produto
            foreach($produtos as $produto){
              $menor_preco = 99999;
              $loja_menor_preco = ""; 
              $quantidade_total = 0;
              
              foreach($produto['lojas'] as $loja){
                if($loja['preco'] < $menor_preco){
                  $menor_preco = $loja['preco'];
                  $loja_menor_preco = $loja['loja'];
                }

                if($loja['quantidade'] > 0){
                  $quantidade_total += $loja['quantidade'];
                }
              }
              if($quantidade_total > 0){

                
                echo "<a href='produto.php?id={$produto['id']}'>
                <div class='product-card bg-white h-100 d-flex flex-column rounded p-2'>
                <img class='imagem rounded' src='{$produto['imagem']}' alt='imagem do produto'>
                <span class='fw-bold'>{$produto['nome']}</span>
                <span>Menor preço via <i><strong>{$loja_menor_preco}!</strong></i></span>
                <span>Menor Preço - R$".$menor_preco."</span>
                </div>
                </a>";
              }
            }
          }
          ?>
      </div>  
    </div>
    <?php include_once('./components/footer.html'); ?>
  </div>  

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>