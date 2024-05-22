<?
session_start();
include ("../../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");
include ("../../include/salaries.php");
include ("../param.php");

$id = mysqli_real_escape_string($db, $_POST['id']);
$retour = array();

if($id > 0){
	$q = "SELECT d.nom, d.lien_doc, d.date, d.id_menu_base, d.verrouille FROM base_ebg3.developpement d WHERE id = $id";
	$r = msqlqi($q);
	$retour['etat'] = mysqli_num_rows($r) > 0 ? 1 : 0;
	$v = mysqli_fetch_assoc($r);

	/* Vérification des autorisations */
	if ($accesN1 == false and accesN2($id) == false)
		$retour['noAccess'] = 1;
	else
		$retour['noAccess'] = 0;
	$retour['verrouille'] = $v['verrouille'];
	/* Informations de la doc */
	
	$retour['titreDoc'] = encodeEbg($v['nom']);
	$retour['lienDoc'] = encodeEbg($v['lien_doc']);
	$retour['dateMajDoc'] = date('d/m/Y', $v['date']);
	$idMenuBase = $v['id_menu_base'];

	/*récupération des informations pour les blocs*/
	$query="SELECT id_bloc, contenu, titre FROM base_ebg3.developpement_blocs WHERE id_dev =$id ORDER BY ordre";
	$result = msqlqi($query,0);  //  0 =>  lire , 1=> insert into id unique, 2 => insert ou update nb de lignes affectées par l'operation
	//$nb_reponse = mysqli_num_rows($result);

	$retour['codeBlocsDoc'] ="";

	while ($val = mysqli_fetch_assoc($result)){

		$id_bloc=$val["id_bloc"];
		$titreBloc=$val["titre"];
		$contenuBloc=$val["contenu"];
		$codeBlocsDoc .='<li class="liTrumbo"><div class="blocDoc" data-id="'.$id_bloc.'"><span class="handle"><i class="material-icons">drag_handle</i></span><input type="text" placeholder="Insérer un titre" value="'.$titreBloc.'"><textarea placeholder="Saisissez votre contenu" class="trumbo">'.$contenuBloc.'</textarea></div></li>';
		$retour['codeBlocsDoc'] = encodeEbg($codeBlocsDoc);


	}

	/* Mots-clés */
	$qTags = "SELECT dt.*, dtl.id_doc FROM base_ebg3.developpement_tags dt LEFT JOIN base_ebg3.developpement_tags_liaison dtl ON dt.id_tag = dtl.id_tag AND dtl.id_doc = $id ORDER BY tag ASC";
	$rTags = msqlqi($qTags);
	while($vTags = mysqli_fetch_assoc($rTags)){
		$tagSelected = ($vTags['id_doc'] > 0) ? 'selected' : '';
		$tagsDoc .= '<option value="' . $vTags['id_tag'] . '" ' . $tagSelected . '>' . encodeEbg($vTags['tag']) . '</option>';
	}
	$retour['tagsDoc'] = $tagsDoc;

	/*Récupère auteurs */
	$auteurs = '';
	$auteurSelected = '';
	$qAuteurs = "SELECT id_auteur from base_ebg3.developpement_auteurs_liaison where id_doc =$id ORDER BY id_auteur ASC";
	$rAuteurs = msqlqi($qAuteurs);
	$auteursArray = array();
	while($vAuteurs = mysqli_fetch_assoc($rAuteurs)){
		array_push($auteursArray, $vAuteurs['id_auteur']);
	}
	foreach ($listeSalaries as $key => $infoSalarie) {
		if (in_array($key, $auteursArray)) {
			$auteurSelected ='selected';
		}
		else{
			$auteurSelected ='';
		}
		if ($infoSalarie['absent'] == 0) {
			$auteurs .= '<option value="' . $key . '" ' . $auteurSelected . '>' . encodeEbg($infoSalarie['prenom']) . ' ' .  encodeEbg($infoSalarie['nom'])  .' </option>';
		}
	}
	$retour['auteurs'] = $auteurs;


	/* Menu lié à cette documentation */
	$qMenuBase = "SELECT mb.id, mb.titre FROM base_ebg3.menu_base mb ORDER BY mb.titre ASC";
	$rMenuBase = msqlqi($qMenuBase);
	$menuBaseDoc = '<option value="0">Aucun</option>';
	while($vMenuBase = mysqli_fetch_assoc($rMenuBase)){
		$menuBaseSelected = ($idMenuBase == $vMenuBase['id']) ? 'selected' : '';
		$menuBaseDoc .= '<option value="' . $vMenuBase['id'] . '" ' . $menuBaseSelected . '>' . encodeEbg($vMenuBase['titre']) . '</option>';
	}
	$retour['menuBaseDoc'] = $menuBaseDoc;
}

/* S'il n'y a pas d'ID de doc, on charge seulement les listes des tags, les auteurs et des menus */
else{
	$qTags = "SELECT * FROM base_ebg3.developpement_tags ORDER BY tag ASC";
	$rTags = msqlqi($qTags);
	$tagsDoc = '';
	while($vTags = mysqli_fetch_assoc($rTags)){
		$tagsDoc .= '<option value="' . $vTags['id_tag'] . '">' . encodeEbg($vTags['tag']) . '</option>';
	}

	foreach ($listeSalaries as $key => $infoSalarie) {
		$absent = $infoSalarie['absent'];
		if ($key == $_SERVER['REMOTE_USER']) {
			$auteurs .= '<option value="' . $key . '"selected>' . encodeEbg($infoSalarie['prenom']) . ' ' .  encodeEbg($infoSalarie['nom'])  .' </option>';
		}
		elseif ($absent == 0) {
			$auteurs .= '<option value="' . $key. '"> ' . encodeEbg($infoSalarie['prenom']) . ' ' .  encodeEbg($infoSalarie['nom'])  .' </option>';
		}

	}

	$qMenuBase = "SELECT mb.id, mb.titre FROM base_ebg3.menu_base mb ORDER BY mb.titre ASC";
	$rMenuBase = msqlqi($qMenuBase);
	$menuBaseDoc = '<option value="0">Aucun</option>';
	while($vMenuBase = mysqli_fetch_assoc($rMenuBase)){
		$menuBaseDoc .= '<option value="' . $vMenuBase['id'] . '">' . encodeEbg($vMenuBase['titre']) . '</option>';
	}
	$retour['menuBaseDoc'] = $menuBaseDoc;

	$retour['etat'] = 1;
	$retour['titreDoc'] = '';
	$retour['auteursDoc'] = '';
	$retour['lienDoc'] = '';
	$retour['dateMajDoc'] = '';
	$retour['menuBaseDoc'] = '';
	$retour['tagsDoc'] = $tagsDoc;
	$retour['codeBlocsDoc'] = '';
	$retour['auteurs'] = $auteurs;
	$retour['user'] = $_SERVER['REMOTE_USER'];
}

echo json_encode($retour);
@mysqli_close($db);
?>