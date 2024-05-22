
<?
session_start();
include("../include/principal/chemins.php");
include ("$uri_site2/include/principal/ebg/connectInc.php");


?>
<style type="text/css">
	#table{
		display: flex;
		flex-direction: column;
		flex-wrap: wrap;
		justify-content: center;
		align-items: center;
		align-content: center;
	}
	thead{
		background-color: blue;
		
	}
	tbody{
		background-color: #add8e6; 
		
	}
	/*thead{
		width: 300px;
	}
	tbody{
		width: 300px;
	}
	th{
		width: 100px;
	}
	td{
		width: 100px;
		text-align: center;
		}*/
	</style>


	<table id ="table">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Prenom</th>
				<th>Sociétés</th>
			</tr>
		</thead>
		<tbody>
			<?
			$q = "SELECT tb.Nom, tb.Prenom, tb.Societes FROM base_ebg3.table_lucas tb WHERE Societes = 'EBG'";
			$r = msqlqi($q);
			while ($v = mysqli_fetch_assoc($r)) {
				echo "<tr>";
				foreach ($v as $key => $value) {
					echo "<td>". $value ."</td>";
				}
				echo "</tr>";
			}


			?>

		</tbody>
	</table>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
	<script type="text/javascript">
		$("td").on("click",function(){
			/*$(this).siblings().addBack().css("background-color","red")*/
			$(this).parent().css("background-color","red")
			/*$(this).parent().parent().css("background-color","red")*/
		})
		$("th").on("click",function(){
			$(this).siblings().addBack().css("background-color","red")
		})
	</script>