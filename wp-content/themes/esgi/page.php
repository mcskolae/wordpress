<?php get_header(); ?>

<main id="main" class="site-main has-hero">

    <div class="page-hero">
        <div class="container">
            <p class="breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
                &rsaquo; <?php the_title(); ?>
            </p>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>

    <div class="container page-body">
        <?php while (have_posts()): the_post(); ?>
            <div class="page-content entry-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>

</main>

<?php get_footer(); ?>
