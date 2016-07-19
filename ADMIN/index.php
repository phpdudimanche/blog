<?php
//--- ETAPE 1 : EXPLICATIONS : page index.php
//--- alertes et tableau de bord de l'accueil de l'administration
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_famille.php - compter_tout() - compteur de famille
OBJETS/Bg_billet.php - lister_billet_avec_famille_nom() - billets liés à une famille
OBJETS/Bg_billet.php -  lister_billet_sans_famille() - billets non liés à une famille
OBJETS/Bg_billet_score.php -  lister_ordonner_compter_billets_sas() - billets à traiter
*/

//--- ETAPE 2 : LIBRAIRIE
require_once('../LIB/config_db.php');//require_once('../LIB/appel_db.php');
require_once('../OBJETS/Billet.php');//require_once('../OBJETS/Bg_billet.php');
require_once('../OBJETS/Famille.php');//require_once('../OBJETS/Bg_famille.php');
require_once('../OBJETS/Billet_score.php');//require_once('../OBJETS/Bg_billet_score.php');

include ("haut_admin.php");

//--- ETAPE 3 OBJETS
$myBg_billet=	new Billet();
$myBg_famille=	new Famille();
$myBg_billet_score=	new Billet_score();

//--- SCRIPT EXISTENCE DE DFAMILLE
$comptageBg_famille=$myBg_famille->compter_tout();
//--- PRE REQUIS FAMILLE AVANT BILLET
if ($comptageBg_famille!="0")
{
$sas=$myBg_billet_score->lister_ordonner_compter_billets_sas();
	if (count($sas)!=0) {
	$compte_billet_attente=0;
	$compte_billet_retrait=0;

echo "Le(s) billet(s) à traiter en priorité : <br />";
		for ($i=0; $i<count($sas); $i++){
		$myBg_billet_score=$sas[$i];
				if ($myBg_billet_score->BILLET_ATTENTE!=NULL) {
						($myBg_billet_score->NBRE_ATTENTE >1)?$genre="billets en attente":$genre="billet en attente";// pluriel ou singulier
						($compte_billet_attente==0)?$titre="<br />".$myBg_billet_score->NBRE_ATTENTE." ".$genre."<br />":$titre="";// titre qu'une fois
				echo $titre."<a href=\"Bg_billet_edt.php?edt=mdf&BG_BI_ID=".$myBg_billet_score->BG_BI_ID."\">".$myBg_billet_score->BILLET_ATTENTE."</a><br />";
						$compte_billet_attente++;
				}
				if ($myBg_billet_score->BILLET_RETRAIT!=NULL) {
						($myBg_billet_score->NBRE_RETRAIT >1)?$genre="billets en retrait":$genre="billet en retrait";// pluriel ou singulier
						($compte_billet_retrait==0)?$titre="<br />".$myBg_billet_score->NBRE_RETRAIT." ".$genre."<br />":$titre="";// titre qu'une fois
				echo $titre."<a href=\"Bg_billet_edt.php?edt=mdf&BG_BI_ID=".$myBg_billet_score->BG_BI_ID."\">".$myBg_billet_score->BILLET_RETRAIT."</a><br />";
						$compte_billet_retrait++;
			}
		}
	}
	else {// lecture de la version
$fichier = fopen($chaine_root."LIB/version_".$version.".txt", "r");
$content = fread($fichier, 8024);
echo nl2br($content);
		}
}

else
{
echo "Merci de <a href=Bg_famille_edt.php?edt=cre>créer d'abord une famille</a> avant de créer un billet<br><br>";
}

$famille_manque= $myBg_billet->lister_billet_sans_famille();//--- BILLETS SANS FAMILLE (et non avec famille 0)

if (count($famille_manque)!=0){echo "<u>".count($famille_manque)." Billets sans famille :</u><br>";}
for ($i=0; $i<count($famille_manque); $i++){
$myBg_billet= $famille_manque[$i];
echo $myBg_billet->BG_BI_ID." - <a href=\"Bg_famille_gst.php?gst=asso&BG_BI_ID=".$myBg_billet->BG_BI_ID."\">".$myBg_billet->BG_BI_LIBELLE."</a><br>";
}

include ("bas_admin.php");
?>