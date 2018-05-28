<?php
	session_start(); 
	include('entete.php');
	include('menu.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="acceuil.css">
	<title>A vous la Parole:</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
   	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>



<body>

<div id="corps" align="center">
	<h2>La fondation mondiale pour le changement</h2><br/>
</div>

<section>
	
	<div class="container">
		
       <div id="myCarousel" class="carousel slide" data-ride="carousel">

			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
			</ol>

			<div class="carousel-inner">

				<div class="item active">
					<img src="https://www.contrepoints.org/wp-content/uploads/2014/07/Libert%C3%A9-dexpression-Demeure-du-chaos-CC-matttdotorg.jpg" alt="Parler" style="width:100%;height:60%;">
					<div class="carousel-caption">
						<h3>S'exprimer en liberté</h3>
					  	<p>
					  		“Dans la plupart des pays, les citoyens possèdent la liberté de parole. Mais dans une démocratie, ils possèdent encore la liberté après avoir parlé.”
					  	</p>
					</div>
				</div>

				<div class="item">
					<img src="http://statics.lesinrocks.com/content/thumbnails/uploads/2016/05/img_1020-tt-width-604-height-403-crop-0-bgcolor-000000-lazyload-0.jpg" alt="paris" style="width:100%;height:60%;">
					<div class="carousel-caption">
						<h3>PAS peur</h3>
					  	<p>“Nuit debout est le premier mouvement social post-marxiste”</p>
					</div>
				</div>

			</div>

				<a class="left carousel-control" href="#myCarousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				  	<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				  	<span class="sr-only">Next</span>
				</a>
		</div>
	</div>
	<br/> <hr>
			

	<section>		
		<div id="corps" align="center">
			<article class="article"> 
				<h2>
					<strong>Sport</strong>
				</h2>
			</article>	
		
			<video src="madrid.mp4" controls poster="https://i.ytimg.com/vi/h6WtXtmvQRI/hqdefault.jpg" width="600"></video>
		
			<p>
				<h4>Dans sa demi-finale aller de la Ligue des champions, le Real Madrid mène désormais 3-0 devant l’Atlético Madrid. Trois buts signés par l’inévitable Cristiano Ronaldo ! Un triplé retentissant, qui débute dès la 10e minute de jeu, concrétisant le bon début de match des siens. Après la pause, il signe son 2e but d’une frappe limpide à l’entrée de la surface (73′). Et il remet ça, plein de sang froid, pour signer son triplé (86′).</h4>
			</p>
		</div>
	</section><hr>


	<section>		
		<div id="corps" align="center">
			<article class="article"> 
				<h2>Droits humains</h2>
				<img src="Images/imagevote.jpg" alt="Droits humains"><br/><br/>
				  
				<p>
					<strong>POURQUOI UNE VOTATION POUR NOTRE PROCESSUS CONSTITUANT ?</strong>
					<br/><br/>
					<h4>
						Nous avons des raisons de penser que le processus constituant actuel est la cause première de notre démocratie malade. Mais il est inconcevable d'imposer légitimement une alternative sans le consentement de la population. Nous demandons donc que le processus constituant fasse l'objet d'une consultation nationale pour faire émerger toutes les alternatives possibles au système actuel puis d'une "votation", terme approprié puisqu'il s'agira de voter pour un projet.
						<br/> Comment un élu ou un candidat à une élection pourrait rester insensible à notre demande ? S'il se dit démocrate, alors il nous doit cette votation. S'il la refuse, il n'est tout simplement pas démocrate...
					</h4>
				</p>
			</article>					
		</div>
	</section><hr>

</section>
			

		
<?php include('footer.php'); ?>


</body>

</html>





