<?php
/**
 * Plugin Name: ESGI
 * Description: CPT Lookbook, taxonomie Collection, hooks WooCommerce, shortcode et API REST.
 * Version:     1.0.0
 * Author:      Max Chen
 * Text Domain: esgi-plugin
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */

defined('ABSPATH') || exit;

define('ESGI_PLUGIN_VERSION', '1.0.0');
define('ESGI_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ESGI_PLUGIN_URL', plugin_dir_url(__FILE__));

function esgi_register_cpt_lookbook(): void {
    $labels = [
        'name'               => _x('Lookbook', 'post type general name', 'esgi-plugin'),
        'singular_name'      => _x('Look', 'post type singular name', 'esgi-plugin'),
        'menu_name'          => __('Lookbook', 'esgi-plugin'),
        'add_new'            => __('Ajouter un look', 'esgi-plugin'),
        'add_new_item'       => __('Ajouter un look', 'esgi-plugin'),
        'edit_item'          => __('Modifier le look', 'esgi-plugin'),
        'new_item'           => __('Nouveau look', 'esgi-plugin'),
        'view_item'          => __('Voir le look', 'esgi-plugin'),
        'search_items'       => __('Rechercher dans Lookbook', 'esgi-plugin'),
        'not_found'          => __('Aucun look trouvé.', 'esgi-plugin'),
        'not_found_in_trash' => __('Aucun look dans la corbeille.', 'esgi-plugin'),
    ];

    register_post_type('lookbook', [
        'labels'          => $labels,
        'public'          => true,
        'show_in_rest'    => true,
        'supports'        => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'has_archive'     => true,
        'rewrite'         => ['slug' => 'lookbook'],
        'menu_icon'       => 'dashicons-camera',
        'menu_position'   => 25,
        'capability_type' => 'post',
    ]);
}
add_action('init', 'esgi_register_cpt_lookbook');

function esgi_register_taxonomy_collection(): void {
    $labels = [
        'name'          => _x('Collections', 'taxonomy general name', 'esgi-plugin'),
        'singular_name' => _x('Collection', 'taxonomy singular name', 'esgi-plugin'),
        'search_items'  => __('Rechercher une collection', 'esgi-plugin'),
        'all_items'     => __('Toutes les collections', 'esgi-plugin'),
        'edit_item'     => __('Modifier la collection', 'esgi-plugin'),
        'add_new_item'  => __('Ajouter une collection', 'esgi-plugin'),
        'menu_name'     => __('Collections', 'esgi-plugin'),
    ];

    register_taxonomy('collection', ['lookbook', 'product'], [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'collection'],
        'show_admin_column' => true,
    ]);
}
add_action('init', 'esgi_register_taxonomy_collection');

