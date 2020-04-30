<?php include('acces.php'); 

if (isset($_POST['forminscription'])) {
    $Nom = htmlspecialchars($_POST['nom']);
    $Prenom = htmlspecialchars($_POST['prenom']);
    $Mail = htmlspecialchars($_POST['mail']);
    
    $query = $pdo->prepare("INSERT INTO ``fiche_personne`( `nom`, `prenom`, `email`) VALUES (?,?,?)");
    $query->execute(array($Nom, $Prenom, $Mail));
}

?>

<!-- page internet -->
<!DOCTYPE html>
<html>
	<head>
        <link rel="stylesheet" href="style.css" />
		<meta charset="utf-8">
	</head>
<body>
    <?php include('header.php'); ?>
<div class='inscription'>
<h1>INSCRIPTION</h3>
<br /><br />
<form method='POST' action="">
	<table>
		<tr>
			<td><label for="nom">Nom :</label></td>
			<td><input type="text" placeholder="Votre nom" name="nom"></td>
			<td><label for="prenom">Prenom :</label></td>
			<td><input type="text" placeholder="Votre prenom" name="prenom"></td>
			<td><label for="mail">Mail :</label></td>
			<td><input type="mail" placeholder="Votre mail" name="mail"></td>
		</tr>
	</table>
    <button type="submit" name="forminscription" class="submit_inscription">Valider</button>
</form>
</div>
</body>
</html>
