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
    // Abilita il supporto per immagini in evidenza nei post e nei custom post types
    // Enable support for featured images in posts and custom post types
    add_theme_support('post-thumbnails');

    // Registrazione del Custom Post Type "Home"
    // Register the Custom Post Type "Home"
    register_post_type('home', [
        'label' => 'Homes', // Nome visibile nella dashboard / Name visible in the dashboard
        'public' => true, // Il post type è accessibile nel frontend e nel backend / The post type is accessible in the frontend and backend
        'supports' => ['title', 'editor', 'thumbnail'], // Elementi supportati come titolo, contenuto e immagine in evidenza / Supported elements like title, content, and featured image
        'has_archive' => true, // Abilita una pagina archivio per i post di questo tipo / Enables an archive page for this post type
        'rewrite' => ['slug' => 'free-now'], // Slug personalizzato per gli URL dei post / Custom slug for post URLs
    ]);

    // Registrazione della tassonomia personalizzata "home_types"
    // Register the custom taxonomy "home_types"
    register_taxonomy('home_types', 'home', [
        'label' => 'Home Types', // Nome della tassonomia / Taxonomy label
        'public' => true, // Rende la tassonomia accessibile nel backend e nel frontend / Makes the taxonomy accessible in the backend and frontend
        'hierarchical' => false, // NON GERARCHICO → Funziona come un tag (selezione multipla possibile, ma limitata nel codice) /  NOT HIERARCHICAL → Works like a tag (multiple selections possible, but limited in code)
        'rewrite' => ['slug' => 'home-types'], // Slug personalizzato per gli URL della tassonomia / Custom slug for taxonomy URLs
    ]);

    // Registrazione della tassonomia personalizzata "home_category"
    // Register the custom taxonomy "home_category"
    register_taxonomy('home_category', 'home', [
        'label' => 'Home Categories', // Nome della tassonomia / Taxonomy label
        'public' => true, // Rende la tassonomia accessibile nel backend e nel frontend / Makes the taxonomy accessible in the backend and frontend
        'hierarchical' => true, // GERARCHICO → Funziona come le categorie (selezione multipla possibile con struttura ad albero) / HIERARCHICAL → Works like categories (multiple selections possible with a tree structure)
        'rewrite' => ['slug' => 'home-category'], // Slug personalizzato per gli URL della tassonomia / Custom slug for taxonomy URLs
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

// Aggiunta della categoria alle pagine per poterla visualizzare nel frontend
// Add category to pages so it can be displayed in the frontend
function display_home_category() {
    // Recupera le categorie assegnate al post corrente
    // Get the categories assigned to the current post
    $home_categories = wp_get_post_terms(get_the_ID(), 'home_category');

    // Se ci sono categorie, le visualizza
    // If there are categories, display them
    if (!empty($home_categories) && !is_wp_error($home_categories)) {
        echo '<ul class="home-categories">';
        foreach ($home_categories as $category) {
            // Escapa e mostra il nome della categoria
            // Escape and display the category name
            echo '<li>' . esc_html($category->name) . '</li>';
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