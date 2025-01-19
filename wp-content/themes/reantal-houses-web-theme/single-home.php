<?php
get_header(); // Include l'header del tema / Includes the theme header
?>
<main>
    <?php
    // Verifica se ci sono post da visualizzare / Checks if there are posts to display
    if (have_posts()) :
        // Loop sui post trovati / Loop through the found posts
        while (have_posts()) : the_post();

            // Recupera i metadati personalizzati del post corrente / Retrieves custom metadata for the current post
            $price = get_post_meta(get_the_ID(), 'price', true); // Prezzo della casa / Home price
            $location = get_post_meta(get_the_ID(), 'location', true); // Posizione della casa / Home location
            $size = get_post_meta(get_the_ID(), 'size', true); // Dimensioni della casa / Home size
            $rooms = get_post_meta(get_the_ID(), 'rooms', true); // Numero di stanze della casa / Number of rooms in the home
            ?>
            <article>
                <h1><?php the_title(); ?></h1> <!-- Titolo del post / Post title -->
                <p><strong>Price:</strong> <?php echo esc_html($price); ?> USD</p> <!-- Prezzo in formato sicuro / Price displayed safely -->
                <p><strong>Location:</strong> <?php echo esc_html($location); ?></p> <!-- Posizione in formato sicuro / Location displayed safely -->
                <p><strong>Size:</strong> <?php echo esc_html($size); ?> m²</p> <!-- Dimensioni in formato sicuro / Size displayed safely -->
                <p><strong>Rooms:</strong> <?php echo esc_html($rooms); ?></p> <!-- Numero di stanze in formato sicuro / Number of rooms displayed safely -->
                <div><?php the_content(); ?></div> <!-- Contenuto completo del post / Full post content -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="image"><?php the_post_thumbnail(); ?></div> <!-- Immagine in evidenza / Featured image -->
                <?php endif; ?>
            </article>
            <?php
        endwhile;
    endif;
    ?>
</main>
<?php
get_footer(); // Include il footer del tema / Includes the theme footer
?>
