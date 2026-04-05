<?php get_header(); ?>

<main id="main" class="site-main has-hero" style="padding:0;">

    <div class="page-hero">
        <div class="container">
            <p class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Accueil', 'esgi'); ?></a>
                &rsaquo; <?php esc_html_e('Lookbook', 'esgi'); ?>
            </p>
            <h1><?php esc_html_e('Lookbook', 'esgi'); ?></h1>
            <p class="lookbook-hero-subtitle"><?php esc_html_e('Nos inspirations style & tenues de la saison', 'esgi'); ?></p>
        </div>
    </div>

    <section class="section">
        <div class="container">

            <?php if (have_posts()): ?>
            <div class="products-grid">
                <?php while (have_posts()): the_post();
                    $season  = get_post_meta(get_the_ID(), '_look_season', true);
                    $stylist = get_post_meta(get_the_ID(), '_look_stylist', true);
                    $season_labels = ['spring' => 'Printemps/Été', 'fall' => 'Automne/Hiver', 'capsule' => 'Capsule'];
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('product-card'); ?>>

                    <?php if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('esgi-card'); ?>
                    </a>
                    <?php endif; ?>

                    <div class="product-card-body">
                        <?php if ($season): ?>
                        <span class="lookbook-card-season">
                            <?php echo esc_html($season_labels[$season] ?? $season); ?>
                        </span>
                        <?php endif; ?>

                        <h3 class="lookbook-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <?php if ($stylist): ?>
                        <p class="lookbook-card-stylist">✍️ <?php echo esc_html($stylist); ?></p>
                        <?php endif; ?>

                        <a href="<?php the_permalink(); ?>" class="btn btn-outline lookbook-card-link">
                            <?php esc_html_e('Voir le look', 'esgi'); ?>
                        </a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(); ?>

            <?php else: ?>
            <p class="lookbook-empty">
                <?php esc_html_e('Aucun look disponible pour le moment.', 'esgi'); ?>
            </p>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>
