<?php

// Bootstrap
function add_bootstrap_to_theme() {
    // Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');

    // Bootstrap JS Bundle (incluso Popper.js)
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'add_bootstrap_to_theme');

// Font Awesome
function enqueue_font_awesome() {
    // Font Awesome CSS
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Funzione per la configurazione iniziale del tema
// Function to set up the theme
function rental_homes_setup() {
    // Supporto per immagini in evidenza
    // Enable support for featured images
    add_theme_support('post-thumbnails');

    // Registrazione del Custom Post Type "Home"
    // Register the Custom Post Type "Home"
    register_post_type('home', [
        'label' => 'Homes', // Etichetta visibile per l'utente / User-visible label
        'public' => true, // Rende il post type pubblico / Makes the post type public
        'supports' => ['title', 'editor', 'thumbnail'], // Elementi supportati / Supported elements
        'has_archive' => true, // Abilita un archivio per i post / Enables an archive for posts
        'rewrite' => ['slug' => 'home'], // URL personalizzato per i post / Custom URL slug for posts
    ]);

    // Registrazione della tassonomia personalizzata "home_types"
    // Register the custom taxonomy "home_types"
    register_taxonomy('home_types', 'home', [
        'label' => 'Home Types', // Etichetta per la tassonomia / Taxonomy label
        'public' => true, // Rende la tassonomia pubblica / Makes the taxonomy public
        'rewrite' => ['slug' => 'home-types'], // URL personalizzato per la tassonomia / Custom URL slug for the taxonomy
    ]);
}
// Collegamento della funzione di configurazione al momento dell'inizializzazione
// Hook the setup function to the initialization process
add_action('init', 'rental_homes_setup');

// Aggiunta della tassonomia alle pagine per poterla visualizzare nel frontend
// Add taxonomy to pages so it can be displayed in the frontend
function display_home_types() {
    // Recupera le tipologie assegnate al post corrente
    // Get the types assigned to the current post
    $home_types = wp_get_post_terms(get_the_ID(), 'home_types');

    // Se ci sono tipologie, le visualizza
    // If there are types, display them
    if (!empty($home_types) && !is_wp_error($home_types)) {
        echo '<ul class="home-types">';
        foreach ($home_types as $type) {
            // Escapa e mostra il nome della tipologia
            // Escape and display the type name
            echo '<li>' . esc_html($type->name) . '</li>';
        }
        echo '</ul>';
    }
}

// Funzione per aggiungere supporto alla gestione dei menù
// Function to add support for menu management
function rental_homes_menus() {
    // Registrazione del menu di navigazione
    // Register the navigation menu
    register_nav_menus([
        'primary' => __('Primary Menu', 'rental_homes') // Nome del menu / Menu name
    ]);
}
// Collegamento della funzione di gestione dei menu all'evento di setup del tema
// Hook the menu setup function to the theme setup event
add_action('after_setup_theme', 'rental_homes_menus');

// Funzione per registrare e caricare gli script e gli stili
// Function to register and load scripts and styles
function rental_homes_assets() {
    // Carica il foglio di stile
    // Load the stylesheet
    wp_enqueue_style('rental_homes_style', get_stylesheet_uri());

    // Carica gli script JS (ad esempio, per il menu mobile)
    // Load the JS scripts (e.g., for the mobile menu)
    wp_enqueue_script('rental_homes_script', get_template_directory_uri() . '/js/main.js', [], false, true);
}
// Collegamento della funzione di registrazione degli asset all'evento degli script
// Hook the asset registration function to the scripts event
add_action('wp_enqueue_scripts', 'rental_homes_assets');
?>