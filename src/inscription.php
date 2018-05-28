<?php 
	include("install.php");
	session_start();
?>

<?php
//une fonction pour sécuriser les entrees du formulaire
	function securisation($donnee)
	{
		$donnee = trim($donnee);//supprime les espaces avant et apres la chaine de caractere;
		$donnee = stripslashes($donnee);
		$donnee = strip_tags($donnee);
		return $donnee;			
	}
?>
<?php
        //vérification du formulaire
	if(isset($_POST))
	{
		//j'extrais tout les donnees tapé par l'utilisateur
		extract($_POST);
		$valider = true; 

		if(isset($_POST['nom']))
		{
			$nom = securisation($_POST['nom']);
		//grace a extract($_Post) je peux maintenant ecrire que $'id' 
			if(empty($nom))
			{
				$valider = false;
				//dans la 3eme cellue du tableau j'ecris ce message d'erreur correspondant
				$err_nom = "Veuillez remplir votre nom.";
			}
			else if(strlen($_POST['nom']) <= 2 )
			{
				$valider = false;
				$err_nom = "Votre nom doit faire plus de 2 caractères.";
			}
		}
		else
			$valider = false;

		if(isset($_POST['prenom']))
		{
			$prenom = securisation($_POST['prenom']);
			if(empty($prenom))
			{
				$valider = false;
				$err_prenom ="Veuillez remplir votre prenom";
			}
			else if(strlen($_POST['prenom']) <= 2 )
			{
				$valider = false;
				$err_prenom = "Votre prenom doit faire plus de 2 caractères.";
			}			
		}
		else
			$valider = false;

		if(isset($_POST['mail']))
		{
			$mail = securisation($_POST['mail']);
			if(empty($mail))
			{
				$valider = false;
				$err_mail = "Veuillez remplir votre mail";
			}					
		}
		else
			$valider = false;

		if(isset($_POST['pseudo']))
		{
			$pseudo = securisation($_POST['pseudo']);	
			if(empty($pseudo))
			{
				$valider = false;
				unset($_POST['pseudo']);
				$err_pseudo = "Veuillez remplir votre pseudo";
			}
		}	
		else
			$valider = false;
		//
		//
		//$mdp_confirm= securisation($_POST['mdp_confirm']);
		
		if(isset($_POST['mdp']))
		{
			//$mdp= securisation($_POST['mdp']);
			//$mdp=$_POST['mdp'];
			if(strlen($_POST['mdp']) < 6 )
			{
				$valider = false;
				unset($_POST['mdp']);
				$err_mdp_lenth = "6 caractères au strict minimum !";
			}
		}
		else
			$valider = false;

		//$mdp_confirm = securisation($_POST['mdp_confirm']);

		if(isset($_POST['mdp_confirm']) && isset($_POST['mdp']))
		{
			if($_POST['mdp'] != $_POST['mdp_confirm'])
			{
				$valider = false;
				$err_mdp = "Mot de passe non identique !!!";
			}
		}
		else 
			$valider = false;



		//VERIFIER SI LE MAIL existe dejà;
		if(isset($mail))
		{
			$reqmail = $qSelDb->prepare('SELECT * FROM formulaire where mail=?');
			//selection tous les champs sans distinction du mail
			$reqmail->execute(array($mail));
			//reselectionne avec distinction du mail = 'mail' tapé par l'utilisateur
			$mailexist = $reqmail->rowCount(); // compte le nombre de fois le mail existe;
			if($mailexist == 0)
			{}
			else{
			$err_mail_exist = "Ce mail existe deja";
			}
		}
		
		//Si TOUT est validé, alors...
		if($valider)
		{
			//ici tt est ok
			$insertmembre = $qSelDb->prepare('INSERT INTO formulaire(nom,prenom,mail,pseudo,mdp) VALUES(?,?,?,?,?)');
			$insertmembre->execute(array($nom,$prenom,$mail,$pseudo,sha1($mdp)));
			//on retourne sur la page de connexion ?? (no lo sé)
			header('Location: connexion.php');
			//cas où tout est ok:
			$erreur = '<div class ="alert alert-success">Vous ETES inscrit,vous pouvez vous connecter maintenant </div>';
			//ici je supprime les tout les champs rempli s'ils sont deja tous remplis
			unset($_POST['nom']);
			unset($_POST['prenom']);
			unset($_POST['mail']);
			unset($_POST['pseudo']);
			unset($_POST['mdp']);
			unset($_POST['mdp_confirm']);		
		}
		//Sinon...
		else{
			//ici pas tout les champs remplis
			if(isset($_POST) && isset($nom))
			{
				$erreur = '<div class=" alert alert-danger">Attention ! les champs ne sont pas tous remplis</div>';	
			}
		}
	}
