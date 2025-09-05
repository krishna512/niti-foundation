<?php

/**
 * Default taxonomy archive page template part
 * @package drschool
 */

$filename = get_post_type();
$queried_object = get_queried_object();
$archive_folder = 'app/template-parts/archive/';
$tax_folder = 'app/template-parts/';

if (is_tag() || is_tax()) {
    $current_taxonomy = $queried_object->taxonomy;
    get_template_part($tax_folder . 'taxonomy/' . $current_taxonomy);
} else {
    get_template_part($archive_folder . 'archive', $filename);
}

