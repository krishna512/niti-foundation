<?php

/**
 * ==================================================
 *  Get current year
 * ==================================================
 */

if (!function_exists('currentYear')) {
    function currentYear($atts)
    {
        return date('Y');
    }
    add_shortcode('year', 'currentYear');
}

/**
 * ==================================================
 *  Identify if homepage
 * ==================================================
 */
if (!function_exists('homepage')) {
    function homepage($atts)
    {
        if (is_front_page()) {
            return 'yes';
        }
        return 'no';
    }
    add_shortcode('is_home', 'homepage');
}


/**
 * =================================================
 * CFF Custom Result Shortcode
 * 
 * Result of turnover form
 * =================================================
 */

if (!function_exists('ccff_fields_result')) {
    function ccff_fields_result($atts)
    {
        $atts = shortcode_atts(
            array(
                'result' => 'false' // Default value is false
            ),
            $atts
        );

        $resultOnly = filter_var($atts['result'], FILTER_VALIDATE_BOOLEAN);

        $html = '<div class="result-grid">';
        if ($resultOnly) {
            $html .= '<div class="result-only"><h2><%fieldname15_value%></h2><p><%fieldname15_label%></p></div>';
        } else {
            // Annual average base salary
            $html .= '<div class="result-list"><h3><%fieldname6_value%></h3><p><%fieldname6_label%></p></div>';

            // Daily cost of covering for the position
            $html .= '<div class="result-list"><h3><%fieldname10_value%></h3><p><%fieldname10_label%></p></div>';

            // Average days to fill roles
            $html .= '<div class="result-list"><h3><%fieldname7_value%></h3><p><%fieldname7_label%></p></div>';

            // Average cost to cover position
            $html .= '<div class="result-list"><h3><%fieldname11_value%></h3><p><%fieldname11_label%></p></div>';

            // Average hiring, onboarding, training costs
            $html .= '<div class="result-list"><h3><%fieldname16_value%></h3><p><%fieldname16_label%></p></div>';

            // Daily cost
            $html .= '<div class="result-list"><h3><%fieldname13_value%></h3><p><%fieldname13_label%></p></div>';

            // Time to productivity
            $html .= '<div class="result-list"><h3><%fieldname17_value%></h3><p><%fieldname17_label%></p></div>';

            // Total loss of productivity per employee
            $html .= '<div class="result-list"><h3><%fieldname12_value%></h3><p><%fieldname12_label%></p></div>';

            // Cost per employee
            $html .= '<div class="result-list"><h3><%fieldname14_value%></h3><p><%fieldname14_label%></p></div>';

            // Total # employees
            $html .= '<div class="result-list"><h3><%fieldname8_value%></h3><p><%fieldname8_label%></p></div>';

            //Expected employee churn (%)
            $html .= '<div class="result-list"><h3><%fieldname9_value%></h3><p><%fieldname9_label%></p></div>';
        }
        $html .= '</div>';

        $main = do_shortcode('[CP_CALCULATED_FIELDS_RESULT formid="7"]' . $html . '[/CP_CALCULATED_FIELDS_RESULT]');

        return $main;
    }
    add_shortcode('ccff_fields_result', 'ccff_fields_result');
}

/**
 * =================================================
 * CFF Custom Result Shortcode
 * 
 * Result of Engagement form
 * =================================================
 */
if (!function_exists('ccff_engagement_result')) {
    function ccff_engagement_result($atts)
    {
        $atts = shortcode_atts(
            array(
                'result' => 'false' // Default value is false
            ),
            $atts
        );

        $resultOnly = filter_var($atts['result'], FILTER_VALIDATE_BOOLEAN);

        $html = '<div class="result-grid">';
        if ($resultOnly) {
            $html .= '<div class="result-only"><h3><%fieldname1_value%></h3><p><%fieldname1_label%></p></div>';
        } else {
            $html .= '<div class="result-list"><h3><%fieldname2_value%></h3><p><%fieldname2_label%></p></div>';
            $html .= '<div class="result-list"><h3><%fieldname4_value%></h3><p><%fieldname4_label%></p></div>';
            $html .= '<div class="result-list"><h3><%fieldname5_value%></h3><p><%fieldname5_label%></p></div>';
        }
        $html .= '</div>';
        $main = do_shortcode('[CP_CALCULATED_FIELDS_RESULT formid="8"]' . $html . '[/CP_CALCULATED_FIELDS_RESULT]');

        return $main;
    }
    add_shortcode('ccff_engagement_result', 'ccff_engagement_result');
}




