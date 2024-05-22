

<?php

include ("../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");
$base="base_ebg3";
/*liste des mots non recherchés!*/
$retireMots = array(de, des, la, le, a, à, un, une, ce, ces, du, les, ce, se, mon, ma, mes, ton, ta, tes, son, sa,);
$recherche =  mysqli_real_escape_string($db, $_POST["recherche"]);
$cas =  mysqli_real_escape_string($db, $_POST["cas"]);

if($cas == 'toutVoir'){
	if($_SERVER['REMOTE_USER'] != 'herve' and $_SERVER['REMOTE_USER'] != 'rogeradr')
		$condition = 'WHERE d.date > 0';
	$q = "SELECT d.id, d.nom, d.lien_doc, d.date, GROUP_CONCAT(DISTINCT dal.id_auteur ORDER BY dal.id_auteur asc) AS auteur, GROUP_CONCAT(DISTINCT dt.tag ORDER BY dt.tag asc) AS tags, df.qui FROM $base.developpement d LEFT JOIN $base.developpement_tags_liaison dtl ON d.id = dtl.id_doc LEFT JOIN base_ebg3.developpement_auteurs_liaison dal ON dal.id_doc=d.id  LEFT JOIN $base.developpement_tags dt ON dtl.id_tag = dt.id_tag LEFT JOIN base_ebg3.developpement_favoris df ON d.id = df.id_developpement AND df.qui = '" . $_SERVER['REMOTE_USER'] . "' $condition GROUP BY d.id ORDER BY d.nom ASC";
}
elseif($cas == 'derniersAjouts')
	$q = "SELECT d.id, d.nom, d.lien_doc, d.date, GROUP_CONCAT(DISTINCT dal.id_auteur ORDER BY dal.id_auteur asc) AS auteur, GROUP_CONCAT(DISTINCT dt.tag ORDER BY dt.tag asc) AS tags, df.qui FROM base_ebg3.developpement d LEFT JOIN base_ebg3.developpement_tags_liaison dtl ON d.id = dtl.id_doc LEFT JOIN base_ebg3.developpement_tags dt ON dtl.id_tag = dt.id_tag LEFT JOIN base_ebg3.developpement_auteurs_liaison dal ON dal.id_doc = d.id LEFT JOIN base_ebg3.developpement_favoris df ON d.id = df.id_developpement AND df.qui = '" . $_SERVER['REMOTE_USER'] . "' WHERE d.date > 0 GROUP BY d.id ORDER BY date DESC LIMIT 0, 5";
elseif($cas == 'favoris')
	$q = "SELECT d.id, d.nom, d.lien_doc, d.date, GROUP_CONCAT(DISTINCT dal.id_auteur ORDER BY dal.id_auteur asc) AS auteur , GROUP_CONCAT(DISTINCT dt.tag ORDER BY dt.tag asc) AS tags, df.qui FROM $base.developpement d LEFT JOIN base_ebg3.developpement_auteurs_liaison dal ON dal.id_doc=d.id LEFT JOIN $base.developpement_tags_liaison dtl ON d.id = dtl.id_doc INNER JOIN base_ebg3.developpement_favoris df ON d.id = df.id_developpement AND df.qui = '" . $_SERVER['REMOTE_USER'] . "' LEFT JOIN $base.developpement_tags dt ON dtl.id_tag = dt.id_tag WHERE d.date > 0 GROUP BY d.id ORDER BY d.nom ASC";
elseif($cas == 'auteursDoc')
	$q = "SELECT d.id, d.nom, d.lien_doc, d.date, GROUP_CONCAT(DISTINCT dal.id_auteur ORDER BY dal.id_auteur asc) AS auteur, GROUP_CONCAT(DISTINCT dt.tag ORDER BY dt.tag asc) AS tags, df.qui FROM base_ebg3.developpement d LEFT JOIN base_ebg3.developpement_tags_liaison dtl ON d.id = dtl.id_doc LEFT JOIN base_ebg3.developpement_tags dt ON dtl.id_tag = dt.id_tag LEFT JOIN base_ebg3.developpement_auteurs_liaison dal ON dal.id_doc = d.id LEFT JOIN base_ebg3.developpement_favoris df ON d.id = df.id_developpement AND df.qui = '" . $_SERVER['REMOTE_USER'] . "' WHERE id_auteur = '". $_SERVER['REMOTE_USER'] ."' GROUP BY d.id/* ORDER BY date DESC LIMIT 0, 5*/";
