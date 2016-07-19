<?php

/**
 * @link OBJETS/Bg_billet_score.php
 * @category BO
 * @return les informations utiles au workflow de traitement des billets
 * @todo dans ADMIN/Index.php les lignes 40 et 46 utilisent les mêmes scripts : à adapter, mutualiser et mettre en fonction partagée ici
 * @version $Id$
 * @copyright 2010
 */
class Billet_score {//--- ETAPE 1 : CLASSE

	var $BG_BI_ID;
	var $BG_BI_LIBELLE;
	var $BILLET_ATTENTE;
	var $BILLET_RETRAIT;
	var $NBRE_ATTENTE;
	var $NBRE_RETRAIT;



function Billet_score(){//--- ETAPE 2 : DECLARATION
}

	//--- ETAPE 4 : ATTRIBUTION
function executeQuery($strQuery){
	$myArrayBg_billet_score= array();
	$i = 0;

foreach ($strQuery as $key=>$row){
	$myBg_billet_score=	new Billet_score();// assigner objet
if ( isset($row["bg_bi_id"]) )			$myBg_billet_score->BG_BI_ID			=$row["bg_bi_id"];
if ( isset($row["bg_bi_libelle"]) )		$myBg_billet_score->BG_BI_LIBELLE		=$row["bg_bi_libelle"];
if ( isset($row["billet_attente"]) )	$myBg_billet_score->BILLET_ATTENTE		=$row["billet_attente"];
if ( isset($row["billet_retrait"]) )	$myBg_billet_score->BILLET_RETRAIT		=$row["billet_retrait"];
if ( isset($row["nbre_attente"]) )		$myBg_billet_score->NBRE_ATTENTE		=$row["nbre_attente"];
if ( isset($row["nbre_retrait"]) )		$myBg_billet_score->NBRE_RETRAIT		=$row["nbre_retrait"];
	$myArrayBg_billet_score[$i++]			= 	$myBg_billet_score;
}
	return $myArrayBg_billet_score;
}

	//--- les billets en attente ou retirÃ©s : mettre dans autre classe
function lister_ordonner_compter_billets_sas(){
global $base;
$query = $base->prepare('
SELECT bg_bi_id
,if (bg.bg_bi_statut="retrait", bg.bg_bi_libelle,NULL)as billet_retrait
,if (bg.bg_bi_statut="attente", bg.bg_bi_libelle,NULL)as billet_attente
,(SELECT COUNT(*) FROM bg_billet bg WHERE  bg.bg_bi_statut="attente")as nbre_attente
,(SELECT COUNT(*) FROM bg_billet bg WHERE  bg.bg_bi_statut="retrait")as nbre_retrait
FROM bg_billet bg WHERE  bg.bg_bi_statut="attente" OR bg.bg_bi_statut="retrait"
ORDER BY bg.bg_bi_statut ASC, bg.bg_bi_date ASC ');
$query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);// PDO::FETCH_ASSOC - PDO::FETCH_CLASS, 'Billet'
return $this->executeQuery($result);	


}

}
?>