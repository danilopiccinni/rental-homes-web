<?php
/**
 * ============================================================
 *  GENERIC PAGE TEMPLATE
 *  TEMPLATE GENERICO PER PAGINE STATICHE
 * ------------------------------------------------------------
 *  Template di fallback per tutte le pagine statiche create
 *  dal backend, se non viene specificato un template più
 *  dettagliato (es. page-about.php, page-contact.php).
 *
 *  Fallback template for all static pages created from the
 *  WordPress backend, if no more specific template is set
 *  (e.g. page-about.php, page-contact.php).
 * ============================================================
 */
get_template_part('template-parts/header');  // Includi l'header del tema WordPress / Include the WordPress theme header
if (have_posts()) :
    while (have_posts()) : the_post();
        ?>
        <main>
            <h1><?php the_title(); ?></h1>
            <div><?php the_content(); ?></div>
        </main>
        <?php
    endwhile;
else :
    ?>
    <main>
        <h1>Pagina non trovata</h1>
        <p>La pagina che stai cercando non esiste o è stata rimossa.</p>
    </main>
    <?php
endif;
get_template_part('template-parts/footer'); // Includi il footer del tema WordPress / Include the WordPress theme footer