<?php
// set posts_per_page for post

function filter_main_query($query)
{


	/**
	 * =========================================
	 * resource
	 * =========================================
	 */
	if (!is_admin() && $query->is_main_query() && is_post_type_archive('resource') ||   $query->is_tax('resource-category')) {
		// post per pagination
		$post_per_page = 10;
		$query->set('posts_per_page', $post_per_page);

		// order
		// $query->set('orderby', 'menu_order');

		$query->set('orderby', ['meta_value' => 'DESC']);
		$query->set('meta_key', 'publish_date');
		$query->set('meta_type', 'DATETIME');


		// get url parameters
		$_GET_category = (isset($_GET["category"])) ? $_GET["category"] : '';

		$_GET_related_thematic_area = (isset($_GET["related_thematic_area"])) ? $_GET["related_thematic_area"] : '';

		$_GET_free_title = (isset($_GET["free_title"])) ? $_GET["free_title"] : '';

		$_GET_year = (isset($_GET["p_year"])) ? $_GET["p_year"] : '';
		// $_GET_publish__year = (isset($_GET['publish-year'])) ? $_GET['publish-year'] : [];

		if ($_GET_free_title) {
			$query->set('s', $_GET_free_title);
		}

		// tax query
		$tax_query = array(
			'relation' => 'OR',
		);
		if ($_GET_category) {
			foreach ($_GET_category as $key => $value) {
				$tax_query[] = array(
					'taxonomy' => 'resource-category',
					'field' => 'slug',
					'terms' => $value,
				);
			}
		}

		// meta query
		$meta_query = array(
			'relation' => 'OR',
		);


		if ($_GET_related_thematic_area) {
			foreach ($_GET_related_thematic_area as $key => $value) {
				$meta_query[] = array(
					'key' => 'related_thematic_area',
					'value' => $value,
					'compare' => 'LIKE'
				);
			}


		}

		if ($_GET_year) {
			$currentYear = $_GET_year . '/1/1';
			$nextYear = (int) $_GET_year + 1 . '/1/1';
			// var_dump($currentYear);
			// var_dump($nextYear);

			$meta_query[] = array(
				'key' => 'publish_date',
				'value' => $currentYear,
				'compare' => '>',
				'type' => 'DATE'
			);

			$meta_query[] = array(
				'key' => 'publish_date',
				'value' => $nextYear,
				'compare' => '<',
				'type' => 'DATE'
			);
		}

		if ($_GET_category) {
			$query->set('tax_query', $tax_query);
		}

		if ($_GET_related_thematic_area || $_GET_year || $_GET_free_title) {
			$query->set('meta_query', $meta_query);
		}


		return;
	}


	/**
	 * =========================================
	 * work
	 * =========================================
	 */
	if (!is_admin() && $query->is_main_query() && (is_post_type_archive('work'))) {
		// post per pagination
		$post_per_page = 12;
		$query->set('posts_per_page', $post_per_page);

		// get url parameters 
		$_GET_project_status = (isset($_GET["filter_project_status"])) ? $_GET["filter_project_status"] : [];

		$_GET_project_location = (isset($_GET["filter_project_location"])) ? $_GET["filter_project_location"] : [];

		$_GET_related_thematic_area = (isset($_GET["related_thematic_area"])) ? $_GET["related_thematic_area"] : [];

		$_GET_free_title = (isset($_GET["free_title"])) ? $_GET["free_title"] : '';

		if ($_GET_free_title) {
			$query->set('s', $_GET_free_title);
		}

		// tax query
		$tax_query = array(
			'relation' => 'OR',
		);
		if ($_GET_project_location) {
			foreach ($_GET_project_location as $key => $value) {
				$tax_query[] = array(
					'taxonomy' => 'work-category',
					'field' => 'slug',
					'terms' => $_GET_project_location,
				);
			}
		}

		// meta query
		$meta_query = array(
			'relation' => 'AND',
		);

		foreach ($_GET_project_status as $key => $value) {
			if ($value == 'current') {
				$meta_query[] = array(
					'key' => 'project_end_date',
					'compare' => '>',
					'value' => date("Y-m-d"),
					'type' => 'DATE'
				);
			}

			if ($value == 'phased_out') {

				$meta_query[] = array(
					'key' => 'project_end_date',
					'compare' => '<=',
					'value' => date("Y-m-d"),
					'type' => 'DATE'
				);
				$meta_query[] = array(
					'key' => 'project_end_date',
					'compare' => 'NOT IN',
					'value' => array(''),
					'type' => 'DATE'
				);

			}

		}

		// meta query
		$meta_query = array(
			'relation' => 'OR',
		);

		if ($_GET_related_thematic_area) {
			foreach ($_GET_related_thematic_area as $key => $value) {

				$meta_query[] = array(
					'key' => 'related_thematic_area',
					'value' => $value,
					'compare' => 'LIKE'
				);
			}

		}


		if ($_GET_project_location) {
			$query->set('tax_query', $tax_query);
		}
		if ($_GET_related_thematic_area || $_GET_project_status || $_GET_free_title) {
			$query->set('meta_query', $meta_query);
		}
		return;
	}
}

