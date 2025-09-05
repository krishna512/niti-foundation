<?php

/**
 * ====================================================
 * Read time of post
 * @return string "3 Min. To Read"
 * ====================================================
 */
if (!function_exists('readingTime')) {

    add_shortcode('readingTime', 'readingTime');
    function readingTime()
    {
        global $post;

        $content = get_post_field('post_content', $post->ID);

        $wordcount = str_word_count(strip_tags($content));

        $time = ($number = $wordcount / 200) > 1 ? ceil($number) . '  Min. To Read' : $number . ' Sec. To Read';

        return ($time);
    }
}


/**
 * ====================================================
 * Return Categories attached to post
 * @return $html
 * ====================================================
 */

if (!function_exists('categoriesList')) {

    add_shortcode('postCategories', 'categoriesList');
    function categoriesList()
    {
        $categories = get_the_category();

        if (!empty($categories)) {
            $cats = array();
            foreach ($categories as $category) {
                $cat[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
            }

            echo '<ul class="post-categories">';
            echo join('', $cat);
            echo '</ul>';
        }
    }
}


/**
 * =======================================================
 * Dynamic SVG icon
 * 
 * @return $html
 * =======================================================
 */

if (!function_exists('useSVG')) {
    function useSVG($filename = 'sample-icon')
    {
        $icon = get_stylesheet_directory() . '/assets/icons/' . $filename . '.svg';

        $svg_icon_content = @file_get_contents($icon);

        return $svg_icon_content;
    }
}


/**
 * =======================================================
 * drschool_default_thumbnail
 * =======================================================
 */

function niti_default_thumbnail()
{
    return get_template_directory_uri() . '/assets/images/niti_default_image.jpg';
}

// Default Post Rename 
function change_post_menu_label()
{
    global $menu, $submenu;

    $menu[5][0] = 'Blog';
    $submenu['edit.php'][5][0] = 'Blog';
    $submenu['edit.php'][10][0] = 'New Blog';
    $submenu['edit.php'][16][0] = 'Blog Tags';
    echo '';
}
// add_action('admin_menu', 'change_post_menu_label');

function change_post_object_label()
{
    global $wp_post_types;

    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Blog';
    $labels->singular_name = 'Blog';
    $labels->add_new = 'New Blog';
    $labels->add_new_item = 'New Blog';
    $labels->edit_item = 'Edit Blog';
    $labels->new_item = 'New Blog';
    $labels->view_item = 'View Blog';
    $labels->search_items = 'Search Blog';
    $labels->not_found = 'Not found';
    $labels->not_found_in_trash = 'Not found in trash';
}
// add_action('init', 'change_post_object_label');


// disable Default Post
function remove_default_post_type_menu() {
    // Remove Posts menu
    remove_menu_page('edit.php');
}
add_action('admin_menu', 'remove_default_post_type_menu');

function remove_default_post_type_dashboard_widgets() {
    // Remove dashboard widgets related to Posts
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_recent_posts', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'remove_default_post_type_dashboard_widgets');

/**
 *==============================
 * Hide wordpress version
 *==============================
 */
add_filter('the_generator', '__return_empty_string');
remove_action('wp_head', 'wp_generator');

// Custom BreadCrum
function custom_breadcrumb()
{
    $breadcrumb = '<div class="breadcrumb-wrapper">';
    $breadcrumb .= '<a href="' . home_url() . '" class="breadcrumb-home">Home</a>';

    if (is_home() || is_front_page()) {
        $breadcrumb .= useSVG('breadcrum_icon'). '<span class="breadcrumb-current">Blog</span>';
    } elseif (is_category()) {
        $breadcrumb .=  useSVG('breadcrum_icon'). '<a href="' . get_permalink(get_option('page_for_posts')) . '" class="breadcrumb-blog">Blog</a>';
        $breadcrumb .=  useSVG('breadcrum_icon').  '<span class="breadcrumb-category">' . single_cat_title('', false) . '</span>';
    } elseif (is_tag()) {
        $breadcrumb .=  useSVG('breadcrum_icon'). '<a href="' . get_permalink(get_option('page_for_posts')) . '" class="breadcrumb-blog">Blog</a>';
        $breadcrumb .=  useSVG('breadcrum_icon'). '<span class="breadcrumb-tag">' . single_tag_title('', false) . '</span>';
    } elseif (is_author()) {
        $breadcrumb .=  useSVG('breadcrum_icon').  '<span class="breadcrumb-author">' . get_the_author() . '</span>';
    } elseif (is_date()) {
        if (is_day()) {
            $breadcrumb .=  useSVG('breadcrum_icon'). ' <span class="breadcrumb-date">' . get_the_date() . '</span>';
        } elseif (is_month()) {
            $breadcrumb .=  useSVG('breadcrum_icon'). ' <span class="breadcrumb-date">' . get_the_date('F Y') . '</span>';
        } elseif (is_year()) {
            $breadcrumb .=  useSVG('breadcrum_icon'). ' <span class="breadcrumb-date">' . get_the_date('Y') . '</span>';
        }
    } elseif (is_single()) {
        $breadcrumb .=  useSVG('breadcrum_icon');
        $categories = get_the_category();

        // if ($categories) {
        //     $breadcrumb .= '<a href="' . get_category_link($categories[0]->term_id) . '" class="breadcrumb-category">' . $categories[0]->cat_name . '</a>';
        // }
        // Add post name (slug) and title
        // Get the post type object
        $post_type = get_post_type_object(get_post_type());

        // Retrieve the archive link for the post type
        $archive_url = get_post_type_archive_link($post_type->name);

        // Build the breadcrumb with the archive title as an anchor
        $breadcrumb .= '<span class="breadcrumb-post-name"><a href="' . esc_url($archive_url) . '" '.useSVG('breadcrum_icon') . esc_html($post_type->labels->singular_name) . '</a> <span class="breadcrumb-separate">' .useSVG('breadcrum_icon'). ' </span> <span class="breadcrumb-title">' . esc_html(get_the_title()) . '</span></span>';


    } elseif (is_page()) {
        $breadcrumb .=  useSVG('breadcrum_icon'). '<span class="breadcrumb-current">' . get_the_title() . '</span>';
    } elseif (is_search()) {
        $breadcrumb .=  useSVG('breadcrum_icon').'<span class="breadcrumb-search">Search results for: ' . get_search_query() . '</span>';
    } elseif (is_404()) {
        $breadcrumb .=  useSVG('breadcrum_icon').'<span class="breadcrumb-404">Page not found</span>';
    } elseif (is_archive()) {
        // General archive title
        if (is_post_type_archive()) {
            $post_type = get_post_type_object(get_post_type());
            $archive_title = isset($post_type->name) ? $post_type->name : '';
        } elseif (is_tax()) {
            $term = get_queried_object();
            $archive_title = $term->name;
        } else {
            $archive_title = get_the_archive_title();
        }
        $breadcrumb .=  useSVG('breadcrum_icon').'<span class="breadcrumb-archive">' . $archive_title . '</span>';

        // $breadcrumb .= ' / <span class="breadcrumb-archive">' . get_the_archive_title() . '</span>';
    }

    $breadcrumb .= '</div>';

    return $breadcrumb;
}




/**
 * @param string $post_type
 * @param array $meta_keys
 * @return array unique_post_type_meta_info
 */
function get_unique_post_type_meta_info($post_type, $meta_keys)
{
    $meta_info = [];
    $post_args = [
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'post_status' => array('publish'),
    ];
    // get all post from given post type and retrive given meta-key values
    $posts = get_posts($post_args);
    foreach ($posts as $post_key => $post) {
        $post_meta_datas = get_post_meta($post->ID);
        foreach ($post_meta_datas as $key => $meta_datas) {
            $value = $meta_datas[0];
            if ($value && in_array($key, $meta_keys)) {
                $val = (get_field($key, $post->ID)) ?: '';
                if (isset($meta_info[$key][$value])) {
                    if (array_key_exists($value, $meta_info[$key])) {
                        $meta_info[$key][$value]['value'] = ($val) ? $val : $value;
                        $meta_info[$key][$value]['count'] = $meta_info[$key][$value]['count'] + 1;
                    }
                } else {
                    $meta_info[$key][$value]['value'] = ($val) ? $val : $value;
                    $meta_info[$key][$value]['count'] = 1;
                }
            }
        }
    }
    return $meta_info;
}