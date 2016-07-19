<?php
//--- ETAPE 1 : EXPLICATIONS : page famille.php
//--- sur le front-office
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_billet.php - lister_billet_actif_famille($BG_FA_ID) -  tous les billets actifs de la famille
OBJETS/Parser.php - TronqueHtml($myBg_billet->BG_BI_TEXTE, 255, ' ', ' [...]') - tronquer le texte
LIB/config_db.php - formatDateAffiche($myBg_billet->BG_BI_DATE) - afficher la date en français
*/

include ("haut.php");
include (__DIR__ ."/OBJETS/Parser.php");// $chaine_root.

echo  ucfirst($myBg_famille->BG_FA_LIBELLE)." : ".$myBg_famille->BG_FA_TITRE;//mettre en majuscule première lettre (tout = strtoupper) : préférer feuille de style à fonction
echo "<br />";
echo $myBg_famille->BG_FA_TEXTE;
echo "<br /><br />";
//--- à terme, mettre image à côté

$total=count($billets_famille);//echo $total;

// LISTE DES BILLETS DEBUT --- mettre en minuscule, pas parse !  TODO remettre en majuscule
echo "   <div class=\"liste\">\n";
for ($i=0; $i<$total; $i++){
$myBg_billet= $billets_famille[$i];
?>
<a href=billet.php?BG_BI_ID=<?php echo $myBg_billet->BG_BI_ID;?><?php echo "&URL=".$myBg_billet->BG_BI_URL;?>><?php echo $myBg_billet->BG_BI_TITRE;?></a>
<?php
$b=1;
$a=$i+$b;
//echo $i.' / ou '.$a.' de'.$total.'| ';
if ($a==$total)// test : si seul ou dernier
{
//$sep=" FIN ";//echo $sep;
}
else
{
$sep=" - ";
echo $sep;
}
}
echo "  </div>\n";
// LISTE DES BILLETS FIN

//--- PRESENTER BILLETS FAMILLE
echo "   <div class=\"les_billets\">\n";
for ($i=0; $i<$total; $i++){
$myBg_billet= $billets_famille[$i];

$style=parite($i);// pair ou impair : texte droite ou gauche

?>

<div class="billet">
  <div class="date"><?php echo formatDateAffiche($myBg_billet->BG_BI_DATE);?></div>
  <div class="titre"><a href=billet.php?BG_BI_ID=<?php echo $myBg_billet->BG_BI_ID;?><?php echo "&URL=".$myBg_billet->BG_BI_URL;?>><?php echo $myBg_billet->BG_BI_TITRE;?></a></div>
  <div class="stitre"><?php echo $myBg_billet->BG_BI_STITRE;?></div>
  <div class="texte_tronque">
	<a href=billet.php?BG_BI_ID=<?php echo $myBg_billet->BG_BI_ID;?><?php echo "&URL=".$myBg_billet->BG_BI_URL;?>><?php afficher_image("billet",$myBg_billet->BG_BI_ID,$style); ?></a>
  <?php echo TronqueHtml($myBg_billet->BG_BI_TEXTE, 255, ' ', ' [...]');?></div>
	<hr />
  <div class="libelle"><a href=billet.php?BG_BI_ID=<?php echo $myBg_billet->BG_BI_ID;?><?php echo "&URL=".$myBg_billet->BG_BI_URL;?>>En savoir +</a> sur le billet : <?php echo $myBg_billet->BG_BI_LIBELLE;?></div>
  <div class="famille">de la famille : <a href=famille.php?BG_FA_ID=<?php echo $myBg_billet->BG_FA_ID;?><?php echo "&URL=".$myBg_billet->BG_FA_URL;?>><?php echo $myBg_billet->BG_FA_LIBELLE;?></a></div>
</div>

<?php
}
echo "  </div>\n";

include ("cote.php");
include ("bas.php");
?>