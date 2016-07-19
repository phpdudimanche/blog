function tjs_haut(l) {
	var indice=l.selectedIndex
	if (indice<0) {
		alert("Aucune ligne n'est sélectionnée");
	}
	if (indice>0) {
		tjs_swap(l,indice,indice-1);
	}
}

function tjs_bas(l) {
	var indice=l.selectedIndex
	if (indice<0) {
		alert("Aucune ligne n'est sélectionnée");
	}
	if (indice<l.options.length-1) {
		tjs_swap(l,indice,indice+1);
	}
}

function tjs_swap(l,i,j) {
	var valeur=l.options[i].value;
	var texte=l.options[i].text;
	l.options[i].value=l.options[j].value;
	l.options[i].text=l.options[j].text;
	l.options[j].value=valeur;
	l.options[j].text =texte;
	l.selectedIndex=j
	tjs_ordre(l.form);
}

function tjs_ordre(f) {
	var l=f.liste;
	var ordre="";
		for(var i=0;i<l.options.length;i++) {
		if (i>0) {ordre+="~";}
		ordre+=l.options[i].value;
		ordre+="/";
		ordre+=[i];
	}
	f.ordre.value=ordre;
}

function showOnglet(id,total,numero){
	 for (var i = 1; i <= total; i++) {
		var nom = id+i;
		if(nom == id+numero){
			document.getElementById(nom).style.display="";
		}else{
			document.getElementById(nom).style.display="none";
		}
	 }
}

function Statut_billet_modifie(formulaire){/* pour gst  */
if (formulaire.BG_BI_STATUT.value=="") {alert("Statut non choisi.");}
else{
formulaire.action ='Bg_billet_act.php?act=statut';
formulaire.submit();}
}

function Statut_billet_test(formulaire){/* pour edt  */
if (formulaire.BG_BI_STATUT.value=="") {alert("Statut non choisi.");}
else{}
}

function ValiderBillet(formulaire) {
if (formulaire.BG_FA_ID.value=="") {alert("Famille non choisie.");}
else if (formulaire.BG_BI_STATUT.value=="") {alert("Statut non choisi.");}
else {
formulaire.submit();
}
}