<?

session_start();
include ("../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");
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
	<script type="text/javascript" src="<?= $url_site2?>/documentation/js/index2.js"></script>
</head>
<body>
	<? 
	$page = 'accueil';
	?>
	<header>
		<nav class="top-nav">
			<div class="container">
				<div class="nav-wrapper">
					<a href="#" data-target="nav-mobile" class="sidenav-trigger btn"><i class="material-icons">menu</i></a>
					<a class="page-title">Documentation</a>
				</div>
			</div>
		</nav>
		<ul id="nav-mobile" class="sidenav sidenav-fixed">
			<? include("$uri_site2/documentation/menuHorizontal.php")?>
			<li><a href="<?= $url_site ?>documentation"><i class="fas fa-chevron-left"></i> Retour</a></li>
		</ul>
	</header>
	<main>
		<div class="container">
			<div id="toutVoir">
				<div class="row">
					<div class="col s12">
						<h3 class="header">Toute la documentation</h3>
						<div class="collection"></div>
						<div class="no-results">Aucun résultat.</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<? if ($accesN1){ ?> 
		<div class="fixed-action-btn">
			<a class="btn-floating btn-large" href="./admin/document.php">
				<i class="fas fa-plus fa-lg"></i>
			</a>
		</div>
	<? } ?>
</body>
</html>

<script>

</script>

<!-- <script type="text/javascript" src="<? echo $url_site2?>/documentation/js/document.js"></script> -->