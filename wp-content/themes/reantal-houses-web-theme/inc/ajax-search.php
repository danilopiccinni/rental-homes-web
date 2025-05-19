<?php
/**
 * ============================================================
 *  AJAX SEARCH HANDLER FOR 'HOME' POST TYPE
 *  GESTIONE RICERCA AJAX PER IL TIPO DI POST 'HOME'
 * ------------------------------------------------------------
 *  Questa funzione gestisce le richieste AJAX inviate dal
 *  frontend per cercare case filtrando per disponibilità,
 *  parole chiave e intervallo di prezzo.
 *
 *  This function handles AJAX requests from the frontend to
 *  search for homes filtered by availability, keywords,
 *  and price range.
 * ============================================================
 */

function ajax_search() {
    $args = [
        'post_type'      => 'home',
        'posts_per_page' => -1,
        'meta_query'     => [
            [
                'key'     => 'availability',
                'value'   => 1,
                'compare' => '='
            ]
        ]
    ];

    // Keyword search
    if (!empty($_POST['search'])) {
        $args['s'] = sanitize_text_field($_POST['search']);
    }

    // Minimum price filter
    if (!empty($_POST['price_min'])) {
        $args['meta_query'][] = [
            'key'     => 'price',
            'value'   => sanitize_text_field($_POST['price_min']),
            'type'    => 'NUMERIC',
            'compare' => '>='
        ];
    }

    // Maximum price filter
    if (!empty($_POST['price_max'])) {
        $args['meta_query'][] = [
            'key'     => 'price',
            'value'   => sanitize_text_field($_POST['price_max']),
            'type'    => 'NUMERIC',
            'compare' => '<='
        ];
    }

    // Execute the query
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            generate_small_home_card();
        endwhile;
    else :
        echo '<p class="text-center">No results found.</p>';
    endif;

    wp_die(); // Termina correttamente la chiamata AJAX
}
add_action('wp_ajax_ajax_search', 'ajax_search');           // Logged-in users
add_action('wp_ajax_nopriv_ajax_search', 'ajax_search');    // Guests (not logged in)
?>