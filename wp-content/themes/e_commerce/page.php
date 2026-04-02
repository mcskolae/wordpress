<?php

get_header();
?>

<main id="main" class="site-main" style="padding:0;">

    <!-- En-tête de page -->
    <div class="page-hero">
        <div class="container">
            <p class="breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:rgba(255,255,255,.6);"><?php esc_html_e( 'Accueil', 'esgi' ); ?></a>
                &rsaquo; <?php the_title(); ?>
            </p>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>

    <div class="container" style="padding-top:60px;padding-bottom:60px;">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <div class="page-content" style="max-width:800px;margin:0 auto;background:var(--color-white);border-radius:16px;padding:48px;box-shadow:var(--shadow);">
                <?php the_content(); ?>
            </div>
            <?php
        endwhile;
        ?>
    </div>

</main>

<?php get_footer(); ?>
