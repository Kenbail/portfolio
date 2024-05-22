/* fonction qui permet de gérer les différent cas des cases à cocher*/ 
$(document).ready(function(){
    //sessionStorage.clear()
    /* Permet d'afficher une pop up sur le hover */
    $(".buttons-container").hover(function(){
        if($('.next').css("pointer-events") == "none"){
            $(".remplir").show()
        }  
    })
    /* met le boutton suivant en gris inclickable */
    // $(".next").css("background-color","grey")     
    // $(".next").css("pointer-events","none")//blocage bouton
    
     $("body").on('click',"input:checkbox", function() {
         var box = $(this);
         var laclass = $(this).attr("class")
         var p = $(this).next()
         var allp = $($("."+laclass).next())
         var allh5 = $("h5."+box.attr("class")) 
         var autre = $('input[autre]')
        /*vérifie Si il y'a plusieur case à afficher */ 
        if(box.attr("Multitude")== undefined){
                /* regarde si il y'aura la possibilité de cocher plusieur cases*/
            if(box.attr("choixM")==undefined){
                /*si la case n'est pas cochée et que on ne peux selectionner que 1 case, décoche toute les autres cases, et ajoute un input si il faut préciser du texte */
                if (box.is(":checked")) {
                    $("."+box.attr('class')+"suppr").parent().empty()
                    allp.empty()
                    allp.hide()
                    var group = "input:checkbox[name='" + box.attr("name") + "']";
                    $(group).prop("checked", false);
                    box.prop("checked", true);
                    /* Permet au checkbox qui on l'attribut ajout d'ajouter un input de texte en dessous d'elle pour précisez des informations */
                    if (box.attr("ajout")!=undefined){
                        p.show()
                        p.append("<label> "+ box.attr("label")+ "</label><input type='text' id='sous"+box.attr('id')+"' class='"+box.attr('class')+"'>");
                    }else{
                        if(box.attr("tableau") == null){
                            $("."+laclass).attr("check_oui_non","oui")
                        }
                        
                    }
                }else {
                    /*si la case est coché, alors on la décoche et enlève le input si il y'en a un  */
                    box.prop("checked", false);
                    $("."+laclass).attr("check_oui_non","non")
                    p.hide()
                }
            }else{
                /*choix multiple activer donc on ne décoche pas les autres cases quand un nouvelle est cocher, avec l'ajout du input si il faut préciser du texte */
                if (box.is(":checked")) {
                    $(autre).prop("checked", false);
                    autre.next().empty()
                    autre.next().next().empty()
                    p.hide()
                    $("."+laclass+":not([nocheck])").attr("check_oui_non","oui")
                    if (box.attr("ajout")!=undefined){
                        p.append("<label" + box.attr("id") + "> "+ box.attr("label")+ "</label>");
                        p.append("<input nocheck class='"+box.attr('class')+"' type='text'>");
                        p.show()
                        
                    }
                    /*Permet au checkbox qui sont elle même afficher grace à une autre checkbox d'afficher un input texte en dessous pour précisez des informations */
                    if (box.attr("sousajout")!=undefined){
                        $("<p></p>").insertAfter(box.parent())
                        box.parent().next().append("<input id='sous"+ box.attr("id") +"' type='text' class='"+box.attr('class')+"suppr'>");
                    }
                }else{
                    /* supprime le input text ajouter par une sous checkbox */
                    if (box.attr("sousajout")!=undefined){
                        $("."+box.attr('class')+"suppr").parent().empty()
                    }
                    box.prop("checked", false);
                    p.empty()
                    p.hide()
                    if($("."+ laclass +":checked").length < 1){
                        $("."+laclass).attr("check_oui_non","non")
                    }
                    
                }
            }
        }else{
            /* supprime le input text ajouter par une sous checkbox */
            $(".sous"+box.attr('class')+"suppr").parent().empty()
            /* Déclaration de variable */
            var h4 =$("h4[class ='"+ box.attr("class")+ "']")
            var h5 =$("h5[class ='"+ box.attr("class")+ "']")
            var poslabel = $("."+ box.attr('class')+"[hidden]:first").parent()
            /*zone de traitement dans le cas ou il y'a plusieur input à afficher */
            if (box.is(":checked")) {
                $("label."+ box.attr("class")).empty()
                $("<label class='"+ box.attr("class")+ "'>"+ box.attr("label")+ "</label>").insertBefore(poslabel)
                allh5.next().empty()
                $("."+laclass).attr("check_oui_non","oui")
                var group2 = "input:checkbox[name=" + box.attr("name") + "]";
                $(group2).prop("checked", false);
                h4.show()
                h5.show()
                allh5.next().show()
                /* Vérifie si les sous checkbox peux être cocher en même temps que d'autre */
                $(h5).each(function(){
                    if($(this).attr("choixm")!= undefined){
                        $(this).next().append("<input id='"+$(this).attr('id')+"' type='checkbox' sousajout choixm name=sous"+box.attr("name")+" class=sous"+box.attr("name")+">");
                        
                    }else{
                        $(this).next().append("<input id='"+$(this).attr('id')+"' type='checkbox' name=sous"+box.attr("name")+" class=sous"+box.attr("name")+">");
                    }
                })
                box.prop("checked", true);
            }else{
                box.prop("checked", false);
                $("label."+ box.attr("class")).empty()
                allh5.next().empty()
                h4.hide()
                h5.hide()
                allh5.next().hide()
                $("."+laclass).attr("check_oui_non","non")
             }
             /*dans le cas ou il est possible de ne pas répondre à une question */
             /* -------------------------------------------------------------------------- */
             /*if(box.attr("aucun")!= undefined){
                if (box.is(":checked")) {
                    $("label."+ box.attr("class")).empty()
                    allh5.next().empty()
                    h4.hide()
                    h5.hide()
                    allh5.next().hide()
                    $("."+laclass).attr("check_oui_non","oui")
                }else{
                    $("label."+ box.attr("class")).empty()
                    allh5.next().empty()
                    h4.hide()
                    h5.hide()
                    allh5.next().hide()
                    $("."+laclass).attr("check_oui_non","non")
                }
            }*/
            /* -------------------------------------------------------------------------- */
        }
        /*Permet au checkbox de créer un tableau on click */
        if(box.attr("tableauoui")!=undefined){
            $("."+laclass).attr("check_oui_non","non")
            if (box.is(":checked")) {
                $("span[more]."+laclass).empty()
                p.show()
                p.append("<table><thead>Entête</thead><tbody class="+ box.attr('class')+"><tr><td><input id='sous"+box.attr('id')+"' type='text' itableau='1' class="+ box.attr('class')+" check_oui_non='non'></td><td><input id='sous"+box.attr('id')+"' type='text' itableau='1'class="+ box.attr('class')+" check_oui_non='non'></td></tr></tbody></table>")
                $("<span class="+ box.attr("class") +" more>More<span>").insertAfter(p)
                $("span[more]").show()
            }else{
                p.next().hide()
                p.next().next().next().hide()
                $("span[more]").hide()
                
            }
        }
        /* Permet de supprimer le tableau en cas de click sur la réponse "non" */
        else if(box.attr("tableaunon") !=undefined){
            if (box.is(":checked")) {
                p.next().hide()
                p.next().hide()
                p.empty()
                $("span[more]."+ box.attr("class")).hide()
                $("."+laclass).attr("check_oui_non","oui")
            }else{
                $("."+laclass).attr("check_oui_non","non")
                
            }
            
        }
        /* Fonction qui vérifie que toute les questions ont été répondu */
        verifinput()
    });

    
    $("body").on('keyup',"[type='text']",function(){
        /* Fonction qui vérifie que les tableaux sont remplis correctements */
        veriftableau($(this))
        /* Fonction qui vérifie que toute les questions ont été répondu */
        verifinput()
    })
    /* Fonction du bouton qui permet d'ajouter de nouvelle case au tableau */
    $("body").on('click',"span[more]", function() {
        var question = $(this).attr('class')
        var tableau = $('tbody.'+question)
        var sousid = $("td input."+question)
        tableau.append('<tr><td><input id="'+sousid.attr("id")+'" type="text" itableau="1" class='+question+' check_oui_non="non"></td><td><input id="'+sousid.attr("id")+'" type="text" itableau="1" class='+question+' check_oui_non="non"></td><td><button class='+question+' type="button" moins>Supprimer</button></td></tr>')
        veriftableau($(this))
        verifinput()
    });
    /* Fonction du bouton qui permet de supprimer les cases ajouter d'un tableau */
    $("body").on('click',"button[moins]", function() {
        var tableau = $(this).parent().parent()
        tableau.remove()
        veriftableau($(this))
        verifinput()
        
    });

    });
 

