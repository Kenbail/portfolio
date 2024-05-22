<?
session_start();
include("../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");
include "$uri_site2/documentation/param.php";
include ("../include/salaries.php");

$id = mysqli_real_escape_string($db, $_GET['id']);



if(empty($id))
	header('location:index.php');
$q = "SELECT d.nom, d.auteurs, d.date, d.id_menu_base, d.lien_doc, d.verrouille as verrou FROM base_ebg3.developpement d WHERE d.id = $id";
$r = msqlqi($q);
$n = mysqli_num_rows($r);
if($n < 1)
	header('location:index.php');
$v = mysqli_fetch_assoc($r);
/*recherche et redirectionne si la doc posséde un lien externe */
if ($v["lien_doc"] != '') {
    header("Location: " . $v["lien_doc"]);
    exit();
}

$nomDoc = encodeEbg($v['nom']);
$lienDoc = encodeEbg($v['lien_doc']);
//$menuDoc = encodeEbg($v['menu']);  // ancienne version
$codeDoc = encodeEbg($v['code']);
$auteursDoc = encodeEbg($v['auteurs']);
$dateDoc = date('d/m/Y', $v['date']);
$idMenuBaseDoc = $v['id_menu_base'];

$codeBlocsDoc = "";
$menuDoc = "";
$query="SELECT id_bloc, contenu, titre FROM base_ebg3.developpement_blocs WHERE id_dev=$id ORDER BY ordre";
$result = msqlqi($query,0);  //  0 =>  lire , 1=> insert into id unique, 2 => insert ou update nb e lignes affectées par l'operation
while ($val = mysqli_fetch_assoc($result))
{

	$id_bloc=$val["id_bloc"];
	$titre=$val["titre"];
	$contenu=$val["contenu"];
	
	// Ligne menu
	$menuDoc .= "<li><a title='$titre' href=\"#$id_bloc\" class=\"truncate\">$titre</a></li>";
	// Bloc complet
	$codeBlocsDoc .= '<div class="row section scrollspy" id="'.$id_bloc.'"><h2 class="header">'.$titre.'</h2>'.$contenu.'</div>';

}
?>
<!DOCTYPE HTML>
<html>
<head>
	<style >
		.section ul li{
			list-style-type: disc !important;
		}
		.section ul{
			padding-left: 40px !important;
		}
		#signature{
			font-family: Franklin Gothic Medium
			text-shadow:0 0 3px #0061FE, 0 0 7px #0061FE, 0 0 20px #0061FE;color:#0061FE;
		}
		table{
			border-collapse:unset;	
		}
		td,th
		{
			border: 1px solid #B2B2B2;
		}

		.nobordure td,.nobordure th
		{
			border:0px!important;
		}
	</style>
	<script>
		var id = '<?= $id ?>'
	</script>
	<?
	$title = $nomDoc;
	include 'head.php'; 
	?>
	<script type="text/javascript" src="<? echo $url_site2?>/documentation/js/document.js"></script>
</head>
<body>
	<header>
		<nav class="top-nav">
			<? 
			if ($v["verrou"] == 0){
				if ($accesN1 or accesN2($id)){?> 
					<ul id="nav-mobile" class="right"><!-- hide-on-med-and-down -->
						<li><a href="<?= $url_site2 ?>/documentation/admin/document.php?id=<?= $id ?>"><i class="fas fa-cog fa-lg"></i></a></li>
					</ul>
					<?
				}
			}elseif ($v["verrou"] == 1) {?>
				 <ul class="right">
						<li><a class="tooltipped" data-position="bottom" data-tooltip="Cette page est verrouillée. Elle ne peut être modifiée que par un administrateur."><i class="fas fa-lock fa-lg"></i></a></li>
					</ul>  <?
				
			}?>
			<div class="container">
				<div class="nav-wrapper">
					<a href="#" data-target="sidenav" class="sidenav-trigger btn"><i class="material-icons">menu</i></a>
					<a class="page-title truncate"><?= $nomDoc ?></a>
				</div>
			</div>
		</nav>
		<ul id="sidenav" class="sidenav sidenav-fixed">
			<? include("$uri_site2/documentation/menuHorizontal.php")?>
			<li><a href="<?= $url_site ?>documentation"><i class="fas fa-chevron-left"></i> Retour</a></li>
			<?= $menuDoc ?>
			<li class="dateModification">Modifié le&nbsp;: <span class="tooltipped" data-position="top" data-tooltip="Pour vous aider à savoir s'il y a du nouveau depuis votre dernier passage."><b><?= $dateDoc ?></b><sup><i class="fas fa-question-circle"></i></sup></span></li>
		</ul>

	</header>	
	<main>
		<div class="container">
			
			<?=  /*$codeDoc.*/$codeBlocsDoc  ?>
			<div class="row">
				<div class="col s12"align="right">
					<label align="right">Auteurs</label>
					
				</div>
				<div class="col s12" align="right" id="signature">

					<?
					$qRauteur = "SELECT GROUP_CONCAT(DISTINCT dal.id_auteur ORDER BY dal.id_auteur asc) AS auteurs FROM base_ebg3.developpement_auteurs_liaison dal WHERE id_doc = $id";
					$rRauteur = msqlqi($qRauteur);
					$vAuteurs = mysqli_fetch_assoc($rRauteur);
					$vAuteurs = explode(",", $vAuteurs["auteurs"]);
					foreach ($listeSalaries as $key => $infoSalarie){
						if (in_array(encodeEbg($key), encodeEbg($vAuteurs) )) {

							echo " ─ ". encodeEbg($infoSalarie['nomComplet']);
						}
					}


					?>
				</div>
			</div>
		</div>
	</main>
	<footer>
	</footer>
	<div class="fixed-action-btn">
		<a class="btn-floating btn-large" id="boutonFavoris">
			<i class="far fa-star fa-lg"></i>
		</a>
	</div>
	<!-- Import jQuery -->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script> -->


	<!-- <script src="./js/Trumbowyg-main/dist/trumbowyg.min.js"></script> -->
</body>
</html>