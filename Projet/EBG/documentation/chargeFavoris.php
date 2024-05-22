<?
session_start();
include("../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");

$id =  mysqli_real_escape_string($db, $_POST['id']);
$etat =  mysqli_real_escape_string($db, $_POST['etat']);

if($id > 0){
	if($etat > 0){
		if($etat == 1){
			$q = "DELETE FROM base_ebg3.developpement_favoris WHERE id_developpement = '$id' AND qui = '" . $_SERVER['REMOTE_USER'] . "'";
		}
		else{
			$q = "INSERT INTO base_ebg3.developpement_favoris (id_developpement, qui) VALUES ('$id', '" . $_SERVER['REMOTE_USER'] . "')";
		}
		$r = msqlqi($q, 2);
	}
	$q2 = "SELECT id FROM base_ebg3.developpement_favoris WHERE id_developpement = '$id' AND qui = '" . $_SERVER['REMOTE_USER'] . "'";
	$r2 = msqlqi($q2);
	$n2 = mysqli_num_rows($r2);
	$nouvelEtat = ($n2 > 0) ? 1 : 2;
	echo json_encode(array(1, $nouvelEtat));
}
else
	echo json_encode(array(0));
?>