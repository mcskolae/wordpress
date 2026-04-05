<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container blog-container">

        <h1 class="blog-title">Articles</h1>

        <?php if (have_posts()): ?>

            <div class="products-grid">
                <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('product-card'); ?>>

                    <?php if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('esgi-card'); ?>
                    </a>
                    <?php endif; ?>

                    <div class="product-card-body">
                        <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="blog-card-excerpt"><?php the_excerpt(); ?></p>
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
