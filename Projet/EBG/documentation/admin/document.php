<?
session_start();
include ("../../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");
include ("../../include/salaries.php");
include ("../param.php");
$id = mysqli_real_escape_string($db, $_GET['id']);
?>
<!DOCTYPE HTML>
<html>
<head>
	<? 
	$title = 'Documentation';
	include $uri_site2 . '/documentation/head.php'; 
	?>
	<script>
		var id = '<?= $id ?>';
		if(id == '')
			id = 0;
		ip='<? echo $url_site?>';
		
	</script>

	<script src="//rawcdn.githack.com/RickStrahl/jquery-resizable/0.35/dist/jquery-resizable.min.js"></script>
	<script src="../js/Trumbowyg-main/dist/trumbowyg.min.js"></script>
	<script src="../js/Trumbowyg-main/dist/plugins/upload/trumbowyg.upload.min.js"></script>
	<script src="../js/Trumbowyg-main/dist/plugins/table/trumbowyg.table.min.js"></script>
	<script src="../js/Trumbowyg-main/dist/plugins/resizimg/trumbowyg.resizimg.min.js"></script>
	<!-- <script src="trumbowyg/dist/plugins/giphy/trumbowyg.giphy.min.js"></script> -->
	<script type="text/javascript" src="<?= $url_site2?>/documentation/admin/document.js"></script>
	<script type="text/javascript" src="<?= $url_site2?>/documentation/js/codemirror.js"></script>
	<script type="text/javascript" src="<?= $url_site2?>/documentation/js/htmlmixed.js"></script>
	<script type="text/javascript" src="<?= $url_site2?>/documentation/js/xml.js"></script>
	<!-- <script type="text/javascript" src="<?= $url_site2?>/documentation/js/css.js"></script> -->
	<link href="<?= $url_site2?>/documentation/css/codemirror.css" rel="stylesheet">
	<!-- <link href="<?= $url_site2?>/documentation/css/docs.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="../js/Trumbowyg-main/dist/ui/trumbowyg.min.css">
	<link rel="stylesheet" href="../js/Trumbowyg-main/dist/plugins/table/ui/trumbowyg.table.min.css">
	<!-- <link rel="stylesheet" href="trumbowyg/dist/plugins/giphy/ui/trumbowyg.giphy.min.css"> -->
	<style>
		/*[for="auteurs"]{
			color: blue !important;
			}
			div.container > :nth-child(7) .input-field label{
				color: blue !important;
				}*/
	/*th, td
	{
		border:1px solid #C4C4C4!important;
		}*/
		
		td,th{
			border:1px solid #B6B6B6;
		}
		.trumbowyg-editor ul li{
			list-style-type: disc !important;
		}
		.trumbowyg-editor ul{
			padding-left: 40px !important;
		}
	</style>
</head>
<body>
	<? 
	$page = 'accueil';
	?>
	<header>
		<nav class="top-nav">
			<div class="container">
				<div class="row">
					<div class="nav-wrapper col s12">
						<a href="#" data-target="sidenav" class="sidenav-trigger btn"><i class="material-icons">menu</i></a>
						<a class="page-title truncate" value=""id="grandTitreDoc"></a>
					</div>
				</div>
			</div>
		</nav>
		<ul id="sidenav" class="sidenav sidenav-fixed">
			<? include("$uri_site2/documentation/menuHorizontal.php")?>
			<li><a href="<?= $url_site ?>documentation/document.php?id=<?= $id ?>"><i class="fas fa-chevron-left"></i> Retour</a></li>
			<li class="dateModification">Modifié le&nbsp;: <span class="tooltipped" data-position="top" data-tooltip="Pour vous aider à savoir s'il y a du nouveau depuis votre dernier passage."><b id="dateMajDoc"><?= $dateDoc ?></b><sup><i class="fas fa-question-circle"></i></sup></span></li>
		</ul>
	</header>
	<main>
		<div id="verouille"></div>
		<div class="container">
			<input type="hidden" id="idDoc" value="0">
			<div class="row" style="margin-top: 20px">
				<div class="input-field col s12">
					<input value="" id="titreDoc" type="text">
					<label for="titreDoc">Titre</label>
				</div>
			</div>
			<div class="row">
				<!-- <div class="input-field col s4">
					<textarea id="menuDoc" class="materialize-textarea"></textarea>
					<label for="menuDoc">Menu</label>
				</div> -->
				<div class="input-field col s12">
<!-- 					<textarea id="codeDoc" class="materialize-textarea"></textarea>
-->					<label for="codeDoc">Contenu de la page</label>
</div>
</div>
<div class="row">
	<ul class="ul  z-depth-2 grey lighten-5" id="codeBlocsDoc"></ul>
	<div class="row"><div class="col s-1 offset-s5"><a class="btn-floating btn-large waves-effect waves-dark-blue light-blue" id="boutonAjouter"><i class="material-icons">add</i></a></div></div>
</div>
<div class="row">
	<div class="input-field col s6">
		<select multiple id="tagsDoc"></select>
		<label for="tagsDoc">Mots-clés</label>
	</div>
	<div class="input-field col s6">
		<input value="" id="lienDoc" type="text">
		<label for="lienDoc">Lien externe</label>
		<small>Pour les documentations externes</small>
	</div>
</div>
<div class="row">
				<!-- <div class="input-field col s5">
					<select id="menuBaseDoc"></select>
					<label for="menuBaseDoc">Menu universel</label>
					<small>Correspondance avec le menu universel</small>
				</div> -->
			</div>
			<div class="row">
				<div class="col s6">
					<span style="margin-right: 30px;">Mettre à jour la date&nbsp;?</span>
					<div class="switch tooltipped" data-position="top" data-tooltip="En cas de mise à jour majeure, permet de faire remonter la documentation." style="display: inline-block;">
						<label>
							Non
							<input type="checkbox" id="dateMajSwitch">
							<span class="lever"></span>
							Oui
						</label>
					</div>
				</div>
				<div class="input-field col s6 ">
					<select multiple id="auteurs"></select>
					<label for="auteurs">Auteurs</label>
				</div>
			</div>
		</div>
		<div class="fixed-action-btn">
			<a class="dropbtn btn-floating btn-large boutonEnregistrement" id="boutonEnregistrement"><i class="fas fa-save fa-lg"></i></a>
			<ul>
				<li><a class="btn-floating red" id="boutonSuppression"><i class="fas fa-trash fa-lg "></i></a></li>
			</ul>
		</div>
		<div class="row"></div>

	</main>
</body>
</html>