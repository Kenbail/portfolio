<?
session_start();
include ("../../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");

$id = mysqli_real_escape_string($db, $_GET['id']);

?>
<!DOCTYPE HTML>
<html>
<head>
	<? 
	$title = 'Documentation';
	include $uri_site2 . '/documentation/head.php'; ?>
	<script>
		var id = '<?= $id ?>';
		if(id == '')
			id = 0;
	</script>
	<script type="text/javascript" src="<?= $url_site2?>/documentation/admin/tags.js"></script>
	<script type="text/javascript" src="<?= $url_site2?>/documentation/js/noty.min.js"></script>
	<script type="text/javascript" src="<?= $url_site2?>/documentation/js/noty-parameters.js"></script>
	<link href="<?= $url_site2?>/documentation/css/noty.min.css" rel="stylesheet">
</head>
<body>
	<? 
	$page = 'accueil';
	?>
	<header>
		<nav class="top-nav">
			<div class="container">
				<div class="nav-wrapper">
					<a class="page-title">Mots-clés - Admin</a>
				</div>
			</div>
		</nav>
		<ul id="nav-mobile" class="sidenav sidenav-fixed">
			<? include("$uri_site2/documentation/menuHorizontal.php")?>
			<? if($id > 0){ ?>
				<li><a href="<?= $url_site ?>documentation/admin/document.php?id=<?= $id ?>"><i class="fas fa-chevron-left"></i> Retour</a></li>
			<? } else { ?>
				<li><a href="<?= $url_site ?>documentation/"><i class="fas fa-chevron-left"></i> Retour</a></li>
			<? } ?>
		</ul>
	</header>
	<main>
		<div class="container">
			<div class="row valign-wrapper" style="margin-top: 20px">
				<div class="input-field col s6">
					<input type="text" id="inputAjoutTag">
					<label for="inputAjoutTag">Nouveau mot-clé</label>
				</div>
				<div class="input-field col s6">
					<button class="btn" id="boutonAjoutTag">Ajouter</button>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<div class="collection" id="tags"></div>
				</div>
			</div>
		</div>
<!-- <div class="fixed-action-btn">
<a class="btn-floating btn-large red" id="boutonSuppression">
<i class="fas fa-trash fa-lg"></i>
</a>
</div> -->
</main>
<div id="modalSuppressionTag" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4>Suppression</h4>
			</div>
		</div>
		<div class="row">
			<div class="col s12 center-align">
				<button class="btn boutonSuppressionTag red" id="boutonSuppressionTag" data-id="0">Supprimer sans fusionner</button>
			</div>
			<div class="col s12 center-align" style="padding-top: 20px; padding-bottom: 15px;">
				--- ou ---
			</div>
			<div class="col s6 offset-s3">
				<div class="collection" id="listeTagsTransfert"></div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Annuler</a>
		</div>
	</div>
</div>
<div id="modalEditionTag" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4>Edition</h4>
			</div>
		</div>
		<div class="row">
			<div class="col s5">
				<h5>Associé</h5>
				<div class="collection" id="listeDocumentsSelectionnes"></div>
			</div>
			<div class="col s2 center-align" style="padding-top: 60px; padding-bottom: 15px;">
				<i class="fas fa-exchange-alt"></i>
			</div>
			<div class="col s5">
				<h5>Non associé</h5>
				<div class="collection" id="listeDocumentsNonSelectionnes"></div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Annuler</a>
		</div>
	</div>
</div>
</body>
</html>