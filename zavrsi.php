
<?php 
    include_once('./includes/header_index.php');

    include_once('./cart.php');
?>

<div class="container">
    <div class="container-inner">
        <div class="prikaz">

        <?php

            $userId = (int)$_SESSION['user_id'];
            $konacna_cena = $_SESSION['cart_total'];

            if($konacna_cena > 0)
            {
                $porudzbina_id = $connection->dodajPorudzbinu($userId, $konacna_cena);
                
                $connection->dodajProizvodeUPorudzbinu($porudzbina_id, $_SESSION['item_cart']);

                
                $korpa->isprazniKorpu();
                
                echo 'Uspesno ste poslali Vasu porudzbinu, u vrednosti od '. $konacna_cena . ' dinara.';

                session_destroy();
                
            }

        ?>

        </div>

    </div>
</div>



<?php include_once('./includes/footer.php'); ?>
