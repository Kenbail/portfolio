/*configuration des trumboygs*/
var infoTrumbo ={
	btnsDef: {
        // Create a new dropdown
        image: {
        	dropdown: ['insertImage', 'upload'],
        	ico: 'insertImage'
        },
        formatting2: {
        	dropdown: ['p', 'h3', 'h4', 'h5'],
        	ico: 'p'
        }
    },
    btns: [
    ['viewHTML'],
    ['alert'],
    ['undo', 'redo'],
    ['formatting2'],
    ['strong', 'underline', 'em', 'del'],
    ['fontsize'],
    ['blockquote'],
    ['image'],
    ['table', 'tableCellBackgroundColor', 'tableBorderColor'],
    ['foreColor', 'backColor'],
    ['link'],
    ['justifyLeft', 'justifyCenter','justifyRight',],/* 'justifyFull'*/
    ['unorderedList', 'orderedList'],
    ['horizontalRule'],
    ['removeformat'],
    ['fullscreen']/*plein écran*/
    ],
    autogrowOnEnter: true,
    tagClasses: {
    	h3: 'header',
    	h4: 'header',
    	h5: 'header',
    },
    plugins: {
    	upload: {
    		serverPath : ip+'documentation/admin/uploadImg.php',  
    		fileFieldName : 'fichier',
    		imageWidthModalEdit :true,
    		error : function(uploaderror) {
    			alert("erreur")
    		}

    	},
    	resizimg: {
    		minSize: 64,
    		step: 8,
    	},
    	table: {

    	}

    }
};
function alerte(){
	alert("TESTE")
}
function chargeDocument(id){
	$.ajax({type: 'POST',processData: true,url: 'documentCharge.php',data: {id: id},dataType: 'json',success: function(msg){
		if(msg['etat'] > 0){
			if (msg['noAccess'] > 0){
				$(location).attr("href", "../../documentation/document.php?id=" + id);
			}
			if (msg['verrouille'] > 0){
				var v = new Noty({
					text: 'merci de ne pas modifier cette page',
					modal: true, 
					type: 'error',
					layout: 'center',
					closeWith: ['click'],
					timeout: false,
					/*buttons: [Noty.button("Fermer la page","btn btn-noty"),],*/
					callbacks:{
						onShow: function(){
							$('#boutonEnregistrement').hide();
						},
						onClose: function(){
							$(location).attr("href", "../../documentation/document.php?id=" + id);
						},
					}
				}).show();
				$('.noty_modal').on('click',function(){
					v.close()
				})
			}else{
				$('#titreDoc').val(msg['titreDoc'])
				$('#grandTitreDoc').html(msg['titreDoc'])
			$('#menuDoc').val(msg['menuDoc'])
			$('#codeDoc').val(msg['codeDoc'])
			$('#codeBlocsDoc').html(msg['codeBlocsDoc'])
			$('#dateMajDoc').html(msg['dateMajDoc'])
			$('#tagsDoc').html(msg['tagsDoc'])
			$('#auteurs').html(msg['auteurs'])
			$('#menuBaseDoc').html(msg['menuBaseDoc'])
			$('#lienDoc').val(msg['lienDoc'])
			M.updateTextFields()
			$('select').formSelect();
			/*high()*/ 
			$('.trumbo').trumbowyg(infoTrumbo);
			$('#user').html(msg['user'])
			}
			



			/*ajoute un trumbowyg si la page est vide*/
			if (msg['codeBlocsDoc'] == ''){
				$('#boutonAjouter').trigger("click")
			}
			/*fait en sorte que le trumbowyg soit déplaçable*/
			$( "#codeBlocsDoc" ).sortable({ handle: '.handle' });
		}
	}});
}

function chargeBoutonSuppression(){
	if(id > 0)
		$('#boutonSuppression').show()
	else
		$('#boutonSuppression').hide()
}

var cm
/*function high(){
    // Define an extended mixed-mode that understands vbscript and
    // leaves mustache/handlebars embedded templates in html mode
    var mixedMode = {
    	name: "htmlmixed",
    	scriptTypes: [
    	{matches: /\/x-handlebars-template|\/x-mustache/i, mode: null},
    	{matches: /(text|application)\/(x-)?vb(a|script)/i, mode: "vbscript"}
    	]
    };
    cm = CodeMirror.fromTextArea(document.getElementById('codeDoc'), {
    	mode: mixedMode,
    	selectionPointer: true,
    	lineWrapping:true
    });
}*/

