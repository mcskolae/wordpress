<?php
get_header();
?>

<main id="main" class="site-main" style="padding:0;">

    <div class="page-hero">
        <div class="container">
            <p class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,.6);"><?php esc_html_e('Accueil', 'esgi'); ?></a>
                &rsaquo; <?php esc_html_e('Lookbook', 'esgi'); ?>
            </p>
            <h1><?php esc_html_e('Lookbook', 'esgi'); ?></h1>
            <p style="opacity:.75;"><?php esc_html_e('Nos inspirations style & tenues de la saison', 'esgi'); ?></p>
        </div>
    </div>

    <section class="section">
        <div class="container">

            <?php if (have_posts()) : ?>
            <div class="products-grid">
                <?php while (have_posts()) : the_post();
                    $season  = get_post_meta(get_the_ID(), '_look_season', true);
                    $stylist = get_post_meta(get_the_ID(), '_look_stylist', true);
                    $season_labels = ['spring' => 'Printemps/Été', 'fall' => 'Automne/Hiver', 'capsule' => 'Capsule'];
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('product-card'); ?>>

                    <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('esgi-card', ['style' => 'width:100%;height:220px;object-fit:cover;']); ?>
                    </a>
                    <?php endif; ?>

                    <div class="product-card-body">
                        <?php if ($season) : ?>
                        <span style="font-size:.75rem;color:var(--color-accent);font-weight:700;text-transform:uppercase;letter-spacing:.5px;">
                            <?php echo esc_html($season_labels[$season] ?? $season); ?>
                        </span>
                        <?php endif; ?>

                        <h3 style="margin:4px 0 8px;">
                            <a href="<?php the_permalink(); ?>" style="color:var(--color-primary);"><?php the_title(); ?></a>
                        </h3>

                        <?php if ($stylist) : ?>
                        <p style="font-size:.85rem;color:var(--color-muted);">✍️ <?php echo esc_html($stylist); ?></p>
                        <?php endif; ?>

                        <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="margin-top:12px;font-size:.85rem;padding:8px 16px;">
                            <?php esc_html_e('Voir le look', 'esgi'); ?>
                        </a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(); ?>

            <?php else : ?>
            <p style="text-align:center;color:var(--color-muted);">
                <?php esc_html_e('Aucun look disponible pour le moment.', 'esgi'); ?>
            </p>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>
