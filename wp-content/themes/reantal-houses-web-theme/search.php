<div class="container my-5">
    <h1 class="text-center mb-4">Cerca una Casa</h1> 
    <!-- Search for a Home -->

    <!-- Form di Ricerca / Search Form -->
    <form id="search-form" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" id="search" class="form-control" 
                   placeholder="Cerca per titolo o descrizione..." autocomplete="off">
            <!-- Search by title or description -->
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Recupera gli elementi necessari / Get the necessary elements
    let searchInput = document.getElementById("search");
    let homeList = document.getElementById("home-list");
    let searchResults = document.getElementById("search-results");
    let loadingMessage = document.getElementById("loading");

    // Ascolta l'input dell'utente nel campo di ricerca / Listen for user input in the search field
    searchInput.addEventListener("input", function() {
        let searchTerm = searchInput.value.trim(); // Rimuove spazi vuoti / Remove extra spaces

        if (searchTerm.length > 2) { 
            homeList.style.display = "none"; // Nasconde la lista delle case disponibili / Hide home list
            searchResults.style.display = "flex"; // Mostra i risultati della ricerca / Show search results
            loadingMessage.style.display = "block"; // Mostra il messaggio di caricamento / Show loading message

            fetchResults(searchTerm); // Esegue la funzione di ricerca / Call the search function
        } else { 
            homeList.style.display = "flex"; // Mostra di nuovo la lista iniziale / Show the initial home list
            searchResults.style.display = "none"; // Nasconde i risultati della ricerca / Hide search results
            loadingMessage.style.display = "none"; // Nasconde il messaggio di caricamento / Hide loading message
        }
    });

    // Funzione AJAX per la ricerca / AJAX function for search
    function fetchResults(searchTerm) {
        let formData = new FormData();
        formData.append("action", "ajax_search"); // Specifica l'azione per WordPress AJAX / Define action for WordPress AJAX
        formData.append("search", searchTerm); // Passa il termine di ricerca / Pass the search term

        fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
            method: "POST", // Metodo POST per inviare dati / Use POST method to send data
            body: formData // Invia i dati della ricerca / Send search data
        })
        .then(response => response.text()) // Converte la risposta in testo / Convert response to text
        .then(data => {
            searchResults.innerHTML = data; // Inserisce i risultati nel div searchResults
            loadingMessage.style.display = "none"; // Nasconde il messaggio di caricamento / Hide loading message
        })
        .catch(error => console.error("Errore nella ricerca:", error)); // Gestisce errori / Handle errors
    }
});
</script>