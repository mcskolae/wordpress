<?php get_header(); ?>

<main id="main" class="site-main" style="padding:0;">

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

    <div class="container" style="padding:60px 20px;">

        <?php if (have_posts()): ?>

            <div class="products-grid">
                <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('product-card'); ?>>

                    <?php if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                        <?php the_post_thumbnail('esgi-card', ['style' => 'width:100%;height:220px;object-fit:cover;']); ?>
                    </a>
                    <?php endif; ?>

                    <div class="product-card-body">
                        <p style="font-size:.8rem;color:var(--color-muted);margin-bottom:6px;">
                            <?php echo esc_html(get_the_date()); ?>
                            &bull;
                            <?php echo esc_html(get_the_category_list(', ')); ?>
                        </p>
                        <h3 style="font-size:1.05rem;margin-bottom:10px;">
                            <a href="<?php the_permalink(); ?>" style="color:var(--color-primary);"><?php the_title(); ?></a>
                        </h3>
                        <p style="font-size:.9rem;color:var(--color-muted);margin-bottom:16px;"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="font-size:.85rem;padding:8px 16px;">Lire la suite</a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <div style="margin-top:48px;display:flex;justify-content:center;gap:8px;">
                <?php
                the_posts_pagination([
                    'prev_text' => '&larr; Précédent',
                    'next_text' => 'Suivant &rarr;',
                ]);
                ?>
            </div>

        <?php else: ?>
            <p style="text-align:center;color:var(--color-muted);">Aucun article trouvé.</p>
        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>
