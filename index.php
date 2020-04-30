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
    $genre = $pdo->query('SELECT nom FROM genre');
    $distrib = $pdo->query('SELECT nom FROM distrib');
?>
<div class="research">
    <div class="bloc-filtre">
        
    <form method="GET" action="">
        <div class="input-group">
            <div class="input-group-text">
                <span class="input-text">Titre</span>
            </div>
            <input type="text" class="form-control" name="titre">
        </div>

        <div class="input-group">
            <select class="custom-select" name="genre">
            <option selected>Genre...</option>
            
            <?php
            $valGenre = 0;
            while ($donneesGenre = $genre->fetch()) {
                echo "<option value='$valGenre'>$donneesGenre[0]</option>";
                $valGenre++;
                //var_dump($donneesGenre);
            }
            ?>

            </select>
        </div>

        <div class="input-group">
            <select class="custom-select" name="distrib">
            <option selected>Distributeur...</option>
            
            <?php
            $valDistrib = 0;
            while($donneesDistrib = $distrib->fetch()) {
                echo "<option value='$valDistrib'>$donneesDistrib[0]</option>";
                $valDistrib++;
                //var_dump($donneesDistrib);
                //var_dump($valDistrib);
            }
            ?>
            </select>
        </div>
        <div class="filtrer">
            <button type="submit" class="bouton_submit">Filtrer</button>
        </div>
    </form>
    </div>

    <div class="bloc-filtre">
    <form method="GET" action="">
        <span class="input-text">Date de projection</span>
        <input type="date" class="start" name="date" min="1980-01-01" max="2018-12-31">
       <div class="filtrer">
            <button type="submit" class="bouton_submit">Filtrer</button>
        </div>
    </form>
    </div>
    <!-- SELECT * FROM film WHERE '2007-10-01' BETWEEN date_debut_affiche AND date_fin_affiche  -->
</div>

<main>
<?php    
//    $answerFilm = $pdo->query("SELECT * from film");
//    foreach($answerFilm as $key) {
//        $displayFilm = $key[3];
//        $displayFilmResum = $key[4];
//        $displayFilmYear = $key[8];
//        var_dump($displayFilm);
// }
if(isset($_GET['date'])) {
    $selectDate = htmlspecialchars($_GET["date"]);
    $answerFilm = $pdo->prepare("SELECT * FROM film WHERE '$selectDate' BETWEEN date_debut_affiche AND date_fin_affiche");
    $answerFilm->execute(); 

    echo "<table class='table-hover'>
        <tr>
            <th>Nom</th>
            <th>Résumer</th>
        </tr>";

    foreach($answerFilm as $key) {

        $displayFilm = $key[3];
        $displayFilmResum = substr($key[4],0,25);
            
        echo "<p>
        <tbody>
        <tr>
        <form method='GET' action='info_film.php'>
            <td class='titre'>$displayFilm</td>
            <td class='resum'>$displayFilmResum ... <br><p><input type='text' class='cache' name='nom' value='$displayFilm'/></p>
            <p><button type='submit' class='bouton_submit'>En savoir plus</button></p></td>
        </form>
        </tr>
        </tbody>
        </p>";   
    }            
}

if(isset($_GET["titre"]) && $_GET['genre'] === "Genre..." && $_GET['distrib'] === "Distributeur..." ) {

    $selectFilm = htmlspecialchars($_GET["titre"]);
    $answerFilm = $pdo->prepare("SELECT * from film WHERE titre LIKE '%$selectFilm%' ORDER BY titre");
    $answerFilm->execute(); 

    echo "<table class='table-hover'>
        <tr>
            <th>Nom</th>
            <th>Résumer</th>
        </tr>";

    foreach($answerFilm as $key) {

        $displayFilm = $key[3];
        $displayFilmResum = substr($key[4],0,25);
            
        echo "<p>
        <tbody>
        <tr>
        <form method='GET' action='info_film.php'>
            <td class='titre'>$displayFilm</td>
            <td class='resum'>$displayFilmResum ... <br><p><input type='text' class='cache' name='nom' value='$displayFilm'/></p>
            <p><button type='submit' class='bouton_submit'>En savoir plus</button></p></td>
        </form>
        </tr>
        </tbody>
        </p>";   
    }            
}

