<?php

function remove_posts_columns($defaults)
{
    unset($defaults['author']);
    return $defaults;
}
add_filter('manage_posts_columns', 'remove_posts_columns');