/* Fonction qui gère les input de types dates, vérifie entre autre que la date inscrite est suppérieur à la date actuel */
$("body").on('change',"input[type='date']", function() {
    var d = new Date();
    var anne = d.getFullYear()
    var mois = d.getMonth()+1
    var jour = d.getDate()
    var listchiffre = [1,2,3,4,5,6,7,8,9]
    var i;
    for (i = 0; i < listchiffre.length; ++i) {
        if(listchiffre[i] == mois){
            mois = "0"+mois
        }
        if(listchiffre[i] == jour){
            jour = "0"+jour
        }
    }
    var strDate = anne + "-" + mois + "-" + jour;
    var dateremp = $(this).val()

    if (dateremp > strDate){
        $(this).attr("check_oui_non","oui")
        $(this).next().hide()
    }else{
        $(this).next().empty()
        $(this).attr("check_oui_non","non")
        $(this).next().show()
        $(this).next().append("Erreur, veuillez remplir une date supérieur à la date actuel")
        $(this).next().css("color","red")
    }
})
/* Fonction vérifiant que les talbeaux soient bien remplis */
function veriftableau($this){
    var a = 0
    var b = $('input[itableau=1]')
    b = b.length
    var laclass = $this.attr("class")
        /* vérifie que les inputs du tableau son bien remplis */ 
        $('input[itableau=1]').each(function(){
            if ($(this).val()!=""){
                a +=1
            }
        })
       if( a == b){
            $("."+laclass).attr("check_oui_non","oui")
        }else{
            $("."+laclass).attr("check_oui_non","non")
        }

}
/* Fonction qui vérifie que toute les questions ont été répondu */
// function verifinput() {
//     setTimeout(
//         function() 
//         {
//             var listeinput = $('input').get()
//             var listecheck = $('input[check_oui_non="oui"]').get()
//         if(listecheck.length == listeinput.length){
//             $(".next").css("background-color","#00498f")
//             $(".next").css("pointer-events","auto")
//             $(".next").css("cursor","pointer");
//             $(".remplir").hide()
//         }else{
//             $(".next").css("background-color","grey")
//             $(".next").css("pointer-events","none")
//             $(".next").css("cursor","not-allowed");
//             $(".remplir").show()
//             }
//         }, 400);
//  }

 /* Fonction qui récupère les informations inscrites et les mets variables de session */
 $(".test").on("click",function(){
    var stockage = []
    var stockagequestion = null
    var storedvar
    /* Pour chaque ID */
    $("[id]").each(function(){ 
        /* Fait la différence entre les id qui désignent les réponses aux question, ceux qui sont des réponses complémentaire et les autres */
        if(isNaN($(this).attr("id"))){
            /* Permet aux question qui ont plusieurs sous réponses d'être répertorier ensemble */
            if($("sous"+ $(this).attr("id")) != ""){
                if( $(this).val()!=""){
                    if(stockagequestion != $(this).attr('id')  && stockagequestion!= null ){
                        stockagequestion= $(this).attr('id')
                        stockage = []
                        sessionStorage.setItem( $(this).attr('id'), $(this).val())
                        storedvar = sessionStorage.getItem( $(this).attr('id'))
                        stockage.push(storedvar)
                    }else{
                    stockagequestion= $(this).attr('id')
                    sessionStorage.setItem( $(this).attr('id'), $(this).val())
                    storedvar = sessionStorage.getItem( $(this).attr('id')) || []
                    stockage.push(storedvar)
                    sessionStorage.setItem( $(this).attr('id'), stockage);
                    
                    } 
                }   
            }
            /* gère les différents cas d'input  */
        }else{
            if($(this).is('input[type="date"]')){
                sessionStorage.setItem( $(this).attr('id'), $(this).val())
            }
            if($(this).is('input:text')){
                sessionStorage.setItem( $(this).attr('id'), $(this).val())
            }
            if($(this).is('input:checkbox')){
                if($(this).is(":checked")){
                    sessionStorage.setItem( $(this).attr('id'), true)
                }
            }
        // else{
        //     if(sessionStorage!=empty){
        //         sessionStorage.getItem('input:checkbox')

        //     }
        
    
    
    
    
    
    }
       
        

    })
    $('.envoi').on('click', function() {
        // alert('RRRRR');
        // var url =  "Routing.generate('post_question')";
        var count = 0;
        for(count = 0; count < localStorage.length; count++){ 
            if(localStorage.getItem("10") != null){
                console.log(count)
                // count++;
            }
        }
        $.ajax ({
            type: "POST",
            url: '/questionlist',
            dataType:   'json',  
            async:      true,  
            data: { recupStorage : stockage
            },
            success: function(data, textStatus, jqXHR) {
                alert(recupStorage);
            },
            error:function (){
                alert('error!');
            }
        });


        })
 })








