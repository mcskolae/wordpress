<?php
if (!defined('ABSPATH')) {
    exit;
}

function esgi_setup() {
    load_theme_textdomain('esgi', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style',
    ]);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_image_size('esgi-card', 520, 440, true);
    add_image_size('esgi-hero', 1400, 600, true);
    register_nav_menus([
        'primary' => __('Menu principal', 'esgi'),
        'footer'  => __('Menu pied de page', 'esgi'),
    ]);
}
add_action('after_setup_theme', 'esgi_setup');

function esgi_scripts() {
    wp_enqueue_style(
        'esgi-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap',
        [],
        null
    );
    wp_enqueue_style('esgi-style', get_stylesheet_uri(), ['esgi-fonts'], '1.0.0');
    wp_enqueue_script('esgi-main', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true);
    wp_localize_script('esgi-main', 'esgiData', [
        'restUrl' => esc_url_raw(rest_url()),
    ]);
}
add_action('wp_enqueue_scripts', 'esgi_scripts');

function esgi_new_product_badge() {
    global $product;
    if (!$product instanceof WC_Product) {
        return;
    }
    $days = (int) apply_filters('esgi_new_product_days', 30);
    $date = $product->get_date_created();
    if (!$date) {
        return;
    }
    $diff = (time() - $date->getTimestamp()) / DAY_IN_SECONDS;
    if ($diff <= $days) {
        echo '<span class="product-badge">' . esc_html__('Nouveau', 'esgi') . '</span>';
    }
}
add_action('woocommerce_before_shop_loop_item_title', 'esgi_new_product_badge', 5);

function esgi_shop_title($title) {
    if (is_shop()) {
        return __('Notre Collection', 'esgi');
    }
    return $title;
}
add_filter('woocommerce_page_title', 'esgi_shop_title');

function esgi_widgets_init() {
    register_sidebar([
        'name'          => __('Sidebar boutique', 'esgi'),
        'id'            => 'shop-sidebar',
        'description'   => __('Filtres et widgets de la boutique.', 'esgi'),
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'esgi_widgets_init');

function esgi_cart_count(): int {
    if (function_exists('WC') && WC()->cart) {
        return (int) WC()->cart->get_cart_contents_count();
    }
    return 0;
}

function esgi_cart_link(): void {
    if (!function_exists('wc_get_cart_url')) {
        return;
    }
    $count = esgi_cart_count();
    printf(
        '<a href="%s" class="cart-link" aria-label="%s">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            %s
            <span class="cart-count" aria-hidden="true">%d</span>
        </a>',
        esc_url(wc_get_cart_url()),
        esc_attr__('Voir le panier', 'esgi'),
        esc_html__('Panier', 'esgi'),
        $count
    );
}

function esgi_inject_wc_nav_items(string $items, $args): string {
    if ($args->theme_location !== 'primary' || !function_exists('wc_get_page_id')) {
        return $items;
    }

    $shop    = get_permalink(wc_get_page_id('shop'));
    $account = get_permalink(wc_get_page_id('myaccount'));

    $extra  = '<li class="menu-item"><a href="' . esc_url($shop) . '">Boutique</a></li>';
    $extra .= '<li class="menu-item"><a href="' . esc_url($account) . '">Mon compte</a></li>';
    $extra .= '<li class="menu-item"><a href="' . esc_url(home_url('/lookbook/')) . '">Lookbook</a></li>';

    return $items . $extra;
}
add_filter('wp_nav_menu_items', 'esgi_inject_wc_nav_items', 10, 2);

add_filter('excerpt_length', fn() => 24);
add_filter('excerpt_more', fn() => '&hellip;');

add_filter('woocommerce_enqueue_styles', '__return_empty_array');

add_action('rest_api_init', function () {
    register_rest_route('esgi/v1', '/cart-count', [
        'methods'             => 'GET',
        'callback'            => fn() => rest_ensure_response(['count' => esgi_cart_count()]),
        'permission_callback' => '__return_true',
    ]);
});
