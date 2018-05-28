<?php
include("config.php");

try
	{
	//$qDb = "CREATE DATABASE IF NOT EXISTS `webproject`";
    // use exec() because no results are returned
    //$conn->exec($qDb);
    //echo "Database created successfully<br>";

    //$dbname = "nom_de_votre_bdd";
    $qSelDb = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $qSelDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	    // sql to create table
	$qTbFormulaire = "CREATE TABLE IF NOT EXISTS formulaire (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  	mail VARCHAR(50) NOT NULL,
  	nom VARCHAR(30) NOT NULL,
  	prenom VARCHAR(30) NOT NULL,
  	pseudo VARCHAR(30) NOT NULL,
  	mdp TEXT NOT NULL
  	)ENGINE=InnoDB";
//ENGINE = InnoDB --> c'est un moteur de tables, spécificités de MySQL. Moteurs de stockage

///////////////////////////////////////////////////::


///////////////////////////////////////////////////::
	
    $qTbPetitions = "CREATE TABLE IF NOT EXISTS petitions (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    pseudo VARCHAR(30) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    categorie VARCHAR(30) NOT NULL,
    petition_titre VARCHAR(100) NOT NULL,
    petition_sujet TEXT NOT NULL,
    petition_date DATETIME NOT NULL,
    nb_signature INT(10) NOT NULL,
    nb_obtenue INT(10) NOT NULL default 0
    )ENGINE=InnoDB";
//    categorie VARCHAR(30) NOT NULL,

////////////////////////////////////////////////////::

    $qTbListeSignee = "CREATE TABLE IF NOT EXISTS liste (
    id_liste INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    id_petition INT(6) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    titre VARCHAR(100) NOT NULL
    )ENGINE=InnoDB";

    // use exec() because no results are returned
    $qSelDb->exec($qTbFormulaire);
    //echo "Table formulaire created successfully";
    $qSelDb->exec($qTbPetitions);

    $qSelDb->exec($qTbListeSignee);

//////////////////////////////////////

    /////quelques petitions précréées...

    $sql1 = "INSERT IGNORE INTO petitions (id, pseudo, mail, categorie, petition_titre, petition_sujet, petition_date, nb_signature, nb_obtenue)
    VALUES ('1',
            'Johndu33',
            'johndoe@example.com',
            'politique',
            'Le premier ministre',
            'Bonjour à tous ! \n Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat nonproident, sunt in culpa qui officia deserunt ollit anim id est laborum.',
            '2017-05-12 12:22:22',
            '109',
            '100')";

    $sql2 = "INSERT IGNORE INTO petitions (id, pseudo, mail, categorie, petition_titre, petition_sujet, petition_date, nb_signature, nb_obtenue)
    VALUES ('2',
            'Jessycat',
            'jess@example.fr',
           'autres',
            'Sauvons nos animaux !',
            'Bonjour à tous ! \n Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodoconsequat. Duis miaouuu irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat nonproident, sunt in culpa qui officia deserunt ollit anim id est laborum.',
            '2017-05-12 02:30:51',
            '19',
            '11')";

    $qSelDb->exec($sql1);    
    $qSelDb->exec($sql2); 


    }

catch(PDOException $e)
    {
    //echo $qDb . "<br>" . $e->getMessage();
    echo $qTbFormulaire . "<br>" . $e->getMessage();
    echo $qTbPetitions . "<br>" . $e->getMessage();
    echo $qTbListeSignee . "<br>" . $e->getMessage();
    }

?>