/**
 * =================================================
 * CFF Custom Result Shortcode
 * 
 * Result of Growth form
 * =================================================
 */
if (!function_exists('ccff_growth_result')) {
    function ccff_growth_result($atts)
    {
        $atts = shortcode_atts(
            array(
                'result' => 'false' // Default value is false
            ),
            $atts
        );

        $resultOnly = filter_var($atts['result'], FILTER_VALIDATE_BOOLEAN);

        $html = '<div class="result-grid">';
        if ($resultOnly) {
            $html .= '<div class="result-only"><h3><%fieldname1_value%></h3><p><%fieldname1_label%></p></div>';
        } else {
            $html .= '<div class="result-list"><h3><%fieldname7_value%></h3><p><%fieldname7_label%></p></div>';
            $html .= '<div class="result-list"><h3><%fieldname8_value%></h3><p><%fieldname8_label%></p></div>';
        }
        $html .= '</div>';
        $main = do_shortcode('[CP_CALCULATED_FIELDS_RESULT formid="9"]' . $html . '[/CP_CALCULATED_FIELDS_RESULT]');

        return $main;
    }
    add_shortcode('ccff_growth_result', 'ccff_growth_result');
}

// Custom shortcode function to display child pages of CASE STUDIES parent pages from a custom post type with a search filter
function custom_post_type_child_pages_shortcode_with_search_case_studies($atts)
{
    // Parse shortcode attributes
    $atts = shortcode_atts(
        array(
            'parent_ids' => '8194', // Default value for parent page IDs
            'post_type' => 'resource', // Default value for custom post type
        ),
        $atts
    );

    // Extract parent page IDs from shortcode attribute
    $parent_ids = explode(',', $atts['parent_ids']);

    // Get search query if provided
    $search_query = isset($_GET['search_query']) ? sanitize_text_field($_GET['search_query']) : '';

    // Custom query arguments
    $args = array(
        'post_type' => $atts['post_type'],
        'post_parent__in' => $parent_ids,
        'posts_per_page' => -1, // Get all child pages
        's' => $search_query, // Include search query
        // Add any additional query parameters as needed
    );

    // Custom query
    $child_pages_query = new WP_Query($args);

    // Output buffer
    ob_start();

    // Search filter form
    ?>


    <div class="container">
        <div class="row">
            <?php

            // Check if there are child pages
            if ($child_pages_query->have_posts()):
                while ($child_pages_query->have_posts()):
                    $child_pages_query->the_post();


                    echo resource_hub();

                endwhile;
                wp_reset_postdata(); // Reset post data
            else:
                // If no child pages found, display a message or fallback content
                echo 'No child pages found.';
            endif;
            ?>
        </div>
    </div>
    <?php
    // Return buffered content
    return ob_get_clean();
}
// Register the shortcode
add_shortcode('custom_child_pages_with_search_cuse_studies', 'custom_post_type_child_pages_shortcode_with_search_case_studies');



// Custom shortcode function to display child pages of EBOOK parent pages from a custom post type with a search filter
function custom_post_type_child_pages_shortcode_with_search_ebook($atts)
{
    // Parse shortcode attributes
    $atts = shortcode_atts(
        array(
            'parent_ids' => '7257', // Default value for parent page IDs
            'post_type' => 'resource', // Default value for custom post type
        ),
        $atts
    );

    // Extract parent page IDs from shortcode attribute
    $parent_ids = explode(',', $atts['parent_ids']);

    // Get search query if provided
    $search_query = isset($_GET['search_query']) ? sanitize_text_field($_GET['search_query']) : '';

    // Custom query arguments
    $args = array(
        'post_type' => $atts['post_type'],
        'post_parent__in' => $parent_ids,
        'posts_per_page' => -1, // Get all child pages
        's' => $search_query, // Include search query
        // Add any additional query parameters as needed
    );

    // Custom query
    $child_pages_query = new WP_Query($args);

    // Output buffer
    ob_start();

    // Search filter form
    ?>

    <div class="container">
        <div class="row">
            <?php

            // Check if there are child pages
            if ($child_pages_query->have_posts()):
                while ($child_pages_query->have_posts()):
                    $child_pages_query->the_post();
                    $feature_img = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : '';
                    echo resource_hub();
                    // Display child page content
        
                endwhile;
                wp_reset_postdata(); // Reset post data
            else:
                // If no child pages found, display a message or fallback content
                echo 'No child pages found.';
            endif;
            ?>
        </div>
    </div>


    <?php

    // Return buffered content
    return ob_get_clean();
}
// Register the shortcode
add_shortcode('custom_child_pages_with_search_ebook', 'custom_post_type_child_pages_shortcode_with_search_ebook');



