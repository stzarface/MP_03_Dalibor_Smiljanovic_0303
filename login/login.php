

<?php include_once('../initdb.php') ?>
<?php include_once('../includes/header.php'); ?>


<?php


if(isset($_SESSION['user'])) {
    header('Location: ../meni/meni.php');
}

//ako korisnik vec postoji u cookies
if(isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
    header('Location: ../meni/meni.php');
}

//ako se korisnik upravo ulogovao
if(isset($_POST['user']) && isset($_POST['pass'])) {
    
    if($connection->proveriKorisnika($_POST['user'],$_POST['pass'])) {
        //ako je checkiran keep me logged in
        if(isset($_POST['keep'])) {
            setcookie("user",$_POST['user'],time()+60*60*24);
        }
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['user_id'] = $connection->getUserId($_POST['user']);
        header('Location: ../meni/meni.php');
    }
    $greska = true;
}

?>

<div class="container">
    <div class="container-inner">
        <form id="login" action="./login.php" method="POST">
            <div class="row">
                <div class="form-left">
                    <label for="user">Korisnicko ime:</label>
                </div>
                <div class="form-right">
                    <input type="email" name="user" id="user" required placeholder="Unesite Vas email">
                </div>
            </div>

            <div class="row">
                <div class="form-left">
                    <label for="password">Lozinka:</label>
                </div>
                <div class="form-right">
                    <input type="password" name="pass" id="pass"  required  placeholder="Unesite Vasu lozinku">
                </div>
            </div>

            <div class="row">
                <div class="form-left">
                    <label for="keep">Ostani prijavljen:</label>
                </div>
                <div class="form-right">
                    <input type="checkbox" name="keep" id="keep">
                </div>
            </div>

            <div class="row">
                <div class="form-left">
                    
                </div>
                <div class="form-right">
                    <input type="submit" value="Login" id="submit">
                    
                </div>
                
            </div>
            
        </form>

    </div>
</div>

            <?php if(isset($greska) && $greska) :?>
            <div id='greska'>Pogrešan unos. Proveri lozinku ili korisničko ime.</div>
            <?php endif; ?>

<?php include_once('../includes/footer.php'); ?>

