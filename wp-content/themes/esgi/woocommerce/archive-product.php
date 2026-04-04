<?php
defined('ABSPATH') || exit;

get_header('shop');
?>

<div class="shop-header">
    <div class="container">
        <h1><?php woocommerce_page_title(); ?></h1>
        <?php
        if (is_product_category()) {
            $desc = term_description();
            if ($desc) echo '<p>' . wp_kses_post($desc) . '</p>';
        } else {
            echo '<p>Découvrez toute notre collection streetwear</p>';
        }
        ?>
    </div>
</div>

<main id="main" class="site-main" style="padding:0;">
    <div class="container">
        <div class="shop-layout">

            <aside class="shop-sidebar" aria-label="Filtres boutique">

                <div class="sidebar-widget">
                    <h3>Recherche</h3>
                    <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="hidden" name="post_type" value="product">
                        <div style="display:flex;gap:8px;">
                            <input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>"
                                placeholder="Rechercher..."
                                style="flex:1;padding:10px 12px;border:2px solid var(--color-border);border-radius:var(--radius);font-family:var(--font-base);">
                            <button type="submit" style="padding:10px 14px;background:var(--color-accent);color:#fff;border:none;border-radius:var(--radius);cursor:pointer;">→</button>
                        </div>
                    </form>
                </div>

                <div class="sidebar-widget">
                    <h3>Catégories</h3>
                    <?php
                    $cats = get_terms([
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => true,
                        'exclude'    => [get_option('default_product_cat')],
                    ]);
                    if (!is_wp_error($cats) && !empty($cats)):
                    ?>
                    <ul style="display:flex;flex-direction:column;gap:8px;">
                        <?php foreach ($cats as $cat):
                            $active = is_tax('product_cat', $cat->slug);
                        ?>
                        <li>
                            <a href="<?php echo esc_url(get_term_link($cat)); ?>"
                               style="display:flex;justify-content:space-between;align-items:center;color:<?php echo $active ? 'var(--color-accent)' : 'var(--color-primary)'; ?>;font-weight:<?php echo $active ? '700' : '400'; ?>;">
                                <?php echo esc_html($cat->name); ?>
                                <span style="background:var(--color-bg);padding:2px 8px;border-radius:100px;font-size:.75rem;color:var(--color-muted);"><?php echo absint($cat->count); ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>

                <?php if (is_active_sidebar('shop-sidebar')): ?>
                    <?php dynamic_sidebar('shop-sidebar'); ?>
                <?php endif; ?>

            </aside>

            <div class="shop-content">

                <?php if (woocommerce_product_loop()): ?>

                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
                        <?php woocommerce_result_count(); ?>
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>

                    <?php woocommerce_product_loop_start(); ?>

                        <?php while (have_posts()): ?>
                            <?php the_post(); ?>
                            <?php wc_get_template_part('content', 'product'); ?>
                        <?php endwhile; ?>

                    <?php woocommerce_product_loop_end(); ?>

                    <?php woocommerce_pagination(); ?>

                <?php else: ?>
                    <?php do_action('woocommerce_no_products_found'); ?>
                <?php endif; ?>

            </div>

        </div>
    </div>
</main>

<?php get_footer('shop'); ?>