add_action('pre_get_posts', 'filter_main_query', 11);


/**
 * Update the Report And Covid widget or  query.
 *
 * @since 1.0.0
 * @param \WP_Query $query The WordPress query instance.
 */
function custom_query_callback($query)
{
	// Modify the posts query here

	$post_per_page = 10;
	$query->set('posts_per_page', $post_per_page);

	$query->set('orderby', ['meta_value' => 'DESC']);
	$query->set('meta_key', 'publish_date');
	$query->set('meta_type', 'DATETIME');

	// get url parameters
	$_GET_category = (isset($_GET["category"])) ? $_GET["category"] : '';

	$_GET_related_thematic_area = (isset($_GET["related_thematic_area"])) ? $_GET["related_thematic_area"] : '';

	$_GET_free_title = (isset($_GET["free_title"])) ? $_GET["free_title"] : '';

	$_GET_year = (isset($_GET["p_year"])) ? $_GET["p_year"] : '';
	// $_GET_publish__year = (isset($_GET['publish-year'])) ? $_GET['publish-year'] : [];

	if ($_GET_free_title) {
		$query->set('s', $_GET_free_title);
	}

	// tax query
	$tax_query = array(
		'relation' => 'OR',
	);
	if ($_GET_category) {
		foreach ($_GET_category as $key => $value) {
			$tax_query[] = array(
				'taxonomy' => 'resource-category',
				'field' => 'slug',
				'terms' => $_GET_category,
			);
		}
	}

	// meta query
	$meta_query = array(
		'relation' => 'OR',
	);


	if ($_GET_related_thematic_area) {

		foreach ($_GET_related_thematic_area as $key => $value) {
			$meta_query[] = array(
				'key' => 'related_thematic_area',
				'value' => $value,
				'compare' => 'LIKE'
			);
		}


	}

	if ($_GET_year) {
		$currentYear = $_GET_year . '/1/1';
		$nextYear = (int) $_GET_year + 1 . '/1/1';
		// var_dump($currentYear);
		// var_dump($nextYear);

		$meta_query[] = array(
			'key' => 'publish_date',
			'value' => $currentYear,
			'compare' => '>',
			'type' => 'DATE'
		);

		$meta_query[] = array(
			'key' => 'publish_date',
			'value' => $nextYear,
			'compare' => '<',
			'type' => 'DATE'
		);
	}

	if ($_GET_category) {
		$query->set('tax_query', $tax_query);
	}

	if ($_GET_related_thematic_area || $_GET_year || $_GET_free_title) {
		$query->set('meta_query', $meta_query);
	}


	return;


}
add_action('elementor/query/report-covid', 'custom_query_callback');



/**
 * Update the Report And Covid widget or  query.
 *
 * @since 1.0.0
 * @param \WP_Query $query The WordPress query instance.
 */
function activities_blog($query)
{
	// Modify the posts query here

	$post_per_page = 16;
	$query->set('posts_per_page', $post_per_page);

	$query->set('orderby', ['meta_value' => 'DESC']);
	$query->set('meta_key', 'published_date');
	$query->set('meta_type', 'DATETIME');

	
	return;



}
add_action('elementor/query/activities-blog', 'activities_blog');

function update($query)
{
	// Modify the posts query here

	$post_per_page = 12;
	$query->set('posts_per_page', $post_per_page);

	$query->set('orderby', ['meta_value' => 'DESC']);
	$query->set('meta_key', 'published_date');
	$query->set('meta_type', 'DATETIME');

	return;
}
add_action('elementor/query/update', 'update');

function homeupdate($query)
{
	// Modify the posts query here

	$post_per_page = 3;
	$query->set('posts_per_page', $post_per_page);

	$query->set('orderby', ['meta_value' => 'DESC']);
	$query->set('meta_key', 'published_date');
	$query->set('meta_type', 'DATETIME');

	return;
}
add_action('elementor/query/update-home', 'homeupdate');


function homepublication($query)
{
	// Modify the posts query here

	$post_per_page = 4;
	$query->set('posts_per_page', $post_per_page);

	$query->set('orderby', ['meta_value' => 'DESC']);
	$query->set('meta_key', 'publish_date');
	$query->set('meta_type', 'DATETIME');

	return;
}
add_action('elementor/query/home-publication', 'homepublication');
