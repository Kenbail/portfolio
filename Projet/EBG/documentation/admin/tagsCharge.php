<?
session_start();
include("../../include/principal/chemins.php");
include ("$uri_site/include/principal/ebg/connectInc.php");

$q = "SELECT dt.id_tag, dt.tag, COUNT(dtl.id_doc) AS nb FROM base_ebg3.developpement_tags dt LEFT JOIN base_ebg3.developpement_tags_liaison dtl ON dt.id_tag = dtl.id_tag GROUP BY dt.id_tag ORDER BY dt.tag ASC";
$r = msqlqi($q);
$n = mysqli_num_rows($r);

$data = array();
while($v = mysqli_fetch_assoc($r)){
	$json=array();

	$json["id"] = $v['id_tag'];
	$json["tag"] = encodeEbg($v['tag']);
	$json["nombre"] = $v['nb'];

	array_push($data,$json); 
}

echo json_encode($data);
?>