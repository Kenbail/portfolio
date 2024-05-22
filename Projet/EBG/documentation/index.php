<?
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);	
session_start();
include ("../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");
include ("$uri_site2/documentation/param.php");
$dossier_base="base_ebg3";

$queryTag= "SELECT dt.tag FROM base_ebg3.developpement_tags dt";
$resultTag= msqlqi($queryTag);
?>
<!DOCTYPE HTML>
<html>
<head>
	<? 
	$title = 'Documentation';
	include 'head.php'; ?>
	<script type="text/javascript"> 
		var tags =[ <? while ($valTag= mysqli_fetch_assoc($resultTag)) {
			echo encodeEbg("'".$valTag["tag"]."',");
		};?>];
	</script>
	<script type="text/javascript" src="<?= $url_site2?>/documentation/js/index.js"></script>
</head>
<body>
	<? 
	$page = 'accueil';
	?>
	<header>
		<nav class="top-nav">
			<div class="container">
				<div class="nav-wrapper">
					<a href="#" data-target="sidenav" class="sidenav-trigger btn"><i class="material-icons">menu</i></a>
					<a class="page-title">Documentation</a>
				</div>
			</div>
		</nav>
		<ul id="sidenav" class="sidenav sidenav-fixed">
			<? include("$uri_site2/documentation/menuHorizontal.php")?>
			

			<div style="font-size: 1.5em; color: #012039; font-weight: 500; padding: 0 20px;">Mots-clés<? if($accesN1){ echo ' <a href="./admin/tags.php"><i class="fas fa-cog fa-fw"></i></a>';} ?></div>
			<div style="padding: 0 10px;" id="nuageTags">
			</div>
		</ul>
	</header>
	<main>
		<div class="container">
			<div class="row">
				<div class="input-field col s12">
					<i class="fas fa-search prefix" style="top:10px;"></i>
					<input placeholder="Tapez votre recherche ici..." id="rechercheDocumentation" type="search">
				</div>
				<button id="btnRecherche" data-cas="mot" style="display: none;">Rechercher</button>
			</div>
			<div id="resultatsRecherche" style="display: none;">
				<div class="row">
					<div class="col s12">
						<h3 class="header">Résultats</h3>
						<div class="collection"></div>
						<div class="no-results">Aucun résultat.</div>
					</div>
				</div>
			</div>
			<div id="derniersAjouts">
				<div class="row">
					<div class="col s12">
						<h3 class="header">Derniers ajouts</h3>
						<div class="collection"></div>
					</div>
				</div>
			</div>
			<div id="favoris">
				<div class="row">
					<div class="col s12">
						<h3 class="header">Favoris</h3>	
						<div class="collection"></div>
						<div class="no-results">Vous n'avez pas de favoris.</div>
					</div>
				</div>
			</div>

			<div id="auteursDoc">
				<div class="row">
					<div class="col s12">
						<h3 class="header">Vos documents</h3>	
						<div class="collection"></div>
						<div class="no-results">Vous n'avez pas créé de document.</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12 center-align">
					<a class="btn" href="index2.php">Tout voir</a>
				</div>
			</div>
		</div>
	</main>
	<?/* if ($accesN1){ */?> 
		<div id="boutonCreer" class="fixed-action-btn">
			<a class="btn-floating btn-large" href="./admin/document.php">
				<i class="fas fa-plus fa-lg"></i>
			</a>
		</div>
		<?/* } */?>
	</body>
	</html>
