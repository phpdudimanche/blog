<?php
class Famille {//--- ETAPE 1 : CLASSE

var $BG_FA_ID;//int(10) unsigned
var $BG_FA_LIBELLE;//varchar(20)
var $BG_FA_ORDRE;//int(10) unsigned
var $BG_FA_TITRE;//varchar(255)
var $BG_FA_TEXTE;//longtext
var $BG_FA_URL;//text
var $BG_FA_MERE_ID;//int(10) unsigned

function Famille(){//--- ETAPE 2 : DECLARATION
}

//--- ETAPE 4 : ATTRIBUTION
function executeQuery($strQuery){
$myArrayBg_famille= array();
$i = 0;
//$resultSet = getArray($strQuery);
//while ($row = $resultSet->fetchRow() ){
foreach ($strQuery as $key=>$row){
$myBg_famille=	new Famille();
if ( isset($row["bg_fa_id"]) )		$myBg_famille->BG_FA_ID		=$row["bg_fa_id"];
if ( isset($row["bg_fa_libelle"]) )		$myBg_famille->BG_FA_LIBELLE		=$row["bg_fa_libelle"];
if ( isset($row["bg_fa_ordre"]) )		$myBg_famille->BG_FA_ORDRE		=$row["bg_fa_ordre"];
if ( isset($row["bg_fa_titre"]) )		$myBg_famille->BG_FA_TITRE		=$row["bg_fa_titre"];
if ( isset($row["bg_fa_texte"]) )		$myBg_famille->BG_FA_TEXTE		=$row["bg_fa_texte"];
if ( isset($row["bg_fa_url"]) )		$myBg_famille->BG_FA_URL		=$row["bg_fa_url"];
if ( isset($row["bg_fa_mere_id"]) )		$myBg_famille->BG_FA_MERE_ID		=$row["bg_fa_mere_id"];
$myArrayBg_famille[$i++]			= 	$myBg_famille;
}
return $myArrayBg_famille;
}

//-- initialiser
function retrouver_un($bg_fa_id){
global $base;
$query = $base->prepare("SELECT * FROM bg_famille WHERE bg_fa_id=".$bg_fa_id);
$query->execute(); 	
$row = $query->fetchAll(PDO::FETCH_ASSOC);
$this->BG_FA_ID      =$row[0]["bg_fa_id"];
$this->BG_FA_LIBELLE      =sortant($row[0]["bg_fa_libelle"]);
$this->BG_FA_ORDRE      =$row[0]["bg_fa_ordre"];
$this->BG_FA_TITRE      =sortant($row[0]["bg_fa_titre"]);
$this->BG_FA_TEXTE      =sortant($row[0]["bg_fa_texte"]);
$this->BG_FA_URL      =$row[0]["bg_fa_url"];
$this->BG_FA_MERE_ID      =$row[0]["bg_fa_mere_id"];
}

function compter_billets_actifs_famille($mere){
global $base;
$query = $base->prepare('SELECT COUNT(bg_billet.bg_bi_id)FROM bg_billet_famille
INNER JOIN bg_billet ON bg_billet_famille.bg_bi_id=bg_billet.bg_bi_id
WHERE bg_billet.bg_bi_statut="actif" AND bg_billet_famille.bg_fa_id='.$mere.' ');
$query->execute(); 	
$result = $query->fetchAll(PDO::FETCH_NUM);
return $result[0];
}

/**
 *@TODO ne pas melanger requete et affichage
 */
function afficher_arbo_fo($mere,$famille){// celle utilisÈe en FO cÙtÈ.php
global $base;
$query = $base->prepare('SELECT DISTINCT bg_famille.bg_fa_id, bg_famille.bg_fa_libelle,bg_famille.bg_fa_url, bg_famille.bg_fa_mere_id, bg_famille.bg_fa_ordre
FROM bg_famille
INNER JOIN bg_billet_famille ON bg_billet_famille.bg_fa_id=bg_famille.bg_fa_id
INNER JOIN bg_billet ON bg_billet.bg_bi_id=bg_billet_famille.bg_bi_id
WHERE bg_billet.bg_bi_statut="actif"
AND bg_famille.bg_fa_mere_id='.$mere.' ORDER BY bg_famille.bg_fa_ordre ASC ');
$query->execute(); 	
$result = $query->fetchAll(PDO::FETCH_ASSOC);// PDO::FETCH_ASSOC - PDO::FETCH_CLASS, 'Billet'
//return $result;	

//-------------------------------------------------------------------- DISPLAY debut
	echo "<ul>\n";//affiche mÍme si pas de rÈsultat

foreach ($result as $key=>$data){// $i=-1; [$i++]
//print_r($data);
		echo '<li><a href="famille.php?&BG_FA_ID='.$data['bg_fa_id'].'&URL='.$data['bg_fa_url'];
if ($data['bg_fa_id']==$famille)
{
$class="on";
}
else
{
$class="of";
}
		echo '" class="'.$class.'">';
		echo $data['bg_fa_libelle'];
		echo '</a>';
//echo " (".$this->compter_billets_actifs_famille($data['bg_fa_id']).")";
$tab=$this->compter_billets_actifs_famille($data['bg_fa_id']);
echo  " (".$tab[0].")";
	$this->afficher_arbo_fo($data['bg_fa_id'],$famille);
		echo "</li>\n";
}

	echo "</ul>\n";//affiche mÍme si pas de rÈsultat
//-------------------------------------------------------------------- DISPLAY fin	
	
}

//---------------------------------- ADMIN
//--- compter tout sans critËre
function compter_tout(){
global $base;
$query = $base->prepare('SELECT COUNT(bg_fa_id) FROM bg_famille');
$query->execute(); 	
$result = $query->fetchAll(PDO::FETCH_NUM);
return $result[0];
}

function lister_tout_alpha(){
global $base;
$query = $base->prepare("SELECT * FROM bg_famille ORDER BY bg_fa_libelle ASC");
$query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);
return $this->executeQuery($result);
}

function afficher_arbo($bg_fa_mere_id=0){
	echo '<ul>';
global $base;
$query = $base->prepare('
SELECT bg_fa_id, bg_fa_libelle, bg_fa_mere_id
, (SELECT COUNT(*) FROM `bg_billet_famille` bf WHERE bf.bg_fa_id=bg.bg_fa_id)as nombre
FROM bg_famille bg
WHERE bg_fa_mere_id='.$bg_fa_mere_id.'
ORDER by bg_fa_ordre');
$query->execute(); 	
$result = $query->fetchAll(PDO::FETCH_ASSOC);		

		foreach ($result as $key=>$data){
		echo '<li a href=><a href=Bg_famille_edt.php?edt=mdf&BG_FA_ID='.$data['bg_fa_id'].'>'.$data['bg_fa_libelle'].'</a>';
		echo ' - <a href=Bg_famille_edt.php?edt=fa&BG_FA_MERE_ID='.$data['bg_fa_mere_id'].'>ajouter famille</a> - <a href=Bg_famille_edt.php?edt=sousfa&BG_FA_ID='.$data['bg_fa_id'].'>ajouter sous famille</a> - <a href=Bg_famille_edt.php?edt=ordre&BG_FA_MERE_ID='.$data['bg_fa_mere_id'].'>changer ordre</a> - ';

if ($data['nombre']==0) {
echo '<a href=Bg_billet_edt.php?edt=cre&BG_FA_ID='.$data['bg_fa_id'].'>cr√©er un billet</a>';
}
else if($data['nombre']==1){
echo '<a href=Bg_billet_gst.php?BG_FA_ID='.$data['bg_fa_id'].'>voir le billet</a> - <a href=Bg_billet_edt.php?edt=cre&BG_FA_ID='.$data['bg_fa_id'].'>cr√©er un autre billet</a>';
}
else {
	echo '<a href=Bg_billet_gst.php?BG_FA_ID='.$data['bg_fa_id'].'>voir les billets</a> - <a href=Bg_billet_edt.php?edt=cre&BG_FA_ID='.$data['bg_fa_id'].'>cr√©er un autre billet</a>';// dÈtecter (original)
}

		$this->afficher_arbo($data['bg_fa_id']);
		echo '</li>';
	}
	echo '</ul>';
}

function lister_arbo($bg_fa_mere_id){
global $base;
$result=array();//--- WARNING
$query = $base->prepare('SELECT bg_fa_id, bg_fa_libelle, bg_fa_mere_id FROM bg_famille WHERE bg_fa_mere_id='.$bg_fa_mere_id.' ORDER by bg_fa_ordre');
$query->execute(); 
$result2 = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($result2 as $key=>$data){// sinon pb avec result et affichage bo liste deroulante famille  WARNING

$arbo=$this->lister_arbo($data['bg_fa_id']);// dÈclarer la variable et le faire avant : anticiper
$donnees=array('BG_FA_ID'=>$data['bg_fa_id'],'BG_FA_LIBELLE'=>$data['bg_fa_libelle']);
$result[] = array('BG_FA_ID'=>$data['bg_fa_id'],'BG_FA_LIBELLE'=>$data['bg_fa_libelle'],'SOUS_FAMILLE'=> $arbo);
	}
return $result;
}

//--- que presentation BO
function select_arbo ($arborescence,$sep,$famille){
$total = count($arborescence);//--- A CHAQUE NIVEAU DE TABLEAU
$z=0;//--- AJOUT : FAMILLE_EN_COURS ‡ sÈlectionner /
while($z < $total)
{

if ($famille==$arborescence[$z]['BG_FA_ID']){$choix=" selected=\"selected\"";}else{$choix="";}

	echo "<option value=\"".$arborescence[$z]['BG_FA_ID']."\"".$choix.">";
echo $sep." ".$arborescence[$z]['BG_FA_LIBELLE']."";//.$z." nbre : ".$arborescence[$z]['BG_FA_ID']." - " / <br>
	echo "</option>\n";
if ($arborescence[$z]['SOUS_FAMILLE']!=NULL){
$ajout=" - ";
$sep=$sep.$ajout;
//echo "-- SUITE<br>";
$this->select_arbo ($arborescence[$z]['SOUS_FAMILLE'],$sep,$famille);
}else{}
$z++;
}
// http://php.developpez.com/sources/?page=divers#genplansite
}

function choisir_famille ($arborescence,$sep,$famille,$option){//--- GESTION LISTING BILLET_GST
if ($option==1){$cgt=" onChange=\"this.form.submit();\"";}else{$cgt="";};//--- FORM
	echo "\n<select name=\"BG_FA_ID\"".$cgt.">\n";
	echo "<option value=\"\">FAMILLE</option>\n";
$this->select_arbo ($arborescence,$sep,$famille);
	echo "</select>\n";
}

function creer(){

global $base;// ne mettre nulle part l'autoincrement
$query = "INSERT INTO bg_famille(bg_fa_libelle, bg_fa_ordre, bg_fa_titre, bg_fa_texte, bg_fa_url, bg_fa_mere_id) VALUES(?, ?, ?, ?, ?, ?)";     
$stmt = $base->prepare('INSERT INTO bg_famille(bg_fa_libelle, bg_fa_ordre, bg_fa_titre, bg_fa_texte, bg_fa_url, bg_fa_mere_id) VALUES(?, ?, ?, ?, ?, ?)');// $query      
$stmt->bindParam(1, $this->BG_FA_LIBELLE, PDO::PARAM_STR);        
$stmt->bindParam(2, $this->BG_FA_ORDRE, PDO::PARAM_INT);        
$stmt->bindParam(3, $this->BG_FA_TITRE, PDO::PARAM_STR);
$stmt->bindParam(4, $this->BG_FA_TEXTE, PDO::PARAM_STR); 
$stmt->bindParam(5, $this->BG_FA_URL, PDO::PARAM_STR);
$stmt->bindParam(6, $this->BG_FA_MERE_ID, PDO::PARAM_INT); 
            if($stmt->execute()){
                                $nombre=$stmt->rowCount();
                                   
                                }else{
                                    die('KO execution');
                                }
}

function detruire($bg_fa_id){
try{
global $base;
$query="DELETE from bg_famille WHERE bg_fa_id=:id";
$stmt = $base->prepare($query);
$stmt->bindParam(':id', $bg_fa_id, PDO::PARAM_INT);
$stmt->execute(); 

}
catch(PDOException $exception){ //capture d'erreur
echo "Erreur: " . $exception->getMessage();
exit();
}
}

function modifier_un(){
	try{
global $base;
$query="UPDATE bg_famille set
bg_fa_mere_id=:bg_fa_mere_id,
bg_fa_url=:bg_fa_url,
bg_fa_texte=:bg_fa_texte,
bg_fa_titre=:bg_fa_titre,
bg_fa_ordre=:bg_fa_ordre,
bg_fa_libelle=:bg_fa_libelle
where bg_fa_id=:bg_fa_id";
$stmt = $base->prepare($query);
$stmt->bindParam(':bg_fa_libelle', $this->BG_FA_LIBELLE, PDO::PARAM_STR);        
$stmt->bindParam(':bg_fa_ordre', $this->BG_FA_ORDRE, PDO::PARAM_INT);        
$stmt->bindParam(':bg_fa_titre', $this->BG_FA_TITRE, PDO::PARAM_STR);
$stmt->bindParam(':bg_fa_texte', $this->BG_FA_TEXTE, PDO::PARAM_STR); 
$stmt->bindParam(':bg_fa_url', $this->BG_FA_URL, PDO::PARAM_STR);
$stmt->bindParam(':bg_fa_mere_id', $this->BG_FA_MERE_ID, PDO::PARAM_INT); 
$stmt->bindParam(':bg_fa_id', $this->BG_FA_ID, PDO::PARAM_INT);
$stmt->execute();

	}
	catch(PDOException $exception){ 
	echo "Erreur: " . $exception->getMessage();
	exit();
	}
}

	
function lister_ordre_niveau($bg_fa_mere_id){

global $base;
$quer="SELECT bg_fa_libelle, bg_fa_id, bg_fa_ordre FROM bg_famille WHERE bg_fa_mere_id=$bg_fa_mere_id ORDER BY bg_fa_ordre ASC";
$query = $base->prepare($quer);
$query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);
return $this->executeQuery($result);
}	

function modifier_ordre($id,$ordre){
global $base;
$query="UPDATE bg_famille SET bg_fa_ordre=:ordre WHERE bg_fa_id=:id";
$stmt = $base->prepare($query);
$stmt->bindParam(':ordre', $ordre, PDO::PARAM_INT);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

}

function traiter_ordre($ordre)// rÈcupËre la liste de la grille de comparaison classÈe
{
$first=explode ("~",$ordre);// 1/0 4/1 3/2
$nbr= count($first);
$cpt=-1;// sinon n'affichait pas le 0
do
{
$cpt++;
$two=explode ("/",$first[$cpt]);
$this->modifier_ordre($two[0],$two[1]);//inclusion de fonction par $this
}
while ($cpt<$nbr-1);// fin
}
	
}//--- FIN DE CLASSE
?>