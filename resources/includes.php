<?php

/**
 * Set up
 */

 $libDIR = dirname(__FILE__) . '/lib/';

 // require_once $libDIR . '_vite.php';
 require_once $libDIR . '_vite.lib.php';
 require_once $libDIR . '_setup.php';
 

$functions = dirname(__FILE__) . '/functions/';

require_once $functions . '/_login.php';

require_once $functions . '/_securities.php';

require_once $functions . '/_utils.php';

require_once $functions . '/_acf-hooks.php';

require_once $functions . '/_admin-hooks.php';

require_once $functions . '/_shortcode.php';

require_once $functions . '/_custom_function.php';

require_once  $functions . '/_pagination.php';

require_once  $functions . '/_buttons.php';

require_once  $functions . '/_pre_get_posts.php';

require_once  $functions . '/_filter_form.php';