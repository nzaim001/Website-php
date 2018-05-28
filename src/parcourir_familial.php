<?php 
	session_start();
	include('install.php');
	include('entete.php');
	include('menu.php');
?>

		


<?php 

	$parcoursPet = $qSelDb->prepare ( "SELECT *, SUBSTRING(petition_sujet, 1, 50) as resume FROM petitions WHERE categorie='Familial' ORDER BY petition_date DESC" );
	$parcoursPet->execute();	

 ?>


		


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		 <link rel="stylesheet" type="text/css" href="CSS.css">
	<title>Les pétitions</title>
	</head>
	<body>		


	<ul class="nav nav-pills" style="">
  		<li role="presentation" class="active">
  			<a href="parcourir_petition.php">Toutes catégories</a>
  		</li>
  		<li role="presentation">
  			<a href="parcourir_politique.php">Politique</a>
  		</li>
  		<li role="presentation">
  			<a href="parcourir_environnement.php">Environnement</a>
  		</li>
  		<li role="presentation">
  			<a href="parcourir_familial.php">Familial</a>
  		</li>
  		<li role="presentation">
  			<a href="parcourir_sante.php">Santé</a>
  		</li> 		
  		<li role="presentation">
  			<a href="parcourir_autres.php">Autres</a>
  		</li>
	</ul>		

	<?php

		// On affiche chaque entrée une à une

		while ($donnees = $parcoursPet->fetch())

		{

	?>
	<div id="corps" align="center">
		<fieldset>
		
			<legend>
				"<strong><?php echo $donnees['petition_titre']; ?></strong>"
				Posted by <?php echo $donnees['pseudo']; ?>
				<em style="font-size: 10px">(<?php echo $donnees['petition_date'];?>) </em> 
			</legend>
			
			<p>
				<?php echo nl2br(htmlspecialchars($donnees['resume'])); ?><em>...*</em>
			</p>
			
			<p>
				<a href="page.php?id=<?php echo $donnees['id'] ?>">
					<em style="font-size: 10px;">*Voir la suite</em>
				</a>
			</p>
		
		</fieldset></div>


	<?php

		}

	$parcoursPet->closeCursor();

	include('footer.php');
	
	?>


	</body>
</html>
