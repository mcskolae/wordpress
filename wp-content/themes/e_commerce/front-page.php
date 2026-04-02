<?php
get_header();
?>

<main id="main" class="site-main" style="padding:0;">

    <section class="hero" aria-label="<?php esc_attr_e('Présentation ESGI', 'esgi'); ?>">
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <?php esc_html_e('Collection Printemps 2025', 'esgi'); ?>
                </div>

                <h1><?php esc_html_e('Le Style Urbain,', 'esgi'); ?> <span><?php esc_html_e('Réinventé.', 'esgi'); ?></span></h1>

                <p><?php esc_html_e('Découvrez notre sélection exclusive de vêtements, accessoires et sneakers pour votre quotidien urbain. Qualité premium, livraison rapide.', 'esgi'); ?></p>

                <div class="hero-actions">
                    <?php if (function_exists('wc_get_page_id')) : ?>
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-primary">
                        <?php esc_html_e('Voir la boutique', 'esgi'); ?>
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('a-propos'))); ?>" class="btn btn-outline" style="color:#fff;border-color:rgba(255,255,255,.3);">
                        <?php esc_html_e('Notre histoire', 'esgi'); ?>
                    </a>
                </div>

                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-value">500+</div>
                        <div class="hero-stat-label"><?php esc_html_e('Produits', 'esgi'); ?></div>
                    </div>
                    <div>
                        <div class="hero-stat-value">12k+</div>
                        <div class="hero-stat-label"><?php esc_html_e('Clients satisfaits', 'esgi'); ?></div>
                    </div>
                    <div>
                        <div class="hero-stat-value">4.9★</div>
                        <div class="hero-stat-label"><?php esc_html_e('Note moyenne', 'esgi'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="features-strip">
        <div class="container">
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">🚚</div>
                    <h4><?php esc_html_e('Livraison gratuite', 'esgi'); ?></h4>
                    <p><?php esc_html_e('Dès 50 € d\'achat', 'esgi'); ?></p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🔄</div>
                    <h4><?php esc_html_e('Retours 30 jours', 'esgi'); ?></h4>
                    <p><?php esc_html_e('Satisfait ou remboursé', 'esgi'); ?></p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🔒</div>
                    <h4><?php esc_html_e('Paiement sécurisé', 'esgi'); ?></h4>
                    <p><?php esc_html_e('SSL & 3D Secure', 'esgi'); ?></p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">💬</div>
                    <h4><?php esc_html_e('Support 7j/7', 'esgi'); ?></h4>
                    <p><?php esc_html_e('Équipe disponible', 'esgi'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if (function_exists('wc_get_page_id')) : ?>
    <section class="section section-alt" aria-label="<?php esc_attr_e('Produits en vedette', 'esgi'); ?>">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Nouveautés & Tendances', 'esgi'); ?></h2>
                <p><?php esc_html_e('Les dernières pièces de notre collection', 'esgi'); ?></p>
            </div>

            <?php echo do_shortcode('[products limit="8" columns="4" orderby="date" order="DESC"]'); ?>

            <div style="text-align:center;margin-top:40px;">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-primary">
                    <?php esc_html_e('Voir tous les produits', 'esgi'); ?>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="section" aria-label="<?php esc_attr_e('Catégories', 'esgi'); ?>">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Nos Univers', 'esgi'); ?></h2>
                <p><?php esc_html_e('Explorez nos catégories', 'esgi'); ?></p>
            </div>

            <?php
            $categories = get_terms([
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'number'     => 6,
                'exclude'    => [get_option('default_product_cat')],
            ]);

            if (!is_wp_error($categories) && !empty($categories)) :
            ?>
            <div class="products-grid">
                <?php foreach ($categories as $cat) :
                    $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    $image        = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'esgi-card') : '';
                    $link         = get_term_link($cat);
                ?>
                <a href="<?php echo esc_url($link); ?>" class="product-card category-card" style="display:block;text-decoration:none;">
                    <div style="height:180px;background:<?php echo $image ? 'url(' . esc_url($image) . ') center/cover' : 'var(--color-border)'; ?>;display:flex;align-items:flex-end;">
                        <div style="width:100%;padding:20px;background:linear-gradient(transparent,rgba(0,0,0,.7));color:#fff;">
                            <h3 style="font-size:1.1rem;color:#fff;margin:0;"><?php echo esc_html($cat->name); ?></h3>
                            <p style="font-size:.85rem;opacity:.8;margin:4px 0 0;"><?php echo esc_html($cat->count); ?> <?php esc_html_e('produits', 'esgi'); ?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
