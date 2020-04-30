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
<!-- Requete Bdd pour la recherche -->
<?php    
    $nomMembre = $pdo->query('SELECT nom FROM fiche_personne');
    //var_dump($nomMembre);
    // foreach ($nomMembre as $key) {
    //     echo "<p>".$key["nom"]."</p>";
    // }
    $Membre = $pdo->query("SELECT fiche_personne.nom, fiche_personne.prenom, abonnement.nom AS nom_abo, abonnement.resum, membre.date_abo, membre.date_inscription 
    FROM fiche_personne, membre, abonnement 
    WHERE  fiche_personne.nom LIKE '%%' AND fiche_personne.prenom LIKE '%%' AND membre.id_abo = abonnement.id_abo AND fiche_personne.id_perso = membre.id_fiche_perso  ORDER BY fiche_personne.nom");
    // foreach ($Membre as $key) {
    //       var_dump($key);
    //   }
    $membre1 = $pdo->query("SELECT fiche_personne.nom, fiche_personne.prenom AS nom_abo, membre.date_abo, membre.date_inscription 
    FROM fiche_personne, membre
    WHERE fiche_personne.nom LIKE '%%' AND fiche_personne.prenom LIKE '%%' AND fiche_personne.id_perso = membre.id_fiche_perso  AND membre.id_abo LIKE '%0%' ORDER BY fiche_personne.nom");
    
    // foreach ($membre1 as $key) {
    //       var_dump($key);
    //   }
?>
<div class="connexion_personnel">

<div class="research">
    <div class="bloc-filtre">
        
    <form method="GET" action="">
        <h3 class="titre-membre">Membre abonnées</h3>
        <div class="input-membre">
            <div class="input-membre-text">
                <span class="input-text">Nom</span>
            </div>
            <input type="text" class="form-control" name="nom">
        
            <div class="input-membre-text">
                <span class="input-text">Prénom</span>
            </div>
            <input type="text" class="form-control" name="prenom">
        </div>
        <div class="filtrer">
            <button type="submit" class="bouton_submit">Filtrer</button>
        </div>
    </form>
    </div>


    <div class="bloc-filtre2">
        
    <form method="GET" action="">
    <h3 class="titre-membre">Membre non abonnées</h3>
        <div class="input-membre">
            <div class="input-membre-text">
                <span class="input-text">Nom</span>
            </div>
            <input type="text" class="form-control" name="nom2">
        
            <div class="input-membre-text">
                <span class="input-text">Prénom</span>
            </div>
            <input type="text" class="form-control" name="prenom2">
        </div>
        <div class="filtrer">
            <button type="submit" class="bouton_submit">Filtrer</button>
        </div>
    </form>
    </div>
</div>

<?php
if(isset($_GET["nom"]) && isset($_GET["prenom"])) {

$selectPrenom = $_GET["prenom"];
$selectNom = $_GET["nom"];
$answerNom = $pdo->prepare("SELECT fiche_personne.nom, fiche_personne.prenom, abonnement.nom AS nom_abo, abonnement.resum, membre.date_abo, membre.date_inscription 
FROM fiche_personne, membre, abonnement 
WHERE fiche_personne.nom LIKE '%$selectNom%'AND fiche_personne.prenom LIKE '%$selectPrenom%' AND membre.id_abo = abonnement.id_abo AND fiche_personne.id_perso = membre.id_fiche_perso  ORDER BY fiche_personne.nom");
$answerNom->execute(); 

echo "<table class='table-hover1'>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Abonnement</th>
        <th>Detail abonnement</th>
        <th>Date d'abonnement</th>
        <th>Date d'inscription</th>
    </tr>";

foreach($answerNom as $key) {
    //var_dump($key);

    $displaynom = $key[0];
    $displayNom = ucfirst($displaynom);
    $displayprenom = $key[1];
    $displayPrenom = ucfirst($displayprenom);
    $displayAbo = $key[2];
    $displayAboDetail = $key[3];
    $dateAbo = $key[4];
    $dateInscription = $key[5];
        
    echo "<p>
    <tbody>
    <tr>
    <form method='GET' action='info_membre.php'>
        <td class='membre'>$displayNom</td>
        <td class='membre'>$displayPrenom</td>
        <td class='membre'>$displayAbo</td>
        <td class='membre'>$displayAboDetail</td>
        <td class='membre'>$dateAbo</td>
        <td class='membre'>$dateInscription</td>
        <td class ='membre'><input type='text' class='cache' name='nom' value='$displaynom'/>
        <button type='submit' class='bouton_submit'>En savoir plus</button></td>
    </form>
    </tr>
    </tbody>
    </p>";
}
}

if(isset($_GET["nom2"]) && isset($_GET["prenom2"])) {

    $selectPrenom1 = $_GET["prenom2"];
    $selectNom1 = $_GET["nom2"];
    $answerNom1 = $pdo->prepare("SELECT fiche_personne.nom, fiche_personne.prenom AS nom_abo, membre.date_abo, membre.date_inscription 
    FROM fiche_personne, membre
    WHERE fiche_personne.nom LIKE '%$selectNom1%' AND fiche_personne.prenom LIKE '%$selectPrenom1%' AND fiche_personne.id_perso = membre.id_fiche_perso  AND membre.id_abo LIKE '%0%' ORDER BY fiche_personne.nom");
    $answerNom1->execute(); 

    echo "<table class='table-hover2'>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date du dernier abonnement</th>
            <th>Date d'inscription</th>
        </tr>";

    foreach($answerNom1 as $key) {
        //var_dump($key);

        $displaynom = $key[0];
        $displayNom = ucfirst($displaynom);
        $displayprenom = $key[1];
        $displayPrenom = ucfirst($displayprenom);
        $dateAbo = $key[2];
        $dateInscription = $key[3];
            
        echo "<p>
        <tbody>
        <tr>
        <form method='GET' action='info_membre.php'>
            <td class='membre'>$displayNom</td>
            <td class='membre'>$displayPrenom</td>
            <td class='membre'>$dateAbo</td>
            <td class='membre'>$dateInscription</td>
            <td class ='membre'><input type='text' class='cache' name='nom' value='$displaynom'/>
            <button type='submit' class='bouton_submit'>En savoir plus</button></td>
        </form>
        </tr>
        </tbody>
        </p>";
    }
}
?>
</body>
</html>