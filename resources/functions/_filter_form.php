<?php

function get_filter_form($posttype, $taxonomies = '', $_GET_category = '')
{
    $terms_location = '';
    $terms = '';
    if ($taxonomies == 'work-category') {
        $terms_location = get_terms(['taxonomy' => $taxonomies]);
        // var_dump($terms_location);
    } else if ($taxonomies) {
        $terms = get_terms(['taxonomy' => $taxonomies]);
    }

    $tax_name_exploded = explode("_", $taxonomies);
    $tax_name = ucwords(join(' ', $tax_name_exploded));


    /**
     * ===================================
     *  related_thematic_area
     *  data in this post type 
     * ===================================
     */
    $related_thematic_area_data = [];
    $arg = array(
        'post_type' => $posttype,
        'posts_per_page' => '-1',
        'post_status' => array('publish'),
    );
    $the_query = new WP_Query($arg);
    // var_dump($the_query);
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            get_the_ID();
            $related_thematic_area_id = get_field('related_thematic_area');
            if ($related_thematic_area_id) {
                foreach ($related_thematic_area_id as $thematic_area) {
                    if (isset($thematic_area->ID) && !in_array($thematic_area->ID, $related_thematic_area_data)) {
                        array_push($related_thematic_area_data, $thematic_area->ID);
                    }
                }
            }
        }
    }
    wp_reset_postdata();

    /**==============================
     * Url Parameters
     *================================*/
    if (is_tax()) {
        $queried_object = get_queried_object();
        $_GET_category = $queried_object->slug;
    } else {
        $_GET_category = (isset($_GET["category"])) ? $_GET["category"] : '';
    }
    $post_type =  (isset($_GET['post_type'])) ? $_GET['post_type'] : get_post_type();
    $_GET_free_title = (isset($_GET["free_title"])) ? $_GET["free_title"] : '';
    $_GET_related_thematic_area = (isset($_GET["related_thematic_area"])) ? $_GET["related_thematic_area"] : '';
    $_GET_filter_project_status = (isset($_GET["filter_project_status"])) ? $_GET["filter_project_status"] : '';
    $_GET_project_location = (isset($_GET["project_location"])) ? $_GET["project_location"] : '';

    $_GET_year = (isset($_GET["p_year"])) ? $_GET["p_year"] : '';
    ob_start();
    ?>

