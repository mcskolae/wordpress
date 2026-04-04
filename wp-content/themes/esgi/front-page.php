<?php get_header(); ?>

<main id="main" class="site-main" role="main">

    <section class="home-hero">
        <div class="home-hero__overlay"></div>
        <div class="container home-hero__inner">
            <span class="home-hero__eyebrow"><?php esc_html_e('Collection', 'esgi'); ?> <?php echo esc_html(gmdate('Y')); ?></span>
            <h1 class="home-hero__title">
                BORN IN<br><em>THE STREETS</em>
            </h1>
            <p class="home-hero__sub"><?php esc_html_e('Streetwear authentique, taillé pour ceux qui ne rentrent pas dans les cases.', 'esgi'); ?></p>
            <div class="home-hero__actions">
                <?php if (function_exists('wc_get_page_id')): ?>
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--primary">
                        Shop now
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--ghost">Voir la boutique</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if (class_exists('WooCommerce')): ?>
    <section class="home-drops">
        <div class="container">
            <header class="home-drops__header">
                <h2>Nouveaux drops</h2>
                <?php if (function_exists('wc_get_page_id')): ?>
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="home-drops__link">Tout voir →</a>
                <?php endif; ?>
            </header>
            <?php echo do_shortcode('[recent_products limit="4" columns="4" orderby="date" order="DESC"]'); ?>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
