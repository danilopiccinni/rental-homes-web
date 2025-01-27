<?php
// Includi l'header del tema WordPress / Include the WordPress theme header
get_header();
?>

<main class="container my-5">
  <!-- Titolo principale della pagina / Main page title -->
  <h1 class="text-center mb-5">All Available Homes</h1>

  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
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
            // Recupera i metadati personalizzati / Retrieve custom metadata
            $price = get_post_meta(get_the_ID(), 'price', true);
            $location = get_post_meta(get_the_ID(), 'location', true);
            $image = get_field('image'); // Campo immagine personalizzato / Custom image field
            ?>

            <div class="col">
              <div class="card h-100">
                <?php if ($image) : ?>
                  <img style="width: 100%; height: 200px; object-fit: cover;" src="<?php echo esc_url($image); ?>" class="card-img-top" alt="Home Image">
                <?php else : ?>
                  <img style="width: 100%; height: 200px; object-fit: cover;" src="https://via.placeholder.com/600x400" class="card-img-top" alt="Placeholder Image">
                <?php endif; ?>

                <div class="card-body">
                  <h5 class="card-title"> <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"> <?php the_title(); ?> </a></h5>
                  <p class="card-text"><strong>Price:</strong> <?php echo esc_html($price); ?> USD</p>
                  <p class="card-text"><strong>Location:</strong> <?php echo esc_html($location); ?></p>
                </div>

                <div class="card-footer text-center">
                  <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
                </div>
              </div>
            </div>

        <?php
        endwhile; // Fine del ciclo / End of the loop
    else :
        // Messaggio se non ci sono case disponibili
        // Message if no homes are available
        echo '<p class="text-center">No homes found.</p>';
    endif;

    // Ripristina i dati del post dopo la query personalizzata
    // Reset post data after the custom query
    wp_reset_postdata();
    ?>
  </div>
</main>

<?php
// Includi il footer del tema WordPress / Include the WordPress theme footer
get_footer();
?>