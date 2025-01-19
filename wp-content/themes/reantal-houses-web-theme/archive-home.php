<?php
// Includi l'header del tema WordPress / Include the WordPress theme header
get_header();
?>

<main>
  <!-- Titolo principale della pagina / Main page title -->
  <h1>All Available Homes</h1>
  <?php
  // Argomenti per la query WP_Query per recuperare i post del tipo "home"
  // Arguments for the WP_Query to fetch posts of type "home"
  $args = [
      'post_type' => 'home', // Specifica il tipo di post da recuperare / Specify the post type to retrieve
      'posts_per_page' => -1, // Recupera tutti i post disponibili / Retrieve all available posts
  ];

  // Esegue la query / Execute the query
  $homes = new WP_Query($args);

  // Controlla se ci sono post da mostrare / Check if there are posts to display
  if ($homes->have_posts()) :
      // Ciclo attraverso i post disponibili / Loop through the available posts
      while ($homes->have_posts()) : $homes->the_post();
          ?>
          <div class="home">
              <!-- Titolo del post con un link al singolo post -->
              <!-- Post title with a link to the single post -->
              <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              
              <!-- Mostra un estratto del contenuto del post -->
              <!-- Display an excerpt of the post content -->
              <div><?php the_excerpt(); ?></div>
          </div>
      <?php
      endwhile; // Fine del ciclo / End of the loop
  else :
      // Messaggio se non ci sono case disponibili
      // Message if no homes are available
      echo '<p>No homes found.</p>';
  endif;

  // Ripristina i dati del post dopo la query personalizzata
  // Reset post data after the custom query
  wp_reset_postdata();
  ?>
</main>

<?php
// Includi il footer del tema WordPress / Include the WordPress theme footer
get_footer();
?>