<?php
//--- ETAPE 1 : EXPLICATIONS : page billet.php LOCAL
//--- sur le front-office
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_billet.php - lister_un_billet_avec_famille_nom($BG_BI_ID) -  le billet demandé : actif et avec famille
LIB/config_db.php - formatDateAffiche($myBg_billet->BG_BI_DATE) - afficher la date en français
*/
include ("haut.php");
//print_r($billets_famille);
//--- PRECEDENT SUIVANT FAMILLE DEBUT ---
// TO DO : mutualiser la fonction commune sortant de la présentation : la preuve, problème chez FREE : ajout sortant()
$total=count($billets_famille);
for ($i=0; $i<count($billets_famille); $i++){

	if ($billets_famille[$i]['bg_bi_id']==$myBg_billet->BG_BI_ID)
			{

			$a=$i-1;// avant
			isset($billets_famille[$a]['bg_bi_id'])?$avant=$billets_famille[$a]['bg_bi_id'].'|'.$billets_famille[$a]['bg_bi_libelle'].'|'.$billets_famille[$a]['bg_bi_url']:$avant="";

				if($avant!="")
				{
				$lien=explode('|',$avant);
				$avant= "<< <a href='billet.php?BG_BI_ID=".$lien[0]."&URL=".$lien[2]."'>".sortant($lien[1])."</a>";
				}
				else
				{
				}

			$b=$i+1;// apres
			isset($billets_famille[$b]['bg_bi_id'])?$apres=$billets_famille[$b]['bg_bi_id'].'|'.$billets_famille[$b]['bg_bi_libelle'].'|'.$billets_famille[$b]['bg_bi_url']:$apres="";

				if($apres!="")
				{
				$lien=explode('|',$apres);
				$apres= "<a href='billet.php?BG_BI_ID=".$lien[0]."&URL=".$lien[2]."'>".sortant($lien[1])."</a> >> ";
				}
				else
				{
				}

			}
	else
			{
			//echo $billets_famille[$i]['bg_bi_id'];
			}

}
//--- PRECEDENT SUIVANT FAMILLE FIN ---
?>

<div class="precedent_suivant">
	<div class="precedent"><?php echo $avant; ?></div><div class="suivant"><?php echo $apres; ?></div>
</div>

<hr />

<div class="les_billets">

	<div class="billet">
	  <div class="date"><?php echo formatDateAffiche($myBg_billet->BG_BI_DATE);?></div>
	  <div class="titre"><?php echo $myBg_billet->BG_BI_TITRE;?></div>
	  <div class="stitre"><?php echo $myBg_billet->BG_BI_STITRE;?></div>
	  <div class="texte_tronque"><?php echo afficher_image("billet",$myBg_billet->BG_BI_ID,$style)."".$myBg_billet->BG_BI_TEXTE;?><hr /></div>
	  <div class="libelle">billet : <?php echo $myBg_billet->BG_BI_LIBELLE;?></div>
	  <div class="famille">de la famille : <a href=famille.php?BG_FA_ID=<?php echo $myBg_billet->BG_FA_ID;?><?php echo "&URL=".$myBg_billet->BG_FA_URL;?>><?php echo $myBg_billet->BG_FA_LIBELLE;?></a></div>
	</div>

</div>
<?php

include ("cote.php");
include ("bas.php");
?>