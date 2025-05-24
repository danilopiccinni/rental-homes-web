<?php
/**
 * ========================================================
 *  FRONTEND BOOKING FORM
 *  FORM DI PRENOTAZIONE FRONTEND
 * --------------------------------------------------------
 *  Visualizza un form per prenotare una casa direttamente
 *  dalla pagina del singolo post "home".
 *
 *  Displays a form to book a house directly from the
 *  single "home" post page.
 * ========================================================
 */

// Start session if not already active / Avvia sessione se non già attiva
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Recupera dati dalla sessione / Retrieve data from session
$home_id = get_the_ID();
$old     = $_SESSION['booking_old']     ?? [];
$errors  = $_SESSION['booking_errors']  ?? [];
$success = $_SESSION['booking_success'] ?? null;
$warning = $_SESSION['booking_warning'] ?? null;

// Rimuove i dati dalla sessione per evitare duplicazioni / Cleanup
unset($_SESSION['booking_errors'], $_SESSION['booking_success'], $_SESSION['booking_warning']);

// Mappa errori per campo / Field error mapping
$field_errors = [
    'booking_name'     => [],
    'booking_email'    => [],
    'booking_checkin'  => [],
    'booking_checkout' => [],
];

// Assegna errori ai rispettivi campi / Assign errors to fields
foreach ($errors as $error) {
    if (stripos($error, 'name') !== false) {
        $field_errors['booking_name'][] = $error;
    }
    if (stripos($error, 'email') !== false) {
        $field_errors['booking_email'][] = $error;
    }
    if (stripos($error, 'check-in') !== false || stripos($error, 'checkin') !== false) {
        $field_errors['booking_checkin'][] = $error;
    }
    if (stripos($error, 'check-out') !== false || stripos($error, 'checkout') !== false) {
        $field_errors['booking_checkout'][] = $error;
    }
}
?>

<!-- ==============================================
     MESSAGGI GLOBALI (ERRORI / SUCCESSO / AVVISO)
     GLOBAL MESSAGES (ERROR / SUCCESS / WARNING)
     ============================================== -->
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        <h5 class="mb-2">Booking Error(s)</h5>
        <ul class="mb-0">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo esc_html($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif (!empty($warning)) : ?>
    <div class="alert alert-warning">
        <h5 class="mb-2">Notice</h5>
        <?php echo esc_html($warning); ?>
    </div>
<?php elseif (!empty($success)) : ?>
    <div class="alert alert-success">
        <h5 class="mb-2">Success</h5>
        <?php echo esc_html($success); ?>
    </div>
<?php endif; ?>

<!-- =============================
     FORM DI PRENOTAZIONE
     BOOKING FORM
     ============================= -->
<form id="booking-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <?php wp_nonce_field('submit_booking_nonce_action', 'submit_booking_nonce_field'); ?>

    <input type="hidden" name="action" value="submit_booking">
    <input type="hidden" name="home_id" value="<?php echo esc_attr($home_id); ?>">

    <!-- NOME / NAME -->
    <div class="mb-3">
        <label for="booking_name" class="form-label">Name / Nome:</label>
        <input type="text"
               id="booking_name"
               name="booking_name"
               class="form-control <?php echo !empty($field_errors['booking_name']) ? 'is-invalid' : ''; ?>"
               required
               value="<?php echo esc_attr($old['name'] ?? ''); ?>">
        <?php if (!empty($field_errors['booking_name'])) : ?>
            <div class="invalid-feedback">
                <?php echo esc_html(implode(' ', $field_errors['booking_name'])); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- EMAIL -->
    <div class="mb-3">
        <label for="booking_email" class="form-label">Email:</label>
        <input type="email"
               id="booking_email"
               name="booking_email"
               class="form-control <?php echo !empty($field_errors['booking_email']) ? 'is-invalid' : ''; ?>"
               required
               value="<?php echo esc_attr($old['email'] ?? ''); ?>">
        <?php if (!empty($field_errors['booking_email'])) : ?>
            <div class="invalid-feedback">
                <?php echo esc_html(implode(' ', $field_errors['booking_email'])); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- CHECK-IN -->
    <div class="mb-3">
        <label for="booking_checkin" class="form-label">Check-in Date / Data di arrivo:</label>
        <input type="date"
               id="booking_checkin"
               name="booking_checkin"
               class="form-control <?php echo !empty($field_errors['booking_checkin']) ? 'is-invalid' : ''; ?>"
               required
               value="<?php echo esc_attr($old['checkin'] ?? ''); ?>">
        <?php if (!empty($field_errors['booking_checkin'])) : ?>
            <div class="invalid-feedback">
                <?php echo esc_html(implode(' ', $field_errors['booking_checkin'])); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- CHECK-OUT -->
    <div class="mb-3">
        <label for="booking_checkout" class="form-label">Check-out Date / Data di partenza:</label>
        <input type="date"
               id="booking_checkout"
               name="booking_checkout"
               class="form-control <?php echo !empty($field_errors['booking_checkout']) ? 'is-invalid' : ''; ?>"
               required
               value="<?php echo esc_attr($old['checkout'] ?? ''); ?>">
        <?php if (!empty($field_errors['booking_checkout'])) : ?>
            <div class="invalid-feedback">
                <?php echo esc_html(implode(' ', $field_errors['booking_checkout'])); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- INVIO / SUBMIT -->
    <button type="submit" class="btn btn-primary">
        Book Now / Prenota Ora
    </button>
</form>
