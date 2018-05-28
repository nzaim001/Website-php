<?php 
	session_start();
	include('install.php');
	include('entete.php');
	include('menu.php');
 ?>


<?php 

/////////////////////////////////////////
	//conditions sur la signature:

	if(isset($_POST['signature']))
	{
		if(isset($_SESSION['mail'])) // + autre condition pr que le meme utilisateur ne resigne pas deux fois
		{
			$parcoursListe = $qSelDb->prepare('SELECT id_liste FROM liste WHERE id_petition = ? AND mail = ?');
			$parcoursListe->execute(array($_GET['id'], $_SESSION['mail']));
			$signee = $parcoursListe->rowCount();

			if( $signee < 1 )
			{

			///// Ajout d'une ligne dans la table `liste`
			$selectpet = $qSelDb->prepare('SELECT id, petition_titre FROM petitions WHERE id = ?');
			$selectpet->execute( array($_GET['id']) );
			$datapet = $selectpet->fetch();


			$insertlist = $qSelDb->prepare('INSERT INTO liste (id_petition, titre, mail) VALUES (?,?,?)');
			$insertlist->execute(array(
				$datapet['id'], $datapet['petition_titre'], $_SESSION['mail']
				));



			////// on incremente le nbre de signature
			$modifpet = $qSelDb->prepare('UPDATE petitions SET nb_obtenue = nb_obtenue + 1 WHERE id = ?');
			$modifpet->execute(array($_GET['id']));


			//Puis affiche que c'est signée

			$ok_signature = "Votre signature a été prise en compte.";

			}
			else
			{
				$ok_signature = "Vous avez déjà signé cette pétition.";
			}

		}
		else
		{
			$ok_signature = "Connectez-vous pour signer. Ou inscrivez-vous si vous ne l'êtes pas déjà ! ;)";
		}

		unset($_POST['signature']);

	}

//////////////////////////////
	if(isset($_GET['id']) && $_GET['id'] >= 1)
	{
		
		$parcoursPet = $qSelDb->prepare ( "SELECT * FROM petitions WHERE id=?" );
		$parcoursPet->execute(array($_GET['id']));
		
		// On affiche chaque entrée une à une
		$donnees = $parcoursPet->fetch();
	}
	else
	{
		header('Location: acceuil.php');
	}
///////////////////////////////

	if( $donnees['nb_signature'] - $donnees['nb_obtenue'] <= 0)
	{
		$info_msg =  '<div class ="alert alert-success"> Le nombre de signature a été atteint ! :)</div>';
	}

 ?>




<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>

<body>


	<p>
		<span class="errormsg" style="color: blue"><?php if(isset($ok_signature)) echo $ok_signature; ?></span>
	</p>

		<fieldset style="margin: 20px; padding: 20px;">
		
			<legend>
				"<strong><?php echo $donnees['petition_titre']; ?></strong>"
				Posted by <?php echo $donnees['pseudo']; ?>
				<em style="font-size: 10px">(<?php echo $donnees['petition_date'];?>) </em> 
			</legend>
			
			<p>
				<?php echo nl2br(htmlspecialchars($donnees['petition_sujet'])); ?>
			</p>
			

			<p>
			<table align="center">
				<tr>
					<td>
						Nombre de signatures à atteindre :
					</td>
					<td align="right" style="background-color: #FFCCFF">
						 <?php echo $donnees['nb_signature'] ?>
					</td>
				</tr>

				<tr>
					<td>
						Nombre de signatures obtenues à ce jour :
					</td>
					<td align="right" style="background-color: #FDDFFD">
						<?php echo $donnees['nb_obtenue'] ?>
					</td>
				</tr>

				<tr>
					<?php if(isset($info_msg)) echo $info_msg; ?>
				</tr>

			</table>

				<form action="page.php?id=<?php echo $donnees['id'] ?>" method="POST">
					<input type="submit" name="signature" value="Signer la pétition">
				</form>


			</p>

			
		
		</fieldset>

<?php
		


	$parcoursPet->closeCursor();

 ?>



</body>

</html>