// Shortcode For Author Name Details Display

if (!function_exists('author_shortcode')) {
    function author_shortcode()
    {

        $blog_author = get_field('author');
        if ($blog_author) { ?>
            <div class="author-single-info">

                <div class="author-single-data">

                    <span class="author-name">
                        <span class="date-icon"> <?php echo useSVG('new_slash'); ?> </span>
                        Posted By : <?php
                        $author = [];
                        foreach ($blog_author as $post) {
                            $permalink = get_permalink($post->ID);
                            $author[] = '<a href="' . esc_url($permalink) . '">' . $post->post_title . '</a>';

                        }

                        echo implode(', ', $author);
                        ?>
                    </span>
                </div>
            </div>
            <?php
        }
    }

    add_shortcode('author_name_2', 'author_shortcode');
}

// Shortcode For Work Themes Single Page Display

if (!function_exists('Work_themes_shortcode')) {
    function Work_themes_shortcode()
    {
        // Related Thematic Area

        $related_thematic_area = get_field('related_thematic_area');

        if ($related_thematic_area) {
            ?>
            <div class="author-wrapper">

                <div class="work-single-info">

                    <?php foreach ($related_thematic_area as $key => $post) {
                        $permalink = get_permalink($post->ID);

                        $thematic[] = '<a href="' . esc_url($permalink) . '"class="work-single-data">'
                            . get_the_title($post->ID) . '</a>';
                    }

                    echo implode(', ', $thematic);
                    ?>

                </div>
            </div>
            <?php

        } else {
            return '<div class="author-wrapper"><div class="work-single-info">No Themes found</div></div>';
        }
    }

    add_shortcode('work_theme_single', 'Work_themes_shortcode');
}

// Shortcode For Work Themes Single Page Display

if (!function_exists('date_themes_shortcode')) {
    function date_themes_shortcode()
    {
        $published_date = get_field('published_date');
        $project_end_date = get_field('project_end_date');
        ?>
        <div class="work-single-info date">
            <div class="work-single-data">
                <?php if ($published_date || $project_end_date): ?>
                    <span class="date-icon"> <?php echo useSVG('date'); ?> </span>
                    
                <?php endif; ?>
                <?php if ($published_date): ?>
                <?php echo $published_date; ?>

                -
                <?php endif; ?>
                <?php if ($project_end_date): ?>
                    
                    <?php echo $project_end_date; ?>
                <?php endif; ?>
            </div>
        </div>


        <?php
    }

    add_shortcode('date_theme_single', 'date_themes_shortcode');
}


// Shortcode For Event Date

if (!function_exists('event_date_shortcode')) {
    function event_date_shortcode()
    {
        $start_date_and_time = get_field('start_date_and_time');
        $end_date_and_time = get_field('end_date_and_time');
        if ($end_date_and_time || $start_date_and_time):
            ?>
            <div class="event-single-info date">
                <div class="event-single-data">
                    <span class="date-icon"> <?php echo useSVG('fontisto_date'); ?> </span>
                    Event Date :
                    <a class="link"> <?php echo $start_date_and_time; ?>
                        <?php if ($end_date_and_time): ?>
                            -
                            <?php echo $end_date_and_time; ?>
                        <?php endif; ?>
                    </a>
                </div>
            </div>

            <?php
        endif;
    }

    add_shortcode('event_date', 'event_date_shortcode');
}


