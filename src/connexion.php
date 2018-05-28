<?php
	session_start(); 
	include("install.php");
 ?>

<?php 
	if(isset($_POST['deconnecter']) AND $_POST['deconnecter']=='Déconnexion')
	{
		session_destroy();
		$_SESSION = array();
		header('Location: connexion.php');
	}	
?>

<?php
        //vérification du formulaire
	if(!empty($_POST))
	{
		//j'extrais tout les donnees tapé par l'utilisateur
		extract($_POST);
		$valider = true; 
		
		//grace a extract($_Post) je peux maintenant ecrire que $'id' 
	
		if(empty($_POST['mail']))
		{
			$valider = false;
			//$err_conn_mail="Entrez votre mail!";
		}
		if(empty($_POST['mdp']))
		{
			$valider = false;
			///$err_conn_mdp="Entrez votre mdp!";
		}

		if($valider)
		{
			//ici tt est ok
			$insertmembre = $qSelDb->prepare("SELECT * FROM formulaire where mail=? AND mdp=?");
			$insertmembre->execute(array($_POST['mail'],sha1($_POST['mdp'])));
			$user = $insertmembre->rowCount(); // compte le nombre de fois le mail existe;

			if($user == 0)
			{
				$err_acces="Mail ou Mot de passe incorrect";
			}
			else
			{
				$_SESSION['mail'] = $_POST['mail'];
				//$_SESSION['mdp'] = $_POST['mdp'];
				 //sauvegarde dans session pr le réutiliser dans les autres pages

				$err_acces = '<div class ="alert alert-success">Vous etes connecté(e)</div>';
				unset($_POST['mail']);
				unset($_POST['mdp']);
				header('Location: profil.php');

			}
			//ici je supprime les tout les champs rempli s'ils sont deja tous remplis
			unset($_POST['mail']);

			unset($_POST['mdp']);
		}
		else
		{
			//ici pas tout les champs remplis
			if(isset($_POST) && isset($_POST['mail']))
			{
				$err_connexion = '<div class="alert alert-danger">Mail et/ou mot de passe incorrect !</div>';
			}	
		}
	}
?>



<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	 <link rel="stylesheet" type="text/css" href="connexion.css">
	<title>Se connecter</title>

</head>


<body>
	<?php  if(isset($err_connexion)) echo $err_connexion ?>
	<?php include('entete.php'); ?>
	<?php include('menu.php'); ?>

	<div id="corps" align="center">

		<fieldset>
			<legend>
				Remplissez vos coordonnées <img src="Images/bien.gif" /> : 
			</legend>

			<form action="connexion.php" method="POST">
			<p> 
			<table>

				<tr>
					<td align="right">
						<label for="mail">Tapez votre adresse mail: *</label>
					</td>
					<td>
						<input type="email" name="mail" id="mail" placeholder="ex: xxx@gmail.com" >
					</td>
				</tr>

				<tr>
					<td align="right">
						<label for="mdp">Tapez votre mot de passe: *</label>
					</td>
					<td>
						<input type="password" name="mdp" id="mdp">
					</td>
				</tr>

				<tr>
					<td ></td>
					<td>
						<span class="errormsg"><?php if(isset($err_acces)) echo $err_acces; ?></span>
					</td>
				</tr>
				
				<tr>
					<td ></td>
					<td>
						<br/>
						<form action="profil.php" method="POST">
							<input type="submit" name="Se connecter" value="Se connecter">
						</form>
					</td>
					<td></td>
				</tr>
		
			</table>		
			</p>
 	
			</form>


		</fieldset>
	</div>

		
	<?php include('footer.php'); ?>


</body>


</html>



