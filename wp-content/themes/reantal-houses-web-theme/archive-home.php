<?php
get_header(); // Includi l'header del tema WordPress / Include the WordPress theme header
get_template_part('search'); // Includi il modulo di ricerca / Include the search module
?>

<main class="container my-5">
  <h1 class="text-center mb-5">All Available Homes</h1>

  <!-- Contenitore per la lista delle case, inizialmente visibile / Container for the home list, initially visible -->
  <div id="home-list" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php
    // Definizione dei parametri per la query delle case disponibili / Define query parameters for available homes
    $args = [
        'post_type' => 'home', // Cerca solo nei post di tipo 'home' / Search only in 'home' post type
        'posts_per_page' => -1, // Recupera tutte le case disponibili / Retrieve all available homes
        'meta_query' => [
            [
                'key'   => 'availability', // Controlla il campo 'availability' / Check the 'availability' field
                'value' => 1, // Deve essere uguale a 1 (disponibile) / Must be 1 (available)
                'compare' => '=' // Confronto esatto con il valore 1 / Exact comparison with value 1
            ]
        ]
    ];

    // Esegue la query per recuperare le case disponibili / Execute the query to retrieve available homes
    $homes = new WP_Query($args);
    
    if ($homes->have_posts()) :
      while ($homes->have_posts()) : $homes->the_post();

        generate_small_home_card(); // Genera una card per ogni casa trovata / Generate a card for each found home

      endwhile;
    else :
      echo '<p class="text-center">No homes found.</p>'; // Messaggio se nessuna casa è trovata / Message if no home is found
    endif;
      
    wp_reset_postdata(); // Ripristina i dati della query globale di WordPress / Reset WordPress global query data
    ?>
  </div>
  
  <!-- Contenitore per i risultati della ricerca AJAX, inizialmente nascosto / Container for AJAX search results, initially hidden -->
  <div id="search-results" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="display: none;"></div>

  <!-- Messaggio di caricamento visibile solo durante la ricerca / Loading message visible only during search -->
  <p id="loading" class="text-center" style="display: none;">Caricamento...</p>

</main>

<?php 
get_footer(); // Includi il footer del tema WordPress / Include the WordPress theme footer
?>