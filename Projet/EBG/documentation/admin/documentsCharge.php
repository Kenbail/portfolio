<?
session_start();
include ("../../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");

$id = mysqli_real_escape_string($db, $_POST['id']);
$retour = array();

if($id > 0){
	$data = array();
	$q = "SELECT d.nom, d.lien_doc, d.id FROM base_ebg3.developpement_tags_liaison dtl INNER JOIN base_ebg3.developpement d ON dtl.id_doc = d.id AND dtl.id_tag = $id ORDER BY d.nom ASC";
	$r = msqlqi($q);
	while($v = mysqli_fetch_assoc($r)){
		$json = array();
		$json['id'] = encodeEbg($v['id']);
		$json['nom'] = encodeEbg($v['nom']);
		$json['lien'] = encodeEbg($v['lienDoc']);

		array_push($data, $json);
	}
	array_push($retour, $data);

	$data2 = array();
	$q = "SELECT d.nom, d.lien_doc, d.id FROM base_ebg3.developpement d LEFT JOIN base_ebg3.developpement_tags_liaison dtl ON  dtl.id_doc = d.id AND dtl.id_tag = $id WHERE dtl.id_tag IS NULL ORDER BY d.nom ASC";
	$r = msqlqi($q);
	while($v = mysqli_fetch_assoc($r)){
		$json = array();
		$json['id'] = encodeEbg($v['id']);
		$json['nom'] = encodeEbg($v['nom']);
		$json['lien'] = encodeEbg($v['lienDoc']);

		array_push($data2, $json);
	}
	array_push($retour, $data2);
}
echo json_encode($retour);
@mysqli_close($db);
?>