if (!function_exists('event_date_archive_shortcode')) {
    function event_date_archive_shortcode()
    {
        $start_date_and_time = get_field('start_date_and_time');
        $end_date_and_time = get_field('end_date_and_time');
        if ($end_date_and_time || $start_date_and_time):
            ?>
            <div class="work-single-info date">
                <div class="work-single-data">
                    <span class="date-icon"> <?php echo useSVG('fontisto_date'); ?> </span>
                    <?php echo $start_date_and_time; ?>
                    <?php if ($end_date_and_time): ?>
                        -
                        <?php echo $end_date_and_time; ?>
                    <?php endif; ?>

                </div>
            </div>

            <?php
        endif;
    }

    add_shortcode('event_date_archive', 'event_date_archive_shortcode');
}


// Shortcode For Event venue

if (!function_exists('event_location_shortcode')) {
    function event_location_shortcode()
    {

        $venue = get_field('venue');
        if ($venue):
            ?>


            <div class="author-single-info">

                <div class="author-single-data">

                    <span class="author-name source">
                        <span class="slash-icon"> <?php echo useSVG('new_slash'); ?> </span>
                        Event Location : <a class="link info"><?php echo $venue; ?></a>
                    </span>

                </div>
            </div>
            <?php
        endif;

    }
    add_shortcode('event_location_shortcode', 'event_location_shortcode');
}



// Shortcode For Work Team Single Page Display

if (!function_exists('Work_team_shortcode')) {
    function Work_team_shortcode()
    {
        // Team Member
        $team_members = get_field('team_members');
        if ($team_members) {
            ?>
            <div class="author-wrapper">

                <div class="work-single-info">

                    <?php

                    foreach ($team_members as $key => $post) {
                        $permalink = get_permalink($post->ID);
                        $post_name = $post->post_title;
                        $team_name[] = '<a href="' . esc_url($permalink) . '" class="work-single-data">' . $post_name . '</a>';
                    }
                    echo implode(', ', $team_name);
                    ?>

                </div>
            </div>
            <?php

        } else {
            return '<div class="author-wrapper"><div class="work-single-info">No Team found</div></div>';
        }

    }

    add_shortcode('work_team_single', 'Work_team_shortcode');
}



// Shortcode For Work Single Page Display

if (!function_exists('Work_donor_shortcode')) {
    function Work_donor_shortcode()
    {

        // Donors & Partners
        $related_donors_category = get_field('related_donors_category');
        // var_dump($related_donors_category);


        if ($related_donors_category) { ?>
            <div class="author-wrapper">

                <div class="work-single-info">

                    <?php foreach ($related_donors_category as $key => $post) {
                        $permalink = get_permalink($post->ID);

                        $partner[] = '<a href="' . esc_url($permalink) . '"class="work-single-data">'
                            . get_the_title($post->ID) . '</a>';
                    }

                    echo implode(', ', $partner);
                    ?>

                </div>
            </div>
            <?php


        } else {
            return '<div class="author-wrapper"><div class="work-single-info">No Donor found</div></div>';
        }

    }
    add_shortcode('work_donor_single', 'Work_donor_shortcode');
}


// Shortcode For In the news Source

if (!function_exists('in_the_news_shortcode')) {
    function in_the_news_shortcode()
    {

        $website_link = get_field('website_link');

        if (is_array($website_link) && !empty($website_link)) { ?>
            <div class="work-single-info date">
                <div class="work-single-data">

                    <?php if ($website_link): ?>
                        <span class="date-icon"> <?php echo useSVG('slash'); ?> </span>
                        <?php
                        $link_url = $website_link['url'];
                        $link_title = $website_link['title'];
                        $link_target = $website_link['target'] ? $website_link['target'] : '_self';
                        ?>
                        <a class="link-uderscore" href="<?php echo esc_url($link_url); ?>"
                            target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                    <?php endif; ?>

                </div>
            </div>
            <?php
        }

    }
    add_shortcode('source_shortcode', 'in_the_news_shortcode');
}



if (!function_exists('in_the_news_single_shortcode')) {
    function in_the_news_single_shortcode()
    {

        $website_link = get_field('website_link');

        if (is_array($website_link) && !empty($website_link)) { ?>
            <div class="author-single-info">

                <div class="author-single-data">

                    <span class="author-name source">
                        <span class="slash-icon"> <?php echo useSVG('new_slash'); ?> </span>
                        Source :
                        <?php if ($website_link):
                            $link_url = $website_link['url'];
                            $link_title = $website_link['title'];
                            $link_target = $website_link['target'] ? $website_link['target'] : '_self';
                            ?>
                            <a class="link info" href="<?php echo esc_url($link_url); ?>"
                                target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                        <?php endif; ?>
                    </span>

                </div>
            </div>
            <?php
        }

    }
    add_shortcode('source_single_shortcode', 'in_the_news_single_shortcode');
}



