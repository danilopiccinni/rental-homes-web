<?php
/**
 * ========================================================
 *  HANDLE BOOKING FORM SUBMISSION
 *  GESTIONE INVIO FORM DI PRENOTAZIONE
 * --------------------------------------------------------
 *  Riceve, valida e processa i dati del form di prenotazione
 *  inviato dal frontend. Crea un nuovo post di tipo "booking"
 *  se la validazione va a buon fine.
 *
 *  Receives, validates and processes booking form data from
 *  the frontend. Creates a new "booking" post if validation passes.
 * ========================================================
 */

function handle_booking_form_submission() {
    // Avvia la sessione PHP, se non già attiva
    // Start PHP session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Assicura che l'azione sia quella attesa
    // Ensure correct form action
    if (isset($_POST['action']) && $_POST['action'] === 'submit_booking') {

        // Verifica il nonce per la sicurezza
        // Verify nonce for security
        if (
            !isset($_POST['submit_booking_nonce_field']) ||
            !wp_verify_nonce($_POST['submit_booking_nonce_field'], 'submit_booking_nonce_action')
        ) {
            wp_die('Security check failed.');
        }

        // === RACCOLTA E SANIFICAZIONE DEI DATI / COLLECT & SANITIZE INPUT ===
        $home_id  = isset($_POST['home_id']) ? intval($_POST['home_id']) : 0;
        $name     = isset($_POST['booking_name']) ? sanitize_text_field($_POST['booking_name']) : '';
        $email    = isset($_POST['booking_email']) ? sanitize_email($_POST['booking_email']) : '';
        $checkin  = isset($_POST['booking_checkin']) ? sanitize_text_field($_POST['booking_checkin']) : '';
        $checkout = isset($_POST['booking_checkout']) ? sanitize_text_field($_POST['booking_checkout']) : '';

        // Salva i dati per ripopolare il form in caso di errore
        // Store old values for repopulation on error
        $_SESSION['booking_old'] = [
            'name'     => $name,
            'email'    => $email,
            'checkin'  => $checkin,
            'checkout' => $checkout,
        ];

        // === VALIDAZIONE DEI DATI / VALIDATE DATA ===
        $errors = validate_booking_data($home_id, $name, $email, $checkin, $checkout);

        if (!empty($errors)) {
            $_SESSION['booking_errors'] = $errors;
            wp_redirect(get_permalink($home_id));
            exit;
        }

        // === VERIFICA CONFLITTI DI DISPONIBILITÀ / CHECK FOR DATE CONFLICTS ===
        if (is_booking_conflict($home_id, $checkin, $checkout)) {
            $_SESSION['booking_errors'] = [
                'Sorry, this home is already booked for the selected dates. Please choose another period.'
            ];
            wp_redirect(get_permalink($home_id));
            exit;
        }

        // === CREAZIONE DEL POST DI PRENOTAZIONE / CREATE BOOKING POST ===
        $booking_post = [
            'post_title'  => sprintf('Booking for Home ID %d by %s', $home_id, $name),
            'post_status' => 'publish',
            'post_type'   => 'booking',
        ];

        $booking_id = wp_insert_post($booking_post);

        if ($booking_id && !is_wp_error($booking_id)) {

            // === SALVATAGGIO METADATI / SAVE BOOKING METADATA ===
            update_post_meta($booking_id, 'home_id',         $home_id);
            update_post_meta($booking_id, 'customer_name',   $name);
            update_post_meta($booking_id, 'customer_email',  $email);
            update_post_meta($booking_id, 'checkin_date',    $checkin);
            update_post_meta($booking_id, 'checkout_date',   $checkout);

            // Messaggio di successo / Success message
            $_SESSION['booking_success'] = 'Booking submitted successfully!';

            // Pulisce i vecchi dati / Clear old data
            unset($_SESSION['booking_old']);

            wp_redirect(get_permalink($home_id));
            exit;

        } else {
            // Errore in fase di inserimento / Insert error
            $_SESSION['booking_errors'] = [
                'An unexpected error occurred. Please try again later.'
            ];
            wp_redirect(get_permalink($home_id));
            exit;
        }
    }
}
// Hook per utenti loggati e non / Hooks for both logged-in and guest users
add_action('admin_post_nopriv_submit_booking', 'handle_booking_form_submission');
add_action('admin_post_submit_booking', 'handle_booking_form_submission');


/**
 * ========================================================
 *  VALIDATE BOOKING DATA
 *  VALIDAZIONE DEI DATI DELLA PRENOTAZIONE
 * --------------------------------------------------------
 *  Controlla che tutti i campi richiesti siano presenti e
 *  che le date siano corrette (check-in < check-out e
 *  non nel passato).
 *
 *  Validates required fields and ensures that dates are
 *  well-formed, logical and not in the past.
 * ========================================================
 */
function validate_booking_data($home_id, $name, $email, $checkin, $checkout) {
    $errors = [];

    $checkin_ts  = strtotime($checkin);
    $checkout_ts = strtotime($checkout);
    $today_ts    = strtotime(date('Y-m-d'));

    // Controlli base / Basic checks
    if (!$home_id) {
        $errors[] = 'Invalid home ID.';
    }
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (empty($email)) {
        $errors[] = 'Email is required.';
    }
    if (empty($checkin)) {
        $errors[] = 'Check-in date is required.';
    }
    if (empty($checkout)) {
        $errors[] = 'Check-out date is required.';
    }

    // Formato date / Date format
    if ($checkin && !$checkin_ts) {
        $errors[] = 'Check-in date format is invalid.';
    }
    if ($checkout && !$checkout_ts) {
        $errors[] = 'Check-out date format is invalid.';
    }

    // Logica temporale / Logical checks
    if ($checkin_ts && $checkout_ts && $checkout_ts <= $checkin_ts) {
        $errors[] = 'Checkout must be after check-in.';
    }

    if ($checkin_ts && $checkin_ts < $today_ts) {
        $errors[] = 'Check-in date cannot be in the past.';
    }

    if ($checkout_ts && $checkout_ts < $today_ts) {
        $errors[] = 'Check-out date cannot be in the past.';
    }

    return $errors;
}


/**
 * ========================================================
 *  CHECK BOOKING CONFLICT
 *  VERIFICA SOVRAPPOSIZIONE DATE PRENOTAZIONE
 * --------------------------------------------------------
 *  Controlla se esiste già una prenotazione per la stessa
 *  casa in un intervallo di date che si sovrappone.
 *
 *  Checks if another booking exists for the same home
 *  with overlapping dates.
 * ========================================================
 */
function is_booking_conflict($home_id, $new_checkin, $new_checkout) {
    $args = [
        'post_type'      => 'booking',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'fields'         => 'ids', // Ottimizza la query / Optimize query
        'meta_query'     => [
            'relation' => 'AND',
            [
                'key'     => 'home_id',
                'value'   => $home_id,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
            [
                'key'     => 'checkin_date',
                'value'   => $new_checkout,
                'compare' => '<', // Inizio esistente < Fine nuova
                'type'    => 'DATE',
            ],
            [
                'key'     => 'checkout_date',
                'value'   => $new_checkin,
                'compare' => '>', // Fine esistente > Inizio nuova
                'type'    => 'DATE',
            ],
        ],
    ];

    $query = new WP_Query($args);
    return $query->have_posts();
}