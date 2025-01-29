<?php
get_header();
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
get_footer();