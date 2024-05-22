<?
session_start();
include ("../../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");

$id = mysqli_real_escape_string($db, $_POST['id']);

if($id > 0){
	$qDoc = "DELETE FROM base_ebg3.developpement WHERE id = '$id'";
	$rDoc = msqlqi($qDoc, 2);
	if($rDoc > 0){
		echo json_encode(array('etat' => 1, 'message' => '<h6><i class="fas fa-check"></i> Suppression réussie.</h6>'));
		$qFav = "DELETE FROM base_ebg3.developpement_favoris WHERE id_developpement = '$id'";
		$rFav = msqlqi($qFav);
		$qTag = "DELETE FROM base_ebg3.developpement_tags_liaison WHERE id_doc = '$id'";
		$rTag = msqlqi($qTag);
		$qDbloc = "DELETE FROM base_ebg3.developpement_blocs WHERE id_dev = '$id'";
		$rDbloc = msqlqi($qDbloc);
		$qAuteur = "DELETE FROM base_ebg3.developpement_auteurs_liaison WHERE id_doc = '$id'";
		$rAuteur = msqlqi($qAuteur);
	}
	else
		echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> Une erreur s\'est produite.</h6>'));
}
else
	echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> ID manquant.</h6>'));