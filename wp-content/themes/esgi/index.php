<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container" style="max-width:900px;">

        <h1 style="margin-bottom:40px;">Articles</h1>

        <?php if (have_posts()): ?>

            <div class="products-grid">
                <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('product-card'); ?>>

                    <?php if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('esgi-card', ['style' => 'width:100%;height:200px;object-fit:cover;']); ?>
                    </a>
                    <?php endif; ?>

                    <div class="product-card-body">
                        <h3 style="font-size:1rem;"><a href="<?php the_permalink(); ?>" style="color:var(--color-primary);"><?php the_title(); ?></a></h3>
                        <p style="font-size:.85rem;color:var(--color-muted);"><?php the_excerpt(); ?></p>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(); ?>

        <?php else: ?>
            <p>Aucun contenu disponible.</p>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
