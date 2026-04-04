<?php
defined('ABSPATH') || exit;

get_header('shop');
?>

<main id="main" class="site-main">
    <div class="container">

        <?php while (have_posts()): the_post();

            echo '<nav class="woocommerce-breadcrumb" aria-label="Fil d\'Ariane">';
            woocommerce_breadcrumb();
            echo '</nav>';

            do_action('woocommerce_before_single_product');

            if (post_password_required()) {
                echo get_the_password_form(); // phpcs:ignore
                return;
            }
            ?>

            <div id="product-<?php the_ID(); ?>" <?php wc_product_class('', get_the_ID()); ?>>

                <?php do_action('woocommerce_before_single_product_summary'); ?>

                <div class="summary entry-summary">
                    <?php
                    do_action('woocommerce_single_product_summary');

                    echo '<div style="margin-top:24px;padding:20px;background:var(--color-bg);border-radius:var(--radius);display:flex;flex-wrap:wrap;gap:16px;">';
                    $guarantees = [
                        'Livraison gratuite dès 50 €',
                        'Retours sous 30 jours',
                        'Paiement sécurisé',
                    ];
                    foreach ($guarantees as $text) {
                        echo '<div style="display:flex;align-items:center;gap:8px;font-size:.85rem;color:var(--color-muted);">' . esc_html($text) . '</div>';
                    }
                    echo '</div>';
                    ?>
                </div>

                <?php do_action('woocommerce_after_single_product_summary'); ?>

            </div>

            <?php do_action('woocommerce_after_single_product'); ?>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer('shop'); ?>
