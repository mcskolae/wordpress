<?php

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <div class="error-404">
            <div class="error-code" aria-hidden="true">404</div>
            <h1><?php esc_html_e( 'Page introuvable', 'esgi' ); ?></h1>
            <p><?php esc_html_e( 'Oups ! La page que vous cherchez n\'existe pas ou a été déplacée.', 'esgi' ); ?></p>

            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( 'Retour à l\'accueil', 'esgi' ); ?>
                </a>
                <?php if ( function_exists( 'wc_get_page_id' ) ) : ?>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-outline">
                    <?php esc_html_e( 'Voir la boutique', 'esgi' ); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
