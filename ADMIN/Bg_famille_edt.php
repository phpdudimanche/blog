<?php
//--- ETAPE 1 : EXPLICATIONS : page Bg_famille_edt.php
//--- FORMULAIRE EDITION : cr�ation modification et changment d'ordre des familles
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_famille.php -  retrouver_un($BG_FA_ID) - initialiser une famille
OBJETS/Bg_famille.php - lister_ordre_niveau($myBg_famille->BG_FA_MERE_ID) - classer par ordre les familles d'un m�me niveau pr�cis
*/
//--- ETAPE 2 : LIBRAIRIE
require_once('../LIB/config_db.php');//require_once('../LIB/appel_db.php');
require_once('../OBJETS/Famille.php');

//--- ETAPE 3 OBJETS
$myBg_famille=	new Famille();

//--- ETAPE 4 PARAMETRES
isset($_REQUEST["edt"])?$edt=$_REQUEST["edt"]:$edt="";
isset($_REQUEST["BG_FA_ID"])?$BG_FA_ID=$_REQUEST["BG_FA_ID"]:$BG_FA_ID="";
isset($_REQUEST["BG_FA_MERE_ID"])?$BG_FA_MERE_ID=$_REQUEST["BG_FA_MERE_ID"]:$BG_FA_MERE_ID="";

//--- ETAPE 5 HAUT DE PAGE
include ("haut_admin.php");

//--- ETAPE 6 SCRIPTS ACTION
switch ($edt)
{
case "cre":
$action="Création";
$act="crea";
break;
case "mdf":
$action="Modification";
$act="maj";
$myBg_famille-> retrouver_un($BG_FA_ID);
break;
case "fa":
$action="Création (de même niveau) ";//passer le nom en param
$myBg_famille->BG_FA_MERE_ID=$BG_FA_MERE_ID;
$edt="cre";
$act="crea";
break;
case "sousfa":
$action="Création (de sous niveau) ";//passer le nom en param
$myBg_famille->BG_FA_MERE_ID=$BG_FA_ID;
$edt="cre";
$act="crea";
break;
case "ordre":
$myBg_famille->BG_FA_MERE_ID=$BG_FA_MERE_ID;
break;
}

//--- ETAPE 7 FORMULAIRE EDITION
if ($edt!="ordre")
{
//--- formulaire d'édition début
?>

<FORM  ACTION="Bg_famille_act.php" METHOD="POST">
<input type="hidden" name="act" value="<?php echo $edt;?>">
<FIELDSET>
<legend><?php echo $action;?> de bg_famille &nbsp;</legend>
<input type="hidden" name="BG_FA_ID" value="<?php echo $myBg_famille->BG_FA_ID;?>">
<dt><LABEL>libelle</LABEL></dt>
<dd><input type="text" name="BG_FA_LIBELLE" size="27" value="<?php echo $myBg_famille->BG_FA_LIBELLE;?>"></dd>
<dt><LABEL>ordre</LABEL></dt>
<dd><input type="text" name="BG_FA_ORDRE" size="27" value="<?php echo $myBg_famille->BG_FA_ORDRE;?>"></dd>
<dt><LABEL>titre</LABEL></dt>
<dd><input type="text" name="BG_FA_TITRE" size="50" value="<?php echo $myBg_famille->BG_FA_TITRE;?>"></dd>
<dt><LABEL>texte</LABEL></dt>
<dd><textarea  name="BG_FA_TEXTE" value="" cols="70" rows="5"><?php echo $myBg_famille->BG_FA_TEXTE;?></textarea></dd>
<dt><LABEL>url</LABEL></dt>
<dd><input type="text" name="BG_FA_URL" size="27" value="<?php echo $myBg_famille->BG_FA_URL;?>"></dd>
<dt><LABEL>mereid</LABEL></dt>
<dd><input type="text" name="BG_FA_MERE_ID" size="27" value="<?php echo $myBg_famille->BG_FA_MERE_ID;?>"></dd>
<div id="action">
<input type="Submit" value="envoyer" class="BUTTON" name="envoie">
<input type="Reset" value="annuler" class="BUTTON" name="effacer">
</div>
</FIELDSET>
</FORM>

<?php
//--- formulaire d'édition fin
}
else
{
//--- RECUPERATION DES FAMILLES
//echo $myBg_famille->BG_FA_MERE_ID;
$liste_ordre=$myBg_famille->lister_ordre_niveau($myBg_famille->BG_FA_MERE_ID);
//print_r($liste_ordre);

echo "<FORM name='tjsform' action='Bg_famille_act.php?act=ordre&rub=$myBg_famille->BG_FA_MERE_ID' method=post>";
	echo "<TABLE border=0>";
		echo "<TR>";
			echo "<TD valign=top align=center>";
				echo "<SELECT name='liste' size='25' style='width:300px'>";

//--- BOUCLE POUR CHAQUE FAMILLE
for ($i=0; $i<count($liste_ordre); $i++){
$myBg_famille= $liste_ordre[$i];
echo "<OPTION value=$myBg_famille->BG_FA_ID>$myBg_famille->BG_FA_LIBELLE</OPTION>";
}

		echo "</SELECT>";
echo "<br><INPUT type=hidden name=ordre> <input type=submit name=act value=ordre>";
			echo "</TD>";
			echo "<TD valign=top>";
				echo "<INPUT type=button value='Monter' style='width:100px' onClick='tjs_haut(this.form.liste)'>";
				echo "<BR>";
				echo "<INPUT type=button value='Descendre' style='width:100px' onClick='tjs_bas(this.form.liste)'>";
			echo "</TD>";
		echo "</TR>";
	echo "</TABLE>";

	//echo "</SELECT>";
	//echo "<INPUT type=hidden name=ordre> <input type=submit name=act value=ordre>";
	echo "</FORM>";


}
include ("bas_admin.php");

?>