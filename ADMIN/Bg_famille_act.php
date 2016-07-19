<?php
//--- ETAPE 1 : EXPLICATIONS : page Bg_famille_act.php
//--- SCRIPT ACTION : insertion modification  
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_famille.php - creer() - créer une famille
OBJETS/Bg_famille.php - modifier_un() - modifier une famille
OBJETS/Bg_famille.php - detruire($BG_FA_ID) - supprimer une famille
??? supprimer aussi les associations billets-familles : le dire, et renvoyer vers billets non associés (index.php))
OBJETS/Bg_famille.php - traiter_ordre($ordre) - modifier l'ordre de familles de même niveau
*/
//--- ETAPE 2 : LIBRAIRIE
require_once('../LIB/config_db.php');//require_once('../LIB/appel_db.php');
require_once('../OBJETS/Famille.php');
//--- ETAPE 3 OBJETS
$myBg_famille=	new Famille();
//--- ETAPE 4 PARAMETRES
isset($_REQUEST["act"])?$act=$_REQUEST["act"]:$act="";
isset($_REQUEST["BG_FA_ID"])?$BG_FA_ID=$_REQUEST["BG_FA_ID"]:$BG_FA_ID="";
isset($_REQUEST["BG_FA_LIBELLE"])?$BG_FA_LIBELLE=$_REQUEST["BG_FA_LIBELLE"]:$BG_FA_LIBELLE="";
isset($_REQUEST["BG_FA_TITRE"])?$BG_FA_TITRE=$_REQUEST["BG_FA_TITRE"]:$BG_FA_TITRE="";
isset($_REQUEST["BG_FA_TEXTE"])?$BG_FA_TEXTE=$_REQUEST["BG_FA_TEXTE"]:$BG_FA_TEXTE="";
isset($_REQUEST["BG_FA_URL"])?$BG_FA_URL=$_REQUEST["BG_FA_URL"]:$BG_FA_URL="";
isset($_REQUEST["BG_FA_MERE_ID"])?$BG_FA_MERE_ID=$_REQUEST["BG_FA_MERE_ID"]:$BG_FA_MERE_ID="";
isset($_REQUEST["BG_FA_ORDRE"])?$BG_FA_ORDRE=$_REQUEST["BG_FA_ORDRE"]:$BG_FA_ORDRE="";
isset($_REQUEST["ordre"])?$ordre=$_REQUEST["ordre"]:$ordre="";//ajout
//--- ETAPE 5 : SCRIPT CREATION
switch($act)
{
case "cre":
$action="creation";
$myBg_famille->BG_FA_ID=$BG_FA_ID;
$myBg_famille->BG_FA_LIBELLE=$BG_FA_LIBELLE;
$myBg_famille->BG_FA_TITRE=$BG_FA_TITRE;
$myBg_famille->BG_FA_TEXTE=$BG_FA_TEXTE;
$myBg_famille->BG_FA_URL=$BG_FA_URL;
$myBg_famille->BG_FA_MERE_ID=$BG_FA_MERE_ID;
$myBg_famille->BG_FA_ORDRE=$BG_FA_ORDRE; //echo $myBg_famille->BG_FA_ID." ".$myBg_famille->BG_FA_LIBELLE." ".$myBg_famille->BG_FA_TITRE." ".$myBg_famille->BG_FA_TEXTE." ".$myBg_famille->BG_FA_URL." ".$myBg_famille->BG_FA_MERE_ID." ".$myBg_famille->BG_FA_ORDRE;
$myBg_famille->creer();
header ("Location:Bg_famille_gst.php");
break;
case "mdf":
$action="modification";
$myBg_famille->BG_FA_ID=$BG_FA_ID;
$myBg_famille->BG_FA_LIBELLE=$BG_FA_LIBELLE;
$myBg_famille->BG_FA_TITRE=$BG_FA_TITRE;
$myBg_famille->BG_FA_TEXTE=$BG_FA_TEXTE;
$myBg_famille->BG_FA_URL=$BG_FA_URL;
$myBg_famille->BG_FA_MERE_ID=$BG_FA_MERE_ID;
$myBg_famille->BG_FA_ORDRE=$BG_FA_ORDRE;
$myBg_famille->modifier_un();
header ("Location:Bg_famille_gst.php");
break;
case "sup":
$action="suppression";
$myBg_famille->BG_FA_ID=$BG_FA_ID;
$myBg_famille->detruire($BG_FA_ID);
header ("Location:Bg_famille_gst.php");
break;
case "ordre"://ajout de ce cas
$action="schangement d'ordre'";
$myBg_famille->traiter_ordre($ordre);
header ("Location:Bg_famille_gst.php");
break;
}
?>

