/**
 * =============================================================================
 *  MAIN JAVASCRIPT FILE
 *  FILE JAVASCRIPT PRINCIPALE
 * -----------------------------------------------------------------------------
 *  Questo script gestisce la ricerca AJAX delle case nel tema WordPress.
 *  Avvia automaticamente la ricerca al caricamento della pagina e aggiorna i
 *  risultati in tempo reale quando l'utente modifica i campi di input.
 *
 *  This script handles the AJAX-based home search in the WordPress theme.
 *  It auto-triggers the search on page load and updates results live as
 *  the user modifies the input fields.
 * =============================================================================
 */

document.addEventListener("DOMContentLoaded", function() {
    // Elementi del DOM utilizzati nella ricerca / DOM elements used for search
    let searchForm      = document.getElementById("search-form");
    let searchResults   = document.getElementById("search-results");
    let homeList        = document.getElementById("home-list");
    let loadingMessage  = document.getElementById("loading");

    // Esegui la ricerca appena la pagina viene caricata / Trigger search on page load
    fetchResults();

    // Attiva la ricerca AJAX a ogni modifica dei campi / Live search on input change
    searchForm.addEventListener("input", function() {
        fetchResults(); // Esegue chiamata AJAX / Executes AJAX call
    });

    /**
     * ======================================================
     *  FUNZIONE FETCHRESULTS()
     *  FETCHRESULTS FUNCTION
     * ------------------------------------------------------
     *  Raccoglie i dati dal form, esegue una chiamata AJAX
     *  e aggiorna i risultati in base ai filtri impostati.
     *
     *  Collects form data, sends an AJAX request and updates
     *  the result area based on the selected filters.
     * ======================================================
     */
    function fetchResults() {
        let formData = new FormData(searchForm);

        // Aggiunge l'azione richiesta da WordPress per l'AJAX / Adds required WP AJAX action
        formData.append("action", "ajax_search");

        // Mostra il loader e nasconde la lista iniziale / Show loader and hide initial list
        loadingMessage.style.display = "block";
        homeList.style.display = "none";
        searchResults.style.display = "flex";

        // Esegue richiesta AJAX tramite Fetch API / Perform AJAX request via Fetch API
        fetch(ajaxurl, {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Mostra i risultati nel contenitore / Display results in container
            searchResults.innerHTML = data;
            loadingMessage.style.display = "none"; // Nasconde il loader / Hide loader
        })
        .catch(error => console.error("Search error:", error)); // Gestione errori / Error handling
    }
});
