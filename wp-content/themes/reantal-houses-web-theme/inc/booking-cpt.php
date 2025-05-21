<?php
/**
 * ========================================================
 *  CUSTOM POST TYPE: BOOKING
 *  TIPO DI POST PERSONALIZZATO: PRENOTAZIONE
 * --------------------------------------------------------
 *  Registra un tipo di post personalizzato per gestire
 *  le prenotazioni delle case. Ogni prenotazione include
 *  dati come utente, casa, date e stato.
 *
 *  Registers a custom post type for managing house
 *  bookings. Each booking stores data like user,
 *  property, dates, and status.
 * ========================================================
 */

/**
 * ========================================================
 *  REGISTER BOOKING CUSTOM POST TYPE
 *  REGISTRAZIONE DEL TIPO DI POST PERSONALIZZATO 'BOOKING'
 * --------------------------------------------------------
 *  Crea un tipo di post non pubblico utilizzato per tracciare
 *  e gestire le prenotazioni da backend.
 *
 *  Creates a non-public custom post type used to track
 *  and manage bookings from the admin interface.
 * ========================================================
 */
function rental_homes_register_booking_cpt() {

    register_post_type('booking', [

        // Etichetta principale per il menu e l'amministrazione
        // Main label for the admin menu and management
        'label' => __('Bookings', 'rental_homes'),

        // Non visibile pubblicamente sul frontend
        // Not publicly accessible from frontend
        'public' => false,

        // Visibile nella dashboard di WordPress
        // Displayed in the WordPress admin UI
        'show_ui' => true,

        // Campi supportati: titolo e campi personalizzati
        // Supported features: title and custom fields
        'supports' => ['title', 'custom-fields'],

        // Icona del menu (icona calendario)
        // Menu icon (calendar icon)
        'menu_icon' => 'dashicons-calendar-alt',

        // Etichette localizzate per l'interfaccia utente
        // Localized labels for admin interface
        'labels' => [
            'name'               => __('Bookings', 'rental_homes'),
            'singular_name'      => __('Booking', 'rental_homes'),
            'add_new_item'       => __('Add New Booking', 'rental_homes'),
            'edit_item'          => __('Edit Booking', 'rental_homes'),
        ],
    ]);
}

// Hook di inizializzazione per la registrazione del CPT
// Initialization hook for CPT registration
add_action('init', 'rental_homes_register_booking_cpt');