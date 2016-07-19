# Blog #

Un simple blog qui correspondait strictement à mes besoins.

## Technique ##
Version remaniée d'un ancien blog en PHP4 avec PEAR DB puis MDB2, désormais transformé en PDO.

## Installation ##
Le script sql est disponible dans le dossier "LIB".  
La sécurisation des accès peut se faire par .htaccess (en connaissant le chemin root).
La configuration de la base de données et des messages d'accueil et de bas de page se fait dans "LIB/\_config\_db.php", à renommer  "LIB/config\_db.php".

## Fonctions front-office ##
 - Les billets sont affichés par ordre antéchronologique. 
 - La famille ne s'affiche que si elle contient des billets de type "actif", ce qui évite de laisser de faux espoirs.
 - Par famille, la liste de tout ses billets est affichée.
 - Dans une page billet, se trouvent des liens vers les billets prédécesseurs et successeurs.

## Fonctions back-office ##
 - Les billets ont plusieurs statuts : 'actif','attente','retrait', ce qui permet de ne pas les afficher s'ils ne sont pas prêts.
 - Des images peuvent être liées par FTP à chaque billet en suivant ce pattern [billet-{id du billet}-S.jpg].
 - Les familles peuvent être réordonnées entre elles par une interface graphique.