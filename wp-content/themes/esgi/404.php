<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <div class="error-404">
            <div class="error-code" aria-hidden="true">404</div>
            <h1>Page introuvable</h1>
            <p>La page que vous cherchez n'existe pas ou a été déplacée.</p>

            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Retour à l'accueil</a>
                <?php if (function_exists('wc_get_page_id')): ?>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-outline">Voir la boutique</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
