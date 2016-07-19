<?php
//--- ETAPE 1 : EXPLICATIONS : page index.php
//--- sur le front-office
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_billet.php - lister_billet_avec_famille_nom_actif(0,x) -  x derniers billets actifs
*/
include ("haut.php");
include (__DIR__."/OBJETS/Parser.php");//include ($chaine_root."OBJETS/Parser.php");// $path.
//--- CHERCHER BILLETS ACCUEIL
$billets_accueil=$myBg_billet->lister_billet_avec_famille_nom_actif(0,3);
	//echo "ici : ";print_r($billets_accueil);
	//exit();// TEST
//--- PRESENTER BILLETS ACCUEIL
echo "<div class=\"les_billets\">\n";
echo "		<div class=\"centre\">\n\n";//---- AJOUT
for ($i=0; $i<count($billets_accueil); $i++){
$myBg_billet= $billets_accueil[$i];

$style=parite($i);
	//echo $myBg_billet->bg_bi_date; // --- TODO devoir remettre toute la casse en minuscule OK - TODO template mustache TODO remettre en majuscule : OK
	// duplicate content entre index.php et famille.php
?>

<div class="billet">
  <div class="date"><?php echo formatDateAffiche($myBg_billet->BG_BI_DATE);?></div>
  <div class="titre"><a href=billet.php?BG_BI_ID=<?php echo $myBg_billet->BG_BI_ID;?><?php echo "&URL=".$myBg_billet->BG_BI_URL;?>><?php echo $myBg_billet->BG_BI_TITRE;?></a></div>
  <div class="stitre"><?php echo $myBg_billet->BG_BI_STITRE;?></div>
  <div class="texte_tronque">
	<a href=billet.php?BG_BI_ID=<?php echo $myBg_billet->BG_BI_ID;?><?php echo "&URL=".$myBg_billet->BG_BI_URL;?>><?php afficher_image("billet",$myBg_billet->BG_BI_ID,$style);?></a>
  <?php echo TronqueHtml($myBg_billet->BG_BI_TEXTE, 255, ' ', ' [...]');?>
  <hr />
  </div>
  <div class="libelle"><a href=billet.php?BG_BI_ID=<?php echo $myBg_billet->BG_BI_ID;?><?php echo "&URL=".$myBg_billet->BG_BI_URL;?>>En savoir +</a> sur le billet : <?php echo $myBg_billet->BG_BI_LIBELLE;?></div>
  <div class="famille">de la famille : <a href=famille.php?BG_FA_ID=<?php echo $myBg_billet->BG_FA_ID;?><?php echo "&URL=".$myBg_billet->BG_FA_URL;?>><?php echo $myBg_billet->BG_FA_LIBELLE;?></a></div>
</div>

<?php
} //--- AJOUT DE FIN DE DIV
?>
		</div>
</div>

<?php
include ("cote.php");
include ("bas.php");
?>