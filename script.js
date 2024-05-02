$(document).ready(function () {
    $(".orange.texte").mouseleave(function () {
        var couleur = $(this).css("color");
        $(this).css("color", couleur)
    })
    $(".orangebackground").mouseleave(function () {
        var bgcouleur = $(this).css("background-color");
        $(this).css("background-color", bgcouleur)
    })
})