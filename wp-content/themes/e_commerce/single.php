<?php

get_header();
?>

<main id="main" class="site-main">
    <div class="container" style="max-width:860px;">

        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( '' ); ?>>

            <!-- En-tête -->
            <header style="margin-bottom:32px;">
                <p style="font-size:.85rem;color:var(--color-muted);margin-bottom:12px;">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--color-muted);"><?php esc_html_e( 'Accueil', 'esgi' ); ?></a>
                    &rsaquo;
                    <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'blog' ) ) ); ?>" style="color:var(--color-muted);"><?php esc_html_e( 'Blog', 'esgi' ); ?></a>
                    &rsaquo; <?php the_title(); ?>
                </p>

                <h1 style="font-size:clamp(1.6rem,4vw,2.4rem);margin-bottom:16px;"><?php the_title(); ?></h1>

                <div style="display:flex;align-items:center;gap:16px;color:var(--color-muted);font-size:.9rem;flex-wrap:wrap;">
                    <span>📅 <?php echo esc_html( get_the_date() ); ?></span>
                    <span>✍️ <?php the_author(); ?></span>
                    <?php $cats = get_the_category();
                    if ( $cats ) : ?>
                    <span>🏷️ <?php echo esc_html( $cats[0]->name ); ?></span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
            <div style="margin-bottom:32px;border-radius:16px;overflow:hidden;">
                <?php the_post_thumbnail( 'esgi-hero', [ 'style' => 'width:100%;height:400px;object-fit:cover;' ] ); ?>
            </div>
            <?php endif; ?>

            <div class="entry-content" style="background:var(--color-white);border-radius:16px;padding:40px;box-shadow:var(--shadow);line-height:1.8;font-size:1.05rem;">
                <?php the_content(); ?>
            </div>

        </article>

        <?php endwhile; ?>

        <!-- Navigation entre articles -->
        <nav style="margin-top:40px;display:flex;justify-content:space-between;gap:16px;">
            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            if ( $prev ) : ?>
            <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="btn btn-outline" style="flex:1;">
                &larr; <?php echo esc_html( get_the_title( $prev ) ); ?>
            </a>
            <?php endif;
            if ( $next ) : ?>
            <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="btn btn-outline" style="flex:1;text-align:right;">
                <?php echo esc_html( get_the_title( $next ) ); ?> &rarr;
            </a>
            <?php endif; ?>
        </nav>

    </div>
</main>

<?php get_footer(); ?>
