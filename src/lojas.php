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
  <link rel="stylesheet" href="./styles/header.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peça Fácil</title>
</head>
<body>
<?php include_once('./components/header.php') ?>

<div class="content-wraper mt-4">
  <h4 class="text-center">Lojas Parceiras</h4>
  <div class="d-flex flex-row flex-wrap gap-2 my-2 justify-content-center">
  <?php
  // mostar cada loja no array lojas
    foreach ($lojas as $loja) {
        echo "
        <a href='{$loja->link}' target='_blank'>
          <div class='bg-white p-3 rounded text-center card-loja'>
            <img class='logo-loja' src='{$loja->icone}' alt='Icone da loja'>
            <h3>{$loja->nome}</h3>
          </div>
        </a>
        
        ";
      
    }  
  ?>
  </div>
  </div>
  <?php include_once('./components/footer.html');  ?> 
    
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>