elseif(isset($_GET['genre']) && $_GET['genre'] !== 'Genre...' && isset($_GET['titre']) && $_GET['distrib'] == "Distributeur...") {
    
    $selectFilm = htmlspecialchars($_GET["titre"]);
    $selectDistrib = htmlspecialchars($_GET['genre']);
    $answerGenre = $pdo->prepare("SELECT * FROM film WHERE id_genre = $selectDistrib AND titre LIKE '%$selectFilm%' ORDER BY titre");
    $answerGenre->execute(array());
    //var_dump($pdo->errorInfo());

    echo "<table class='table-hover'>
        <tr>
            <th scope='col'>Film</th>
            <th scope='col'>Résumer</th>
        </tr>";

    while($row = $answerGenre->fetch()) {
        $displayResum = substr($row["resum"],0,30);
        $displayTitre = $row['titre'];
        
        echo "<p>
            <tbody>
            <tr>
            <form method='GET' action='info_film.php'>
                <td class='titre'>$displayTitre</td>
                <td class='resum'>$displayResum ...<br> <p><input type='text' class='cache' name='nom' value='$displayTitre'/></p>
                <button type='submit' class='bouton_submit'>En savoir plus</button></td>
                </form>
            </tr>
            </tbody>
            </p>";
    }
}

elseif(isset($_GET['distrib']) && $_GET['genre'] == 'Genre...' && isset($_GET['titre']) && $_GET['distrib'] !== "Distributeur...") {
    $selectFilm = htmlspecialchars($_GET["titre"]);
    $selectDistrib = htmlspecialchars($_GET['distrib']);
    $answerGenre = $pdo->prepare("SELECT * FROM film WHERE id_distrib = $selectDistrib AND titre LIKE '%$selectFilm%' ORDER BY titre");
    $answerGenre->execute(array());
    //var_dump($pdo->errorInfo());
    
    echo "<table class='table-hover'>
    <thead>
    <tr>
    <th scope='col'>Film</th>
        <th scope='col'>Résumer</th>
    </tr>
    </thead>";

    while($row = $answerGenre->fetch()) {
        $displayResum = substr($row["resum"],0,30);
        $displayTitre = $row['titre'];
        
        echo "<p>
            <tbody>
            <tr>
            <form method='GET' action='info_film.php'>
                <td class='titre'>$displayTitre</td>
                <td class='resum'>$displayResum ...<br> <p><input type='text' class='cache' name='nom' value='$displayTitre'/></p>
                <button type='submit' class='bouton_submit'>En savoir plus</button></td>
                </form>
            </tr>
            </tbody>
            </p>";
    }
}


elseif(isset($_GET['distrib']) && isset($_GET['genre']) && isset($_GET['titre']) && $_GET['distrib'] !== "Distributeur...") {
    
    $selectFilm = htmlspecialchars($_GET["titre"]);
    $selectDistrib = htmlspecialchars($_GET['distrib']);
    $genre = htmlspecialchars($_GET['genre']);
    $answerGenre = $pdo->prepare("SELECT * FROM film WHERE id_distrib = $selectDistrib AND id_genre = $genre AND titre LIKE '%$selectFilm%' ORDER BY titre");
    $answerGenre->execute(array());
    //var_dump($pdo->errorInfo());
    
    echo "<table class='table-hover'>
    <thead>
    <tr>
    <th scope='col'>Film</th>
        <th scope='col'>Résumer</th>
    </tr>
    </thead>";

    while($row = $answerGenre->fetch()) {
        $displayResum = substr($row["resum"],0,30);
        $displayTitre = $row['titre'];
        
        echo "<p>
            <tbody>
            <tr>
            <form method='GET' action='info_film.php'>
                <td class='titre'>$displayTitre</td>
                <td class='resum'>$displayResum ...<br> <p><input type='text' class='cache' name='nom' value='$displayTitre'/></p>
                <button type='submit' class='bouton_submit'>En savoir plus</button></td>
                </form>
            </tr>
            </tbody>
            </p>";
    }
}
?>
<?php
?>
</main>

</body>
</html>