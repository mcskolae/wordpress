<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container single-post-container">

        <?php while (have_posts()): the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

            <header class="post-header">
                <p class="post-breadcrumb">
                    <a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
                    &rsaquo;
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('blog'))); ?>">Blog</a>
                    &rsaquo; <?php the_title(); ?>
                </p>

                <h1 class="post-title"><?php the_title(); ?></h1>

                <div class="post-info">
                    <span><?php echo esc_html(get_the_date()); ?></span>
                    <span><?php the_author(); ?></span>
                    <?php $cats = get_the_category();
                    if ($cats): ?>
                    <span><?php echo esc_html($cats[0]->name); ?></span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (has_post_thumbnail()): ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('esgi-hero'); ?>
            </div>
            <?php endif; ?>

            <div class="post-content entry-content">
                <?php the_content(); ?>
            </div>

        </article>

        <?php endwhile; ?>

        <nav class="post-nav">
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
</main>

<?php get_footer(); ?>
