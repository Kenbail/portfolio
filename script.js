$(document).ready(function () {
    setTimeout(() => {
        $(".loading-screen").hide()
        var laclass = $(".orangebackground").attr("class")
        $('.' + laclass).css("background-color", "lightblue")
        $("body").css("background-color", "rgb(210,210,210)")
    }, 3000);

    /*$(".orange.texte").mouseleave(function () {
        var couleur = $(this).css("color");
        $(this).css("color", couleur)
    })*/


    // i pour interval
    var i = 0
    $('.gauche').on("click", function () {
        if (i == 0) {
            var laclass = $(".orangebackground").attr("class")
            $('.' + laclass).css("background-color", "lightblue")
            $("body").css("background-color", "rgb(210,210,210)")
            setTimeout(() => {
                i = i + 1
            }, 100);
        } if (i == 1) {
            setTimeout(() => {
                var laclass = $(".orangebackground").attr("class")
                $('.' + laclass).css("background-color", "orange")
                $("body").css("background-color", "black")
                i = 0
            }, 100);
        }
    })

})





