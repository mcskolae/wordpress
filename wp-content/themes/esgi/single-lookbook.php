<?php get_header(); ?>

<main id="main" class="site-main has-hero">

    <?php while (have_posts()): the_post(); ?>

    <div class="page-hero">
        <div class="container">
            <p class="breadcrumb">
                <a href="<?php echo esc_url(get_post_type_archive_link('lookbook')); ?>"><?php esc_html_e('Lookbook', 'esgi'); ?></a>
                &rsaquo; <?php the_title(); ?>
            </p>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>

    <section class="section">
        <div class="container">

            <article id="post-<?php the_ID(); ?>">

                <?php if (has_post_thumbnail()): ?>
                <div class="look-image">
                    <?php the_post_thumbnail('esgi-hero'); ?>
                </div>
                <?php endif; ?>

                <?php
                $stylist       = get_post_meta(get_the_ID(), '_look_stylist', true);
                $season        = get_post_meta(get_the_ID(), '_look_season', true);
                $season_labels = ['spring' => 'Printemps/Été', 'fall' => 'Automne/Hiver', 'capsule' => 'Capsule'];
                ?>

                <?php if ($season || $stylist): ?>
                <div class="look-meta">
                    <?php if ($season): ?>
                    <span class="look-meta__season"><?php echo esc_html($season_labels[$season] ?? $season); ?></span>
                    <?php endif; ?>
                    <?php if ($stylist): ?>
                    <span class="look-meta__stylist">✍️ <?php echo esc_html($stylist); ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if (get_the_content()): ?>
                <div class="look-description entry-content">
                    <?php the_content(); ?>
                </div>
                <?php endif; ?>

                <?php
                $product_ids = array_filter(array_map('intval', explode(',', get_post_meta(get_the_ID(), '_look_product_ids', true))));
                if (!empty($product_ids)):
                    $products = wc_get_products(['include' => $product_ids, 'status' => 'publish', 'limit' => -1]);
                ?>
                <div class="look-products">
                    <h2 class="look-products__title"><?php esc_html_e('Les pièces du look', 'esgi'); ?></h2>
                    <div class="products-grid">
                        <?php foreach ($products as $product): ?>
                        <article class="product-card">
                            <a href="<?php echo esc_url($product->get_permalink()); ?>" aria-label="<?php echo esc_attr($product->get_name()); ?>">
                                <?php echo $product->get_image('esgi-card'); ?>
                            </a>
                            <div class="product-card-body">
                                <h3 class="look-product-name">
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>">
                                        <?php echo esc_html($product->get_name()); ?>
                                    </a>
                                </h3>
                                <p class="price"><?php echo wp_kses_post($product->get_price_html()); ?></p>
                                <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="btn btn-primary" <?php echo $product->supports('ajax_add_to_cart') ? 'data-product_id="' . esc_attr($product->get_id()) . '" data-quantity="1"' : ''; ?>>
                                    <?php echo esc_html($product->add_to_cart_text()); ?>
                                </a>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </article>

            <nav class="look-nav">
                <?php
                $prev = get_previous_post();
                $next = get_next_post();
                if ($prev): ?>
                <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="btn btn-outline">
                    &larr; <?php echo esc_html(get_the_title($prev)); ?>
                </a>
                <?php endif;
                if ($next): ?>
                <a href="<?php echo esc_url(get_permalink($next)); ?>" class="btn btn-outline">
                    <?php echo esc_html(get_the_title($next)); ?> &rarr;
                </a>
                <?php endif; ?>
            </nav>

        </div>
    </section>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
