<?php
session_start();
include ("../../include/principal/chemins.php");

	$tmp_file = $_FILES['fichier']['tmp_name'];
	$success=true;
    $msg="Le fichier a bien &eacute;t&eacute; upload&eacute;";
    if( !is_uploaded_file($tmp_file) )
    {
        $msg="Le fichier est introuvable";
        $success=false;
    }
   // on vérifie maintenant l'extension
    $type_file = $_FILES['fichier']['type'];
    if( !strstr($type_file, 'jpg') && !strstr($type_file, 'png') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
    {
        $msg="Le fichier n'est pas une image";
        $success=false;
    }

// on vérifie maintenant la taille
    $verifSize = $_FILES['fichier']['size'];
    if (($verifSize/1024/1024) > 2 ) {
        $msg="Fichier trop volumineux";
        $success=false;     
    }

    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier']['name'];  // nom final du fichier

    $repertoire="documentation/uploads";
    $fichierFinalUrl = "$url_site2/$repertoire/$name_file";
    $fichierFinalUri = "$uri_site2/$repertoire/$name_file";
    
    if( !move_uploaded_file($tmp_file, $fichierFinalUri) )
    {
        $msg="Impossible de copier le fichier dans $repertoire";
        $success=false;
    }

// $output will be converted into JSON
$output = array("success" => $success, "file" => "$fichierFinalUrl", "error"=>"$msg");
echo json_encode($output);
?>