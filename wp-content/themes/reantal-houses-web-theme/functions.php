<?php
/**
 * Theme Functions
 * Funzioni principali del tema Rental Homes
 */

// ===========================
//  INCLUDES (FILE ESTERNI)
// ===========================
require_once get_template_directory() . '/inc/theme-setup.php';                  // Theme support & menu / Supporto tema e menu
require_once get_template_directory() . '/inc/ajax-search.php';                 // AJAX search handlers / Gestione ricerca AJAX
require_once get_template_directory() . '/inc/display-taxonomies.php';          // Taxonomy display helpers / Visualizzazione tassonomie
require_once get_template_directory() . '/inc/tgm-plugin-activation.php';       // Required plugins setup / Setup plugin richiesti
require_once get_template_directory() . '/inc/acf-home-details-group.php';      // ACF: Home Details field group / Gruppo campi ACF per "home"
require_once get_template_directory() . '/inc/booking-cpt.php';                 // Booking CPT registration / Registrazione Custom Post Type "booking"
require_once get_template_directory() . '/inc/acf-booking-fields.php';          // ACF: Booking fields / Campi ACF per prenotazioni
require_once get_template_directory() . '/inc/booking-handler.php';             // Booking form handler / Gestione invio form prenotazione
// ===========================
//  FRONTEND ASSETS
// ===========================

/**
 * Load Bootstrap CSS/JS
 * Carica Bootstrap nel tema
 */
function rental_homes_enqueue_bootstrap() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'rental_homes_enqueue_bootstrap');

/**
 * Load Font Awesome
 * Carica Font Awesome
 */
function rental_homes_enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', [], '6.5.1');
}
add_action('wp_enqueue_scripts', 'rental_homes_enqueue_font_awesome');

/**
 * Load custom theme assets
 * Carica gli asset personalizzati del tema
 */
function rental_homes_enqueue_assets() {
    wp_enqueue_style('rental-homes-style', get_stylesheet_uri());
    wp_enqueue_script('rental-homes-script', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], false, true);
    wp_localize_script('rental-homes-script', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'rental_homes_enqueue_assets');


// ===========================
//  NAVIGATION MENUS
// ===========================

/**
 * Register navigation menus
 * Registra i menu di navigazione
 */
function rental_homes_register_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'rental_homes'),
    ]);
}
add_action('after_setup_theme', 'rental_homes_register_menus');


// ===========================
//  HOME CARD TEMPLATE
// ===========================

/**
 * Generate small home card
 * Genera una card compatta per i post "home"
 */
function generate_small_home_card() {
    $price = get_post_meta(get_the_ID(), 'price', true);
    $location = get_post_meta(get_the_ID(), 'location', true);
    $image = get_field('image'); ?>

    <div class="col">
        <div class="card h-100">
            <?php if ($image) : ?>
                <img style="width: 100%; height: 200px; object-fit: cover;" src="<?php echo esc_url($image); ?>" class="card-img-top" alt="Home Image">
            <?php else : ?>
                <img style="width: 100%; height: 200px; object-fit: cover;" src="https://via.placeholder.com/600x400" class="card-img-top" alt="Placeholder Image">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                        <?php the_title(); ?>
                    </a>
                </h5>
                <p class="card-text"><strong>Price:</strong> <?php echo esc_html($price); ?> USD</p>
                <p class="card-text"><strong>Location:</strong> <?php echo esc_html($location); ?></p>
            </div>
            <div class="card-footer text-center">
                <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
<?php }
// ===========================
//  END HOME CARD TEMPLATE
// ===========================