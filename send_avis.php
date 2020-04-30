<?php include('acces.php'); ?>
<html>
	<head>
        <link rel="stylesheet" href="style.css" />
		<meta charset="utf-8">
	</head>
<body>
    <?php include('header.php'); ?>

<?php 
if(isset($_POST['avis']) && isset($_POST['id_membre']) && isset($_POST['id_film'])) {
    $id_m = htmlspecialchars($_POST['id_membre']);
    $id_f = htmlspecialchars($_POST['id_film']);
    $avis = htmlspecialchars($_POST['avis']);
    //echo $id_f."=>".$id_m."===>".$avis;
    $pdo->exec("UPDATE historique_membre SET avis = '$avis' WHERE id_membre = $id_m AND id_film = $id_f");
    echo "<div class='center'><span class='send'> Avis envoyer ;)</span></div>";
}
?>
</body>
</html>