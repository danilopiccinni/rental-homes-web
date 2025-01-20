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
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-brands fa-wordpress"></i></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <!-- Link alla home page del sito / Link to the site's home page -->
                                <a class="nav-link active" aria-current="page" href="<?php echo site_url('/'); ?>">Home</a>
                            </li> 
                            <li class="nav-item">
                                <!-- Link alla pagina "free now" con slug "/home/" / Link to the "free now" page with slug "/home/" -->            
                                <a class="nav-link" href="<?php echo site_url('/home/'); ?>">Free now</a>
                            </li>
                            <li class="nav-item">
                                <!-- Link alla pagina "About" / Link to the "About" page -->           
                                <a class="nav-link" href="<?php echo site_url('/about/'); ?>">About</a>
                            </li>
                            <li class="nav-item">
                                <!-- Link alla pagina "Contact" / Link to the "Contact" page -->     
                                <a class="nav-link" href="<?php echo site_url('/contact/'); ?>">Contact</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Admin
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Login</a></li>
                                    <li><a class="dropdown-item" href="#">Support</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Copyright</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                            </li>
                        </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        

        <nav class="d-none">
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