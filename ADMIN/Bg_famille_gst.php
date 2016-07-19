<?php
//--- ETAPE 1 : EXPLICATIONS : page Bg_famille_gst.php
//--- listing des objets avant gestion
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_famille.php -  compter_tout() - compter les familles
OBJETS/Bg_famille.php -  afficher_arbo_associer_billet($bg_fa_mere_id=0,$BG_BI_ID) - liste arborescente des familles ‡ lier ‡ un billet
OBJETS/Bg_famille.php -  lister_arbo($bg_fa_mere_id=0)
OBJETS/Bg_famille.php -  choisir_famille($tableau," - ","3","0")
OBJETS/Bg_famille.php -  Lister_tout_alpha() - liste alphabÈtique des familles
OBJETS/Bg_famille.php -  afficher_arbo($bg_fa_mere_id=0) - prÈsenter les familles dans une arborescence
*/
//--- ETAPE 2 : LIBRAIRIE CGT
require_once('../LIB/config_db.php');//require_once('../LIB/appel_db.php');
require_once('../OBJETS/Famille.php');

//--- ETAPE 3 OBJETS CGT
$myBg_famille=	new Famille();

//--- ETAPE 4 PARAMETRES
isset($_REQUEST["gst"])?$gst=$_REQUEST["gst"]:$gst="";
isset($_REQUEST["BG_BI_ID"])?$BG_BI_ID=$_REQUEST["BG_BI_ID"]:$BG_BI_ID="";

include ("haut_admin.php");

//--- SCRIPT EXISTENCE DE DONNEES : ET COMBIEN ?
$comptageBg_famille=$myBg_famille->compter_tout();
		$comptageBg_famille=$comptageBg_famille[0];// car getChamp a ete remplace par array CGT
//--- GESTION DU PLURIEL ET DES ACTIONS
switch ($comptageBg_famille)
{
case "0":
$cas="rien";$message="bg_famille";
break;
case "1":
$cas="singulier";$message="bg_famille";
break;
case ($comptageBg_famille>1):
$cas="pluriel";$message="bg_familles";
break;
}

if ($gst=="asso")//--- AJOUT BILLET FAMILLE DEBUT
{
echo "Liste arborescente des bg_familles √† lier au billet";
$myBg_famille->afficher_arbo_associer_billet($bg_fa_mere_id=0,$BG_BI_ID);
}
else
{
// $tableau=$myBg_famille->lister_arbo($bg_fa_mere_id=0);//la liste d√©roulante des familles
//--- VERIF print_r($tableau);
//--- VERIF echo "<br><br>";
//echo $myBg_famille->choisir_famille($tableau," - ","3","0");
//echo "<br><br>";

//--- MESSAGE ADAPTE
echo $comptageBg_famille." ".$message."<br />";
//--- CREATION
echo "Cr√©er un objet : bg_famille <a href=Bg_famille_edt.php?edt=cre>en suivant le lien</a><br><br>
";
//--- TABLEAU SI ENTREE DEJA EN BASE
if ($cas!="rien")
{
//--- MENU DIV

//--- DIV 1
?>
<a href="#" onClick="showOnglet('liste',2,1)">Liste alphab√©tique</a> - <a href="#" onClick="showOnglet('liste',2,2)">Liste arborescente</a> <br><br>
<div id="liste1" style="display:none">
<TABLE id=listing cellSpacing=0 cellPadding=0>
<CAPTION>Liste alphab√©tique des bg_familles</CAPTION>
<COLGROUP>
	<COL id=identifiants><COL id=libelles><COL id=actions>
</COLGROUP>
<THEAD><TR>
	<TH>ID</TH><TH>LIBELLES</TH><TH>ACTIONS</TH>
</TR></THEAD>
<TFOOT><TR>
	<TD>ID</TD><TD>LIBELLES</TD><TD>ACTIONS</TD>
</TR></TFOOT>
<?php
$ListeAlpha_bg_famille=$myBg_famille->Lister_tout_alpha();
//--- VERIF print_r($ListeAlpha_bg_famille);
//--- BOUCLE DEBUT
	for ($i=0; $i<count($ListeAlpha_bg_famille); $i++){
	//--- ASSIGNATION OBJET
	$myBg_famille= $ListeAlpha_bg_famille[$i];
	//--- GESTION lIGNE PAIRE IMPAIRE
	if ($i%2 == 1) {$type="impair";}else{$type="pair";}
	//--- GESTION LIGNE SURVOL
	echo "<TR onmouseover= \"this.className='survol' \"  onmouseout=\"this.className='$type'\" class='$type'><TD><a href=Bg_famille_edt.php?edt=mdf&BG_FA_ID=".$myBg_famille->BG_FA_ID.">".$myBg_famille->BG_FA_ID."</a></TD><TD><a href=Bg_famille_edt.php?edt=mdf&BG_FA_ID=".$myBg_famille->BG_FA_ID.">".$myBg_famille->BG_FA_LIBELLE."</a></TD><TD><a href=Bg_famille_edt.php?edt=mdf&BG_FA_ID=".$myBg_famille->BG_FA_ID.">MODIF</a> ou <a href=Bg_famille_act.php?act=sup&BG_FA_ID=".$myBg_famille->BG_FA_ID.">SUPPR</a></TD></TR>
	";
	}
echo "</TABLE>";
echo "</div>";
//--- DIV 2
echo "<div id='liste2' style='display:'>";
echo "Liste arborescente des bg_familles";
$myBg_famille->afficher_arbo($bg_fa_mere_id=0);
echo "</div>";
}


}//--- AJOUT BILLET FAMILLE FIN

include ("bas_admin.php");

?>