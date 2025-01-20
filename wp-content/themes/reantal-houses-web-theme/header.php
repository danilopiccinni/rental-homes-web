<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"> <!-- Imposta il set di caratteri per il sito / Sets the character set for the site -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Rende il sito responsivo sui dispositivi mobili / Makes the site responsive on mobile devices -->
    <title><?php bloginfo('name'); ?></title> <!-- Mostra il nome del sito come titolo della pagina / Displays the site name as the page title -->
    <?php wp_head(); ?> <!-- Carica gli script e gli stili aggiunti dal tema o dai plugin / Loads scripts and styles added by the theme or plugins -->
</head>
<body <?php body_class(); ?>> <!-- Aggiunge classi specifiche al tag <body> in base al contesto della pagina / Adds specific classes to the <body> tag based on the page context -->
    <header>
        <nav>
            <ul class="d-flex justify-content-center gap-5">
                <!-- Link alla home page del sito / Link to the site's home page -->
                <li><i class="fa-brands fa-wordpress"></i><a href="<?php echo site_url('/'); ?>">Home</a></li> 

                <!-- Link alla pagina "free now" con slug "/home/" / Link to the "free now" page with slug "/home/" -->
                <li><a href="<?php echo site_url('/home/'); ?>">free now</a></li> 

                <!-- Link alla pagina "About" / Link to the "About" page -->
                <li><a href="<?php echo site_url('/about/'); ?>">About</a></li> 

                <!-- Link alla pagina "Contact" / Link to the "Contact" page -->
                <li><a href="<?php echo site_url('/contact/'); ?>">Contact</a></li> 
            </ul>
        </nav>
    </header>