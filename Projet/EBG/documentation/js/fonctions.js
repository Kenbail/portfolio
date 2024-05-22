function chargeDocuments(cas, destination, recherche){
	$(destination + ' .collection, ' + destination + ' .no-results').hide()
	$.ajax({type: 'POST',processData: true,
		url: 'rechercheDocumentations.php',
		data: {recherche: recherche, cas: cas},
		dataType: 'json',
		success: function(msg){
			var retour = ''
			if(msg.length > 0){
				$.each( msg, function( key, resultatRecherche ) {
					retour += '<a href="' + resultatRecherche['lien'] + '" class="collection-item" data-id="' + resultatRecherche['id'] + '"><span class="badge">' + resultatRecherche['tags'] + '</span>' + resultatRecherche['nom'] + resultatRecherche['favoris'] + resultatRecherche['auteursDoc'] +'</a>'
				});
				$(destination + ' .collection').html(retour).show()
			}
			else{
				retour = 'Aucun résultat.'
				$(destination + ' .no-results').show()
			}
		}
	});
}

function chargeTags(){
	$.ajax({type: 'POST',processData: true,
		url: 'tagsCharge.php',
		data: {},
		dataType: 'json',
		success: function(msg){
			var tags = msg[0]
			var totalDocs = msg[1]
			var nuageTags = ''
			$.each(tags, function(index,tag){
				var tailleTag = Math.round(tag['nb'] / totalDocs * 100 * 2)
				var opaciteTag = tailleTag + 50
				
				if (tailleTag < 10) {
					tailleTag = '0' + tailleTag

				}
				else if(opaciteTag > 99)
					opaciteTag = 99
				
				nuageTags += '<span class="rechercheTag" data-cas="tag" data-id="' + tag['id_tag'] + '" data-tag ="' + tag['tag'] + '"style="font-size:1.' +tailleTag + 'em; opacity: 0.' + opaciteTag + ';">' + tag['tag'] + '('+ tag['nb'] + ')</span>';
				

			})
			/*foreach ($listeTags as $tag) {
	$tailleTag = round($tag[2] / $totalDocs * 100 * 2);
	$opaciteTag = $tailleTag + 50;
	if(strlen($tailleTag) == 1)
		$tailleTag = '0' . $tailleTag;
	else if($opaciteTag > 99)
		$opaciteTag = 99;
	$nuageTags .= '<span class="rechercheTag" data-cas="tag" data-id="' . $tag[0] . '" data-tag="' . $tag[1] . '" style="font-size:1.' . $tailleTag . 'em; opacity: 0.' . $opaciteTag . ';">' . $tag[1] . ' (' . $tag[2] . ')</span>';

}*/

$("#nuageTags").html(nuageTags);

}});
}