<?php 
	session_start();
	include('install.php');
	include('entete.php');
	include('menu.php');
?>

<?php

if(!isset($_SESSION['mail']))
{
	header('Location: connexion.php');
}
else
{
        //vérification du Formulaire
	if(!empty($_POST))
	{
		//j'extrais tout les donnees tapé par l'utilisateur
		extract($_POST);
		$valider = true; 
		
		//grace a extract($_Post) je peux maintenant ecrire que $'id' 
	
	////Verification du titre
		if(empty($_POST['titre_petition'])){
			$valider = false;
			$err_titre = "Un titre manque à votre pétition.";
		}
		else
		{
			$insertTitle= $qSelDb->prepare("SELECT petition_titre FROM petitions where petition_titre=?");
			$insertTitle->execute(array($_POST['titre_petition']));
			$nbTitre = $insertTitle->rowCount();
			if( $nbTitre != 0)
			{
				$valider = false;
				$err_titre = "Ce titre de pétition a déjà été prise...";
			}
		}

	////Verification du sujet
		if(empty($_POST['sujet_petition']))
		{
			$valider = false;
			$err_sujet = "Ecrivez le sujet de votre pétition.";
		}

	////Verification du nb_signature
		if(empty($_POST['nb_signature']) ){
			$valider = false;
			$err_signature = "Entrez le nombre de signatures à atteindre.";
		}
		else if( (int)$_POST['nb_signature'] == 0 )
		{
			$valider = false;
			$err_signature = "Veuillez entrer un NOMBRE de signatures voulu !";
		}
		else if( (int)$_POST['nb_signature'] < 0 )
		{
			$valider = false;
			$err_signature = "Veuillez entrer un nombre de signatures > 0 !";
		}

	////Verification de categorie
		if(empty($_POST['categorie']))
		{
			$valider = false;
			$err_categorie = "Choisissez une catégorie.";
		}
		else
		{
			if(isset($_POST['politique'])) 
			{
				$categorie = 'politique';
			}
			else if(isset($_POST['environnement'])) 
			{
				$categorie = 'environnement';
			}
			else if(isset($_POST['famillial'])) 
			{
				$categorie = 'famillial';
			}
			else if(isset($_POST['sante'])) 
			{
				$categorie = 'santé';
			}
			else if(isset($_POST['autres'])) 
			{
				$categorie = 'autres';
			}

		}

///////// Si TOUT est validé, alors...
		if($valider)
		{
			$insertprofil = $qSelDb->prepare("SELECT pseudo FROM formulaire where mail=? ");
			$insertprofil->execute(array($_SESSION['mail']));
			// cherche le pseudo où mail=$_SESSION['mail']

			$donnee = $insertprofil->fetch();	
			$pseudo = $donnee['pseudo'];	
			
//////////////////////////			

			$insertpet = $qSelDb->prepare('INSERT INTO petitions (pseudo, mail, categorie, petition_titre, petition_sujet, nb_signature, petition_date) 
										VALUES(?,?,?,?,?,?,NOW())');
			$insertpet->execute(array(
				$pseudo, $_SESSION['mail'], $categorie, $_POST['titre_petition'], $_POST['sujet_petition'], $_POST['nb_signature']
				));

//////////////////////////

			//cas où tout est ok:
			$erreur = '<div class ="alert alert-success"> Votre nouvelle pétition a été publiée ! </div>';
			//ici je supprime les tout les champs rempli s'ils sont deja tous remplis
			unset($_POST['titre_petition']);
			unset($_POST['sujet_petition']);
			unset($_POST['nb_signature']);

			unset($_POST['politique']);
			unset($_POST['environnement']);
			unset($_POST['famillial']);
			unset($_POST['autres']);
		}
		//Sinon...
		else{
			//ici pas tout les champs remplis

			$erreur='<div class=" alert alert-danger">Attention ! Les champs ne sont pas tous remplis</div>';	

			//unset($_POST['titre_petition']);
			//unset($_POST['sujet_petition']);
			unset($_POST['nb_signature']);
		}
	}
}
?>

<!DOCTYPE html>
<html>
	
	<head>
		<meta charset="utf-8">
		 <link rel="stylesheet" type="text/css" >
	<title>Annoncer une pétition</title>
	</head>

	<body>

	<div id="corps" align="center">

		<fieldset>
			<legend>
				<h2>Annoncez une nouvelle pétition !</h2>
			</legend>

			<form action="petition.php" method="POST">
			<p> 
			<table>

				<tr>
					<span><?php if(isset($erreur)) echo $erreur; ?></span>
				</tr>



				<tr>
					<label for="titre_petition">Titre de votre pétition : </label>
					<input type="text" name="titre_petition" id="titre_petition" value="<?php if(isset($_POST['titre_petition'])) echo $_POST['titre_petition']?>">
				</tr>
				<br/>
				<tr>
					<span class="errormsg" style="color: red">
						<?php if(isset($err_titre)) echo $err_titre; ?>
					</span>
				</tr>
				<br/>
				<br/>

				<tr>
						<select multiple class="form-control" name="categorie">
							
 							<option name="politique">Politique</option>
 							<option name="environnement">Environnement</option>
  							<option name="famillial">Familial</option>
  							<option name="sante">Santé</option>
  							<option name="autres">Autres</option>
						</select>					
				</tr>
				<br/>
				<tr>
					<span class="errormsg" style="color: red">
						<?php if(isset($err_categorie)) echo $err_categorie; ?>
					</span>
				</tr>
				<br/>
				<br/>



				<tr>
					<label for="sujet_petition">Sujet de votre pétition : </label><br/>
					<textarea name="sujet_petition" id="sujet_petition" class="form-control" rows="20" cols="150"><?php if(isset($_POST['sujet_petition'])) echo $_POST['sujet_petition']?></textarea>
				</tr>
				<br/>
				<tr>
					<span class="errormsg" style="color: red">
						<?php if(isset($err_sujet)) echo $err_sujet; ?>
					</span>
				</tr>
				<br/>
				<br/>



				<tr>
					<label for="nb_signature">Nombre de signatures que vous souhaitez atteindre : </label>
					<input type="text" name="nb_signature" id="nb_signature" >
				</tr>
				<br/>
				<tr>
					<span class="errormsg" style="color: red">
						<?php if(isset($err_signature)) echo $err_signature; ?>
					</span>
				</tr>
				<br/>
				<br/>




				<tr>
					<form action="petition.php" method="POST">
						<input type="submit" name="publier" value="Publier ma pétition">
					</form>
				</tr>
		
			</table>		
			</p>
 	
			</form>


		</fieldset>
	</div>

		
	<?php include('footer.php'); ?>
		
	
	</body>

</html>






