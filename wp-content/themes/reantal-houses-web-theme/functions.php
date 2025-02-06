<?php


function ajax_search() {

    // Verifica se il parametro 'search' è stato inviato / Check if the 'search' parameter was sent
    if (!isset($_POST['search']) || empty($_POST['search'])) {
        wp_send_json_error("No search term provided."); // Restituisce un errore se il termine di ricerca è vuoto / Return an error if the search term is empty
        wp_die(); // Termina l'esecuzione dello script / Stop script execution
    }

    $search_term = sanitize_text_field($_POST['search']); // Sanifica il termine di ricerca / Sanitize the search term

    $args = [
        'post_type' => 'home', // Cerca solo nei post di tipo 'home' / Search only in 'home' post type
        'posts_per_page' => -1, // Recupera tutti i risultati disponibili / Retrieve all available results
        'meta_query' => [
            [
                'key'   => 'availability', // Controlla il campo 'availability' / Check the 'availability' field
                'value' => 1, // Deve essere uguale a 1 (disponibile) / Must be 1 (available)
                'compare' => '=' // Confronta il valore esattamente con 1 / Compare exactly with 1
            ]
        ],
        's' => $search_term // Cerca il termine nel titolo e nella descrizione / Search in title and description
    ];

    $query = new WP_Query($args); // Esegue la query con i parametri sopra / Execute the query with the above parameters

    if ($query->have_posts()) : 
        while ($query->have_posts()) : $query->the_post();

            generate_small_home_card(); // Genera la card per ogni casa trovata / Generate a card for each found home

        endwhile;
    else :
        echo '<p class="text-center">No results found.</p>'; // Messaggio se nessuna casa è trovata / Message if no home is found
    endif;

    wp_die(); // Termina l'esecuzione dello script / Stop script execution
}

// Registra l'azione AJAX per utenti loggati e non loggati / Register AJAX action for logged-in and non-logged-in users
add_action('wp_ajax_ajax_search', 'ajax_search'); 
add_action('wp_ajax_nopriv_ajax_search', 'ajax_search');


// Funzione per generare una card per ogni casa trovata / Function to generate a card for each found home
function generate_small_home_card() {
    
    // Recupera i metadati della casa / Retrieve home metadata
    $price = get_post_meta(get_the_ID(), 'price', true); // Prezzo / Price
    $location = get_post_meta(get_the_ID(), 'location', true); // Posizione / Location
    $image = get_field('image'); // Immagine della casa / Home image

    ?>

    <div class="col">
        <div class="card h-100">
            <?php if ($image) : ?>
                <!-- Mostra l'immagine della casa se disponibile / Show home image if available -->
                <img style="width: 100%; height: 200px; object-fit: cover;" src="<?php echo esc_url($image); ?>" class="card-img-top" alt="Home Image">
            <?php else : ?>
                <!-- Se non c'è un'immagine, usa un placeholder / If no image, use a placeholder -->
                <img style="width: 100%; height: 200px; object-fit: cover;" src="https://via.placeholder.com/600x400" class="card-img-top" alt="Placeholder Image">
            <?php endif; ?>

            <div class="card-body">
                <h5 class="card-title">
                    <!-- Titolo della casa con link al dettaglio / Home title with link to details -->
                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                        <?php the_title(); ?>
                    </a>
                </h5>
                <p class="card-text"><strong>Price:</strong> <?php echo esc_html($price); ?> USD</p> <!-- Mostra il prezzo / Show price -->
                <p class="card-text"><strong>Location:</strong> <?php echo esc_html($location); ?></p> <!-- Mostra la posizione / Show location -->
            </div>

            <div class="card-footer text-center">
                <!-- Pulsante per visualizzare i dettagli della casa / Button to view home details -->
                <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>

    <?php
}



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