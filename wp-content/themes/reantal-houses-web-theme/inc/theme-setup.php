<?php
/**
 * ============================================================
 *  THEME SETUP: CUSTOM POST TYPE & TAXONOMIES
 *  CONFIGURAZIONE DEL TEMA: CPT E TASSONOMIE
 * ------------------------------------------------------------
 *  Registra il Custom Post Type "home" e le relative
 *  tassonomie personalizzate. Aggiunge il supporto alle immagini
 *  in evidenza per i post.
 *
 *  Registers the "home" Custom Post Type and its related custom
 *  taxonomies. Enables support for post thumbnails.
 * ============================================================
 */
function rental_homes_setup() {

    // Enable featured images
    // Abilita immagini in evidenza
    add_theme_support('post-thumbnails');

    /**
     * --------------------------------------------
     *  REGISTER CUSTOM POST TYPE: HOME
     *  REGISTRAZIONE CUSTOM POST TYPE: HOME
     * --------------------------------------------
     */
    register_post_type('home', [
        'label'         => 'Homes',
        'public'        => true,
        'supports'      => ['title', 'editor', 'thumbnail'],
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'free-now'], // URL base
    ]);

    /**
     * --------------------------------------------
     *  REGISTER TAXONOMY: HOME TYPES
     *  REGISTRAZIONE TASSONOMIA: TIPOLOGIE DI CASE
     * --------------------------------------------
     */
    register_taxonomy('home_types', 'home', [
        'label'        => 'Home Types',
        'public'       => true,
        'hierarchical' => false, // non gerarchica (come i tag)
        'rewrite'      => ['slug' => 'home-types'],
    ]);

    /**
     * --------------------------------------------
     *  REGISTER TAXONOMY: HOME CATEGORY
     *  REGISTRAZIONE TASSONOMIA: CATEGORIE DI CASE
     * --------------------------------------------
     */
    register_taxonomy('home_category', 'home', [
        'label'        => 'Home Categories',
        'public'       => true,
        'hierarchical' => true, // gerarchica (come le categorie)
        'rewrite'      => ['slug' => 'home-category'],
    ]);
}
add_action('init', 'rental_homes_setup');
?>