<?php
//--- ETAPE 1 : EXPLICATIONS : page Bg_billet_gst.php
//--- listing des objets avant gestion
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_famille.php - compter_tout() - compter toutes les familles
OBJETS/Bg_billet.php - compter_tout() - compter tous les billets
OBJETS/Bg_famille.php - lister_arbo($bg_fa_mere_id=0) - lister et indenter l'arborescence des familles
OBJETS/Bg_billet.php - lister_billet_avec_famille_nom_precis($BG_FA_ID) - lister les billets d'une famille
OBJETS/Bg_billet.php - lister_billet_avec_famille_nom() -  lister les billets de toutes les familles
OBJETS/Bg_famille.php -  choisir_famille($tableau," - ",$myBg_billet->BG_FA_ID,"1") - liste deroulante des familles avec selection de la famille en cours, et action js de changement
OBJETS/Bg_billet.php - liste_statut ($myBg_billet->BG_BI_STATUT,"1")  - liste deroulante des statuts avec selection du statut en cours, et action js de changement
* */
//--- ETAPE 2 : LIBRAIRIE  CGT
require_once('../LIB/config_db.php');//require_once('../LIB/appel_db.php');
require_once('../OBJETS/Billet.php');
require_once('../OBJETS/Famille.php');//--- AJOUT

//--- ETAPE 3 OBJETS CGT
$myBg_billet=	new Billet();
$myBg_famille=	new Famille();//--- AJOUT

//--- ETAPE 4 PARAMETRES
isset($_REQUEST["gst"])?$gst=$_REQUEST["gst"]:$gst="";
isset($_REQUEST["BG_FA_ID"])?$BG_FA_ID=$_REQUEST["BG_FA_ID"]:$BG_FA_ID="";//--- AFFICHER LES BILLETS D'UNE FAMILLE

include ("haut_admin.php");

//--- SCRIPT EXISTENCE DE DFAMILLE
$comptageBg_famille=$myBg_famille->compter_tout();

//--- PRE REQUIS FAMILLE AVANT BILLET
if ($comptageBg_famille!="0")
{
echo "";
}
else
{
echo "Merci de <a href=Bg_famille_edt.php?edt=cre>créer d'abord une famille</a> avant de créer un billet<br><br>";
}

//--- SCRIPT EXISTENCE DE DONNEES : ET COMBIEN ?
$comptageBg_billet=$myBg_billet->compter_tout();
$comptageBg_billet=$comptageBg_billet[0];
//--- GESTION DU PLURIEL ET DES ACTIONS
switch ($comptageBg_billet)
{
case "0":
$cas="rien";$message="bg_billet";
break;
case "1":
$cas="singulier";$message="bg_billet toute famille confondue";
break;
case ($comptageBg_billet>1):
$cas="pluriel";$message="bg_billets toute famille confondue";
break;
}
//--- MESSAGE ADAPTE
echo $comptageBg_billet." ".$message."<br>";
//--- CREATION
if ($comptageBg_famille!="0"){;
echo "Créer un objet : bg_billet <a href=Bg_billet_edt.php?edt=cre>en suivant le lien</a><br><br>";
}else {};
//--- TABLEAU SI ENTREE DEJA EN BASE
if ($cas!="rien")
{
$tableau=$myBg_famille->lister_arbo($bg_fa_mere_id=0);//A PARTAGER !!
if ($BG_FA_ID!=""){
$billets_famille_precise=$myBg_billet->lister_billet_avec_famille_nom_precis($BG_FA_ID);//--- AFFICHER LES BILLETS D'UNE FAMILLE
//print_r($billets_famille_precise);echo "<br>".$BG_FA_ID."<br>";
$cible="d'une famille précise";
$ListeAlpha_bg_billet=$billets_famille_precise;
}
else{
$cible="";
//--- LISTE DES FAMILLES APPELEE QU'UNE FOIS
$ListeAlpha_bg_billet=$myBg_billet->lister_billet_avec_famille_nom();//$myBg_billet->Lister_tout_alpha();
//print_r($ListeAlpha_bg_billet);
}


?>
<TABLE id=listing cellSpacing=0 cellPadding=0>
<CAPTION>Liste des bg_billets <?php echo $cible;?></CAPTION>
<COLGROUP>
	<COL id=identifiants><COL id=libelles_billet><COL id=famille_billet><COL id=statut_billet><COL id=actions>
</COLGROUP>
<THEAD><TR>
	<TH>ID</TH><TH>LIBELLES</TH><TH>FAMILLE</TH><TH>STATUT</TH><TH>ACTIONS</TH>
</TR></THEAD>
<TFOOT><TR>
	<TD>ID</TD><TD>LIBELLES</TD><TD>FAMILLE</TD><TD>STATUT</TD><TD>ACTIONS</TD>
</TR></TFOOT>
<?php
//--- BOUCLE DEBUT
//print_r($ListeAlpha_bg_billet);
for ($i=0; $i<count($ListeAlpha_bg_billet); $i++){
//--- ASSIGNATION OBJET
$myBg_billet= $ListeAlpha_bg_billet[$i];
//--- GESTION lIGNE PAIRE IMPAIRE
if ($i%2 == 1) {$type="impair";}else{$type="pair";}
//--- GESTION LIGNE SURVOL

echo "\n<FORM name=\"Ligne_edt".$i."\" ACTION=\"Bg_billet_famille_act.php?act=fam\" METHOD=\"POST\">";
echo "<input type=\"hidden\" name=\"BG_BI_ID\" value=\"".$myBg_billet->BG_BI_ID."\">";
echo "<TR onmouseover= \"this.className='survol' \"  onmouseout=\"this.className='$type'\" class='$type'>";
echo "<TD><a href=Bg_billet_edt.php?edt=mdf&BG_BI_ID=".$myBg_billet->BG_BI_ID.">".$myBg_billet->BG_BI_ID."</a></TD>";
echo "<TD><a href=Bg_billet_edt.php?edt=mdf&BG_BI_ID=".$myBg_billet->BG_BI_ID.">".$myBg_billet->BG_BI_LIBELLE."</a></TD>";
echo "<TD>";
echo $myBg_famille->choisir_famille($tableau," - ",$myBg_billet->BG_FA_ID,"1");//--- LISTE DES FAMILLES
		//print_r($tableau);
echo "</TD>";
echo "<TD>&nbsp";
echo $myBg_billet->liste_statut ($myBg_billet->BG_BI_STATUT,"1");
echo "</TD>";
echo "<TD><a href=Bg_billet_edt.php?edt=mdf&BG_BI_ID=".$myBg_billet->BG_BI_ID.">MODIF</a> ou <a href=Bg_billet_act.php?act=sup&BG_BI_ID=".$myBg_billet->BG_BI_ID.">SUPPR</a></TD></TR>";
echo "</form>\n";
}
echo "</TABLE>";
}

include ("bas_admin.php");

?>