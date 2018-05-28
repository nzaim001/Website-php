<?php 
	session_start();
	include("install.php");
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


	///////////////////////////////////////////////
		if(isset($_POST['nom']))
		{
			$nom = securisation($_POST['nom']);					/////Le nom est mis dans la variable $nom
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


	///////////////////////////////////////////////
		if(isset($_POST['objet']))
		{		
			$objet = securisation($_POST['objet']); 							/////L'objet du mail est mis dans la variable $objet	
			if(empty($objet))
			{
				$valider= false;

				$err_objet = "Veuillez remplir l'objet du mail";
			}

		}
		else
		{
			$valider = false;
		}



	///////////////////////////////////////////////
		if(isset($_POST['mail']))
		{
			$emetteur = securisation($_POST['mail']);				/////Le mail est mis dans la variable $mail
			if(empty($emetteur))
			{
				$valider = false;
				$err_mail = "Veuillez remplir votre mail";
			}					
		}
		else
			$valider = false;


	///////////////////////////////////////////////
		if(isset($_POST['comment']))
		{
			//$commentaire = securisation($_POST['comment']);		
			$commentaire = $_POST['comment']; 					/////Le commentaire est mis dans la variable $commentaire
		}	
		else
		{
			$valider = false;
			$err_commentaire = "Veuillez écrire votre commentaire";
		}


	/////////////////////////////////////////////// SI TOUT EST REMPLI
		if($valider)
		{

			

			if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des pb.
			{
				$passage_ligne = "\r\n";
			}
			else
			{
				$passage_ligne = "\n";
			}


				//=====Création de la boundary.

			$boundary = "-----=".md5(rand());

			$boundary_alt = "-----=".md5(rand());

				//==========

				 
				//=====Création du header de l'e-mail.

			$header = "From: \"Projet Web: \"<$emetteur>".$passage_ligne;

			$header.= "Reply-to: \"Projet Web\" <$mail>".$passage_ligne;

			$header.= "MIME-Version: 1.0".$passage_ligne;

			$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;



				 

				//=====Création du message.

			$message = $passage_ligne."--".$boundary.$passage_ligne;

			$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;

			$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;

				//=====Ajout du message au format texte.

			$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;

			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;

			$message.= $passage_ligne.$commentaire.$passage_ligne;		////////////Envoie msg ????


				//=====On ferme la boundary alternative.

			$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;

				//==========


			$message.= $passage_ligne."--".$boundary.$passage_ligne;
 

				//=====Ajout de la pièce jointe.

			//$message.= "Content-Type: image/jpeg; name=\"image.jpg\"".$passage_ligne;

			//$message.= "Content-Transfer-Encoding: base64".$passage_ligne;

			//$message.= "Content-Disposition: attachment; filename=\"image.jpg\"".$passage_ligne;

			//$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;

			//$message.= $passage_ligne."--".$boundary."--".$passage_ligne; 

				//========== 

				//=====Envoi de l'e-mail.

			mail($mail,$objet,$message,$header); //destinataire | objet | comment

			unset($_POST['nom']);
			unset($_POST['objet']);
			unset($_POST['mail']);
			unset($_POST['comment']);

			//header('Location: contact.php');
			//cas où tout est ok:
			$erreur = '<div class ="alert alert-success">Votre message est bien envoyé </div>';
			//ici je supprime les tout les champs rempli s'ils sont deja tous remplis

				
		}
		//Sinon...
		else{
			//ici pas tout les champs remplis
			if(!isset($_POST))
			{
				$erreur='<div class=" alert alert-danger">Attention ! Les champs ne sont pas tous remplis</div>';	
			}
		}
	}

?>





<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	 <link rel="stylesheet" type="text/css" href="contact.css">
	<title>Contactez-nous</title>

</head>

<body>
	<?php include('entete.php'); ?>
	<?php include('menu.php'); ?>
	<div id="corps" align="center">
		<fieldset>
			<legend>
				Contactez-nous  <img src="Images/bien.gif" /> : 
			</legend>
			
			<form action="contact.php" method="POST">
			<p> 
			<table>

				<tr>
					<span><?php if(isset($erreur)) echo $erreur; ?></span>
				</tr>


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
						<label for="objet">Objet: *</label>
					</td>
					<td>
						<input type="text" name="objet" id="objet" value="<?php if(isset($_POST['objet'])) echo $_POST['objet']; ?>"/>
					</td> 
					<td>
						<span class="errormsg"><?php if(isset($err_objet)) echo $err_objet; ?></span>
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
						<label for="comment">Commentaire: *</label>
					</td>
					<td>
						<textarea name="comment" id="comment" class="form-control" ><?php if(isset($_POST['comment'])) echo $_POST['comment']?></textarea>
					</td>
					<td></td>
				</tr>


				<tr>
					<td ></td>
					<td>
						<input type="submit" name="valider" value="Envoyer !">
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
