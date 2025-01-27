<?php
get_header(); // Include l'header del tema / Include the theme's header
?>

<main class="container my-5">
    
    <div class="mb-4">
        <a href="<?php echo site_url('/home/'); ?>"><i class="fa-solid fa-arrow-left"></i> torna alle case disponibili</a>
    </div>

    <div class="row justify-content-center">
        <?php
        // Verifica se ci sono post disponibili / Check if there are posts available
        if (have_posts()) :
            // Ciclo principale: iterazione attraverso i post / Main loop: iterating through the posts
            while (have_posts()) : the_post();
                // Recupera i dati personalizzati del post corrente / Retrieve custom data of the current post
                $price = get_post_meta(get_the_ID(), 'price', true); // Prezzo della proprietà / Property price
                $location = get_post_meta(get_the_ID(), 'location', true); // Posizione della proprietà / Property location
                $size = get_post_meta(get_the_ID(), 'size', true); // Dimensione in metri quadrati / Size in square meters
                $rooms = get_post_meta(get_the_ID(), 'rooms', true); // Numero di stanze disponibili / Number of available rooms
                $services = get_field('services'); // Campo "services" che contiene servizi disponibili / "Services" field containing available services
                $image = get_field('image'); // Campo immagine personalizzato / Custom image field
            ?>

            <!-- INIZIO DELLA CARD / START OF THE CARD -->
            <div class="card mb-3 p-0">

                <?php if ($image) : ?>
                    <!-- Mostra l'immagine personalizzata se disponibile / Show the custom image if available -->
                    <img src="<?php echo esc_url($image); ?>" class="card-img-top" alt="Property Image">
                <?php else : ?>
                    <!-- Mostra un'immagine di placeholder se nessuna immagine è impostata / Show a placeholder image if no custom image is set -->
                    <img src="https://via.placeholder.com/600x400" class="img-fluid rounded-start" alt="Placeholder Image">
                <?php endif; ?>

                <!-- Corpo della card contenente i dettagli della proprietà / Card body containing property details -->
                <div class="card-body text-center">
                    <!-- Titolo del post / Post title -->
                    <h5 class="card-title fs-1 mb-5 text"><?php the_title(); ?></h5>

                    <div class="d-flex gap-5 mb-5 wrap justify-content-center">
                        <!-- Dettagli principali della proprietà / Main property details -->
                        <p class="card-text fs-5"><strong>Price:</strong> <?php echo esc_html($price); ?> USD</p>
                        <p class="card-text fs-5"><strong>Location:</strong> <?php echo esc_html($location); ?></p>
                        <p class="card-text fs-5"><strong>Size:</strong> <?php echo esc_html($size); ?> m²</p>
                        <p class="card-text fs-5"><strong>Rooms:</strong> <?php echo esc_html($rooms); ?></p>
                    </div>

                    <!-- Controlla se esistono servizi disponibili / Check if services are available -->
                    <?php
                    $has_services = false;

                    // Controlla se esiste almeno un valore valido nei servizi
                    if (!empty($services) && is_array($services)) {
                        foreach ($services as $group_fields) {
                            if (is_array($group_fields)) {
                                foreach ($group_fields as $sub_field_value) {
                                    if (!empty($sub_field_value)) {
                                        $has_services = true; // Almeno un servizio è disponibile
                                        break 2; // Esci dai cicli appena trovi un servizio valido
                                    }
                                }
                            }
                        }
                    }
                    ?>

                    <?php if ($has_services) : ?>
                        <p class="card-text fs-3 text"><strong>Available Services:</strong></p>
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
                    <?php else : ?>
                        <!-- Messaggio se nessun servizio è disponibile / Message if no services are available -->
                        <p class="card-text"><strong>Available Services:</strong> No services available.</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- FINE DELLA CARD / END OF THE CARD -->

        <?php
            endwhile; // Fine del ciclo principale / End of the main loop
        else :
            // Messaggio se non ci sono post disponibili / Message if no posts are available
            echo '<p class="text-center">No properties found.</p>';
        endif;
        ?>
    </div>
</main>

<?php
get_footer(); // Include il footer del tema / Include the theme's footer
?>
