<?php
//--- ETAPE 1 : EXPLICATIONS : page Bg_billet_act.php
//--- SCRIPT ACTION : insertion modification
//--- DETAILS FONCTIONS
/*
LIB/db_config.php - formatDateStocke($BG_BI_DATE) - convertir une date fr au format us pour la stocker
OBJETS/Bg_billet.php - creer() - créer un billet
OBJETS/Bg_billet_famille - creer() - associer un billet à une famille
OBJETS/Bg_billet.php -  modifier_un() - modifier un billet
OBJETS/Bg_billet_famille -  modifier_un() - modifier l'association d'un billet à une famille
OBJETS/Bg_billet.php - detruire($BG_BI_ID) - supprimer un billet
* TODO supprimer l'association d'un billet à une famille
*
*/
//--- ETAPE 2 : LIBRAIRIE
require_once('../LIB/config_db.php');//require_once('../LIB/appel_db.php');
require_once('../OBJETS/Billet.php');
require_once('../OBJETS/Billet_famille.php');//-- BILLET_FAMILLE
//--- ETAPE 3 OBJETS
$myBg_billet=	new Billet();
$myBg_billet_famille=	new Billet_famille();//-- BILLET_FAMILLE
//--- ETAPE 4 PARAMETRES
isset($_REQUEST["act"])?$act=$_REQUEST["act"]:$act="";
isset($_REQUEST["BG_BI_ID"])?$BG_BI_ID=$_REQUEST["BG_BI_ID"]:$BG_BI_ID="";
isset($_REQUEST["BG_BI_LIBELLE"])?$BG_BI_LIBELLE=$_REQUEST["BG_BI_LIBELLE"]:$BG_BI_LIBELLE="";
isset($_REQUEST["BG_BI_TITRE"])?$BG_BI_TITRE=$_REQUEST["BG_BI_TITRE"]:$BG_BI_TITRE="";
isset($_REQUEST["BG_BI_STITRE"])?$BG_BI_STITRE=$_REQUEST["BG_BI_STITRE"]:$BG_BI_STITRE="";
isset($_REQUEST["BG_BI_TEXTE"])?$BG_BI_TEXTE=$_REQUEST["BG_BI_TEXTE"]:$BG_BI_TEXTE="";
isset($_REQUEST["BG_BI_URL"])?$BG_BI_URL=$_REQUEST["BG_BI_URL"]:$BG_BI_URL="";
isset($_REQUEST["BG_BI_DATE"])?$BG_BI_DATE=$_REQUEST["BG_BI_DATE"]:$BG_BI_DATE="";
($BG_BI_DATE=="")?$BG_BI_DATE=date("d/m/Y"):$BG_BI_DATE==$BG_BI_DATE;//--- si date vide
isset($_REQUEST["BG_BI_STATUT"])?$BG_BI_STATUT=$_REQUEST["BG_BI_STATUT"]:$BG_BI_STATUT="";
isset($_REQUEST["BG_BF_ID"])?$BG_BF_ID=$_REQUEST["BG_BF_ID"]:$BG_BF_ID="";//-- BILLET_FAMILLE
isset($_REQUEST["BG_FA_ID"])?$BG_FA_ID=$_REQUEST["BG_FA_ID"]:$BG_FA_ID="";//-- BILLET_FAMILLE
//--- ETAPE 5 : SCRIPT CREATION
switch($act)
{
case "cre":
$action="creation";
//$myBg_billet->BG_BI_ID=$BG_BI_ID;
$myBg_billet->BG_BI_LIBELLE=$BG_BI_LIBELLE;
$myBg_billet->BG_BI_TITRE=$BG_BI_TITRE;
$myBg_billet->BG_BI_STITRE=$BG_BI_STITRE;
$myBg_billet->BG_BI_TEXTE=$BG_BI_TEXTE;
$myBg_billet->BG_BI_URL=$BG_BI_URL;
$myBg_billet->BG_BI_DATE=formatDateStocke($BG_BI_DATE);//--- DATE US MANUELLE
$myBg_billet->BG_BI_STATUT=$BG_BI_STATUT;
$myBg_billet->creer();
$myBg_billet_famille->BG_BF_ID=$BG_BF_ID;//--- BILLET FAMILLE
$myBg_billet_famille->BG_BI_ID=$BG_BI_ID;//--- BILLET FAMILLE (n'existe pas encore)
$myBg_billet_famille->BG_FA_ID=$BG_FA_ID;//--- BILLET FAMILLE
$myBg_billet_famille->creer();//--- BILLET FAMILLE
header ("Location:Bg_billet_gst.php");
break;
case "mdf":
$action="modification";
$myBg_billet->BG_BI_ID=$BG_BI_ID;
$myBg_billet->BG_BI_LIBELLE=$BG_BI_LIBELLE;
$myBg_billet->BG_BI_TITRE=$BG_BI_TITRE;
$myBg_billet->BG_BI_STITRE=$BG_BI_STITRE;
$myBg_billet->BG_BI_TEXTE=$BG_BI_TEXTE;
$myBg_billet->BG_BI_URL=$BG_BI_URL;
$myBg_billet->BG_BI_DATE=formatDateStocke($BG_BI_DATE);//--- DATE US MANUELLE
$myBg_billet->BG_BI_STATUT=$BG_BI_STATUT;
$myBg_billet->modifier_un();
$myBg_billet_famille->BG_BF_ID=$BG_BF_ID;//--- BILLET FAMILLE
$myBg_billet_famille->BG_BI_ID=$BG_BI_ID;//--- BILLET FAMILLE
$myBg_billet_famille->BG_FA_ID=$BG_FA_ID;//--- BILLET FAMILLE
$myBg_billet_famille->modifier_un();//--- BILLET FAMILLE
//echo $BG_FA_ID."-".$BG_BI_ID;
header ("Location:Bg_billet_gst.php");
break;
case "sup":
$action="suppression";
$myBg_billet->BG_BI_ID=$BG_BI_ID;
$myBg_billet->detruire($BG_BI_ID);//SUPPRIMER AUSSI L'ASSOVIATION A LA FAMILLE
header ("Location:Bg_billet_gst.php");
break;
case "statut":
$myBg_billet->BG_BI_ID=$BG_BI_ID;
$myBg_billet->BG_BI_STATUT=$BG_BI_STATUT;
$myBg_billet->modifier_statut($BG_BI_ID);
header ("Location:Bg_billet_gst.php");
break;
}
?>