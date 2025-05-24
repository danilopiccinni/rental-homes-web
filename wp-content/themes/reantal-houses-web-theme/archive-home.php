<?php
get_template_part('template-parts/header');  // Includi l'header del tema WordPress / Include the WordPress theme header
get_template_part('search'); // Includi il modulo di ricerca / Include the search module
?>

<main class="container my-5">
  <h1 class="text-center mb-5">All Available Homes</h1>

  <!-- Contenitore per la lista delle case di partenza, inizialmente visibile / Container for the start home list, initially visible -->
  <div id="home-list" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="display: none;"></div>
  
  <!-- Contenitore per i risultati della ricerca AJAX, inizialmente nascosto / Container for AJAX search results, initially hidden -->
  <div id="search-results" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="display: none;"></div>

  <!-- Messaggio di caricamento visibile solo durante la ricerca / Loading message visible only during search -->
  <p id="loading" class="text-center" style="display: none;">Caricamento...</p>

</main>

<?php 
get_template_part('template-parts/footer'); // Includi il footer del tema WordPress / Include the WordPress theme footer
?>