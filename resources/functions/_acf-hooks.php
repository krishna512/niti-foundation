<?php

function acf_json_save_point($path)
{
    return get_stylesheet_directory() . '/acf-json';
}

add_filter('acf/settings/save_json', 'acf_json_save_point');

/**
 * Save CPT json in specific folder
 */
function acf_cpt_save_folder($path)
{
    return get_stylesheet_directory() . '/acf-json/post-types';
}

add_filter('acf/settings/save_json/type=acf-post-type', 'acf_cpt_save_folder');

/**
 * Save blocktypes json in specific folder
 */
function acf_blocktype_save_folder($path)
{
    return get_stylesheet_directory() . '/acf-json/block-types';
}

add_filter('acf/settings/save_json/type=acfe-dbt', 'acf_blocktype_save_folder');


/**
 * Save json in custom file names
 */
function custom_acf_json_filename($filename, $post, $load_path)
{
    $filename = str_replace(
        array(
            ' ',
            '_',
        ),
        array(
            '-',
            '-'
        ),
        $post['title']
    );

    $filename = strtolower($filename) . '.json';

    return $filename;
}
// add_filter('acf/json/save_file_name', 'custom_acf_json_filename', 10, 3);


/**
 * ================================================
 * Local Sync - Load json file on theme load.
 * ================================================
 */

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point($paths)
{

    unset($paths[0]);

    $paths[] = get_stylesheet_directory() . '/acf-json';
    $paths[] = get_stylesheet_directory() . '/acf-json/post-types';

    return $paths;
}

/**
 * ================================================
 * Enable/Disable acf extended modules
 * ================================================
 */

add_action('acf/init', 'my_acfe_modules');
function my_acfe_modules()
{
    // disable block type module
    acf_update_setting('acfe/modules/block_types', false);

    // disable forms module
    acf_update_setting('acfe/modules/forms', false);

    // disable options module
    acf_update_setting('acfe/modules/options', false);

    // disable post type module
    acf_update_setting('acfe/modules/post_types', false);

    // disable taxonomies module
    acf_update_setting('acfe/modules/taxonomies', false);

    // disable options pages module
    acf_update_setting('acfe/modules/options_pages', false);
}