<div class="container">
    <div class="relative z-10 pt-24 section-filter">
        <p class="section-filter__title">Search and filter</p>

        <div class="filter-aside">
            <div class="filter-content">
                <form method="GET" role="search" class="flex flex-wrap items-center gap-6"
                    data-url="<?php echo home_url() . '/' . $posttype; ?>" id="search-area">

                    <div class="filter-block search_title filter-input-wrapper">
                        <input type="text" class="" name="free_title" value="<?php echo $_GET_free_title; ?>"
                            placeholder="Search by keyword">
                    </div>
                    <?php if ($posttype === 'work') { ?>

                    <div class="filter-block search_filter_project_status">
                        <div class="accordion">
                            <div class="accordion-title">
                                <div class="title">Projects</div>
                                <span class="icon"><?php echo useSvg('down-icon'); ?> </span>
                            </div>

                            <!-- Filter Content -->
                            <div class="accordion-body">
                                <div class="accordion-body__wrapper form-select select2-hidden-accessible">

                                    <div class="checkbox-wrapper">
                                        <label class="checkbox-item">
                                            <input type="checkbox" name="filter_project_status[]" id="" value="current">

                                            <span class=""> Current Work </span>
                                        </label>
                                    </div>

                                    <div class="checkbox-wrapper">
                                        <label class="checkbox-item">
                                            <input type="checkbox" name="filter_project_status[]" id=""
                                                value="phased_out">

                                            <span class=""> Phased Out Work </span>
                                        </label>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                    <?php } ?>

                    <?php
                        if ($terms_location) {
                            ?>
                    <div class="filter-block search_location">


                        <div class="accordion">
                            <div class="accordion-title">
                                <div class="title">All Category</div>
                                <span class="icon"><?php echo useSvg('down-icon'); ?> </span>
                            </div>

                            <!-- Filter Content -->
                            <div class="accordion-body">
                                <div class="accordion-body__wrapper form-select select2-hidden-accessible">

                                    <?php
                                            foreach ($terms_location as $term) {
                                                $select_category = ($_GET_project_location == $term->slug) ? 'selected' : '';
                                                ?>
                                    <div class="checkbox-wrapper">
                                        <label class="checkbox-item">
                                            <input type="checkbox" name="filter_project_location[]" id=""
                                                value="<?php echo $term->slug; ?>" <?php echo $select_category; ?>>

                                            <span class=""> <?php echo $term->name; ?> </span>
                                        </label>
                                    </div>

                                    <?php } ?>
                                </div>

                            </div>

                        </div>
                    </div>
                    <?php
                        } ?>

                    <!--category -->
                    <?php
                        if ($terms) {
                            ?>

                    <div class="accordion">
                        <div class="accordion-title">
                            <div class="title">All Resources Category</div>
                            <span class="icon"><?php echo useSvg('down-icon'); ?> </span>
                        </div>

                        <!-- Filter Content -->
                        <div class="accordion-body">
                            <div class="accordion-body__wrapper form-select select2-hidden-accessible">
                                <?php
                                        foreach ($terms as $term) {
                                            $select_category = ($_GET_category == $term->slug) ? 'selected' : '';
                                            ?>
                                <div class="checkbox-wrapper">
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="category[]" id=""
                                            value="<?php echo $term->slug; ?>" <?php echo $select_category; ?>>

                                        <span class=""> <?php echo $term->name; ?> </span>
                                    </label>
                                </div>

                                <?php } ?>
                            </div>
                        </div>

                    </div>

                    <?php
                        } ?>
                    <?php


                        /**
                         * =================================
                         * Related Thematic Area Dropdown
                         * =================================
                         */
                        if ($related_thematic_area_data) {
                            ?>
                    <div class="filter-block search_thematic_area">

                        <div class="accordion">
                            <div class="accordion-title">
                                <div class="title">All Thematic Area</div>
                                <span class="icon"><?php echo useSvg('down-icon'); ?> </span>
                            </div>

                            <!-- Filter Content -->
                            <div class="accordion-body">
                                <div class="accordion-body__wrapper form-select select2-hidden-accessible">

                                    <?php
                                            foreach ($related_thematic_area_data as $related_thematic_area_value) {
                                        $select_related_thematic_area = ($_GET_related_thematic_area == $related_thematic_area_value)
                                                ?>
                                    <div class="checkbox-wrapper">
                                        <label class="checkbox-item form-select select2-hidden-accessible">
                                            <input type="checkbox" name="related_thematic_area[]" id=""
                                                value="<?php echo $related_thematic_area_value; ?>"
                                                <?php echo $select_related_thematic_area; ?>>

                                            <span class=""> <?php echo get_the_title($related_thematic_area_value); ?>
                                            </span>
                                        </label>
                                    </div>

                                    <?php } ?>
                                </div>

                            </div>

                        </div>

                    </div>
                    <?php }


                        /**
                         * ==========================================
                         * Year Dropdown
                         * ==========================================
                         *
                         */
                         if ($posttype === 'resource') {

                            $terms_year = array(
                                'post_type' => array($posttype),
                            );

                            $years = array();
                            $query_year = new WP_Query($terms_year);

                            if ($query_year->have_posts()):
                                while ($query_year->have_posts()):
                                    $query_year->the_post();
                                    $year = get_field('publish_date');
                                    if($year){
                                        $year = (int)explode(',',$year)[1];
                                        if($year){
                                            if (!in_array($year, $years)) {
                                                $years[] = $year;
                                            }
                                        }
                                       
                                    }
                                    
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            asort($years);
                            ?>
                    <div class="accordion" filter-action="">
                        <div class="accordion-title">
                            <div class="title">All Years</div>
                            <span class="icon"><?php echo useSvg('down-icon'); ?> </span>
                        </div>

                        <!-- Filter Content -->
                        <div class="accordion-body">
                            <div class="accordion-body__wrapper form-select select2-hidden-accessible">
                                <?php foreach ($years as $x) {
                                ?>
                                <div class="checkbox-wrapper">
                                    <label class="checkbox-item form-select select2-hidden-accessible">
                                        <input type="checkbox" name="p_year" value="<?php echo $x ; ?>">
                                        <?php echo $x; ?>
                                        </span>
                                    </label>
                                </div>

                                <?php } ?>
                            </div>

                        </div>

                    </div>
                    <?php
                        }

                        ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $return_filter_form = ob_get_contents();
    ob_end_clean();

    return $return_filter_form;
}




