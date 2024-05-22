<?
session_start();
include ("../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");
include ("$uri_site2/documentation/param.php");

$listeTags = array();
$totalDocs = 0;
function rechercheTag(){
	$qTags = "SELECT * FROM (SELECT dt.id_tag, dt.tag, COUNT(dtl.id_doc) AS nb FROM base_ebg3.developpement_tags dt LEFT JOIN base_ebg3.developpement_tags_liaison dtl ON dt.id_tag = dtl.id_tag GROUP BY dt.id_tag ORDER BY nb DESC LIMIT 0, 20) temp ORDER BY tag ASC";
$rTags = msqlqi($qTags);

while($vTags = mysqli_fetch_assoc($rTags)){
	array_push($listeTags, array($vTags['id_tag'], encodeEbg($vTags['tag']), $vTags['nb']));
	$totalDocs += $vTags['nb'];
}
$nuageTags = '';
foreach ($listeTags as $tag) {
	$tailleTag = round($tag[2] / $totalDocs * 100 * 2);
	$opaciteTag = $tailleTag + 50;
	if(strlen($tailleTag) == 1)
		$tailleTag = '0' . $tailleTag;
	else if($opaciteTag > 99)
		$opaciteTag = 99;
	$nuageTags .= '<span class="rechercheTag" data-cas="tag" data-id="' . $tag[0] . '" data-tag="' . $tag[1] . '" style="font-size:1.' . $tailleTag . 'em; opacity: 0.' . $opaciteTag . ';">' . $tag[1] . ' (' . $tag[2] . ')</span>';
}
}
echo json_encode($nuageTags);

?>
