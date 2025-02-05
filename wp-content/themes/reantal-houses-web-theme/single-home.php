<?php
get_header(); // Include l'header del tema / Include the theme's header
?>

<main class="container my-5">

    <div class="mb-4">
        <!-- Link per tornare alla pagina principale delle case disponibili -->
        <!-- Link to go back to the main available homes page -->
        <a href="<?php echo site_url('/home/'); ?>">
            <i class="fa-solid fa-arrow-left"></i> Torna alle case disponibili
        </a>
    </div>

    <div class="row justify-content-center">
        <?php
        // Controlla se ci sono post disponibili
        // Check if there are posts available
        if (have_posts()) :
            // Inizia il ciclo principale per iterare sui post
            // Start the main loop to iterate through the posts
            while (have_posts()) : the_post();

                // Recupera i dati personalizzati del post corrente
                // Retrieve custom data of the current post
                $price = get_post_meta(get_the_ID(), 'price', true); // Prezzo della proprietà / Property price
                $location = get_post_meta(get_the_ID(), 'location', true); // Posizione della proprietà / Property location
                $size = get_post_meta(get_the_ID(), 'size', true); // Dimensione in metri quadrati / Size in square meters
                $rooms = get_post_meta(get_the_ID(), 'rooms', true); // Numero di stanze disponibili / Number of available rooms
                $services = get_field('services'); // Campo ACF "services" con i servizi disponibili / ACF field "services" containing available services
                $image = get_field('image'); // Campo ACF per l'immagine personalizzata / ACF field for custom image
            ?>

            <!-- INIZIO DELLA CARD / START OF THE CARD -->
            <div class="card mb-3 p-0">

                <?php if ($image) : ?>
                    <!-- Mostra l'immagine personalizzata se presente -->
                    <!-- Show the custom image if available -->
                    <img src="<?php echo esc_url($image); ?>" class="card-img-top" alt="Property Image">
                <?php else : ?>
                    <!-- Mostra un'immagine di placeholder se nessuna immagine è impostata -->
                    <!-- Show a placeholder image if no custom image is set -->
                    <img src="https://via.placeholder.com/600x400" class="img-fluid rounded-start" alt="Placeholder Image">
                <?php endif; ?>

                <!-- Corpo della card contenente i dettagli della proprietà -->
                <!-- Card body containing property details -->
                <div class="card-body text-center">
                    <!-- Titolo del post -->
                    <!-- Post title -->
                    <h5 class="card-title fs-1 mb-5 text"><?php the_title(); ?></h5>

                    <!-- Sezione per mostrare il tipo di casa e la categoria -->
                    <!-- Section to display home type and category -->
                    <div class="d-flex gap-5 mb-5 wrap justify-content-center">
                        <p>
                            <?php display_home_types() ?>
                        </p>
                        <p>
                            <?php display_home_category() ?>
                        </p>
                    </div>

                    <!-- Sezione per mostrare i dettagli principali della proprietà -->
                    <!-- Section to display main property details -->
                    <div class="d-flex gap-5 mb-5 wrap justify-content-center">
                        <p class="card-text fs-5"><strong>Price:</strong> <?php echo esc_html($price); ?> USD</p>
                        <p class="card-text fs-5"><strong>Location:</strong> <?php echo esc_html($location); ?></p>
                        <p class="card-text fs-5"><strong>Size:</strong> <?php echo esc_html($size); ?> m²</p>
                        <p class="card-text fs-5"><strong>Rooms:</strong> <?php echo esc_html($rooms); ?></p>
                    </div>

                    <!-- Controlla se ci sono servizi disponibili -->
                    <!-- Check if services are available -->
                    <?php
                    $has_services = false;

                    // Verifica se almeno un servizio è disponibile
                    // Check if at least one service is available
                    if (!empty($services) && is_array($services)) {
                        foreach ($services as $group_fields) {
                            if (is_array($group_fields)) {
                                foreach ($group_fields as $sub_field_value) {
                                    if (!empty($sub_field_value)) {
                                        $has_services = true; //Almeno un servizio è presente / At least one service is available
                                        break 2; //Esce dai cicli appena trova un servizio valido  / Exit loops as soon as a valid service is found                                        
                                    }
                                }
                            }
                        }
                    }
                    ?>

                    <?php if ($has_services) : ?>
                        <p class="card-text fs-3 text"><strong>Available Services:</strong></p>

                        <!-- Lista dei servizi disponibili -->
                        <!-- List of available services -->
                        <div class="d-flex gap-5 mb-5 wrap justify-content-center">
                            <ul class="list-unstyled d-flex flex-wrap gap-3 text-start">
                                <?php foreach ($services as $group_name => $group_fields) : ?>
                                    <?php 
                                    $has_active_fields = false;
                                    foreach ($group_fields as $sub_field_value) {
                                        if ($sub_field_value) {
                                            $has_active_fields = true;
                                            break;
                                        }
                                    }
                                    ?>
                                    <?php if ($has_active_fields) : ?>
                                        <li>
                                            <strong><?php echo esc_html(ucwords(str_replace('_', ' ', $group_name))); ?>:</strong>
                                            <ul class="list-unstyled ps-3 text-start">
                                                <?php foreach ($group_fields as $sub_field_name => $sub_field_value) : ?>
                                                    <?php if ($sub_field_value) : ?>
                                                        <li>✔ <?php echo esc_html(ucwords(str_replace('_', ' ', $sub_field_name))); ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    <?php else : ?>
                        <!-- Messaggio se nessun servizio è disponibile -->
                        <!-- Message if no services are available -->
                        <p class="card-text"><strong>Available Services:</strong> No services available.</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- FINE DELLA CARD / END OF THE CARD -->

        <?php
            endwhile; // Fine del ciclo principale
            // End of the main loop
        else :
            // Messaggio se non ci sono proprietà disponibili
            // Message if no properties are available
            echo '<p class="text-center">No properties found.</p>';
        endif;
        ?>
    </div>
</main>

<?php
get_footer(); // Include il footer del tema / Include the theme's footer
?>
