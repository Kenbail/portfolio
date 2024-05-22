<?
session_start();
include ("../../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");

$idTag = mysqli_real_escape_string($db, $_POST['idTag']);
$idDoc = mysqli_real_escape_string($db, $_POST['idDoc']);
$cas = mysqli_real_escape_string($db, $_POST['cas']);

if($idTag > 0){
	if($cas == 'ajout'){
		$q = "INSERT INTO base_ebg3.developpement_tags_liaison (id_tag, id_doc) VALUES ('$idTag', '$idDoc')";
		$r = msqlqi($q, 2);
		if($r > 0)
			echo json_encode(array('etat' => 1, 'message' => '<h6><i class="fas fa-check"></i> Association réussie.</h6>', 'typeNoty' => 'success'));
		else
			echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> Une erreur s\'est produite.</h6>', 'typeNoty' => 'error'));
	}
	else{
		$q = "DELETE FROM base_ebg3.developpement_tags_liaison WHERE id_tag = $idTag AND id_doc = $idDoc";
		$r = msqlqi($q, 2);
		if($r > 0)
			echo json_encode(array('etat' => 1, 'message' => '<h6><i class="fas fa-check"></i> Association rompue.</h6>', 'typeNoty' => 'success'));
		else
			echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> Une erreur s\'est produite.</h6>', 'typeNoty' => 'error'));
	}
}
else
	echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> ID manquant.</h6>', 'typeNoty' => 'error'));