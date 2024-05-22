function chargeFavoris(id, etat){
	$.ajax({type: 'POST',processData: true,url: 'chargeFavoris.php',data: {id: id, etat: etat},dataType: 'json',success: function(msg){
		if(msg[0] > 0){
			if(msg[1] == 1)
				$('#boutonFavoris').html('<i class="fas fa-star fa-lg"></i>').data('etat', '1')
			else
				$('#boutonFavoris').html('<i class="far fa-star fa-lg"></i>').data('etat', '2')
		}
	}});
}
$(document).ready(function(){
	$('.scrollspy').scrollSpy({scrollOffset:0});
	$('.tooltipped').tooltip();
	$('.sidenav').sidenav()
	chargeFavoris(id)
	$('#boutonFavoris').on('click', function(){
		var etat = $(this).data('etat')
		chargeFavoris(id, etat)
	})
	$('.container img').css('max-width', '100%')
});
