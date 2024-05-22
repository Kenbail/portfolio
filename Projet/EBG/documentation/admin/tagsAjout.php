<?
session_start();
include ("../../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");

$mot = decodeEbg(mysqli_real_escape_string($db, $_POST['mot']));

if($mot != ''){
	$qTest = "SELECT tag FROM base_ebg3.developpement_tags WHERE tag = '$mot'";
	$rTest = msqlqi($qTest);
	if(mysqli_num_rows($rTest) > 0){
		echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> Le mot-clé existe déjà.</h6>', 'typeNoty' => 'warning'));
	}
	else{
		$qAjout = "INSERT INTO base_ebg3.developpement_tags (tag) VALUES ('$mot')";
		$rAjout = msqlqi($qAjout, 1);
		if($rAjout > 0){
			echo json_encode(array('etat' => 1, 'message' => '<h6><i class="fas fa-check"></i> Ajout réussi.</h6>', 'typeNoty' => 'success'));
		}
		else
			echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> Une erreur s\'est produite.</h6>', 'typeNoty' => 'error'));
	}
}
else
	echo json_encode(array('etat' => 0, 'message' => '<h6><i class="fas fa-exclamation-triangle"></i> Mot-clé non défini.</h6>', 'typeNoty' => 'error'));