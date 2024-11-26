<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/header.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peça Fácil | Alertas</title>
</head>
<body>
    <?php 
        // include_once('../components/header.php')
    ?>



    <div class="content-wraper d-flex flex-column">
        <div class="alerta-container">
            <a href="../index.php" class="botao-voltar">
                Voltar ao início
            </a>
            <span class="title text-center">Alertas configurados</span>
        </div>
        <div class="card-alerta bg-white d-flex flex-row">
            <div class="d-flex flex-row">
                <!-- <img src="" alt=""> -->
                 <div class="d-flex flex-column">
                    <span class="title">Nome do produto</span>
                    <span class="preco">R$200,00</span>
                 </div>
                 <div>
                    <button>Ver ofertas</button>
                 </div>

            </div>
        </div>
    </div>
    
    
</body>

<?php include_once('../components/footer.html')?>

</html>