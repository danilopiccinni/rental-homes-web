<?php
/**
 * ============================================================
 *  TGM PLUGIN ACTIVATION SETUP
 *  CONFIGURAZIONE TGM PER L'ATTIVAZIONE DEI PLUGIN
 * ------------------------------------------------------------
 *  Integra TGM Plugin Activation per richiedere automaticamente
 *  plugin fondamentali per il tema, come ACF.
 *
 *  Integrates TGM Plugin Activation to automatically require
 *  essential plugins for the theme, such as ACF.
 * ============================================================
 */

// Include the TGM Plugin Activation class
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';



/**
 * ============================================================
 *  REGISTER REQUIRED PLUGINS
 *  REGISTRAZIONE PLUGIN RICHIESTI
 * ------------------------------------------------------------
 *  Specifica i plugin obbligatori (o consigliati) che il tema
 *  necessita per funzionare correttamente.
 *
 *  Specifies required (or recommended) plugins the theme
 *  needs to function properly.
 * ============================================================
 */
add_action('tgmpa_register', 'rental_homes_register_required_plugins');

function rental_homes_register_required_plugins() {
    $plugins = [
        [
            'name'     => 'Advanced Custom Fields', // Nome visibile nel pannello
            'slug'     => 'advanced-custom-fields', // Slug della directory del plugin
            'required' => true,                     // Obbligatorio per il tema
        ]
    ];

    $config = [
        'id'           => 'rental_homes',                 // ID univoco per il tema
        'menu'         => 'tgmpa-install-plugins',        // Slug menu TGM
        'has_notices'  => true,                           // Mostra notifiche admin
        'dismissable'  => true,                           // Utente può nascondere il messaggio
        'is_automatic' => true,                           // Auto-attivazione dopo installazione
    ];

    tgmpa($plugins, $config);
}
?>