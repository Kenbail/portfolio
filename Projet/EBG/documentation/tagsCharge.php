<?
session_start();
include ("../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");
include ("$uri_site2/documentation/param.php");
$listeTags = array();
$totalDocs = 0;
$retour = array();
$qTags = "SELECT * FROM (SELECT dt.id_tag, dt.tag, COUNT(dtl.id_doc) AS nb FROM base_ebg3.developpement_tags dt LEFT JOIN base_ebg3.developpement_tags_liaison dtl ON dt.id_tag = dtl.id_tag GROUP BY dt.id_tag ORDER BY nb DESC LIMIT 0, 20) temp ORDER BY tag ASC";
$rTags = msqlqi($qTags);

while($vTags = mysqli_fetch_assoc($rTags)){
	$id = $vTags['id_tag'];
	$tag = encodeEbg($vTags['tag']);
	$nb = $vTags['nb'];
	$totalDocs += $vTags['nb'];

	$json=array();
	$json["id_tag"] = $id; 
	$json["tag"] = $tag; 
	$json["nb"] = $nb; 

	array_push($listeTags, $json); 
}
array_push($retour, $listeTags);
array_push($retour, $totalDocs);


echo json_encode($retour);
?>
