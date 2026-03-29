<?php

if (!defined('ABSPATH')) {
  exit;
}

add_action('wp_footer', 'render_switch_back');

function render_switch_back()
{
  session_start();

  if (empty($_SESSION['switch_to_original_user']));

  $url = add_query_arg(
    [
      'action' => 'switch_back',
      'nonce' => wp_create_nonce('switch_back'),
    ],
    admin_url('admin-post.php')
  );

  echo '<div style="position:fixed;bottom:20px;right:20px;z-index:9999;">
    <a href="' . esc_url( $url ) . '" style="background:#d63638;color:#fff;padding:10px 20px;border-radius:4px;text-decoration:none;">
      Switch Back
    </a>
  </div>';
}

add_action('admin_post_switch_back', 'handle_switch_back');

function handle_switch_back()
{
  session_start();

  if (!wp_verify_nonce($_GET['nonce'], 'switch_back')) {
    wp_die('Action non autorisée.');
  }

  $originalUserId = (int) $_SESSION['switch_to_original_user'];
  unset($_SESSION['switch_to_original_user']);

  wp_set_current_user($originalUserId);
  wp_set_auth_cookie($originalUserId);

  wp_redirect(admin_url('users.php'));
  exit;
}
