<?
$accesN1Liste = array('rogeradr','herve','lucas');// ,
$accesN1 = in_array($_SERVER['REMOTE_USER'], $accesN1Liste);

function accesN2($a){
	$sqlVerif = "SELECT * FROM base_ebg3.developpement_auteurs_liaison WHERE id_doc = $a and id_auteur = '". $_SERVER['REMOTE_USER'] ."' ";
	$rVerif = msqlqi($sqlVerif);
	if (mysqli_num_rows($rVerif) >= 1)
		$accesAuteur = true ;
	else 
		$accesAuteur = false ;
	return $accesAuteur;
}


?>