$(document).ready(function(){
	$('.sidenav').sidenav()
	$('.tooltipped').tooltip()
	$('.modal').modal()
	chargeDocument(id)
	chargeBoutonSuppression()
	$('.fixed-action-btn').floatingActionButton();

	$('#boutonEnregistrement').on('click', function(){
		
		var blocs = []
            var memoSuppr = []  // des id existant a virer parce que vides
            var compteurOrdre = 0
            $( ".blocDoc" ).each(function( index ) {
				if($(this).find("input").val()=="" && $(this).find(".trumbo").trumbowyg("html")=="")  // saisie vide
				{
					if($(this).attr("data-id")!="0")
					{
							memoSuppr.push($(this).attr("data-id"))// memo des id a supprimer

						}
                        //var byebye = $(".blocDoc.data-id ") // faire disparaitre physiquement le bloc
                        $(this).parent().remove()

                    }
                    else	
                    	blocs.push({"id": $(this).attr("data-id"), "titre": $(this).find("input").val(), "contenu": $(this).find(".trumbo").trumbowyg("html"), "ordre": compteurOrdre})
                    compteurOrdre ++					
                });

            /*cm.save()*/
            $.ajax({type: 'POST',processData: true,url: 'documentEdition.php',data: {id: id, titreDoc: $('#titreDoc').val()/*, menuDoc: $('#menuDoc').val()*/, codeDoc: $('#codeDoc').val(), dateMajSwitch: $('#dateMajSwitch').prop("checked"), tagsDoc: $('#tagsDoc').val() + "",auteurs: $('#auteurs').val() + "", lienDoc: $('#lienDoc').val(), user: $('#user').html() +"", menuBaseDoc: $('#menuBaseDoc').val(), codeBlocsDoc: JSON.stringify(blocs), memoSuppr:memoSuppr+ "" },dataType: 'json',success: function(msg){
            	if(msg['etat'] == 1){
            		if(id == 0){
            			window.history.replaceState('', '', 'document.php?id='+msg['id']);
            			id = msg['id']
            			chargeBoutonSuppression()
            		}
            		if($('#dateMajSwitch').prop("checked") !== false)
            			$('#dateMajDoc').html(msg['dateMajDoc'])
            		var typeNoty = 'success'
            		$(this).removeClass("pulse");
            	}
            	else
            		var typeNoty = 'error'
            	new Noty({
            		type: typeNoty,
            		timeout: 2000,
            		text: msg['message'],
            	}).show()
            	/*traitement des ID créés*/
            	var nouvId = msg['nouvId']
            	/*nouvId = nouvId.split(',')*/
            	var compteur = 0
            	$("#codeBlocsDoc .blocDoc[data-id='0']").each(function(){
            		$(this).attr('data-id', nouvId[compteur])
            		compteur ++
            	})
            }});



        })
	$('#boutonSuppression').on('click', function(){
		console.log(id)
		var n = new Noty({
			text: 'Voulez-vous vraiment supprimer ce document ?',
			timeout: 5000,
			type: 'error',
			buttons: [
			Noty.button('OUI', 'btn btn-noty', function () {
				$.ajax({type: 'POST',processData: true,url: 'documentSuppression.php',data: {id: id},dataType: 'json',success: function(msg){
					if(msg['etat'] > 0){
						new Noty({
							callbacks: {
								beforeShow: function() {
									$(location).attr("href", "../index.php");
								},
							}
						}).show()

					}
					else{
						new Noty({
							type: 'error',
							timeout: 2000,
							text: msg['message'],
						}).show()
					}
					n.close();
				}});
			}, {id: 'button1', 'data-status': 'ok'}),

			Noty.button('NON', 'btn-flat btn-noty', function () {
				n.close();
			})
			]
		});
		n.show();
	})
	$('#boutonAjouter').on('click', function(){
		$('#codeBlocsDoc').append('<li class="liTrumbo"><div class="blocDoc" data-id="0"><span class="handle ui-sortable-handle"><i class="material-icons">drag_handle</i></span><input placeholder="Insérer un titre" type="text" value=""><textarea placeholder="Saisissez votre texte" class="trumbo"></textarea></div></li>')
		$("#codeBlocsDoc .blocDoc:last-child .trumbo").trumbowyg(infoTrumbo);
	})

	function pulse()
	{
		$('#boutonEnregistrement').addClass('pulse')
	}

	/*Fonction savoir si enregistrer doit pulse*/
	$('#titreDoc, #codeBlocsDoc, #lienDoc').on("keydown", function(){
		pulse();
	})
	$('#dateMajSwitch').on("click", function(){
		pulse();
	})

	$('select').on("change", function(){
		pulse();
	})

	$('#codeBlocsDoc').on( "sortupdate", function() { 
		pulse();    
	});

	$('#boutonEnregistrement').on("click", function(){

		$('#boutonEnregistrement').removeClass('pulse')
	});
	/*$('#boutonCreer').on('click', function(){

	}*/
	$('#titreDoc').on('input', function(e) {
		$('#grandTitreDoc').html($(this).val());
	});
})