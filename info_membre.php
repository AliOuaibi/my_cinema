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
    
    <div id='titre'><h1> FICHE MEMBRE </h1></div>
<div class='film_membre'>
    <div id='film_vu'>
        <h3 class='film_vu'>FILM VU</h3>
         <?php
        //  $selectNom = $_GET['nom'];
        // $answerFilm = $pdo->query("SELECT film.titre,historique_membre.date 
        // FROM historique_membre, fiche_personne , film, membre
        // WHERE fiche_personne.nom LIKE '%abdesslam%' AND fiche_personne.id_perso = membre.id_fiche_perso AND membre.id_membre = historique_membre.id_membre AND historique_membre.id_film = film.id_film");
        
        // foreach($answerFilm as $row) {
        //     var_dump($row);
        // } ?>

        <?php
        $selectNom = $_GET['nom'];
        $answerFilm = $pdo->prepare("SELECT film.titre,historique_membre.date, membre.id_membre
        FROM historique_membre, fiche_personne , film, membre
        WHERE fiche_personne.nom LIKE '%$selectNom%' AND fiche_personne.id_perso = membre.id_fiche_perso AND membre.id_membre = historique_membre.id_membre AND historique_membre.id_film = film.id_film ORDER BY film.titre");
        $answerFilm->execute();

        // echo "<div><table class='table-hover'>
        //     <tr>
        //         <th scope='col'>Film</th>
        //         <th scope='col'>Date</th>
        //     </tr>";
        
        foreach($answerFilm as $row) {    
            echo "<form method='POST' action='avis_membre.php'>
            <input type='text' class='cache' name='film-avis' value='$row[titre]'/>
            <input type='text' class='cache' name='nom-avis' value='$selectNom'/>
            <div class='bordur'>
            <p class='caract'>$row[titre] vu le $row[date] </p><button type='submit' class='bouton_submit'>Ajouter un avis</button>
            </form></div>";
        }
        ?>
    </div>
    <div class='film_ajouter'>
        <div id='ajouter'>
            <h3 class='film_vu'> FILM A AJOUTER </h3>
            <form method="POST" action="">
        <div class="input-group">
            <div class="input-group-text">
                <span class="input-text">Titre</span>
            </div>
            <input type="text" class="form-control" name="titre1">
        </div>
<?php
if(isset($_POST["titre1"])) {

$selectFilm = htmlspecialchars($_POST["titre1"]);
$answerFilm = $pdo->prepare("SELECT * from film WHERE titre = '$selectFilm' ORDER BY titre");
$answerFilm->execute(); 

$selectNom = htmlspecialchars($_GET['nom']);
$answerFilm2 = $pdo->prepare("SELECT film.titre,membre.id_membre
    FROM fiche_personne , film, membre
    WHERE fiche_personne.nom LIKE '$selectNom' AND film.titre LIKE '$selectFilm' AND membre.id_fiche_perso = fiche_personne.id_perso");
$answerFilm2->execute();

echo "<div class='tabF'>
        <p class='ou'>Nom du film :</p> 
    </div>";

foreach ($answerFilm2 as $row) { 
    $id_membre=$row[1];
    //echo "<p>$id_membre</p>";

    foreach($answerFilm as $key) {

        $id_film = $key[0];
        $displayFilm = $key[3];
        echo "<p class='ou'>
        <form method='POST' action='#'>
            <td class='titre'>$displayFilm</td>
            <input type='text' class='cache' name='inserer' value='$id_membre'/>
            <input type='text' class='cache' name='inserer2' value='$id_film'/>
            <button type='submit' class='bouton_submit'>Ajouter</button>
        </form>
        </p>";   
    }
}
}
        if(isset($_POST['inserer']) && isset($_POST['inserer2'])) {
            $id_membre = $_POST['inserer'];
            $id_film = $_POST['inserer2'];
            //echo $id_film ."->". $id_membre;
            $pdo->exec("INSERT INTO historique_membre (id_membre,id_film,date) VALUES ($id_membre,$id_film,now())");
        }          
?>
        </div>
    </div>
</div>
<div id="abo">
<div id='titre'><h1> Gérer Abonnement </h1></div>
<form method="POST" action="">
    <div class="group">
        <select class="custom-select" name="num_abo">
        <option selected>Choix d'abonnement</option>

            <?php
            $abo = $pdo->query('SELECT id_abo,nom FROM abonnement');
            $valAbo = 1;
            while ($donneesAbo = $abo->fetch()) {
                echo "<option value='$valAbo'>$donneesAbo[0] - $donneesAbo[1]</option>";
                $valAbo++;
                //var_dump($donneesAbo);
            }
            ?>
            </select>
        <button type="submit" class="bouton_submit">Valider</button>
    </div>
</form>
<?php 
if(isset($_POST['num_abo'])) {
    $num_abo = htmlspecialchars($_POST['num_abo']);
    
    $selectNom = $_GET['nom'];
    $answerAbo = $pdo->prepare("SELECT membre.id_membre from membre,fiche_personne where fiche_personne.nom = '$selectNom' and membre.id_fiche_perso = fiche_personne.id_perso");
    $answerAbo->execute();
    foreach ($answerAbo as $key) {
        $id_m = $key[0];
        //echo $id_m."====>".$num_abo;
        $pdo->exec("UPDATE membre SET id_abo = $num_abo WHERE id_membre = $id_m");
    }
}
?>
<p class="ou"> OU </p> 
<form method="POST" action="">
    <div>
        <input type='text' class='cache' name='desab' value='0'/>
        <button type="submit" class="bouton_submit">Se désabonner</button>
    </div>
<?php
    if(isset($_POST['desab'])) {
    $num_abo = htmlspecialchars($_POST['desab']);
    
    $selectNom = $_GET['nom'];
    $answerAbo = $pdo->prepare("SELECT membre.id_membre from membre,fiche_personne where fiche_personne.nom = '$selectNom' and membre.id_fiche_perso = fiche_personne.id_perso");
    $answerAbo->execute();
    foreach ($answerAbo as $key) {
        $id_m = $key[0];
        //echo $id_m."====>".$num_abo;
        $pdo->exec("UPDATE membre SET id_abo = $num_abo WHERE id_membre = $id_m");
    }
}
?>
</form>
</div>
</body>
</html>