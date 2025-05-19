<?php
/**
 * ============================================================
 *  DISPLAY CUSTOM TAXONOMIES FOR 'HOME' POST TYPE
 *  VISUALIZZAZIONE DELLE TASSONOMIE PERSONALIZZATE PER 'HOME'
 * ------------------------------------------------------------
 *  Contiene due funzioni per stampare a schermo le tassonomie
 *  personalizzate associate ai post di tipo "home":
 *  - Tipi di casa (home_types)
 *  - Categorie di casa (home_category)
 *
 *  Contains two functions to display custom taxonomies linked
 *  to the "home" post type:
 *  - Home Types (home_types)
 *  - Home Categories (home_category)
 * ============================================================
 */

/**
 * Display Home Types (home_types taxonomy)
 * ----------------------------------------
 * Stampa a schermo i termini associati alla tassonomia "home_types"
 * per il post corrente.
 *
 * Echoes a list of terms from the "home_types" taxonomy
 * for the current post.
 */
function display_home_types() {
    $home_types = wp_get_post_terms(get_the_ID(), 'home_types');

    if (!empty($home_types) && !is_wp_error($home_types)) {
        echo '<ul class="home-types">';
        foreach ($home_types as $type) {
            echo '<li>' . esc_html($type->name) . '</li>';
        }
        echo '</ul>';
    }
}

/**
 * Display Home Categories (home_category taxonomy)
 * ------------------------------------------------
 * Stampa a schermo i termini associati alla tassonomia "home_category"
 * per il post corrente.
 *
 * Echoes a list of terms from the "home_category" taxonomy
 * for the current post.
 */
function display_home_category() {
    $home_categories = wp_get_post_terms(get_the_ID(), 'home_category');

    if (!empty($home_categories) && !is_wp_error($home_categories)) {
        echo '<ul class="home-categories">';
        foreach ($home_categories as $category) {
            echo '<li>' . esc_html($category->name) . '</li>';
        }
        echo '</ul>';
    }
}
?>