// Report And Covid Filter Costimize
function resource_report_covid_filter_form($posttype, $taxonomies = '', $_GET_category = '')
{
    $terms = get_terms([
        'taxonomy' => $taxonomies,
        'slug' => ['reports', 'covid-newsletter'] // Replace with your desired term slugs
    ]);
    
    $tax_name_exploded = explode("_", $taxonomies);
    $tax_name = ucwords(join(' ', $tax_name_exploded));


    /**
     * ===================================
     *  related_thematic_area
     *  data in this post type 
     * ===================================
     */
    $related_thematic_area_data = [];
    $arg = array(
        'post_type' => $posttype,
        'posts_per_page' => '-1',
        'post_status' => array('publish'),
        'tax_query' => array(
        array(
            'taxonomy' => 'resource-category', // Assuming 'category' is the taxonomy
            'field' => 'slug',
            'terms' => array('reports', 'covid-newsletter'), // Replace with the slugs of your categories
        ),
    ),
    );
    $the_query = new WP_Query($arg);
    // var_dump($the_query);
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            get_the_ID();
            $related_thematic_area_id = get_field('related_thematic_area');
            if ($related_thematic_area_id) {
                foreach ($related_thematic_area_id as $thematic_area) {
                    if (isset($thematic_area->ID) && !in_array($thematic_area->ID, $related_thematic_area_data)) {
                        array_push($related_thematic_area_data, $thematic_area->ID);
                    }
                }
            }
        }
    }
    wp_reset_postdata();

    /**==============================
     * Url Parameters
     *================================*/
    if (is_tax()) {
        $queried_object = get_queried_object();
        $_GET_category = $queried_object->slug;
    } else {
        $_GET_category = (isset($_GET["category"])) ? $_GET["category"] : '';
    }
    $post_type =  (isset($_GET['post_type'])) ? $_GET['post_type'] : get_post_type();
    $_GET_free_title = (isset($_GET["free_title"])) ? $_GET["free_title"] : '';
    $_GET_related_thematic_area = (isset($_GET["related_thematic_area"])) ? $_GET["related_thematic_area"] : '';


    $_GET_year = (isset($_GET["p_year"])) ? $_GET["p_year"] : '';
    ob_start();
    ?>

