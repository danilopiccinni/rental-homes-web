<?php
/**
 * ========================================================
 *  ACF FIELD GROUP: BOOKING DETAILS
 *  GRUPPO DI CAMPI ACF: DETTAGLI PRENOTAZIONE
 * --------------------------------------------------------
 *  Definisce i campi personalizzati per ogni prenotazione
 *  gestita tramite il CPT "booking".
 *
 *  Defines the custom fields for each booking handled
 *  via the "booking" custom post type.
 * ========================================================
 */

// Verifica se ACF è attivo prima di procedere
// Ensure ACF is active before registering fields
if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group([
        'key' => 'group_booking_details',
        'title' => 'Booking Details',

        // === CAMPI PERSONALIZZATI / CUSTOM FIELDS ===
        'fields' => [

            // Nome del cliente / Customer name
            [
                'key'     => 'field_booking_name',
                'label'   => 'Name',
                'name'    => 'booking_name',
                'type'    => 'text',
                'required'=> 1,
            ],

            // Email del cliente / Customer email
            [
                'key'     => 'field_booking_email',
                'label'   => 'Email',
                'name'    => 'booking_email',
                'type'    => 'email',
                'required'=> 1,
            ],

            // Data di check-in / Check-in date
            [
                'key'     => 'field_booking_checkin',
                'label'   => 'Check-in Date',
                'name'    => 'booking_checkin',
                'type'    => 'date_picker',
                'required'=> 1,
            ],

            // Data di check-out / Check-out date
            [
                'key'     => 'field_booking_checkout',
                'label'   => 'Check-out Date',
                'name'    => 'booking_checkout',
                'type'    => 'date_picker',
                'required'=> 1,
            ],

            // ID della casa associata / Linked home's ID
            [
                'key'     => 'field_booking_home_id',
                'label'   => 'Home ID',
                'name'    => 'booking_home_id',
                'type'    => 'number',
                'required'=> 1,
            ],

            // Prezzo totale della prenotazione / Total booking price
            [
                'key'     => 'field_booking_total',
                'label'   => 'Total Price',
                'name'    => 'booking_total',
                'type'    => 'number',
                'required'=> 1,
            ],
        ],

        // === POSIZIONE DEI CAMPI / FIELDS LOCATION ===
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'booking',
                ],
            ],
        ],
    ]);
}