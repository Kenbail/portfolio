<?
session_start();
include ("../../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");

$id = mysqli_real_escape_string($db, $_POST['id']);
$idTransfert = mysqli_real_escape_string($db, $_POST['idTransfert']);

if($id > 0){
	$q = "DELETE FROM base_ebg3.developpement_tags WHERE id_tag = $id";
	$r = msqlqi($q, 2);
	if($r > 0){
		if($idTransfert > 0){
			$q2 = "UPDATE base_ebg3.developpement_tags_liaison SET id_tag = '$idTransfert' WHERE id_tag = '$id'";
			$r2 = msqlqi($q2, 2);
			if($r2 >= 0)
				echo json_encode(array('etat' => 1, 'message' => '<h6><i class="fas fa-check"></i> Suppression réussie. Transfert réussi.</h6>', 'typeNoty' => 'success'));
			else
				echo json_encode(array('etat' => 1, 'message' => '<h6><i class="fas fa-check"></i> Suppression réussie. Le transfert a échoué.</h6>', 'typeNoty' => 'warning'));
		}
		else{
			$q3 = "DELETE FROM base_ebg3.developpement_tags_liaison WHERE id_tag = '$id'";
			$r3 = msqlqi($q3, 2);
			echo json_encode(array('etat' => 1, 'message' => '<h6><i class="fas fa-check"></i> Suppression réussie.</h6>', 'typeNoty' => 'success'));
		}
	}
	else
		echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> Une erreur s\'est produite.</h6>', 'typeNoty' => 'error'));
}
else
	echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> ID manquant.</h6>', 'typeNoty' => 'error'));