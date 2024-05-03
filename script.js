$(document).ready(function () {
    $(".orange.texte").mouseleave(function () {
        var couleur = $(this).css("color");
        $(this).css("color", couleur)
    })
    // i pour interval
    var i = 0

    setInterval(() => {
        if (i == 0) {
            var laclass = $(".orangebackground").attr("class")
            $('.' + laclass).css("background-color", "blue")
            i = i + 1
        } if (i == 1) {
            var laclass = $(".orangebackground").attr("class")
            $('.' + laclass).css("background-color", "red")
            i = i + 1
        }
        if (i == 2) {
            var laclass = $(".orangebackground").attr("class")
            $('.' + laclass).css("background-color", "red")
            i = i - 2
        }
    }, 4000);
})





