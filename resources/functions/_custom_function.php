<?php
// resource Hub Case Studies and Ebook Search Filter Shortcode
add_shortcode('custom_child_pages_search_filter', 'search_filter');
function search_filter()
{
    $search_query = isset($_GET['search_query']) ? sanitize_text_field($_GET['search_query']) : '';
    ob_start();
    ?>

    <form method="get" action="">
        <input type="text" id="search_query" name="search_query" placeholder="ENTER A KEYWORD"
            value="<?php echo esc_attr($search_query); ?>" />
        <input type="submit" value="Search" style="position: absolute; margin-left: 18px; border: none;" />
    </form>
    <?php
    return ob_get_clean();
}

// Resource Hub Function 
function resource_hub()
{
    $feature_img = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : '';
    $excerpt = get_the_excerpt();
    $excerpt = substr($excerpt, 0, 350);


    ?>
    <div class="card-wrapper">
        <div class="card custom-card" id="post-<?php the_ID(); ?>">

            <?php if ($feature_img): ?>
                <div class="card-img">
                    <img class="card-img-top" src="<?php echo $feature_img; ?>">
                </div>
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?php the_title(); ?></h5>
                <p class="card-text"><?php echo $excerpt; ?></p>
            </div>
            <div class="card-body learn-btn">
                <a href="<?php the_permalink(); ?>"><button>Learn More</button></a>
            </div>

        </div>
    </div>


    <?php
}

// components functions

/**
 * =======================================================
 * Gutenberg Editor Content
 * =======================================================
 */

if (!function_exists('gutenbergEditorContent')) {
    function gutenbergEditorContent()
    {
        ?>
        <div class="wp-block-post-content entry-content">
            <?php the_content(); ?>
        </div>
        <?php
    }
}




/**
 * =========================================================
 * get heading and sub-heading for archive pages.
 * =========================================================
 */

function get_archive_page_heading($posttype)
{
    if (is_tax()) {
        $queried_object = get_queried_object();
        $pageIdentify = $queried_object;
    } else {
        $pageIdentify = $posttype . '_options';
    }


    // header-info
    $image = (function_exists('get_field') && $image = get_field('image', $pageIdentify)) ? $image : niti_default_thumbnail();

    ob_start();

    echo heroContent($image);

    $archive_page_heading = ob_get_contents();

    ob_end_clean();

    return $archive_page_heading;
}

/**
 * =========================================================
 * Hero-content
 * =========================================================
 */

function heroContent($imageId = '')
{

    if (is_archive()) {
        $queried_object = get_queried_object();

        if (is_tax()) {
            $pageIdentify = $queried_object;
            $label = $queried_object->name;
        } else {
            $posttype = $queried_object->name;
            $label = $queried_object->label;
            $pageIdentify = $posttype . '_options';
        }
        $title = (function_exists('get_field') && $title = get_field('heading', $pageIdentify)) ? $title : $label;
        $sub_heading = (function_exists('get_field') && $sub_heading = get_field('sub_heading', $pageIdentify)) ? $sub_heading : '';
        $image = (function_exists('get_field') && $image = get_field('image', $pageIdentify)) ? $image : niti_default_thumbnail();
        // var_dump($image);
    } else {

        $title = (function_exists('get_field') && $title = get_field('title')) ? $title : '';

    }

    $title = ($title) ? $title : get_the_title();


    ob_start();
    ?>
    <div id="hero-banner"
        class=" hero__banner relative flex min-h-[430px] pt-20 pb-8 md:pt-32 md:pb-20 overflow-hidden hero-content">
        <img src="<?php echo $image; ?>" alt="herobg" class="absolute inset-0 w-full h-full object-cover" />
        <div class="container relative z-10 mt-auto hero__banner--content">
            <div class="text-white">
                <div class=" grid gap-4 relative z-10 max-w-xl">
                    <h1 class=" font-bigShouldersDisplay font-bold">
                        <?php echo $title; ?>
                    </h1>
                    <p>
                        <?php echo $sub_heading; ?>
                    </p>
                </div>

            </div>
        </div>

    </div>

    <?php
}


