<?php
try { 
    $user = 'admin';
    $mdp = "admin";
    $bdd = "cinema";

    $pdo = new PDO  ('mysql:host=127.0.0.1;dbname='.$bdd, $user, $mdp);
}  catch(PDOException $e) {
    echo 'Error : ' . $e->getMessage() . PHP_EOL;
}
?>
