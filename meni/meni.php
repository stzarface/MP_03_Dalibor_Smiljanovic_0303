<?php  include_once('../initdb.php'); ?>
<?php include_once('../includes/header.php'); ?>

<?php

if(isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
}

?>


<?php 
    if(!isset($_SESSION['user'])) {
        $prijavi_se = "Morate biti prijavljeni da biste porucili.";
    }
?>

<h2 style="color:red"><?php if(isset($prijavi_se)) echo $prijavi_se;  ?></h2>

<div class="container">
    <h2>Menu</h2>
    <div class="container-inner">
        <div class="container-inner-menu">
            
            <?php 
                $proizvodi = $connection->nizProizvoda();

                foreach($proizvodi as $proizvod) {

                    echo "<div class='card' id='$proizvod[0]'>";
                        echo "<div class='card-image'>";
                            echo "<img src='.$proizvod[3].' />";
                        echo "</div>";
                        echo "<div class='card-text'>";
                            echo "<h3>".$proizvod[1]."</h3>";
                            echo "<p> Cena: ".$proizvod[2]." rsd</p>";

                            if(isset($_SESSION['user'])) {
                                echo "<button id='naruci' type='button' onclick=\"naruci($proizvod[0],'$proizvod[1]', $proizvod[2])\" >Naruči</button>";
                            }
                        echo "</div>";
                    echo "</div>";
                }
            ?>

        </div>
    </div>
</div>


<div class="container">
    <div class="container-inner">
        <div class="container-inner-menu">
            <div class="meni-bottom">

                <?php
                    if(isset($_SESSION['user'])) {

                        echo "<a id='prikaz' href='../prikaz.php'>Prikaži korpu</a>
                        ";

                        echo "<form id='isprazni' method='POST' action='../isprazni.php'>";
                        echo "<input type='hidden' name='isprazni' />";
                        echo "<input type='submit' value='Isprazni korpu' />";
                        echo "</form>";

                        echo "<form id='logout' action='../logout/logout.php'><input type='submit' value='Logout'/></form>";

                    }

                ?>
            </div>
        </div>
    </div>
</div>


    



<script>
        const naruci = (id, naziv, price) => {
            data = {
                id: id,
                naziv: naziv,
                price: price
            };
            data = JSON.stringify(data);
            console.log(data)
            fetch('../porudzbina.php',{
                method: "POST",
                body: data,
            }).then((response) => {
                response.json().then((data)=> {
                    if(data.response == 'success') {
                        alert(`Uspesno ste dodali u korpu ` + naziv);
                    } else {
                        alert('Niste dodali u korpu');
                    }
                });
            })
        }
    </script>




<?php include_once('../includes/footer.php'); ?>