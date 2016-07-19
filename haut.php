<?php
//--- ETAPE 1 : EXPLICATIONS : page haut.php
//--- sur le front-office : en-tête partagé
//--- le titre sera dynamique

//--- ETAPE 2 : LIBRAIRIE
require_once('LIB/config_db.php');//require_once('LIB/appel_db.php');
require_once('OBJETS/Billet.php');//require_once('OBJETS/Bg_billet.php');
require_once('OBJETS/Famille.php');//require_once('OBJETS/Bg_famille.php');

//--- ETAPE 3 OBJETS
$myBg_billet=	new Billet();//new Bg_billet();
$myBg_famille=	new Famille();//new Bg_famille();

//--- ETAPE 4 VARIABLES
isset($_REQUEST["BG_FA_ID"])?$BG_FA_ID=$_REQUEST["BG_FA_ID"]:$BG_FA_ID="";//--- page famille demandée
isset($_REQUEST["BG_BI_ID"])?$BG_BI_ID=$_REQUEST["BG_BI_ID"]:$BG_BI_ID="";

//--- SESSION
// avant toute sortie

//-- SCRIPTS

//--- CERVEAU DES PAGES
/* détection de la page :
sortie des tableaux
assignation des variables d'optimisation */

$page = explode($repertoire_ou_pas,$_SERVER['SCRIPT_NAME']);// même à la racine : affiche index.php : parser et enlever racine
//echo " -".$page[1];


	switch ($page[1])
				{
				case "index.php":
				$balise_title=$balise_title;
				$balise_description=$edito_titre." ".$edito_texte;
				$billets_accueil=$myBg_billet->lister_billet_avec_famille_nom_actif(0,$accueil);//print_r($billets_accueil);
				break;
				case "famille.php":
				$billets_famille=$myBg_billet->lister_billet_actif_famille($BG_FA_ID);//print_r($billets_famille);
				$myBg_famille->retrouver_un($BG_FA_ID);
				$balise_title=$myBg_famille->BG_FA_TITRE;
				$balise_description=$myBg_famille->BG_FA_TEXTE;
				break;
				case "billet.php":
				$myBg_billet->retrouver_un($BG_BI_ID);
					//$row=$myBg_billet->retrouver_un($BG_BI_ID);
					//print_r($row);
					//echo "<br/<br /><b>ici </b>".$row[0]["bg_bi_id"];
				$balise_title=$myBg_billet->BG_BI_TITRE;
				$balise_description=$myBg_billet->BG_BI_STITRE;
				$BG_FA_ID=$myBg_billet->BG_FA_ID;// pour le menu arborescent famille de la page cote.php
				$billets_famille=$myBg_billet->tableau_billet_actif_famille($BG_FA_ID);// envoyer tableau pour ne pas perturber l'objet
				$style=parite(0);//pour afficher l'image d'un côté précis
				break;
				}


?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
<title><?php echo $balise_title;?></title>
<meta name="description" content="<?php echo $balise_description;?>">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /><!-- ISO-8859-1  UTF-8-->
<link rel="stylesheet" type="text/css" href="<?php echo $style_front;?>" />
<link rel="icon" type="image/png" href="STYLE/logo.png" />
</head>
<body>

<div id="conteneur">

				<div id="centre">
<b><a href="./" class="logo"><?php echo "$edito_titre";?></a></b>
<i><?php echo "$edito_texte";?></i>
<br><br>