<?php
class Billet_famille {//--- ETAPE 1 : CLASSE

var $BG_BF_ID;//int(10) unsigned
var $BG_BI_ID;//int(10) unsigned
var $BG_FA_ID;//int(10) unsigned

function Billet_famille(){//--- ETAPE 2 : DECLARATION
}

//--- ETAPE 4 : ATTRIBUTION
function executeQuery($strQuery){
$myArrayBg_billet_famille= array();
$i = 0;
foreach ($strQuery as $key=>$row){
$myBg_billet_famille=	new Billet_famille();
if ( isset($row["bg_bf_id"]) )		$myBg_billet_famille->BG_BF_ID		=$row["bg_bf_id"];
if ( isset($row["bg_bi_id"]) )		$myBg_billet_famille->BG_BI_ID		=$row["bg_bi_id"];
if ( isset($row["bg_fa_id"]) )		$myBg_billet_famille->BG_FA_ID		=$row["bg_fa_id"];
$myArrayBg_billet_famille[$i++]			= 	$myBg_billet_famille;
}
return $myArrayBg_billet_famille;
}

//--- ETAPE 5 : CRUD C-reate
function creer(){

global $base;
$query="INSERT bg_billet_famille set bg_bi_id=:BG_BI_ID,bg_fa_id=:BG_FA_ID";
$stmt = $base->prepare($query);
$stmt->bindParam(':BG_BI_ID', $this->BG_BI_ID, PDO::PARAM_INT);
$stmt->bindParam(':BG_FA_ID', $this->BG_FA_ID, PDO::PARAM_INT);
$stmt->execute(); 
}

//--- ETAPE 7 : CRUD U-pdate
//-- modifier
function modifier_un(){
global $base;
$query="UPDATE bg_billet_famille set bg_fa_id=:bg_fa_id, bg_bi_id=:bg_bi_id where bg_bf_id=:bg_bf_id";
$stmt=$base->prepare($query);
$stmt->bindParam(':bg_fa_id', $this->BG_FA_ID, PDO::PARAM_INT);
$stmt->bindParam(':bg_bi_id', $this->BG_BI_ID, PDO::PARAM_INT);
$stmt->bindParam(':bg_bf_id', $this->BG_BF_ID, PDO::PARAM_INT);

}

function retrouver_depuis_billet($bg_bi_id){
global $base;
$query="SELECT * FROM bg_billet_famille WHERE bg_bi_id=:bg_bi_id";
$stmt=$base->prepare($query);
$stmt->bindParam(':bg_bi_id', $bg_bi_id, PDO::PARAM_INT);
$stmt->execute(); 	

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$this->BG_BF_ID =$row["bg_bf_id"];
$this->BG_BI_ID =$row["bg_bi_id"];
$this->BG_FA_ID =$row["bg_fa_id"];
}


}//--- FIN DE CLASSE
?>