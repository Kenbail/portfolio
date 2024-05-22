function chargeTags(id, cas){
    $.ajax({type: 'POST',processData: true,url: 'tagsCharge.php',data: {},dataType: 'json',success: function(msg){
        if(cas == 'transfert'){
            var retour = ''
            $.each( msg, function( key, tag ) {
                if(id != tag['id'])
                    retour += '<a class="collection-item boutonSuppressionTag" style="cursor:pointer" data-id="0" data-transfert="' + tag['id'] + '"><span class="badge">(' + tag['nombre'] + ')</span>' + tag['tag'] + '</a>'
            });
            $('#listeTagsTransfert').html(retour)
        }
        else{
            var retour = ''
            $.each( msg, function( key, tag ) {
                retour += '<a class="collection-item"><span class="badge">(' + tag['nombre'] + ') <i class="fas fa-edit fa-fw boutonEditionTagModal" data-id="' + tag['id'] + '" style="cursor:pointer"></i> <i class="fas fa-trash fa-fw boutonSuppressionTagModal red-text" data-id="' + tag['id'] + '" style="cursor:pointer"></i></span>' + tag['tag'] + '</a>'
            });
            $('#tags').html(retour)
        }
    }});
}

function suppressionTag(id, idTransfert){
    $.ajax({type: 'POST',processData: true,url: 'tagsSuppression.php',data: {id: id, idTransfert: idTransfert},dataType: 'json',success: function(msg){
        new Noty({
            type: msg['typeNoty'],
            timeout: 2000,
            text: msg['message'],
        }).show()
        chargeTags()
    }});
}

function ajoutTag(mot){
    $.ajax({type: 'POST',processData: true,url: 'tagsAjout.php',data: {mot: mot},dataType: 'json',success: function(msg){
        new Noty({
            type: msg['typeNoty'],
            timeout: 2000,
            text: msg['message'],
        }).show()
        if(msg['etat'] == 1){
            chargeTags()
            $('#inputAjoutTag').val('')
        }
    }});
}

function chargeDocuments(id){
    $.ajax({type: 'POST',processData: true,url: 'documentsCharge.php',data: {id: id},dataType: 'json',success: function(msg){
        var retour = ''
        $.each( msg[0], function( key, doc ) {
                retour += '<a class="collection-item boutonEditionTag" style="cursor:pointer" data-idtag="' + id + '" data-iddoc="' + doc['id'] + '" data-cas="suppression">' + doc['nom'] + '</a>'
        });
        $('#listeDocumentsSelectionnes').html(retour)
        var retour2 = ''
        $.each( msg[1], function( key, doc ) {
                retour2 += '<a class="collection-item boutonEditionTag" style="cursor:pointer" data-idtag="' + id + '" data-iddoc="' + doc['id'] + '" data-cas="ajout">' + doc['nom'] + '</a>'
        });
        $('#listeDocumentsNonSelectionnes').html(retour2)
    }});
}

function editionTag(idTag, idDoc, cas){
    $.ajax({type: 'POST',processData: true,url: 'tagsEdition.php',data: {idTag: idTag, idDoc: idDoc, cas: cas},dataType: 'json',success: function(msg){
        new Noty({
            type: msg['typeNoty'],
            timeout: 2000,
            text: msg['message'],
        }).show()
        if(msg['etat'] == 1){
            chargeDocuments(idTag)
        }
    }});
}

$(document).ready(function(){
    $('.sidenav').sidenav()
    $('.tooltipped').tooltip()
    $('.modal').modal()
    $('#modalSuppressionTag').modal({onCloseStart: function(){
        $('#boutonSuppressionTag').data('id', '0')
    }})
    $('#modalEditionTag').modal({onCloseStart: function(){
        chargeTags()
    }})
    chargeTags()

    $('#boutonAjoutTag').on('click', function(){
        ajoutTag($('#inputAjoutTag').val().trim())
    })

    $('#inputAjoutTag').on('keyup', function(e){
        if(e.keyCode == '13')
            $('#boutonAjoutTag').trigger('click')
    })

    $(document).on('click', '.boutonSuppressionTagModal', function(){
        $('#boutonSuppressionTag').data('id', $(this).data('id'))
        chargeTags($(this).data('id'), 'transfert')
        $('#modalSuppressionTag').modal('open')
    })

    $(document).on('click', '.boutonSuppressionTag', function(){
        var id = $('#boutonSuppressionTag').data('id')
        var idTransfert = $(this).data('transfert')
        suppressionTag(id, idTransfert)
        $('#modalSuppressionTag').modal('close')
    })

    $(document).on('click', '.boutonEditionTagModal', function(){
        chargeDocuments($(this).data('id'))
        $('#modalEditionTag').modal('open')
    })

    $(document).on('click', '.boutonEditionTag', function(){
        editionTag($(this).data('idtag'), $(this).data('iddoc'), $(this).data('cas'))
    })

})