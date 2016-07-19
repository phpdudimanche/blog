<?php
//--- ETAPE 1 : EXPLICATIONS : page Bg_billet_edt.php
//--- FORMULAIRE EDITION : création modification
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_billet.php - lister_tout_alpha() - sert juste d'anti bug our la connexion
OBJETS/Bg_billet.php - le_nouvel_id() - nouvel identifiant alloué au nouveau produit
OBJETS/Bg_billet.php -  retrouver_un($BG_BI_ID) - trouver un billet précis
OBJETS/Bg_billet_famille.php - retrouver_depuis_billet($BG_BI_ID) - trouver la famille d'un billet précis
OBJETS/Bg_famille lister_arbo($bg_fa_mere_id=0) - liste des familles utilisée pour les autres listes déroulantes
OBJETS/Bg_billet.php - lister_billet_avec_famille_nom() - INUTILE
OBJETS/Bg_famille_billet.php - choisir_famille($tableau," - ",$myBg_billet_famille->BG_FA_ID,"0") - liste déroulante indentée des familles avec sélection de celle du billet
LIB/db_config.php - formatDateAffiche($myBg_billet->BG_BI_DATE) - date us stockée affichée au format fr
OBJETS/Bg_billet.php - liste_statut ($myBg_billet->BG_BI_STATUT,"0") - liste déroulante des statuts avec sélection de celui du billet
*/

//--- ETAPE 2 : LIBRAIRIE
require_once('../LIB/config_db.php');//require_once('../LIB/appel_db.php');
require_once('../OBJETS/Billet.php');
require_once('../OBJETS/Famille.php');
require_once('../OBJETS/Billet_famille.php');

//--- ETAPE 3 OBJETS
$myBg_billet=	new Billet();
$myBg_famille=	new Famille();
$myBg_billet_famille=	new Billet_famille();

//--- ETAPE 4 PARAMETRES
isset($_REQUEST["edt"])?$edt=$_REQUEST["edt"]:$edt="";
isset($_REQUEST["BG_BI_ID"])?$BG_BI_ID=$_REQUEST["BG_BI_ID"]:$BG_BI_ID="";
isset($_REQUEST["BG_BF_ID"])?$BG_BF_ID=$_REQUEST["BG_BIF_ID"]:$BG_BF_ID="";//--- ne pas buger en mode création
isset($_REQUEST["BG_FA_ID"])?$BG_FA_ID=$_REQUEST["BG_FA_ID"]:$BG_FA_ID="";

//--- ETAPE 5 HAUT DE PAGE
include ("haut_admin.php");

//--- ETAPE 6 SCRIPTS ACTION
switch ($edt)
{
case "cre":
$action="CrÃ©ation";
$act="crea";
$myBg_billet-> lister_tout_alpha();//--- ETABLIR CONNECTION : BUG 08080401
$myBg_billet->BG_BI_ID=$myBg_billet->le_nouvel_id();//--- RECUPERATION FUTUR ID : BUG 08080402 (inutile avec PDO)
	$famille=$BG_FA_ID;
break;
case "mdf":
$action="Modification";
$act="maj";
$myBg_billet-> retrouver_un($BG_BI_ID);
$myBg_billet_famille->retrouver_depuis_billet($BG_BI_ID);
	$famille=$myBg_billet_famille->BG_FA_ID;
break;
}
//isset
$tableau=$myBg_famille->lister_arbo($bg_fa_mere_id=0);//--- LISTE DES FAMILLES APPELEE QU'UNE FOIS
//$ListeAlpha_bg_billet=$myBg_billet->lister_billet_avec_famille_nom();//


//--- ETAPE 7 FORMULAIRE EDITION

?>
<FORM name="Billet_edt" ACTION="Bg_billet_act.php" METHOD="POST">
<input type="hidden" name="act" value="<?php echo $edt;?>">
<FIELDSET>
<legend><?php echo $action;?> de bg_billet &nbsp;</legend>
<input type="hidden" name="BG_BI_ID" value="<?php echo $myBg_billet->BG_BI_ID;?>">
<input type="hidden" name="BG_BF_ID" value="<?php echo $myBg_billet_famille->BG_BF_ID;?>">
<dt><LABEL>libelle</LABEL></dt>
<dd><input type="text" name="BG_BI_LIBELLE" size="27" value="<?php echo $myBg_billet->BG_BI_LIBELLE;?>"></dd>
<dt><LABEL>titre</LABEL></dt>
<dd><input type="text" name="BG_BI_TITRE" size="70" value="<?php echo $myBg_billet->BG_BI_TITRE;?>"></dd>
<dt><LABEL>famille</LABEL></dt>
<dd><?php echo $myBg_famille->choisir_famille($tableau," - ",$famille,"0");?></dd>
<dt><LABEL>stitre</LABEL></dt>
<dd><input type="text" name="BG_BI_STITRE" size="88" value="<?php echo $myBg_billet->BG_BI_STITRE;?>"></dd>
<dt><LABEL>texte</LABEL></dt>
<dd><textarea  name="BG_BI_TEXTE" value="" cols="70" rows="15"><?php echo $myBg_billet->BG_BI_TEXTE;?></textarea></dd>
<dt><LABEL>url</LABEL></dt>
<dd><input type="text" name="BG_BI_URL" size="70" value="<?php echo $myBg_billet->BG_BI_URL;?>"></dd>
<dt><LABEL>date</LABEL></dt>
<dd><input type="text" name="BG_BI_DATE" size="10" value="<?php echo formatDateAffiche($myBg_billet->BG_BI_DATE);?>"></dd>
<dt><LABEL>statut</LABEL></dt>
<dd><?php echo $myBg_billet->liste_statut ($myBg_billet->BG_BI_STATUT,"0");?></dd>
<div id="action">
<input type="button" value="valider" class="BUTTON" onClick="ValiderBillet(this.form)">
<!-- <input type="Submit" value="envoyer" class="BUTTON" name="envoie"> -->
<input type="Reset" value="annuler" class="BUTTON" name="effacer">
</div>
</FIELDSET>
</FORM>

<?php

include ("bas_admin.php");

?>