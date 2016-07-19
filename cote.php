<?php
//--- ETAPE 1 : EXPLICATIONS : cote.php
//--- sur le front-office : côté de page partagé
// était initialement dans la page bas.php
//--- DETAILS FONCTIONS
/*
OBJETS/Bg_famille.php - afficher_arbo_fo(0) - arborescence en liste pour le menu famille
*/
?>
			</div>

			<div id="cote">

	<div class="menu">
<h1>Rubriques :</h1>
<?php
echo "<h3><a href=./>ACCUEIL</a></h3>";
echo $myBg_famille->afficher_arbo_fo(0,$BG_FA_ID); //--- TODO REGROUPER TOUTES LES FONCTIONS DE PRESENTATION dans une même librairie ?
//print_r($myBg_famille->afficher_arbo_fo(0,$BG_FA_ID));
?>
	</div>

		    </div>
