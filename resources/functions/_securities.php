<?php
/**
 *==============================
 * Hide wordpress version
 *==============================
 */
add_filter('the_generator', '__return_empty_string');
remove_action('wp_head', 'wp_generator');

/**
 *==============================
 * Disable xmlrpc and pingback
 *==============================
 */

add_filter('xmlrpc_enabled', '__return_false');

add_filter('wp_headers', 'disable_x_pingback');
function disable_x_pingback($headers)
{
    unset($headers['X-Pingback']);

    return $headers;
}

// Disable Self Pingbacks
add_action('pre_ping', function (&$links) {
    $home = get_option('home');
    foreach ($links as $l => $link) {
        if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
});


/**
 *================================================================
 * Completely Disable Comments since we dont have comment feature
 *================================================================
 */


add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

// Disable Comment Form Website URL
add_filter('comment_form_default_fields', function ($fields) {
    if (isset($fields['url'])) {
        unset($fields['url']);
    }

    return $fields;
}, 150);

// Disable Default Post 
// add_action( 'admin_menu', 'remove_default_post_type' );

// function remove_default_post_type() {
//     remove_menu_page( 'edit.php' );
// }

/**
 *==============================
 * Disable wlwmanifest link
 *==============================
 */
remove_action('wp_head', 'wlwmanifest_link');


/**
 * =========================================================
 * Clickjacking protection
 *
 * Add header to stop site loading in an iFrame.
 * =========================================================
 **/
function prevent_clickjacking()
{
    header('X-FRAME-OPTIONS: SAMEORIGIN');
}
add_action('send_headers', 'prevent_clickjacking', 10);