if (!function_exists('audio_shortcode')) {
    function audio_shortcode()
    {

        $audio = get_field('audio');
        // var_dump($audio);
        ?>
        <?php if ($audio): ?>

            <div class="audio-player">
                <audio id="audio" src="<?php echo $audio; ?>"></audio>
                <button id="play-pause" class="play"></button>
                <div class="timeline">
                    <input type="range" id="seek-bar" class="seek-bar" min="0" max="100" value="0" step="1">
                    <span id="current-time">00:00</span> / <span id="duration">00:00</span>
                </div>
                <div class="volume-wrapper">
                    <div id="mute-button" class="volume-btn unmute"></div>
                    <input type="range" id="volume-bar" class="volume-bar" min="0" max="100" value="75">
                </div>

            </div>
        <?php endif; ?>

        <?php

    }
    add_shortcode('audio', 'audio_shortcode');
}



// Work Filter
function project_filter_form_shortcode()
{
    ob_start();
    $posttype = get_post_type();
    $taxonomies = 'work-category';

    $taxonomies_location = 'location';
    echo get_filter_form($posttype, $taxonomies);
    return ob_get_clean();
}

add_shortcode('project_filter_form', 'project_filter_form_shortcode');

//Filter Resource
function resource_filter_form_shortcode()
{
    ob_start();
    $posttype = get_post_type();
    $taxonomies = 'resource-category';
    echo get_filter_form($posttype, $taxonomies);
    return ob_get_clean();
}

add_shortcode('resource_filter_form', 'resource_filter_form_shortcode');

//Filter Resource Report Covid Filter
function resource_report_covid_filter_form_shortcode()
{
    ob_start();
    $posttype = 'resource';
    $taxonomies = 'resource-category';
    echo resource_report_covid_filter_form($posttype, $taxonomies);
    return ob_get_clean();
}

add_shortcode('resource_report_covide_filter_form', 'resource_report_covid_filter_form_shortcode');



// Custom Breadcrumb
function custom_breadcrumb_shortcode()
{
    return custom_breadcrumb();
}
add_shortcode('custom_breadcrumb', 'custom_breadcrumb_shortcode');


// Shortcode Related Project Form Program