?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	 <link rel="stylesheet" type="text/css" href="inscription.css">
	<title>inscription</title>

</head>

<body>
<?php  if(isset($erreur)) echo $erreur ?>
<?php include('entete.php'); ?>
<?php include('menu.php'); ?>

<div id="corps" align="center">
<fieldset>
	<legend>
		Remplissez vos coordonnées <img src="Images/bien.gif" /> : 
	</legend>
	
	<form action="inscription.php" method="POST">
	<p> 
	<table>

		<tr>
			<td align="right">
				<label for="nom">Tapez votre nom: *</label>
			</td>
			<td>
				<input type="text" name="nom" id="nom" placeholder="ex: Liquade" value="<?php if(isset($_POST['nom'])) echo $_POST['nom']; ?>"/>
			</td> 
			<td>
				<span class="errormsg"><?php if(isset($err_nom)) echo $err_nom; ?></span>
			</td>
		</tr>


		<tr>
			<td align="right">
				<label for="prenom">Tapez votre prenom:*</label>
			</td>
			<td>
				<input type="text" name="prenom" id="prenom" placeholder="ex: Colas" value="<?php if(isset($_POST['prenom'])) echo $_POST['prenom']; ?>">
			</td> 
			<td>
				<span class="errormsg"><?php if(isset($err_prenom)) echo $err_prenom; ?></span>
			</td>
		</tr>


		<tr>
			<td align="right">
				<label for="mail">Tapez votre adresse mail: *</label>
			</td>
			<td>
				<input type="email" name="mail" id="mail" placeholder="ex: co_liq@gmail.com" value="<?php if(isset($_POST['mail'])) echo $_POST['mail']; ?>">
			</td>
			<td>
				<span class="errormsg"><?php if(isset($err_mail)) echo $err_mail;elseif(isset($err_mail_exist)) echo $err_mail_exist; ?></span>
			</td>
		</tr>


		<tr>
			<td align="right">
				<label for="pseudo">Tapez votre pseudo: *</label>
			</td>
			<td>
				<input type="text" name="pseudo" id="pseudo" placeholder="ex: coco23" value="<?php if(isset($_POST['pseudo'])) echo $_POST['pseudo']; ?>">
			</td>
			<td>
				<span class="errormsg"><?php if(isset($err_pseudo)) echo $err_pseudo; ?></span>
			</td>
		</tr>


		<tr>
			<td align="right">
				<label for="mdp">Tapez votre mot de passe: *</label>
			</td>
			<td>
				<input type="password" name="mdp" id="mdp">
			</td>
			<td>
				<span class="errormsg"><?php  if(isset($err_mdp_lenth)) echo $err_mdp_lenth ;elseif(isset($err_mdp)) echo $err_mdp; ?></span>
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
				<br/><input type="submit" name="valider" value="Je m'inscris !">
			</td>
			<td></td>
		</tr>
		
	</table>		
	</p>
 	
	</form>

</fieldset></div>

		
<?php include('footer.php'); ?>

</body>

</html>


