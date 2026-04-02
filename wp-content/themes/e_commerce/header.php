<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <header id="masthead" class="site-header" role="banner">
        <div class="container">

            <div class="site-branding">
                <div class="site-logo" aria-hidden="true">E</div>
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <span class="site-title">ESGI</span>
                </a>
            </div>

            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Ouvrir le menu', 'esgi'); ?>">
                <span></span><span></span><span></span>
            </button>

            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Navigation principale', 'esgi'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => function () {
                        echo '<ul id="primary-menu">';
                        echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Accueil', 'esgi') . '</a></li>';
                        if (function_exists('wc_get_page_id')) {
                            echo '<li><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">' . __('Boutique', 'esgi') . '</a></li>';
                            echo '<li><a href="' . esc_url(get_permalink(wc_get_page_id('myaccount'))) . '">' . __('Mon compte', 'esgi') . '</a></li>';
                        }
                        echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('a-propos'))) . '">' . __('À propos', 'esgi') . '</a></li>';
                        echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('contact'))) . '">' . __('Contact', 'esgi') . '</a></li>';
                        echo '</ul>';
                    },
                ]);
                ?>
            </nav>

            <div class="header-actions">
                <div class="header-cart">
                    <?php esgi_cart_link(); ?>
                </div>
            </div>

        </div>
    </header>

    <div id="content" class="site-content">
