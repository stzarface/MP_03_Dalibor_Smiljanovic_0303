
<?php

require_once('./cart.php'); 
if(isset($_POST['isprazni'])) {
    $korpa->isprazniKorpu();
    header('Location: ./meni/meni.php');
}

?>