<div class="container">
    <div class="relative z-10 pt-24 section-filter">
        <p class="section-filter__title">Search and filter</p>

        <div class="filter-aside">
            <div class="filter-content">
                <form method="GET" role="search" class="flex flex-wrap items-center gap-6"
                    data-url="<?php echo home_url() . '/reports' ?>" id="search-area">

                    <div class="filter-block search_title filter-input-wrapper">
                        <input type="text" class="" name="free_title" value="<?php echo $_GET_free_title; ?>"
                            placeholder="Search by keyword">
                    </div>
                     <!--category -->
                    <?php
                        if ($terms) {
                            ?>

                    <div class="accordion">
                        <div class="accordion-title">
                            <div class="title">All Resources Category</div>
                            <span class="icon"><?php echo useSvg('down-icon'); ?> </span>
                        </div>

                        <!-- Filter Content -->
                        <div class="accordion-body">
                            <div class="accordion-body__wrapper form-select select2-hidden-accessible">
                                <?php
                                        foreach ($terms as $term) {
                                            $select_category = ($_GET_category == $term->slug) ? 'selected' : '';
                                            ?>
                                <div class="checkbox-wrapper">
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="category[]" id=""
                                            value="<?php echo $term->slug; ?>" <?php echo $select_category; ?>>

                                        <span class=""> <?php echo $term->name; ?> </span>
                                    </label>
                                </div>

                                <?php } ?>
                            </div>
                        </div>

                    </div>

                    <?php
                        } ?>
                    <?php


                        /**
                         * =================================
                         * Related Thematic Area Dropdown
                         * =================================
                         */
                        if ($related_thematic_area_data) {
                            ?>
                    <div class="filter-block search_thematic_area">

                        <div class="accordion">
                            <div class="accordion-title">
                                <div class="title">All Thematic Area</div>
                                <span class="icon"><?php echo useSvg('down-icon'); ?> </span>
                            </div>

                            <!-- Filter Content -->
                            <div class="accordion-body">
                                <div class="accordion-body__wrapper form-select select2-hidden-accessible">

                                    <?php
                                            foreach ($related_thematic_area_data as $related_thematic_area_value) {
                                        $select_related_thematic_area = ($_GET_related_thematic_area == $related_thematic_area_value)
                                                ?>
                                    <div class="checkbox-wrapper">
                                        <label class="checkbox-item form-select select2-hidden-accessible">
                                            <input type="checkbox" name="related_thematic_area[]" id=""
                                                value="<?php echo $related_thematic_area_value; ?>"
                                                <?php echo $select_related_thematic_area; ?>>

                                            <span class=""> <?php echo get_the_title($related_thematic_area_value); ?>
                                            </span>
                                        </label>
                                    </div>

                                    <?php } ?>
                                </div>

                            </div>

                        </div>

                    </div>
                    <?php }


                        /**
                         * ==========================================
                         * Year Dropdown
                         * ==========================================
                         *
                         */
                         if ($posttype === 'resource') {

                            $terms_year = array(
                                'post_type' => array($posttype),
                                'post_per_page' => -1
                            );

                            $years = array();
                            $query_year = new WP_Query($terms_year);

                            if ($query_year->have_posts()):
                                while ($query_year->have_posts()):
                                    $query_year->the_post();
                                    $year = get_field('publish_date');
                                    if($year){
                                        $year = (int)explode(',',$year)[1];
                                        if($year){
                                            if (!in_array($year, $years)) {
                                                $years[] = $year;
                                            }
                                        }
                                       
                                    }
                                    
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            asort($years);
                            ?>
                    <div class="accordion" filter-action="">
                        <div class="accordion-title">
                            <div class="title">All Years</div>
                            <span class="icon"><?php echo useSvg('down-icon'); ?> </span>
                        </div>

                        <!-- Filter Content -->
                        <div class="accordion-body">
                            <div class="accordion-body__wrapper form-select select2-hidden-accessible">
                                <?php foreach ($years as $x) {
                                ?>
                                <div class="checkbox-wrapper">
                                    <label class="checkbox-item form-select select2-hidden-accessible">
                                        <input type="checkbox" name="p_year" value="<?php echo $x ; ?>">
                                        <?php echo $x; ?>
                                        </span>
                                    </label>
                                </div>

                                <?php } ?>
                            </div>

                        </div>

                    </div>
                    <?php
                        }

                        ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $return_filter_form = ob_get_contents();
    ob_end_clean();

    return $return_filter_form;
}