if (!function_exists('related_project_shortcode')) {
    function related_project_shortcode()
    {

        $arg = array(
            'post_type' => 'work',
            'posts_per_page' => 4,
            'post_status' => array('publish'),
            'post_parent__in' => [get_the_id()],
        );

        $related_project = get_posts($arg);
        // var_dump($related_project);



        if (is_array($related_project) && !empty($related_project)) { ?>

            <div class="section-background nav-items" id="work">
                <div class="container related-wrapper animate-wrapper">
                    <div class="related-title">
                        <h2>Project</h2>

                        <?php

                        echo '<div class="btn-view">';
                        echo btn_layout_1('View All Project', '/work');
                        echo '</div>';
                        ?>
                    </div>

                    <div class="related-content">
                        <?php

                        foreach ($related_project as $post) {

                            $post_title_limit = get_the_title($post);
                            $published_date = get_field('published_date', $post);
                            $project_end_date = get_field('project_end_date', $post);
                            $permalink = get_permalink($post);
                            $feature_img = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : '';
                            $categories = get_the_terms($post, 'work-category');
                            // var_dump($categories);
            
                            ?>

                            <div class="related-card e-loop-item">

                                <?php
                                if ($categories) {
                                    ?>
                                    <div class="related-category">
                                        <div class="card-tag">
                                            <ul class="card-tag-inner">
                                                <?php
                                                foreach ($categories as $category) {
                                                    ?>
                                                    <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                                        <li class="">
                                                            <?php echo $category->name; ?>
                                                        </li>
                                                    </a>

                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="related-card__content">
                                    <div class="content-wrapper">
                                        <?php if ($published_date || $project_end_date) { ?>
                                            <div class="published-date">

                                                <?php echo useSvg('date');

                                                ?>
                                                <span><?php echo $published_date; ?>
                                                    <?php if ($project_end_date): ?>
                                                        -
                                                        <?php echo $project_end_date; ?>
                                                    <?php endif; ?></span>
                                            </div>
                                        <?php } ?>

                                        <div class="resources-title">
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <?php echo $post_title_limit; ?>
                                            </a>
                                        </div>

                                    </div>

                                    <?php

                                    echo '<div class="btn-view">';
                                    echo btn_layout_1('View detail', $permalink);
                                    echo '</div>';
                                    ?>


                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>


                </div>
            </div>

            <?php


        }
    }
    add_shortcode('related_project', 'related_project_shortcode');
}




// Shortcode Related Updates

if (!function_exists('related_activities_shortcode')) {
    function related_activities_shortcode()
    {

        $args = array(
            'post_type' => 'update',
            'posts_per_page' => '3',
            'post_status' => array('publish'),
            'meta_query' => array(
                'relation' => 'OR', // Can be 'AND' or 'OR'
                array(
                    'key' => 'related_project',
                    'value' => get_the_ID(),
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'related_thematic_area',
                    'value' => get_the_ID(),
                    'compare' => 'LIKE'
                )
            )
        );
        $taxonomies = 'update-category';
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            ?>



            <div class="section-background nav-items" id="activities">
                <div class="container related-wrapper animate-wrapper">
                    <div class="related-title">
                        <h2>Related Updates </h2>

                        <?php

                        echo '<div class="btn-view">';
                        echo btn_layout_1('View All Updates', '/update');
                        echo '</div>';
                        ?>
                    </div>

                    <div class="related-content">
                        <?php
                        while ($the_query->have_posts()) {
                            $the_query->the_post();
                            $id = get_the_ID();
                            $permalink = get_the_permalink();
                            $post_title_limit = get_the_title();
                            $feature_img = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : '';
                            // $published_date = get_the_date('d M, Y');
                            $term_category = get_the_terms($id, $taxonomies);
                            $published_date = get_field('published_date');

                            ?>
                            <div class="related-card e-loop-item" data-id="<?php echo $id; ?>">

                                <?php
                                if ($term_category) {
                                    ?>
                                    <div class="related-category  <?php echo $taxonomies; ?> ">
                                        <div class="card-tag">
                                            <ul class="card-tag-inner">
                                                <?php
                                                foreach ($term_category as $category) {
                                                    ?>
                                                    <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                                        <li class="">
                                                            <?php echo $category->name; ?>
                                                        </li>
                                                    </a>

                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="related-card__content">
                                    <div class="content-wrapper">
                                        <?php if ($published_date): ?>
                                            <div class="published-date">
                                                <?php echo useSvg('date'); ?>
                                                <span><?php echo $published_date; ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <div class="resources-title">
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <?php echo $post_title_limit; ?>
                                            </a>
                                        </div>

                                    </div>

                                    <?php

                                    echo '<div class="btn-view">';
                                    echo btn_layout_1('View detail', $permalink);
                                    echo '</div>';
                                    ?>


                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        </di v>


                    </div>
                </div>

                <?php
        }
        // Reset Post Data
        wp_reset_postdata();

    }
    add_shortcode('related_activities', 'related_activities_shortcode');
}



// Shortcode Related Publication

if (!function_exists('project_publication_shortcode')) {
    function project_publication_shortcode()
    {
        $args = array(
            'post_type' => 'resource',
            'posts_per_page' => '4',
            'post_status' => array('publish'),
            'meta_query' => array(
                'relation' => 'OR', // Can be 'AND' or 'OR'
                array(
                    'key' => 'related_project',
                    'value' => get_the_ID(),
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'related_thematic_area',
                    'value' => get_the_ID(),
                    'compare' => 'LIKE'
                ),
            )
        );
        $taxonomies = 'resource-category';
        $the_query = new WP_Query($args);
        // var_dump($the_query);
        if ($the_query->have_posts()) {
            ?>
                <div class="section-background nav-items" id="resources">
                    <div class="container related-resource related-wrapper animate-wrapper">
                        <div class="related-title">
                            <h2>Related Resources </h2>

                            <?php

                            echo '<div class="btn-view">';
                            echo btn_layout_1('View All Resource', '/resource');
                            echo '</div>';
                            ?>
                        </div>


                        <div class="related-resources__wrapper">
                            <?php
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                                $id = get_the_ID();
                                $permalink = get_the_permalink();
                                $excerpt = get_the_excerpt();
                                $excerpt = substr($excerpt, 0, 150);
                                $excerpt_description = substr($excerpt, 0, strrpos($excerpt, ' '));
                                $post_title_limit = get_the_title();
                                $feature_img = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : get_stylesheet_directory_uri() . '/assets/images/DefaultImage.png';
                                // $published_date = get_the_date('d M, Y');
                                $published_date = get_field('publish_date');
                                $term_category = get_the_terms($id, $taxonomies);

                                ?>
                                <div class="resources-card post-card e-loop-item" data-id="<?php echo $id; ?>">
                                    <div class="resources-aside">
                                        <div class="feature-image">
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <img src="<?php echo $feature_img; ?>" alt="resource -image" class="resources-img">
                                            </a>
                                        </div>

                                        <?php
                                        if ($term_category) {
                                            ?>
                                            <div class="related-category <?php echo $taxonomies; ?> ">
                                                <div class="card-tag">
                                                    <ul class="card-tag-inner">
                                                        <?php
                                                        foreach ($term_category as $category) {
                                                            ?>
                                                            <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                                                <li class="">
                                                                    <?php echo $category->name; ?>
                                                                </li>
                                                            </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="resources-content">
                                        <div class="resources-content-wrapper">
                                            <?php if ($published_date): ?>
                                                <div class="published-date resources-date">
                                                    <?php echo useSvg('date'); ?>
                                                    <?php echo $published_date; ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="resources-title">
                                                <a href="<?php echo get_the_permalink(); ?>">
                                                    <?php echo $post_title_limit; ?>
                                                </a>

                                            </div>
                                            <p class="short-desc"><?php echo $excerpt_description; ?></p>
                                            <?php

                                            echo '<div class="btn-view">';
                                            echo btn_layout_1('View detail', $permalink);
                                            echo '</div>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>


                    </div>
                </div>
                <?php
        }
        // Reset Post Data
        wp_reset_postdata();

    }
    add_shortcode('project_publication', 'project_publication_shortcode');
}





// Shortcode Work Related Thematic Area

if (!function_exists('thematic_area_shortcode')) {
    function thematic_area_shortcode()
    {
        $args = array(
            'post_type' => 'work',
            'posts_per_page' => '3',
            'post_status' => array('publish'),
            'meta_query' => array(
                array(
                    'key' => 'related_thematic_area',
                    'value' => get_the_ID(),
                    'compare' => 'LIKE'
                ),
            )
        );
        $taxonomies = 'work-category';
        $the_query = new WP_Query($args);
        // var_dump($the_query);
        if ($the_query->have_posts()) {
            ?>
                <div class="section-back   ground nav-items " id="program">
                    <div class="container related-wrapper animate-wrapper">
                        <div class="related-title">
                            <h2>Works</h2>

                            <?php

                            echo '<div class="btn-view">';
                            echo btn_layout_1('View All Works', '/work');
                            echo '</div>';
                            ?>
                        </div>

                        <div class="related-content">
                            <?php
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                                $id = get_the_ID();
                                $permalink = get_the_permalink();
                                $post_title_limit = get_the_title();
                                $feature_img = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : "";
                                // var_dump($feature_img);
                                $published_date = get_field('published_date');
                                $project_end_date = get_field('project_end_date');
                                $term_category = get_the_terms($id, $taxonomies);

                                ?>
                                <div class="related-card e-loop-item" data-id="<?php echo $id; ?>">

                                    <?php
                                    if ($term_category) {
                                        ?>
                                        <div class="related-category  <?php echo $taxonomies; ?> ">
                                            <div class="card-tag">
                                                <ul class="card-tag-inner">
                                                    <?php
                                                    foreach ($term_category as $category) {
                                                        ?>
                                                        <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                                            <li class="">
                                                                <?php echo $category->name; ?>
                                                            </li>
                                                        </a>

                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="related-card__content">
                                        <div class="content-wrapper">
                                            <?php if ($published_date || $project_end_date) { ?>
                                                <div class="published-date">
                                                    <?php echo useSvg('date'); ?>
                                                    <span><?php echo $published_date; ?>
                                                        <?php if ($project_end_date): ?>
                                                            -
                                                            <?php echo $project_end_date; ?>
                                                        <?php endif; ?></span>
                                                </div>
                                            <?php } ?>

                                            <div class="resources-title">
                                                <a href="<?php echo get_the_permalink(); ?>">
                                                    <?php echo $post_title_limit; ?>
                                                </a>
                                            </div>

                                        </div>

                                        <?php

                                        echo '<div class="btn-view">';
                                        echo btn_layout_1('View detail', $permalink);
                                        echo '</div>';
                                        ?>


                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>


                    </div>
                </div>
                <?php
        }
        // Reset Post Data
        wp_reset_postdata();

    }
    add_shortcode('thematic_area', 'thematic_area_shortcode');
}



// Shortcode MUltimedia 

if (!function_exists('multimedia_shortcode')) {
    function multimedia_shortcode()
    {

        $args = array(
            'post_type' => 'multimedia',
            'posts_per_page' => -1,
            'post_status' => array('publish'),
            'orderby' => array('meta_value' => 'DESC'),
            'meta_key' => 'published_date',
            'meta_type' => 'DATETIME'

        );
        $taxonomies = 'multimedia-category';
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            ?>
                <div class="section-background nav-items " id="activities">
                    <div class="container related-wrapper animate-wrapper">
                        <div class="related-content ">
                            <?php
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                                $id = get_the_ID();
                                $permalink = get_the_permalink();
                                $post_title_limit = get_the_title();
                                $feature_img = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : get_stylesheet_directory_uri() . '/assets/images/audio.png';
                                // $published_date = get_the_date('d M, Y');
                                $term_category = get_the_terms($id, $taxonomies);
                                $published_date = get_field('published_date');
                                $taxoTermsSLug = taxoTermsSLugGallery($id, $taxonomies);
                                $oEmbed = get_field('video_link');
                                $image = ($oEmbed) ? acf_youtube_thumbnail($oEmbed) : get_the_post_thumbnail($id, 'medium');

                                $upload_photos = get_field('upload_photos');

                                $feature_image = '';
                                if (is_array($upload_photos) || is_object($upload_photos)) {
                                    foreach ($upload_photos as $key => $image) {
                                        if ($key === 0) {
                                            $feature_image = $image['url'];
                                        }
                                    }
                                }

                                ?>
                                <div class="related-card mulitmedia-card e-loop-item" data-id="<?php echo $id; ?>">
                                    <?php if ($taxoTermsSLug == 'video') { ?>
                                        <div class="feature-image">
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <?php echo $image; ?>
                                                <span class="video-play-btn">
                                                    <?php echo useSvg('video-play-btn'); ?>
                                                </span>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <?php if ($taxoTermsSLug == 'photo') { ?>
                                        <div class="feature-image">
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <img src="<?php echo $feature_image; ?>" alt="resource -image" class="related-img">

                                            </a>
                                        </div>
                                    <?php } ?>
                                    <?php if ($taxoTermsSLug == 'audio') { ?>
                                        <div class="feature-image">
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <img src="<?php echo $feature_img; ?>" alt="resource -image" class="related-img">

                                            </a>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($term_category) {
                                        ?>
                                        <div class="related-category  <?php echo $taxonomies; ?> ">
                                            <div class="card-tag">
                                                <ul class="card-tag-inner">
                                                    <?php
                                                    foreach ($term_category as $category) {
                                                        ?>
                                                        <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                                            <li class="">
                                                                <?php echo $category->name; ?>
                                                            </li>
                                                        </a>

                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="related-card__content">
                                        <div class="content-wrapper">
                                            <?php if ($published_date): ?>
                                                <div class="published-date">
                                                    <?php echo useSvg('date'); ?>
                                                    <span><?php echo $published_date; ?></span>
                                                </div>
                                            <?php endif; ?>

                                            <div class="resources-title">
                                                <a href="<?php echo get_the_permalink(); ?>">
                                                    <?php echo $post_title_limit; ?>
                                                </a>
                                            </div>

                                        </div>

                                        <?php

                                        echo '<div class="btn-view">';
                                        echo btn_layout_1('View detail', $permalink);
                                        echo '</div>';
                                        ?>


                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>


                    </div>
                </div>

                <?php
        }
        // Reset Post Data
        wp_reset_postdata();

    }
    add_shortcode('multimedia', 'multimedia_shortcode');
}