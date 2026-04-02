<?php

if (!defined('ABSPATH')) {
  exit;
}

add_action('init', function () {
  if (!session_id()) {
    session_start();
  }
});

add_filter('user_row_actions', 'dashboard_switch_to', 10, 2);

function dashboard_switch_to($actions, $user)
{
  if (!current_user_can('administrator')) {
    return $actions;
  }

  if ($user->ID === get_current_user_id()) {
    return $actions;
  }

  $url = add_query_arg(
    [
      'action'  => 'switch_to',
      'user_id' => $user->ID,
      'nonce'   => wp_create_nonce('switch_to_' . $user->ID)
    ],
    admin_url('admin-post.php')
  );

  $actions['switch_to'] = '<a href="' . esc_url($url) . '">Switch To</a>';
  return $actions;
}

add_action('admin_post_switch_to', 'handle_switch');

function handle_switch()
{
  $user_id = isset($_GET['user_id']) ? (int) $_GET['user_id'] : 0;

  if (!$user_id) {
    return;
  }

  if (!wp_verify_nonce($_GET['nonce'] ?? '', 'switch_to_' . $user_id)) {
    wp_die('Action non autorisée.');
  }

  if (!current_user_can('administrator')) {
    wp_die('Accès refusé.');
  }

  $_SESSION['switch_to_original_user'] = get_current_user_id();

  wp_set_current_user($user_id);
  wp_set_auth_cookie($user_id);

  wp_redirect(home_url());
  exit;
}
