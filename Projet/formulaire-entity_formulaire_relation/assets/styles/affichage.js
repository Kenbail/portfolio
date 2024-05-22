$(document).ready(function() {
    // Fonction pour afficher les réponses stockées dans le sessionStorage
    function afficherReponses() {
        $("[id]").each(function() {
            var id = $(this).attr("id");
            var value = sessionStorage.getItem(id);
            
            // Si la valeur est stockée, attribuez-la à l'élément correspondant
            if (value !== null) {
                if ($(this).is('input[type="text"], input[type="date"]')) {
                    $(this).val(value);
                } else if ($(this).is('input[type="checkbox"]')) {
                    $(this).prop("checked", JSON.parse(value)); // Convertit la valeur de chaîne en booléen
                }
            }
        });
    }
    
    // Appel de la fonction pour afficher les réponses lors du chargement de la page
    afficherReponses();
});