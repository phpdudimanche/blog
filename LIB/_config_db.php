<?php
$version="01-02";//consulter les notes sur la version : LIB/version_xx-xx.txt

$environnement=0;//0 local // 1 prod free
if ($environnement==0)
{
$host='localhost';
$user='root';
$pass='root';
$db_name="bg";  // laisser les doubles quotes ! df
$repertoire_ou_pas="/site/";
$chaine_root = 'D:/www/site/';// TODO portabilite  $_SERVER['DOCUMENT_ROOT']+$_SERVER['SCRIPT_NAME']-REP/FICHIER
$echappement="0";//0 NON 1 OUI : concerne les magicquotes, ajouts d'antislash devant apostrophes
}
else
{
$host='';
$user='';
$pass='';
$db_name="";  // laisser les doubles quotes ! df
$path=$_SERVER['DOCUMENT_ROOT']."/dev/";//
$chaine_root = $path;
$repertoire_ou_pas="/dev/";
$echappement="1";//0 NON 1 OUI : concerne les magicquotes, ajouts d'antislash devant apostrophes
}


$dsn="mysql://$user:$pass@$host/$db_name"; // DB et MDB
$accueil=3;//nombre de billets a afficher en accueil

// charte graphique : differents repertoires pour differents design
$style_repertoire="STYLE";// changer ici le repertoire pour changer de style
$style_front=$style_repertoire."/front.css";//
$style_back="../".$style_repertoire."/back.css";
$js_back="../JS/back.js";

//--- CONTENU - ACCUEIL
$balise_title="Blog de Julien Gontier";
$edito_titre="Autour du développement...";
$edito_texte="des questions qu'on se pose en pratiquant.";
//--- pied de page du front-office pour les CGV...
$pied="Site de blog version légère : 350 KO : version ".$version. " : <a href=\"mailto:solution.ecommerce@free.fr?subject=version du blog&body=Je souhaite obtenir la version du blog\">me contacter pour obtenir la version</a>";

	 $base = new PDO("mysql:host=localhost;dbname=bg;port=3306;","root", "");


//--- FONCTIONS GENERALES

function formatDateAffiche($chaine) {//--- PRESENTER DATE FR
 if ($chaine!='') {
	if ($chaine=='0000-00-00') {
		$new_date='';
	}
	else {
		$date=explode('-',$chaine);
		$new_date=substr(trim($date[2]),0,2).'/'.trim($date[1]).'/'.trim($date[0]);
	}
	return $new_date;
 }
 else {
	return $chaine;
 }
}

function formatDateStocke($chaine) {//--- STOCKER DATE US

  if($chaine!=''){
 	$date=explode('/',$chaine);
 	$new_date=$date[2].'-'.$date[1].'-'.$date[0];
 	return $new_date;
  }
  else{return $chaine;}

}

function parite($number) {
   return ($number % 2 == 0)
      ? "texte_droite"
      : "texte_gauche";
}

//--- FONCTIONS DE MISE EN PAGE

//--- sort l'image avec son style
function afficher_image($type,$identifiant,$style)// type:famille|billet id:cle style:droite|gauche
{
	if(file_exists("IMAGES/".$type."-".$identifiant."-S.jpg")==FALSE){
	return FALSE;//laisser sortir le lien sans image : toujours utile au referencement
	}else{
		$dimension=GetImageSize("IMAGES/".$type."-".$identifiant."-S.jpg");//geer la possibilite de plusieurs formats
		$width=$dimension[0];
		$height=$dimension[1];
		$image="<img src=\"IMAGES/".$type."-".$identifiant."-S.jpg\" border=\"0\" class=\"".$style."\" height=\"".$height."px\"  width=\"".$width."px\" />";
		echo $image;
	}
}

?>