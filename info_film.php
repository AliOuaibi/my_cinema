<?php include('acces.php'); ?>

<!-- page internet -->
<!DOCTYPE html>
<html>
	<head>
        <link rel="stylesheet" href="style.css" />
		<meta charset="utf-8">
	</head>
<body>
    <?php include('header.php'); ?>
    <main>
    <?php echo "<div id='titre'><h1> $_GET[nom] </h1></div>"; ?>
    <img src="img/id1.jpg" alt="" class="tof">
    <?php 

    $selectFilm = $_GET['nom'];
    $answerFilm = $pdo->prepare("SELECT * from film WHERE titre = '$selectFilm'");
    $answerFilm->execute();
    
    $answer = $pdo->prepare("SELECT fiche_personne.nom, historique_membre.avis 
    from fiche_personne,historique_membre,film ,membre 
    where film.titre LIKE '$selectFilm' AND film.id_film = historique_membre.id_film 
    and fiche_personne.id_perso = membre.id_fiche_perso and membre.id_membre = historique_membre.id_membre and historique_membre.avis LIKE '%%'");
    $answer->execute();
    foreach($answerFilm as $key) {
        //var_dump($key);
    echo "<div id='tableau'><div id='resum'><h2>Résumer</h2></div><p class='resume'>$key[resum] ($key[duree_min]mn)</p></div>
    <div id='tableau2'><div id='com'><h2> Les avis :<h2></div>"; 
    foreach ($answer as $row) {
        //var_dump($row);
        $nom = $row['nom'];
        $Nom = ucfirst($nom);
        echo "<div id='tab'><p class='nom'>Nom: <br>$Nom</p><p class='nom'>Commentaire :<br>$row[avis]</div></div>";
    }
    }
    ?>
</main>
    </body>
</html>