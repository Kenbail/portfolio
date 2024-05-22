$(document).ready(function(){
		$('.sidenav').sidenav()
		chargeDocuments('derniersAjouts', '#derniersAjouts')
		chargeDocuments('favoris', '#favoris')
		chargeDocuments('auteursDoc', '#auteursDoc')
		chargeTags()
		var lanceAutocomplete
		$("#rechercheDocumentation").keydown(function(e){
			$("#resultatsRecherche").hide();
			if(e.which == 13){
				$("#btnRecherche").trigger("click");
			}
			else{
				clearTimeout(lanceAutocomplete)
				lanceAutocomplete = setTimeout(function(){$("#btnRecherche").trigger("click");}, 500)
			}
		});

		$('#btnRecherche').on('click', function() {
			var recherche = $("#rechercheDocumentation").val().trim()
			if(recherche.length > 2){
				chargeDocuments('recherche', '#resultatsRecherche', recherche)
				$("#resultatsRecherche").show()
			}
			else{
				M.toast({html: 'Tapez plus de 3 caractères'})
			}
		})

		$(document).on('click', '.rechercheTag' , function() {
			var recherche = $(this).data('id')
			$("#rechercheDocumentation").val('')
			chargeDocuments('tag', '#resultatsRecherche', recherche)
			$("#resultatsRecherche").show()
		});
		$("#recherche").autocomplete({
			source: tags
		});
	})
