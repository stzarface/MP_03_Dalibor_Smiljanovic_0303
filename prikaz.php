<?php include_once('./cart.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <header>
        <nav>
        </nav> 
        <h1>Vaša_porudžnina</h1>
    </header>

<div class="container">
    <div class="container-inner">
        <div class="prikaz">

            <p><?php $korpa->listajKorpu(); ?></p>

            <a id='nazad' href="./meni/meni.php">Nazad</a>
            <a id='kupovina' href="./zavrsi.php">Zavrsi kupovinu</a>

        </div>

    </div>
</div>


<?php include_once('./includes/footer.php')  ?>
