<?php include_once('../includes/header.php'); ?>

<?php 

unset($_COOKIE['user']);
setcookie('user','',time()-3600);

session_destroy();

?>


<div class="container">
    <div class="container-inner">
        <div class="prikaz">
            <h3>Uspesno ste se izlogovali. Sada se mozete ponovo prijaviti.</h3>
        </div>
    </div>
</div>


<?php include_once('../includes/footer.php'); ?>