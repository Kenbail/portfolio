$(document).ready(function () {
    var tel = 0
    var h = window.innerHeight;
    var w = window.innerWidth;
    if (w < 500) {
        var tel = 1
    }
    if (tel == 0) {


        $('.zoomable').on('click', function () {
            var image = $(this).clone()
            $(".emplacement_zoom").append(image)
            modal.style.display = "flex";
            $(".emplacement_zoom img").css("height", h / 1.25)
            $(".emplacement_zoom img").css("width", w / 1.5)


        });

        $("#myModal").on("click", function () {
            $(".emplacement_zoom").empty()
            modal.style.display = "none";
        })
        var modal = document.getElementById("myModal");
    }

    $('.head').css("height", h)
    $('#myModal').css("height", h)
    $('#myModal').css("width", w)
    if (tel == 0) {
        $('.catch').css("margin-left", (w / 4))
        $('.catch').css("margin-top", (h / 4))
    } else {
        $('.catch').css("margin-left", (w / 8))
        $('.catch').css("margin-top", (h / 4))
    }




    $('.carousel').carousel();

    $('.carousel.carousel-slider').carousel({
        fullWidth: true,
        indicators: true
    });


});

$(".btn").on("click", function () {
    instance.next()
})
$('.boutton').on("click", function () {
    window.open("IMG/tarif.pdf");

})
