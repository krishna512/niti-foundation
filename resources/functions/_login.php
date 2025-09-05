<?php
/**
 *==============================
 * Login page logo
 *==============================
 */

function login_logo()
{
    $custom_logo_id = get_theme_mod('custom_logo');
    $url = $custom_logo_id ? wp_get_attachment_image_src($custom_logo_id, 'full') : '';
    wp_enqueue_style('yi-login', get_stylesheet_directory_uri() . '/dist/css/login.css');

    if ($url) {
        ?>
        <style type="text/css">
            #login h1 a,
            .login h1 a {
                background-image: url('<?php echo $url[0]; ?>');
            }
        </style>
        <?php
    }
    wp_enqueue_script('custom-login', get_stylesheet_directory_uri() . '/dist/js/login.js', array('jquery'), HELLO_ELEMENTOR_CHILD_VERSION, true);
}
add_action('login_enqueue_scripts', 'login_logo');



/**
 *==============================
 * Logo url
 *==============================
 */
function logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'logo_url');