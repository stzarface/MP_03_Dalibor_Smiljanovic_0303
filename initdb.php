<?php



class Konekcija {

    private $connection;
    function __construct() {
        //povezujemo se bez baze jer hocemo da napravimo novu ako ne postoji 
        $this->connection = new mysqli('localhost','root','');
        if($this->connection->error) {
            die("Greska pri povezivanju: $this->connection->error");
        }

        //kreiramo bazu ako ne postoji - burgers
        $this->connection->query("CREATE DATABASE IF NOT EXISTS `burgers`");

        //selektujemo bazu da bi smo radili sa njom
        $this->connection->select_db('burgers');

        //kreiramo tabelu user ako ne postoji
        $this->connection->query("CREATE TABLE IF NOT EXISTS `user` ( `id_user` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(50) NOT NULL , `password` TEXT NOT NULL , PRIMARY KEY (`id_user`), UNIQUE `uname` (`username`(50))) ENGINE = innoDB;");
        //INSERT IGNORE ignorise duplikate za UNIQUE kolonu (username), tako da nece biti ponavljanja admina u tabeli
        $this->connection->query("INSERT IGNORE INTO `user`(`username`,`password`) VALUES ('admin@admin','$2y$10\$uOIb7qvuvZy18ku1iucS6OUa5P8aNp72HsniMY42v75sYhGXHdSnO')");

        $this->connection->query("CREATE TABLE IF NOT EXISTS `proizvodi` ( `id_proizvod` INT NOT NULL AUTO_INCREMENT , `naziv` VARCHAR(50) NOT NULL , `cena` INT NOT NULL, `slika_putanja` VARCHAR(50) NOT NULL, PRIMARY KEY (`id_proizvod`)) ENGINE = InnoDB;");

        $this->connection->query("INSERT IGNORE INTO `proizvodi`(`id_proizvod`,`naziv`,`cena`, `slika_putanja`) VALUES (1,'Pljeskavica', 300, './images/1.jpg'),(2,'Sendvic', 200,'./images/2.jpg'),(3,'Prsuta sendvic', 250, './images/3.jpg'),(4,'Sendvic jaje', 200, './images/4.jpg'),(5,'Pizza', 220, './images/5.jpg'), (6,'Palacinke', 240, './images/6.jpg'), (7,'Pomfrit', 100, './images/7.jpg'), (8,'Hot dog', 140, './images/8.jpg'), (9,'Salata', 330, './images/9.jpg') ");

        $this->connection->query("CREATE TABLE IF NOT EXISTS `porudzbine` (`id_porudzbina`  INT NOT NULL AUTO_INCREMENT , `id_user` INT NOT NULL, `konacna_cena` INT NOT NULL, `kreirano` timestamp NOT NULL DEFAULT current_timestamp(), PRIMARY KEY (`id_porudzbina`)) ENGINE=InnoDB;");


        $this->connection->query("ALTER TABLE `porudzbine`
        ADD KEY `fk_porudzbina_user` (`id_user`);");

        $this->connection->query("CREATE TABLE IF NOT EXISTS `porudzbine_items` (`id_porudzbina` int(11) NOT NULL, `id_proizvod` int(11) NOT NULL, `amount` int(11) NOT NULL ) ENGINE=InnoDB;");


        $this->connection->query("ALTER TABLE `porudzbine_items`
        ADD PRIMARY KEY (`id_porudzbina`, `id_proizvod`),
        ADD KEY `fk_porudzbina_proizvod` (`id_proizvod`);");

    }

    private function prepareSelectUser() {
        return $this->connection->prepare("SELECT * FROM `user` WHERE `username`=?");
    }

    public function getUserId($username){
        $prepared = $this->prepareSelectUser();
        $prepared->bind_param("s",$username);
        $prepared->execute();
        $res = $prepared->get_result();
        $user = $res->fetch_array();
        
        return $user['id_user'];
    }
    // za registrovanje novog korisnika

    function registrujKorisnika($user, $pass) {

        $prepared = $this->prepareSelectUser();
        $prepared->bind_param("s",$user);
        $prepared->execute();
        $res = $prepared->get_result();
        if($res->num_rows == 1) {
            return false;
        }
        $enc_pass = password_hash($pass, PASSWORD_BCRYPT);
        $statement = $this->connection->prepare("INSERT INTO `user`(`username`,`password`) VALUES (?, ?)");
        $statement->bind_param("ss", $user, $enc_pass);
        $statement->execute();
        return true;
    }

    function dodajPorudzbinu($user_id, $konacna_cena) {
        $statement = $this->connection->prepare("INSERT INTO `porudzbine`(`id_user`, `konacna_cena`) VALUES (?, ?)");
        $statement->bind_param("ii", $user_id, $konacna_cena);
        $statement->execute();
        return $statement->insert_id;
    }

    
    function dodajProizvodeUPorudzbinu($porudzbina_id, $proizvodi) {
        $values = [];
        $bindType = "";
        $bindParams = [];
        foreach($proizvodi as $proizvod=>$amount)
        {
            $values[] = "(?,?,?)";
            $bindType .= "iii";
            $bindParams[] = $porudzbina_id;
            $bindParams[] = $proizvod;
            $bindParams[] = $amount;
        }

        $statement = $this->connection->prepare("INSERT INTO `porudzbine_items`(`id_porudzbina`, `id_proizvod`, `amount`) VALUES " . implode(",", $values));

        $statement->bind_param($bindType, ...$bindParams);
        $statement->execute();
        return true;
    }

    function proveriKorisnika($user, $pass): bool {
        $prepared = $this->prepareSelectUser();
        $prepared->bind_param("s",$user);
        $prepared->execute();
        $res = $prepared->get_result();
        if($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            return password_verify($pass, $row['password']);

        }
        return false;
    }
    // vraca true ako korisnik postoji u bazi

    
    function nizProizvoda() {
        $query_res = $this->connection->query("SELECT * FROM `proizvodi`");
        $result = [];
        foreach ($query_res as $row) {
            array_push($result,[$row['id_proizvod'],$row['naziv'],$row['cena'], $row['slika_putanja']]);

        }
        return $result;
    }
}

$connection = new Konekcija();
