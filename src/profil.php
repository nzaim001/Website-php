<?php 
	session_start();
	include('install.php');
	include('entete.php');
	include('menu.php');
 ?>


<?php 	
	if(isset ($_SESSION['mail']))
	{
		$insertprofil= $qSelDb->prepare("SELECT * FROM formulaire 
		where mail=? ");
		$insertprofil->execute(array($_SESSION['mail']));
	// cherche le pseudo où mail=$_SESSION['mail']

		$donnee = $insertprofil->fetch();
	//prend ensuite le pseudo correspondant qu'on met dans la variable $donnee
	
	
		$insertPetOfProfil= $qSelDb->prepare("SELECT * FROM petitions where mail=? AND pseudo=?");
		$insertPetOfProfil->execute( array($_SESSION['mail'], $donnee['pseudo']) );
		$nbrePet= $insertPetOfProfil->rowCount(); // compte le nombre de fois de petitions publiées

		$seeliste = $qSelDb->prepare("SELECT * FROM liste WHERE mail = ?");
		$seeliste->execute( array($_SESSION['mail']) );
		$nbresignee = $seeliste->rowCount();
	

		$parcoursList = $qSelDb->prepare ( "SELECT titre FROM liste WHERE mail=?" );
		$parcoursList->execute(array($_SESSION['mail']));	

	}
	else
	{
		header('Location: connexion.php');
	}
		
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="profil.css">
	<title>Mon Profil</title>

</head>

	<body>
	<br /><br /><br />
	<div id="corps" align="center">
		
		<fieldset><h2>Bienvenue  <?php echo $donnee['pseudo'] . ' !'; ?> </h2><br/>
			<p style="font-size: 18px;">
				Quelques informations vous concernant: <br/>
			</p>

			<p>
				<table>
					
					<tr>
						<td align="left">
							<u>Votre Nom :</u> 
						</td>
						<td>
							<?php echo $donnee['nom'] ?>
						</td>
					</tr>
					
					<tr>
						<td align="left">
							<u>Votre Prénom :</u> 
						</td>
						<td>
							<?php echo $donnee['prenom'] ?>
						</td>
					</tr>
					
					<tr>
						<td align="left">
							<u>Votre adresse mail :</u> 
						</td>
						<td>
							<?php echo $donnee['mail'] ?>
						</td>
					</tr>
					
					<tr>
						<td align="left">
							<u>Votre pseudo :</u> 
						</td>
						<td>
							<?php echo $donnee['pseudo'] ?>
						</td>
					</tr>

					<tr><td></td></tr>
						
					<tr>
						<td align="left">
							<u>Nombre de pétitions publiées :</u> 
						</td>
						<td align="right">
							<?php echo $nbrePet ?>
						</td>
					</tr>	

					<tr>
						<td align="left">
							<u>Nombre de pétitions signées :</u> 
						</td>
						<td align="right">
							<?php echo $nbresignee ?>
						</td>
					</tr>	
							
					<tr>
						<td><u>Titre des pétitions signées :</u> </td>
						<td>
							<?php
							// On affiche chaque entrée une à une

							while ($donnees = $parcoursList->fetch())
							{
							?>
								<div id="corps" align="center">

									"<strong><?php echo $donnees['titre']; ?></strong>"
									<br/>
								</div>
							<?php

							}
							$parcoursList->closeCursor();
							?>
						</td>
					</tr>

				</table>
			</p>
			
		</fieldset>
	</div>
		
	<?php include('footer.php'); ?>
  </body>
</html>




