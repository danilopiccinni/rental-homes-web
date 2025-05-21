
<?php
/**

========================================================

SINGLE HOME TEMPLATE

TEMPLATE PER SINGOLA CASA DISPONIBILE

Mostra i dettagli dell'immobile e include il modulo

di prenotazione frontend.

Displays the property details and includes the booking

form for the frontend.

========================================================
*/
get_header(); // Include l'header del tema / Include the theme's header
?>

<main class="container my-5">

    <!-- Link di ritorno -->
    <div class="mb-4">
        <a href="<?php echo site_url('/home/'); ?>" class="text-decoration-none">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna alle case disponibili
        </a>
    </div>

    <div class="row justify-content-center">
        <?php if (have_posts()) : while (have_posts()) : the_post();

            // Recupera i metadati della proprietà
            $price    = get_post_meta(get_the_ID(), 'price', true);
            $location = get_post_meta(get_the_ID(), 'location', true);
            $size     = get_post_meta(get_the_ID(), 'size', true);
            $rooms    = get_post_meta(get_the_ID(), 'rooms', true);
            $services = get_field('services');
            $image    = get_field('image');
        ?>

        <!-- CARD DETTAGLI IMMOBILE -->
        <div class="card mb-4 p-0 shadow">

            <!-- FORM DI PRENOTAZIONE -->
            <div class="card-body border-bottom mb-3">
                <?php get_template_part('booking-form'); ?>
            </div>

            <!-- MESSAGGI DI SUCCESSO/ERRORE -->
            <?php if (isset($_GET['booking_status']) && $_GET['booking_status'] === 'success') : ?>
                <div class="alert alert-success mx-3">
                    Booking successful! We will contact you soon.
                </div>
            <?php elseif (isset($_GET['booking_status']) && $_GET['booking_status'] === 'error') : ?>
                <div class="alert alert-danger mx-3">
                    There was an error with your booking. Please try again.
                </div>
            <?php endif; ?>

            <!-- IMMAGINE PRINCIPALE -->
            <?php if ($image) : ?>
                <img src="<?php echo esc_url($image); ?>" class="card-img-top" alt="Property Image">
            <?php else : ?>
                <img src="https://via.placeholder.com/600x400" class="card-img-top" alt="Placeholder Image">
            <?php endif; ?>

            <!-- CONTENUTO DELLA CARD -->
            <div class="card-body text-center">

                <!-- Titolo -->
                <h5 class="card-title fs-1 mb-4"><?php the_title(); ?></h5>

                <!-- Tipo e categoria -->
                <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
                    <p><?php display_home_types(); ?></p>
                    <p><?php display_home_category(); ?></p>
                </div>

                <!-- Dettagli principali -->
                <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
                    <p class="card-text fs-5"><strong>Price:</strong> <?php echo esc_html($price); ?> USD</p>
                    <p class="card-text fs-5"><strong>Location:</strong> <?php echo esc_html($location); ?></p>
                    <p class="card-text fs-5"><strong>Size:</strong> <?php echo esc_html($size); ?> m²</p>
                    <p class="card-text fs-5"><strong>Rooms:</strong> <?php echo esc_html($rooms); ?></p>
                </div>

                <!-- Sezione servizi disponibili -->
                <?php
                $has_services = false;
                if (!empty($services) && is_array($services)) {
                    foreach ($services as $group_fields) {
                        if (is_array($group_fields)) {
                            foreach ($group_fields as $sub_field_value) {
                                if (!empty($sub_field_value)) {
                                    $has_services = true;
                                    break 2;
                                }
                            }
                        }
                    }
                }
                ?>

                <?php if ($has_services) : ?>
                    <p class="card-text fs-3"><strong>Available Services:</strong></p>
                    <div class="d-flex justify-content-center mb-4">
                        <ul class="list-unstyled d-flex flex-wrap gap-4 text-start">
                            <?php foreach ($services as $group_name => $group_fields) :
                                $has_active_fields = false;
                                foreach ($group_fields as $val) {
                                    if ($val) {
                                        $has_active_fields = true;
                                        break;
                                    }
                                }
                                if ($has_active_fields) : ?>
                                    <li>
                                        <strong><?php echo esc_html(ucwords(str_replace('_', ' ', $group_name))); ?>:</strong>
                                        <ul class="list-unstyled ps-3">
                                            <?php foreach ($group_fields as $field_label => $value) :
                                                if ($value) : ?>
                                                    <li>✔ <?php echo esc_html(ucwords(str_replace('_', ' ', $field_label))); ?></li>
                                                <?php endif;
                                            endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif;
                            endforeach; ?>
                        </ul>
                    </div>
                <?php else : ?>
                    <p class="card-text"><strong>Available Services:</strong> No services available.</p>
                <?php endif; ?>

            </div> <!-- /card-body -->
        </div> <!-- /card -->

        <?php endwhile;
        else :
            echo '<p class="text-center">No properties found.</p>';
        endif; ?>
    </div> <!-- /row -->
</main>

<?php
get_footer(); // Include il footer del tema / Include the theme's footer
?>