function esgi_add_lookbook_metabox(): void {
    add_meta_box(
        'esgi_lookbook_details',
        __('Détails du look', 'esgi-plugin'),
        'esgi_lookbook_metabox_callback',
        'lookbook',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'esgi_add_lookbook_metabox');

function esgi_lookbook_metabox_callback(WP_Post $post): void {
    wp_nonce_field('esgi_lookbook_save', 'esgi_lookbook_nonce');

    $stylist  = get_post_meta($post->ID, '_look_stylist', true);
    $season   = get_post_meta($post->ID, '_look_season', true);
    $products = get_post_meta($post->ID, '_look_product_ids', true);
    ?>
    <table class="form-table" style="width:100%;">
        <tr>
            <th><label for="look_stylist"><?php esc_html_e('Styliste', 'esgi-plugin'); ?></label></th>
            <td><input type="text" id="look_stylist" name="look_stylist" value="<?php echo esc_attr($stylist); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="look_season"><?php esc_html_e('Saison', 'esgi-plugin'); ?></label></th>
            <td>
                <select id="look_season" name="look_season">
                    <?php
                    $seasons = [
                        ''        => __('— Choisir —', 'esgi-plugin'),
                        'spring'  => __('Printemps/Été', 'esgi-plugin'),
                        'fall'    => __('Automne/Hiver', 'esgi-plugin'),
                        'capsule' => __('Capsule', 'esgi-plugin'),
                    ];
                    foreach ($seasons as $val => $label) {
                        printf(
                            '<option value="%s" %s>%s</option>',
                            esc_attr($val),
                            selected($season, $val, false),
                            esc_html($label)
                        );
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="look_product_ids"><?php esc_html_e('Produits associés', 'esgi-plugin'); ?></label></th>
            <td>
                <?php
                $selected_ids = array_filter(array_map('intval', explode(',', $products)));
                $all_products = wc_get_products(['status' => 'publish', 'limit' => -1, 'orderby' => 'title', 'order' => 'ASC']);
                ?>
                <select id="look_product_ids" name="look_product_ids[]" multiple style="min-width:300px;height:160px;">
                    <?php foreach ($all_products as $product): ?>
                    <option value="<?php echo esc_attr($product->get_id()); ?>" <?php echo in_array($product->get_id(), $selected_ids, true) ? 'selected' : ''; ?>>
                        <?php echo esc_html($product->get_name()); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php esc_html_e('Ctrl+clic (ou Cmd+clic) pour sélectionner plusieurs produits.', 'esgi-plugin'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function esgi_save_lookbook_meta(int $post_id): void {
    if (!isset($_POST['esgi_lookbook_nonce'])) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['esgi_lookbook_nonce'])), 'esgi_lookbook_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = [
        '_look_stylist'     => sanitize_text_field($_POST['look_stylist'] ?? ''),
        '_look_season'      => sanitize_text_field($_POST['look_season'] ?? ''),
        '_look_product_ids' => implode(',', array_filter(array_map('intval', $_POST['look_product_ids'] ?? []))),
    ];

    foreach ($fields as $key => $value) {
        update_post_meta($post_id, $key, $value);
    }
}
add_action('save_post_lookbook', 'esgi_save_lookbook_meta');

function esgi_display_product_collections(): void {
    global $product;

    if (!$product instanceof WC_Product) {
        return;
    }

    $terms = get_the_terms($product->get_id(), 'collection');

    if (is_wp_error($terms) || empty($terms)) {
        return;
    }

    $links = [];
    foreach ($terms as $term) {
        $links[] = sprintf(
            '<a href="%s" style="color:var(--color-accent,#f97316);font-size:.85rem;">%s</a>',
            esc_url(get_term_link($term)),
            esc_html($term->name)
        );
    }

    echo '<div class="esgi-collections" style="margin-bottom:12px;">';
    echo '<span style="font-size:.85rem;color:var(--color-muted,#6b7280);font-weight:600;">Collection : </span>';
    echo implode(', ', $links); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</div>';
}
add_action('woocommerce_single_product_summary', 'esgi_display_product_collections', 6);

function esgi_add_to_cart_text(string $text, WC_Product $product): string {
    if (!$product->is_in_stock()) {
        return 'Rupture de stock';
    }
    if ($product->is_type('simple')) {
        return 'Ajouter au panier';
    }
    return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'esgi_add_to_cart_text', 10, 2);
add_filter('woocommerce_product_single_add_to_cart_text', 'esgi_add_to_cart_text', 10, 2);

function esgi_lookbook_shortcode(array $atts): string {
    $atts = shortcode_atts([
        'limit'      => 6,
        'collection' => '',
        'columns'    => 3,
    ], $atts, 'esgi_lookbook');

    $args = [
        'post_type'      => 'lookbook',
        'posts_per_page' => (int) $atts['limit'],
        'post_status'    => 'publish',
    ];

    if (!empty($atts['collection'])) {
        $args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery
            [
                'taxonomy' => 'collection',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($atts['collection']),
            ],
        ];
    }

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return '<p>Aucun look disponible.</p>';
    }

    $cols = max(1, min(6, (int) $atts['columns']));
    $out  = '<div class="esgi-lookbook-grid" style="display:grid;grid-template-columns:repeat(' . $cols . ',1fr);gap:24px;">';

    while ($query->have_posts()) {
        $query->the_post();
        $season        = get_post_meta(get_the_ID(), '_look_season', true);
        $season_labels = ['spring' => 'Printemps/Été', 'fall' => 'Automne/Hiver', 'capsule' => 'Capsule'];

        $out .= '<div class="esgi-look-card" style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);">';

        if (has_post_thumbnail()) {
            $out .= '<a href="' . esc_url(get_permalink()) . '">' . get_the_post_thumbnail(null, 'esgi-card', ['style' => 'width:100%;height:220px;object-fit:cover;']) . '</a>';
        }

        $out .= '<div style="padding:16px;">';
        $out .= '<h3 style="font-size:1rem;margin-bottom:4px;"><a href="' . esc_url(get_permalink()) . '" style="color:#1a1a1a;">' . esc_html(get_the_title()) . '</a></h3>';

        if ($season) {
            $out .= '<span style="font-size:.8rem;color:#f97316;font-weight:600;">' . esc_html($season_labels[$season] ?? $season) . '</span>';
        }

        $out .= '</div></div>';
    }

    $out .= '</div>';
    wp_reset_postdata();

    return $out;
}
add_shortcode('esgi_lookbook', 'esgi_lookbook_shortcode');

