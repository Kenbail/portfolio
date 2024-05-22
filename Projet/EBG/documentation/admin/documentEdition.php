<?
session_start();
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
include ("../../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");
include_once './simple_html_dom/simple_html_dom.php';

$id = mysqli_real_escape_string($db, $_POST['id']);
$titreDoc = mysqli_real_escape_string($db, $_POST['titreDoc']);
$codeDoc = mysqli_real_escape_string($db, $_POST['codeDoc']);
$dateMajSwitch = mysqli_real_escape_string($db, $_POST['dateMajSwitch']);
$tagsDoc = mysqli_real_escape_string($db, $_POST['tagsDoc']);
$auteurs = mysqli_real_escape_string($db, $_POST['auteurs']);
$menuBaseDoc = mysqli_real_escape_string($db, $_POST['menuBaseDoc']);
$codeBlocsDoc = json_decode($_POST['codeBlocsDoc'], true);
$memoSuppr = mysqli_real_escape_string($db, $_POST['memoSuppr']);
$lienDoc = mysqli_real_escape_string($db, $_POST['lienDoc']);
//$codeBlocsDoc = array_map(array($db, 'real_escape_string'), $_POST['blocArray']);
$time = time();
/*vérifie si on ajoute un block*/
$testeAjout = 0;
$testeErreur = 0;

/* Création d'une nouvelle entrée si elle n'existe pas */
if($id == 0){
	$qCreation = "INSERT INTO base_ebg3.developpement () VALUES ()";
	$rCreation = msqlqi($qCreation, 1);
	if($rCreation > 0)
		$id = $rCreation;
}
$passage = 0;
/* Mise à jour */
if ($titreDoc ==""){
		echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> La mise à jour a échoué, ajouter un titre</h6>'));
		$passage = 1;
	}
if($id > 0 and $passage == 0){
	/* Traitement de la date */
	if($dateMajSwitch == 'true')
		$majDate = ", date = '" . $time . "'";

	/* Création du menu *** A REMPLACER *** */
	if($codeDoc != ''){
		$menuDocTemp = str_get_html($codeDoc);
		foreach($menuDocTemp->find('h2') as $element) {
			if (str_replace('"', '', stripslashes($element->class)) === 'header') {
				$texteMenu = $element->innertext;
				$idMenu = str_replace('"', '', stripslashes($element->parent()->id));
				$menuDoc .= '<li><a href="#' . $idMenu . '">' . $texteMenu . '</a></li>';
			}
		}
	}
	// Update des blocs //
	$nouvId = array();
	foreach ($codeBlocsDoc as $bloc) {
		if ($bloc['id'] == 0) {
			$sqlInsert = "INSERT INTO base_ebg3.developpement_blocs(titre,contenu,id_dev,ordre) VALUES ('" . addslashes($bloc['titre']) . "', '" . addslashes($bloc['contenu']) . "', '" .("$id") . "','" . $bloc['ordre'] . "') ";
			$resultInsert = msqlqi($sqlInsert,1);
			array_push($nouvId, $resultInsert);
			
		}
		else	{
			$sqlUpdate = "UPDATE base_ebg3.developpement_blocs SET titre = '" . addslashes($bloc['titre']) . "', contenu = '" . addslashes($bloc['contenu']) ."', ordre= '" . $bloc['ordre'] . "' WHERE id_bloc = '". $bloc['id'] ."'"; 
			$resultUpdate = msqlqi($sqlUpdate,2);
		if ($resultUpdate > 0) 
			 $testeAjout += 1 ;
		elseif ($resultUpdate < 0) 
			$testeErreur += 1 ;
		}
	}
	
	/*Suppression des blocs vides*/
	$memoSuppr = explode(',', $memoSuppr);
	foreach ($memoSuppr as $key => $supp) {
		$sqlSuppr = "DELETE FROM base_ebg3.developpement_blocs WHERE id_bloc ='". $memoSuppr[$key] ."' ";
		$resultSuppr = msqlqi($sqlSuppr,2);
	if ($resultSuppr > 0) 
			 $testeAjout += 1 ;
		elseif ($resultSuppr < 0) 
			$testeErreur += 1 ;

	}
	

	/* Enregistrement des informations *** Traiter le nouveau système de bloc *** */
	$qMaj = "UPDATE base_ebg3.developpement SET nom = '" . decodeEbg($titreDoc) . "', lien_doc = '" . decodeEbg($lienDoc) . "', id_menu_base = '" . $menuBaseDoc . "' $majDate WHERE id = $id";
	$rMaj = msqlqi($qMaj, 2);
	if ($rMaj > 0) {
		$testeAjout += 1;

	}
	/* Enregistrement terminé vec succès */
	if($testeErreur >= 1)
		echo json_encode(array('etat' => 0,'nouvId' => $nouvId , 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> La mise à jour a échoué</h6>'));
	elseif($testeAjout >= 1)
		echo json_encode(array('etat' => 1,'nouvId' => $nouvId , 'id' => $id,'titre' => $titreDoc,'codeBlocsDoc' => $codeBlocsDoc,'auteurs'=>$auteurs ,'message' => '<h6><i class="fas fa-check"></i> Mise à jour effectuée.</h6>', 'dateMajDoc' => date('d/m/Y', $time)));
	/* Erreur lors de l'enregistrement */
	else
		echo json_encode(array('etat' => 1,'nouvId' => $nouvId , 'id' => $id,'memoSuppr' => $memoSuppr,'codeBlocsDoc' => $codeBlocsDoc,'auteurs'=>$auteurs ,'message' => '<h6><i class="fas fa-check"></i> Rien n\'a changé .</h6>', 'dateMajDoc' => date('d/m/Y', $time)));

	/* On supprime les tags existants avant d'enregistrer la nouvelle sélection */
	$qDeleteTags = "DELETE FROM base_ebg3.developpement_tags_liaison WHERE id_doc = $id";
	$rDeleteTags = msqlqi($qDeleteTags);

	if($tagsDoc != 'null'){
		$tagsDoc = explode(',', $tagsDoc);
		foreach($tagsDoc AS $tagDoc){
			$qInsertTag = "INSERT INTO base_ebg3.developpement_tags_liaison (id_tag, id_doc) VALUES ('$tagDoc', '$id')";
			$rInsertTag = msqlqi($qInsertTag);
		}
	}
	/* On supprime les auteurs existants avant d'enregistrer la nouvelle sélection */
	$qDeleteAuteurs = "DELETE FROM base_ebg3.developpement_auteurs_liaison WHERE id_doc = $id";
	$rDeleteAuteurs = msqlqi($qDeleteAuteurs);


	if($auteurs != 'null'){
		$auteurs = explode(',', $auteurs);
		foreach($auteurs AS $auteur){
			$qInsertAuteur = "INSERT INTO base_ebg3.developpement_auteurs_liaison (id_auteur, id_doc) VALUES ('$auteur', '$id')";
			$rInsertAuteur = msqlqi($qInsertAuteur);
		}
	}
}
/* Si $id est vide c'est qu'il y a eu un problème */
elseif ($id == "") {
	echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> Document introuvable.</h6>'));
}
	

@mysqli_close($db);
?>
