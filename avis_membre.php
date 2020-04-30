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
    
    <?php 
    // $nom = $_POST['nom-avis'];
    // $nom1 = ucfirst($nom);
    if(isset($_POST['nom-avis']) && isset($_POST['film-avis'])) {
        //echo $_POST['nom-avis'] . '  and  ' . $_POST['film-avis'] ; 
        $nom = htmlspecialchars($_POST['nom-avis']);
        $film = htmlspecialchars($_POST['film-avis']);
        $answer = $pdo->prepare("SELECT historique_membre.id_membre, historique_membre.id_film, historique_membre.avis
        FROM historique_membre,membre,film,fiche_personne
        WHERE fiche_personne.nom LIKE '$nom' AND fiche_personne.id_perso = membre.id_fiche_perso 
        AND membre.id_membre = historique_membre.id_membre AND film.titre LIKE '$film' AND film.id_film = historique_membre.id_film");
        $answer->execute();

        echo "<h3 class='avis'>AVIS :</h3>
        <form method='POST' action='send_avis.php'>        
        <textarea name='avis' placeholder='Votre commentaire ...'></textarea><br/>
        <input type='submit' value='Poster mon commentaires' name='v_commentaire' />";

        foreach ($answer as $key) {
            $id_m = $key[0];
            $id_f = $key[1];
            echo "
            <input type='text' class='cache' name='id_membre' value='$id_m'/>
            <input type='text' class='cache' name='id_film' value='$id_f'/>
            </form>";
        }
    }
    ?>
</body>
</html>