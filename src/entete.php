<!DOCTYPE html>
<html>

	<head>
	    <meta charset="utf-8">
		<title>Site de Petitions</title>
		<link rel="stylesheet" type="text/css" href="entete.css">
	</head>

	<body>
		<header>
			<a id="logo" href="acceuil.php" title="Accueil à vous la parole.com">
				<img src="Images/logo.png" alt=""/>
			</a>

			<form action="acceuil.php" method="POST">
				<input type="submit" name="acceuil" value="Acceuil">
			</form>

			<?php 
			if(isset($_SESSION['mail'])) 
			{
			 ?>		 

				<div id="profil" class="btn-group">
		          	<button id="profil" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
		          		Profil
		          	    <span class="caret"></span></a>
		          	</button>
		          	<ul class="dropdown-menu">
		            	<li>
		            		<form action="profil.php" method="POST">
								<input type="submit" name="mon_profil" value="Voir mon Profil">
							</form>
						</li>

						<li>
							<form action="editprofil.php" method="POST">
								<input type="submit" name="Editer" value="Editer mon profil"/>
							</form>	
						</li>

						<li>
							<form action="connexion.php" method="POST">
								<input type="submit" name="deconnecter" value="Déconnexion">
							</form>
						</li>
		          	</ul>
		        </div>
		        
			 <?php 
			}
			else 
			{ ?>
				<form action="inscription.php" method="POST">
					<input type="submit" name="inscription" value="Inscription">
				</form>

				<form action="connexion.php" method="POST">
					<input type="submit" name="connecter" value="connexion">
				</form>
			<?php 
			}
			 ?>
			


		</header>
	</body>

</html>