function esgi_register_rest_routes(): void {
    register_rest_route('esgi/v1', '/lookbook', [
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => 'esgi_rest_get_lookbook',
        'permission_callback' => '__return_true',
        'args'                => [
            'per_page'   => ['default' => 10, 'sanitize_callback' => 'absint'],
            'collection' => ['default' => '', 'sanitize_callback' => 'sanitize_text_field'],
        ],
    ]);

    register_rest_route('esgi/v1', '/featured-products', [
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => 'esgi_rest_get_featured_products',
        'permission_callback' => '__return_true',
        'args'                => [
            'limit' => ['default' => 8, 'sanitize_callback' => 'absint'],
        ],
    ]);
}
add_action('rest_api_init', 'esgi_register_rest_routes');

function esgi_rest_get_lookbook(WP_REST_Request $request): WP_REST_Response {
    $args = [
        'post_type'      => 'lookbook',
        'posts_per_page' => $request->get_param('per_page'),
        'post_status'    => 'publish',
    ];

    $collection = $request->get_param('collection');
    if ($collection) {
        $args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery
            [
                'taxonomy' => 'collection',
                'field'    => 'slug',
                'terms'    => $collection,
            ],
        ];
    }

    $query = new WP_Query($args);
    $data  = [];

    foreach ($query->posts as $post) {
        $data[] = [
            'id'        => $post->ID,
            'title'     => $post->post_title,
            'excerpt'   => wp_strip_all_tags($post->post_excerpt),
            'url'       => get_permalink($post->ID),
            'thumbnail' => get_the_post_thumbnail_url($post->ID, 'esgi-card'),
            'stylist'   => get_post_meta($post->ID, '_look_stylist', true),
            'season'    => get_post_meta($post->ID, '_look_season', true),
        ];
    }

    return new WP_REST_Response(['total' => $query->found_posts, 'items' => $data], 200);
}

function esgi_rest_get_featured_products(WP_REST_Request $request): WP_REST_Response {
    if (!function_exists('wc_get_products')) {
        return new WP_REST_Response(['error' => 'WooCommerce non actif'], 503);
    }

    $products = wc_get_products([
        'limit'   => $request->get_param('limit'),
        'status'  => 'publish',
        'orderby' => 'date',
        'order'   => 'DESC',
    ]);

    $data = [];
    foreach ($products as $product) {
        $data[] = [
            'id'        => $product->get_id(),
            'name'      => $product->get_name(),
            'price'     => $product->get_price(),
            'url'       => $product->get_permalink(),
            'thumbnail' => wp_get_attachment_url($product->get_image_id()),
            'in_stock'  => $product->is_in_stock(),
        ];
    }

    return new WP_REST_Response(['items' => $data], 200);
}

function esgi_admin_menu(): void {
    add_options_page(
        __('ESGI Plugin', 'esgi-plugin'),
        __('ESGI', 'esgi-plugin'),
        'manage_options',
        'esgi-settings',
        'esgi_settings_page'
    );
}
add_action('admin_menu', 'esgi_admin_menu');

function esgi_settings_page(): void {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['esgi_settings_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['esgi_settings_nonce'])), 'esgi_save_settings')) {
        update_option('esgi_new_product_days', absint($_POST['esgi_new_product_days'] ?? 30));
        echo '<div class="notice notice-success"><p>Paramètres sauvegardés.</p></div>';
    }

    $new_days = get_option('esgi_new_product_days', 30);
    ?>
    <div class="wrap">
        <h1>Paramètres ESGI</h1>
        <form method="post">
            <?php wp_nonce_field('esgi_save_settings', 'esgi_settings_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th>Badge "Nouveau" (jours)</th>
                    <td>
                        <input type="number" name="esgi_new_product_days" value="<?php echo absint($new_days); ?>" min="1" max="365" class="small-text">
                        <p class="description">Affiche le badge sur les produits créés dans ce délai.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <hr>
        <h2>Endpoints REST</h2>
        <ul>
            <li><code><?php echo esc_url(rest_url('esgi/v1/lookbook')); ?></code></li>
            <li><code><?php echo esc_url(rest_url('esgi/v1/featured-products')); ?></code></li>
        </ul>
    </div>
    <?php
}

add_filter('esgi_new_product_days', function(int $default): int {
    $days = get_option('esgi_new_product_days', 0);
    return $days > 0 ? (int) $days : $default;
});
