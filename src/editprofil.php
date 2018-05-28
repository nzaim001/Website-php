<?php 
	session_start();
	include('install.php');
 ?>


<?php 	


	if(isset($_SESSION['mail']))
	{
		$insertprofil = $qSelDb->prepare("SELECT * FROM formulaire where mail=? ");
		$insertprofil->execute(array($_SESSION['mail']));

		$donnee = $insertprofil->fetch();
	}

	function securisation($donnee)
	{
		$donnee = trim($donnee);
		$donnee = stripslashes($donnee);
		$donnee = strip_tags($donnee);
		return $donnee;			
	}

        //vérification du formulaire
	if(!empty($_POST))
	{
		//j'extrais tout les donnees tapé par l'utilisateur
		extract($_POST);
		$valider = true; 
		
		if(isset($_POST['mail']))
		{
			$mail = securisation($_POST['mail']);
			if(empty($mail)) //si a la fin on a un mail vide
			{
				$valider = true;
				$mail = $_SESSION['mail'];
				unset($_POST['mail']);
				//$err_mail ="Veuillez écrire un nouveau mail valide.";
			}					
		}
		else
		{
			$valider = false;
		}

		if(isset($_POST['pseudo']))
		{
			$pseudo = securisation($_POST['pseudo']);	
			if(empty($pseudo)) //si a la fin on a un pseudo vide
			{
				$valider = false;
				unset($_POST['pseudo']);
				$err_pseudo ="Veuillez écrire un nouveau pseudo valide.";
			}
		}	
		else
		{
			$valider = false;
		}
			
		if(isset($_POST['mdp']))
		{
			if(strlen($_POST['mdp']) < 6 )
			{
				$valider = false;
				unset($_POST['mdp']);
				unset($_POST['mdp_confirm']);
				$err_mdp_lenth ="6 caractères au minimum.";
			}
		}
		else
		{
			$valider = false;
		}

		if(isset($_POST['mdp_confirm']) && isset($_POST['mdp']))
		{

			if($_POST['mdp'] != $_POST['mdp_confirm'])
			{
				$valider = false;
				$err_mdp = "Mots de passe non identiques !";
			}
			else
			{
				$mdp = $_POST['mdp'];
			}
		}
		else 
		{
			$valider = false;
		}

		//VERIFIER SI LE MAIL existe dejà;
		if(isset($mail))
		{
			$reqmail = $qSelDb->prepare('SELECT pseudo FROM formulaire where mail=?');
			$reqmail->execute(array($mail));

			$mailexist = $reqmail->rowCount(); 

			if($mailexist > 1)
			{
				$err_mail_exist = "Ce mail existe deja";
				//$valider = false;
			}
		}
		
	
		if($valider)
		{
			//ici tt est ok
			$modifprofil = $qSelDb->prepare('UPDATE formulaire SET mail = :newwmail, pseudo = :newwpseudo, mdp = :newmdp WHERE mail = :mailinitial');
			$modifprofil->execute(array(
				'newwmail' => $mail,
				'newwpseudo' => $pseudo,
				'newmdp' => sha1($mdp),
				'mailinitial' => $_SESSION['mail']
				));

			$modifpet = $qSelDb->prepare('UPDATE petitions SET mail = :newmail, pseudo = :newpseudo WHERE mail = :mail_initial');
			$modifpet->execute(array(
				'newmail' => $mail,
				'newpseudo' => $pseudo,
				'mail_initial' => $_SESSION['mail']
				));

			$modifliste = $qSelDb->prepare('UPDATE liste SET mail = :newmail WHERE mail = :mail_initial');
			$modifliste->execute(array(
				'newmail' => $mail,
				'mail_initial' => $_SESSION['mail']
				));

////////////
			$_SESSION['mail'] = $mail;
			//cas où tout est ok:
			$erreur = '<div class ="alert alert-success">Votre profil est bien modifié. </div>';
			//ici je supprime les tout les champs rempli s'ils sont deja tous remplis
			unset($_POST['mail']);
			unset($_POST['pseudo']);
			unset($_POST['mdp']);
			unset($_POST['mdp_confirm']);
			//on retourne sur la page de profil
			header('Location: profil.php');		
		}
		else
		{
			unset($_POST['mail']);
			unset($_POST['pseudo']);
			unset($_POST['mdp']);
			unset($_POST['mdp_confirm']);
		}
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

		<?php include('entete.php'); ?>
		<?php include('menu.php'); ?>

		<div id="corps" align="center">
			<fieldset>
				<legend>
					<h2> Edition de profil de <?php if(isset($_SESSION['mail'])) echo $donnee['pseudo']; ?> </h2>
				</legend>

			<form action="editprofil.php" method="POST">
				<p> 
				<table>

					<tr>
						<td align="right">
							<label for="mail">Nouveau mail:</label>
						</td>
						<td>
							<input type="email" name="mail" id="mail" placeholder="val_grass@gmail.com" value="<?php if(isset($_POST['mail'])) echo $_POST['mail']; ?>">
						</td>
						<td>
							<span class="errormsg">
								<?php if(isset($err_mail)) echo $err_mail;elseif(isset($err_mail_exist)) echo $err_mail_exist; ?>
							</span>
						</td>
					</tr>


					<tr>
						<td align="right">
							<label for="pseudo">Nouveau pseudo: *</label>
						</td>
						<td>
							<input type="text" name="pseudo" id="pseudo" placeholder="valou8">
						</td>
						<td>
							<span class="errormsg">
								<?php if(isset($err_pseudo)) echo $err_pseudo; ?>
							</span>
						</td>
					</tr>


					<tr>
						<td align="right">
							<label for="mdp">Nouveau mot de passe: *</label>
						</td>
						<td>
							<input type="password" name="mdp" id="mdp">
						</td>
						<td>
							<span class="errormsg">
								<?php  if(isset($err_mdp_lenth)) echo $err_mdp_lenth ;elseif(isset($err_mdp)) echo $err_mdp; ?>
							</span>
						</td>
					</tr>


					<tr>
						<td align="right">
							<label for="mdp_confirm">Confirmez votre mot de passe:* </label>
						</td>
						<td>
							<input type="password" name="mdp_confirm" id="mdp_confirm">
						</td>
						<td></td>
					</tr>


					<tr>
						<td ></td>
						<td>
							<input type="submit" name="valider" value="Mettre à jour">
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




