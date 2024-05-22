$(document).ready(function () {

    $('#trumbo').trumbowyg()

    setTimeout(() => {
        $(".loading-screen").hide()
        $(".couleur.texte").css("background-color", "#93DEFF")
        $("body").css("background-color", "rgb(96, 100, 112)")
    }, 1000);

    /*$(".orange.texte").mouseleave(function () {
        var couleur.texte = $(this).css("color");
        $(this).css("color", couleur.texte)
    })*/


    // i pour interval
    var i = 1
    $('.gauche').on("click", function () {
        if (i == 0) {
            $(".couleur.texte").css("background-color", "#93DEFF")
            $("body").css("background-color", "rgb(96, 100, 112)")
            setTimeout(() => {
                i = i + 1
            }, 100);
        } if (i == 1) {
            setTimeout(() => {
                $(".couleur.texte").css("background-color", "orange")
                $("body").css("background-color", "black")
                i = 0
            }, 100);
        }
    })
    console.log($('.couleur.texte'))
})





