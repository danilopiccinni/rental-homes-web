document.addEventListener("DOMContentLoaded", function() {
    let searchForm = document.getElementById("search-form");
    let searchResults = document.getElementById("search-results");
    let homeList = document.getElementById("home-list");
    let loadingMessage = document.getElementById("loading");

    // Esegui la ricerca appena la pagina viene caricata con campi vuoti
    fetchResults();

    // Gestisci l'evento di ricerca
    searchForm.addEventListener("input", function() {
        fetchResults(); // Chiamata AJAX a ogni input senza refresh
    });

    function fetchResults() {
        let formData = new FormData(searchForm);

        // Aggiunge l'azione per WordPress AJAX
        formData.append("action", "ajax_search");

        // Mostra il loader e nasconde la lista iniziale
        loadingMessage.style.display = "block";
        homeList.style.display = "none";
        searchResults.style.display = "flex";

        fetch(ajaxurl, {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            searchResults.innerHTML = data;
            loadingMessage.style.display = "none";
        })
        .catch(error => console.error("Search error:", error));
    }
});
