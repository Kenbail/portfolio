$(document).ready(function () {
    setTimeout(() => {
        $(".loading-screen").hide()
        var laclass = $(".orangebackground").attr("class")
        $('.' + laclass).css("background-color", "#93DEFF")
        $("body").css("background-color", "rgb(96, 100, 112)")
    }, 1000);

    /*$(".orange.texte").mouseleave(function () {
        var couleur = $(this).css("color");
        $(this).css("color", couleur)
    })*/


    // i pour interval
    var i = 1
    $('.gauche').on("click", function () {
        if (i == 0) {
            var laclass = $(".orangebackground").attr("class")
            $('.' + laclass).css("background-color", "#93DEFF")
            $("body").css("background-color", "rgb(96, 100, 112)")
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





