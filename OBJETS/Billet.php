<?php
//require_once __DIR__ ."/../LIB/Database.php";
class Billet {//--- ETAPE 1 : CLASSE

var $BG_BI_ID;//int(10) unsigned
var $BG_BI_LIBELLE;//varchar(45)
var $BG_BI_TITRE;//text
var $BG_BI_STITRE;//varchar(255)
var $BG_BI_TEXTE;//longtext
var $BG_BI_URL;//text
var $BG_BI_DATE;//date
var $BG_BI_STATUT;//enum('attente','actif','retrait')
var $BG_FA_ID;//ajout manuel FA_ID
var $BG_FA_LIBELLE;//ajout manuel FA_LIBELLE
var $BG_FA_URL;

function Billet(){//--- ETAPE 2 : DECLARATION
}

//--- ETAPE 4 : ATTRIBUTION
function executeQuery($strQuery){
$myArrayBg_billet= array();
$i = 0;

foreach ($strQuery as $key=>$row){
$myBg_billet=	new Billet();
if ( isset($row["bg_bi_id"]) )		$myBg_billet->BG_BI_ID		=$row["bg_bi_id"];
if ( isset($row["bg_bi_libelle"]) )		$myBg_billet->BG_BI_LIBELLE		=sortant($row["bg_bi_libelle"]);
if ( isset($row["bg_bi_titre"]) )		$myBg_billet->BG_BI_TITRE		=sortant($row["bg_bi_titre"]);
if ( isset($row["bg_bi_stitre"]) )		$myBg_billet->BG_BI_STITRE		=sortant($row["bg_bi_stitre"]);
if ( isset($row["bg_bi_texte"]) )		$myBg_billet->BG_BI_TEXTE		=sortant($row["bg_bi_texte"]);
if ( isset($row["bg_bi_url"]) )			$myBg_billet->BG_BI_URL		=$row["bg_bi_url"];
if ( isset($row["bg_bi_date"]) )		$myBg_billet->BG_BI_DATE		=$row["bg_bi_date"];
if ( isset($row["bg_bi_statut"]) )		$myBg_billet->BG_BI_STATUT		=$row["bg_bi_statut"];
if ( isset($row["bg_fa_id"]) )		$myBg_billet->BG_FA_ID		=$row["bg_fa_id"];
if ( isset($row["bg_fa_libelle"]) )		$myBg_billet->BG_FA_LIBELLE		=sortant($row["bg_fa_libelle"]);
if ( isset($row["bg_fa_url"]) )		$myBg_billet->BG_FA_URL		=$row["bg_fa_url"];
$myArrayBg_billet[$i++]			= 	$myBg_billet;
}
return $myArrayBg_billet;

}

//-- initialiser
function retrouver_un($bg_bi_id){
global $base;
$query = $base->prepare("
SELECT bg_billet.bg_bi_id, bg_billet.bg_bi_libelle, bg_billet.bg_bi_date, bg_billet.bg_bi_titre, bg_billet.bg_bi_stitre, bg_billet.bg_bi_texte, bg_billet.bg_bi_url, bg_billet.bg_bi_statut, bg_famille.bg_fa_libelle, bg_famille.bg_fa_id, bg_famille.bg_fa_url
FROM bg_billet
INNER JOIN bg_billet_famille ON bg_billet.bg_bi_id=".$bg_bi_id." AND bg_billet.bg_bi_id=bg_billet_famille.bg_bi_id
INNER JOIN bg_famille ON bg_billet_famille.bg_fa_id=bg_famille.bg_fa_id");
$query->execute(); 	
$row = $query->fetchAll(PDO::FETCH_ASSOC);// PDO::FETCH_ASSOC - PDO::FETCH_CLASS, 'Billet'
//return $row; // ajout de [0]
$this->BG_BI_ID      =$row[0]["bg_bi_id"];
$this->BG_BI_LIBELLE      =sortant($row[0]["bg_bi_libelle"]);
$this->BG_BI_TITRE      =sortant($row[0]["bg_bi_titre"]);
$this->BG_BI_STITRE      =sortant($row[0]["bg_bi_stitre"]);
$this->BG_BI_TEXTE      =sortant($row[0]["bg_bi_texte"]);
$this->BG_BI_URL      =$row[0]["bg_bi_url"];
$this->BG_BI_DATE      =$row[0]["bg_bi_date"];
$this->BG_BI_STATUT      =$row[0]["bg_bi_statut"];
$this->BG_FA_ID      =$row[0]["bg_fa_id"];
$this->BG_FA_LIBELLE      =sortant($row[0]["bg_fa_libelle"]);
$this->BG_FA_URL      =$row[0]["bg_fa_url"];
//return $this->executeQuery($row);
}

function lister_billet_avec_famille_nom_actif($debut,$nbre){
global $base;
$query = $base->prepare("SELECT bg_billet.bg_bi_id, bg_billet.bg_bi_libelle, bg_billet.bg_bi_titre, bg_billet.bg_bi_stitre, bg_billet.bg_bi_texte, bg_billet.bg_bi_url, bg_billet.bg_bi_date, bg_billet.bg_bi_statut, bg_famille.bg_fa_libelle, bg_famille.bg_fa_url, bg_famille.bg_fa_id FROM bg_billet INNER JOIN bg_billet_famille ON bg_billet.bg_bi_id=bg_billet_famille.bg_bi_id INNER JOIN bg_famille ON bg_billet_famille.bg_fa_id=bg_famille.bg_fa_id WHERE bg_billet.bg_bi_statut='actif' ORDER BY bg_billet.bg_bi_date DESC
 LIMIT ".$debut.",".$nbre." ");	
$query->execute(); 	
//$result = $query->fetchAll(PDO::FETCH_CLASS, 'Billet');// PDO::FETCH_ASSOC - PDO::FETCH_CLASS, 'Billet' -> mais ne reindexe pas sur la base des majuscules
//return $result;	
$result = $query->fetchAll(PDO::FETCH_ASSOC);
return $this->executeQuery($result);
}

function tableau_billet_actif_famille($id_famille){// liste les titres de billets pour la page billet.php : retourner un tableau
global $base;
$query = $base->prepare('SELECT bg_billet.bg_bi_id, bg_billet.bg_bi_libelle, bg_billet.bg_bi_url, bg_billet.bg_bi_date, bg_billet.bg_bi_statut
FROM bg_billet
INNER JOIN bg_billet_famille ON bg_billet.bg_bi_id=bg_billet_famille.bg_bi_id
INNER JOIN bg_famille ON bg_billet_famille.bg_fa_id=bg_famille.bg_fa_id
WHERE bg_billet.bg_bi_statut="actif" AND bg_famille.bg_fa_id='.$id_famille.'
ORDER BY bg_billet.bg_bi_date DESC ');
$query->execute(); 	
$result = $query->fetchAll(PDO::FETCH_ASSOC);// PDO::FETCH_ASSOC - PDO::FETCH_CLASS, 'Billet'
return $result;	
}

function lister_billet_actif_famille($id_famille){// liste les billets de la page : famille.php
global $base;
$query = $base->prepare('SELECT bg_billet.bg_bi_id, bg_billet.bg_bi_libelle, bg_billet.bg_bi_url, bg_billet.bg_bi_date, bg_billet.bg_bi_statut, bg_famille.bg_fa_libelle, bg_famille.bg_fa_id, bg_famille.bg_fa_url, bg_billet.bg_bi_titre, bg_billet.bg_bi_stitre, bg_billet.bg_bi_texte
FROM bg_billet
INNER JOIN bg_billet_famille ON bg_billet.bg_bi_id=bg_billet_famille.bg_bi_id
INNER JOIN bg_famille ON bg_billet_famille.bg_fa_id=bg_famille.bg_fa_id
WHERE bg_billet.bg_bi_statut="actif" AND bg_famille.bg_fa_id='.$id_famille.'
ORDER BY bg_billet.bg_bi_date DESC ');
$query->execute(); 
//$result = $query->fetchAll(PDO::FETCH_CLASS, 'Billet');// PDO::FETCH_ASSOC - PDO::FETCH_CLASS, 'Billet'
$result = $query->fetchAll(PDO::FETCH_ASSOC);
return $this->executeQuery($result);
}

//---------- ADMIN

function lister_billet_sans_famille(){
global $base;
$query = $base->prepare('SELECT bg_billet.bg_bi_id, bg_billet.bg_bi_libelle FROM bg_billet LEFT JOIN bg_billet_famille ON bg_billet.bg_bi_id=bg_billet_famille.bg_bi_id WHERE bg_billet_famille.bg_bi_id IS NULL');
$query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);
return $this->executeQuery($result);
}

function compter_tout(){
global $base;
$query = $base->prepare("SELECT COUNT(bg_bi_id) FROM bg_billet");
$query->execute(); 	
$result = $query->fetchAll(PDO::FETCH_NUM);
return $result[0];
}

function lister_billet_avec_famille_nom(){
global $base;
$query = $base->prepare("
SELECT bg_billet.bg_bi_id, bg_billet.bg_bi_libelle, bg_billet.bg_bi_date, bg_billet.bg_bi_statut, bg_famille.bg_fa_libelle, bg_famille.bg_fa_id
FROM bg_billet
INNER JOIN bg_billet_famille ON bg_billet.bg_bi_id=bg_billet_famille.bg_bi_id
INNER JOIN bg_famille ON bg_billet_famille.bg_fa_id=bg_famille.bg_fa_id");
$query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);
return $this->executeQuery($result);
}

function lister_tout_alpha(){

global $base;
$query = $base->prepare("SELECT * FROM bg_billet ORDER BY bg_bi_libelle ASC");// PREPARATION INUTILE
$query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);
return $this->executeQuery($result);
}

function le_nouvel_id(){

global $base;
$query = $base->prepare("SELECT bg_bi_id FROM bg_billet ORDER BY bg_bi_id DESC LIMIT 0,1");// PREPARATION INUTILE
$query->execute(); 
$data = $query->fetch(PDO::FETCH_ASSOC);// 1 resultat
return $data["bg_bi_id"]+1;// [0]["bg_bi_id"]=fetchAll
}

function creer(){

	try{
global $base;// ne mettre nulle part l'autoincrement

$stmt = $base->prepare("INSERT INTO bg_billet(bg_bi_libelle,bg_bi_titre,bg_bi_stitre,bg_bi_texte,bg_bi_url,bg_bi_date,bg_bi_statut) VALUES(?, ?, ?, ?, ?, ?, ?)");// $query      
      
$stmt->bindParam(1, $this->BG_BI_LIBELLE, PDO::PARAM_STR);        
$stmt->bindParam(2, $this->BG_BI_TITRE, PDO::PARAM_STR);
$stmt->bindParam(3, $this->BG_BI_STITRE, PDO::PARAM_STR); 
$stmt->bindParam(4, $this->BG_BI_TEXTE, PDO::PARAM_STR);
$stmt->bindParam(5, $this->BG_BI_URL, PDO::PARAM_STR);
$stmt->bindParam(6, $this->BG_BI_DATE);// 
$stmt->bindParam(7, $this->BG_BI_STATUT, PDO::PARAM_STR);
            if($stmt->execute()){
                                $nombre=$stmt->rowCount();
                                    //echo "OK ".$nombre." traitement";
                                }
								else{
                                   // die('KO execution');
								   print_r($stmt->errorInfo());
								   exit();
                                }
								
	}catch(PDOException $exception){ 
	echo "Erreur: " . $exception->getMessage();
	exit();
	}
}

function modifier_un(){

global $base;
$query="UPDATE bg_billet SET bg_bi_statut=?, bg_bi_date=?, bg_bi_url=?, bg_bi_texte=?, bg_bi_stitre=?, bg_bi_titre=?, bg_bi_libelle=? WHERE bg_bi_id=?";
$stmt=$base->prepare($query);
$stmt->bindParam(1, $this->BG_BI_STATUT, PDO::PARAM_STR);
$stmt->bindParam(2, $this->BG_BI_DATE);
$stmt->bindParam(3, $this->BG_BI_URL, PDO::PARAM_STR);
$stmt->bindParam(4, $this->BG_BI_TEXTE, PDO::PARAM_STR);
$stmt->bindParam(5, $this->BG_BI_STITRE, PDO::PARAM_STR);
$stmt->bindParam(6, $this->BG_BI_TITRE, PDO::PARAM_STR);
$stmt->bindParam(7, $this->BG_BI_LIBELLE, PDO::PARAM_STR);
$stmt->bindParam(8, $this->BG_BI_ID, PDO::PARAM_INT);
$stmt->execute();	
}

function modifier_statut(){
	global $base;
	 $sql=( "UPDATE bg_billet set
bg_bi_statut='".$this->BG_BI_STATUT."'
where bg_bi_id='".$this->BG_BI_ID."'");
	 $stmt = $base->prepare($sql);
	 $stmt->execute();

}

function detruire($bg_bi_id){
	try{
	global $base;
	$query="DELETE from bg_billet WHERE bg_bi_id=:id";
	$stmt = $base->prepare($query);
	$stmt->bindParam(':id', $bg_bi_id, PDO::PARAM_INT);
	$stmt->execute(); 
	}
		catch(PDOException $exception){ //capture d'erreur
		echo "Erreur: " . $exception->getMessage();
		exit();
		}
}


function lister_billet_avec_famille_nom_precis($id_famille){
	try{

global $base;
$query = $base->prepare("SELECT bg_billet.bg_bi_id, bg_billet.bg_bi_libelle, bg_billet.bg_bi_date, bg_billet.bg_bi_statut, bg_famille.bg_fa_libelle, bg_famille.bg_fa_id FROM bg_billet INNER JOIN bg_billet_famille ON bg_billet.bg_bi_id=bg_billet_famille.bg_bi_id INNER JOIN bg_famille ON bg_billet_famille.bg_fa_id=bg_famille.bg_fa_id WHERE bg_famille.bg_fa_id='$id_famille'");// TODO bind
$query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);
return $this->executeQuery($result);
	}
		catch(PDOException $exception){ //capture d'erreur
		echo "Erreur: " . $exception->getMessage();
		exit();
		}
}

//--- affichage BO
function liste_statut ($type,$option){
if ($option==1){$cgt=" onChange=\"Statut_billet_modifie(this.form);\"";}//maj base : gst
else{$cgt=" onChange=\"Statut_billet_test(this.form);\"";}//simple test : edt (peut être en mode création)
//else{$cgt="";};
$arr 	= array('attente','actif','retrait');
		echo "<select name=\"BG_BI_STATUT\"".$cgt."><option value=\"\">STATUT BILLET</option>";//--- NOMS : CHAMP + OBJET
		for ($i=0;$i<count( $arr );$i++){
			$tmp	= $arr[$i];
				echo "<option value=\"".$tmp."\"";
				if ( $tmp == $type ) echo "selected";//-- STATUT EN COURS
				echo ">".$tmp."</option>";
			}
				echo "</select>";
		}


}//--- FIN DE CLASSE
?>