/**
 * =========================================================
 * New user role for client
 * =========================================================
 */
function add_client_role()
{
    add_role(
        'client_role',
        'Niti Role',
        array(
            'read' => true,
            'edit_posts' => true,
            'upload_files' => true,
        ),
    );
}

add_action('init', 'add_client_role');

function add_client_role_capabilities()
{

    $role = get_role('client_role');

    // = general =
    $role->add_cap('moderate_comments', true);
    $role->add_cap('manage_links', true);
    $role->add_cap('manage_options', true);
    $role->add_cap('rocket_manage_options', true);
    $role->add_cap('rocket_manage_cache');
    $role->add_cap('rocket_purge_cache');

    // = posts =
    $role->add_cap('edit_others_posts', true);
    $role->add_cap('delete_posts', true);
    $role->add_cap('publish_posts', true);
    $role->add_cap('read_private_posts', true);
    $role->add_cap('delete_private_posts', true);
    $role->add_cap('delete_published_posts', true);
    $role->add_cap('delete_others_posts', true);
    $role->add_cap('edit_private_posts', true);
    $role->add_cap('edit_published_posts', true);

    // = pages =
    $role->add_cap('edit_pages', true);
    $role->add_cap('edit_others_pages', true);
    $role->add_cap('delete_pages', true);
    $role->add_cap('publish_pages', true);
    $role->add_cap('read_private_pages', true);
    $role->add_cap('delete_private_pages', true);
    $role->add_cap('delete_published_pages', true);
    $role->add_cap('delete_others_pages', true);
    $role->add_cap('edit_private_pages', true);
    $role->add_cap('edit_published_pages', true);

    // = taxonomies =
    $role->add_cap('manage_categories', true);

    // = appearance =
    $role->add_cap('edit_theme_options', true);

    // === users ===
    $role->add_cap('list_users', true);
    $role->add_cap('create_users', true);
    $role->add_cap('delete_users', true);
    $role->add_cap('promote_users', true);
    $role->add_cap('remove_users', true);
}

add_action('init', 'add_client_role_capabilities', 11);

// === Remove some pages for this role ===
add_action('admin_menu', function () {
    $current_user = wp_get_current_user();
    if (in_array('client_role', (array) $current_user->roles)) {
        // echo '<pre>' . print_r( $GLOBALS[ 'menu' ], true) . '</pre>';
        // die();
        // === remove unnecessary admin pages ===//
        remove_menu_page('tools.php');
        remove_menu_page('maxmegamenu');
        remove_menu_page('analogwp_templates');
        remove_menu_page('happy-addons');
        remove_menu_page('ai1wm_export');
        remove_menu_page('options-general.php');
        remove_menu_page('edit.php?post_type=acf-field-group');
        remove_menu_page('postman');
        remove_menu_page('members-settings');
    }
}, 999999);

// Taxonomy Slug function
function taxoTermsSLugGallery($id, $taxonomy_val)
{
    $termsArray = get_the_terms($id, $taxonomy_val);
    $termsSLug = "";
    if ($termsArray) {
        foreach ($termsArray as $term) {
            $termsSLug .= $term->slug;
        }
    }
    return $termsSLug;
}


/**
 * =========================================================
 * Youtube Video Thumbnail
 * =========================================================
 */
if (!function_exists('acf_youtube_thumbnail')) {
    function acf_youtube_thumbnail($oembed)
    {

        preg_match('/src="(.+?)"/', $oembed, $matches_url);
        $src = $matches_url[1];

        preg_match('/embed(.*?)?feature/', $src, $matches_id);
        $id = $matches_id[1];
        $id = str_replace(str_split('?/'), '', $id);

        return '<img  class="related-img" src="http://img.youtube.com/vi/' . $id . '/hqdefault.jpg">';
    }
}

