<?php get_header(); ?>

<main id="main" class="site-main has-hero">

    <div class="page-hero">
        <div class="container">
            <h1>
                <?php
                if (is_category()) {
                    echo esc_html(single_cat_title('', false));
                } elseif (is_tag()) {
                    printf('Tag : %s', single_tag_title('', false));
                } elseif (is_author()) {
                    printf('Articles de %s', esc_html(get_the_author()));
                } elseif (is_date()) {
                    echo 'Archives';
                } else {
                    the_archive_title();
                }
                ?>
            </h1>
        </div>
    </div>

    <div class="container archive-container">

        <?php if (have_posts()): ?>

            <div class="products-grid">
                <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('product-card'); ?>>

                    <?php if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                        <?php the_post_thumbnail('esgi-card'); ?>
                    </a>
                    <?php endif; ?>

                    <div class="product-card-body">
                        <p class="archive-card-meta">
                            <?php echo esc_html(get_the_date()); ?>
                            &bull;
                            <?php echo esc_html(get_the_category_list(', ')); ?>
                        </p>
                        <h3 class="archive-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="archive-card-excerpt"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-outline archive-card-link">Lire la suite</a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <div class="archive-pagination">
                <?php
                the_posts_pagination([
                    'prev_text' => '&larr; Précédent',
                    'next_text' => 'Suivant &rarr;',
                ]);
                ?>
            </div>

        <?php else: ?>
            <p class="archive-empty">Aucun article trouvé.</p>
        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>
