<?php include_once('../initdb.php'); ?>
<?php include_once('../includes/header.php'); ?>

<?php

//ako korisnik vec postoji u sesiji
if(isset($_SESSION['user'])) {
    header('Location: ../meni/meni.php');
}

if (isset($_POST['email']) && isset($_POST['pass'])) {
    if($connection->registrujKorisnika($_POST['email'],$_POST['pass'])) {
        header('Location: ../login/login.php');
    }
    $greska = "Korisnik vec postoji";
}

?>


<div class="container">
    <div class="container-inner">
        <form id="register" action="./register.php" method="POST">
            <div class="row">
                <div class="form-left">
                    <label for="user">Korisnicko ime:</label>
                </div>
                <div class="form-right">
                    <input type="email" name="email" required placeholder="Unesite Vas email">
                </div>
            </div>

            <div class="row">
                <div class="form-left">
                    <label for="pass">Lozinka:</label>
                </div>
                <div class="form-right">
                    <input type="password" name="pass"  required  placeholder="Unesite Vasu lozinku">
                </div>
            </div>

            <div class="row">
                <div class="form-left">
                </div>
                <div class="form-right">
                    <input type="submit" value="Registruj se" id="submit">
                </div>
            </div>
            
        </form>

    </div>
    <p><?php if(isset($greska)) { echo $greska; }?></p>
</div>






















<?php include_once('../includes/footer.php'); ?>