elseif($cas == 'tag')
	$q = "SELECT d.id, d.nom, d.lien_doc, d.date, GROUP_CONCAT(DISTINCT dal.id_auteur ORDER BY dal.id_auteur asc) AS auteur, GROUP_CONCAT(DISTINCT dt.tag ORDER BY dt.tag asc) AS tags, df.qui FROM $base.developpement d INNER JOIN $base.developpement_tags_liaison dtl2 ON d.id = dtl2.id_doc AND dtl2.id_tag = '$recherche' INNER JOIN $base.developpement_tags_liaison dtl ON d.id = dtl.id_doc LEFT JOIN base_ebg3.developpement_auteurs_liaison dal ON dal.id_doc = d.id  INNER JOIN $base.developpement_tags dt ON dtl.id_tag = dt.id_tag LEFT JOIN base_ebg3.developpement_favoris df ON d.id = df.id_developpement AND df.qui = '" . $_SERVER['REMOTE_USER'] . "' WHERE d.date > 0 GROUP BY d.id ORDER BY d.nom ASC";
else
	$q = "SELECT d.id, d.nom, d.lien_doc, d.date, GROUP_CONCAT(DISTINCT dal.id_auteur ORDER BY dal.id_auteur asc) AS auteur , GROUP_CONCAT(DISTINCT dt.tag ORDER BY dt.tag asc) AS tags, df.qui FROM $base.developpement d LEFT JOIN $base.developpement_tags_liaison dtl ON d.id = dtl.id_doc LEFT JOIN base_ebg3.developpement_auteurs_liaison dal ON dal.id_doc = d.id  LEFT JOIN $base.developpement_tags dt ON dtl.id_tag = dt.id_tag LEFT JOIN base_ebg3.developpement_favoris df ON d.id = df.id_developpement AND df.qui = '" . $_SERVER['REMOTE_USER'] . "' WHERE (d.nom LIKE '%" . decodeEbg($recherche) . "%' OR dt.tag LIKE '%" . decodeEbg($recherche) . "%') AND d.date > 0 GROUP BY d.id ORDER BY d.nom ASC";


$r = msqlqi($q);
$data = array();
$nbResultat = mysqli_num_rows($r);
/*si il n'y a pas de résultat, le recherche est séparée pour chaque mot et on fait une recherche sur chaques mots*/
if ($nbResultat == 0){
	$rechercheSplit = explode(" ", $recherche);
	$rechercheSplit = array_diff($rechercheSplit, $retireMots);
	$qSplit = "SELECT d.id, d.nom, d.lien_doc, d.date, GROUP_CONCAT(dt.tag) AS tags, df.qui FROM $base.developpement d LEFT JOIN $base.developpement_tags_liaison dtl ON d.id = dtl.id_doc LEFT JOIN $base.developpement_tags dt ON dtl.id_tag = dt.id_tag LEFT JOIN base_ebg3.developpement_favoris df ON d.id = df.id_developpement AND df.qui = '" . $_SERVER['REMOTE_USER'] ."' WHERE 0=1";
	foreach ($rechercheSplit as $mot) {
		if (strlen($mot)>= 3){
			$qSplit .=  " OR (d.nom LIKE '%" . decodeEbg($mot) . "%' OR dt.tag LIKE '%" . decodeEbg($mot) . "%') ";
		};

	}
	$qSplit .= 'AND d.date > 0 GROUP BY d.id ORDER BY d.nom ASC';
	$r = msqlqi($qSplit);
}



while($v = mysqli_fetch_assoc($r)){
	$id = $v['id'];
	$nom = encodeEbg($v['nom']);
	$lien = $v['lien_doc'] != '' ? encodeEbg($v['lien_doc']) : './document.php?id=' . $id;
	$tags = encodeEbg(str_replace(",",", ",$v["tags"]));
	$favoris = $v["qui"] == $_SERVER['REMOTE_USER'] ? ' <i class="fas fa-star yellow-text"></i>' : '';
	$auteursDoc = in_array($_SERVER['REMOTE_USER'], explode(",",$v['auteur']))  ? ' <i class="fas fa-cog fa-lg"></i> ': '';

	$json=array();

	$json["id"] = $id;
	$json["nom"] = $nom; 
	$json["lien"] = $lien;
	$json["tags"] = $tags;
	$json["favoris"] = $favoris;
	$json["auteursDoc"] = $auteursDoc;

	array_push($data,$json); 
}
/*echo $v['auteur'];*/

echo json_encode($data);