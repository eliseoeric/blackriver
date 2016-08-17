<?php


if( ! function_exists( 'dd' ) ) {
  function dd( $var ) {
    echo "<pre>";
    var_dump( $var );
    echo "</pre>";
  }
}


/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
//todo turn this into a service provider list
$sage_includes = [
  'modules/assets.php',    // Scripts and stylesheets
  'modules/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'modules/titles.php',    // Page titles
  'modules/wrapper.php',   // Theme wrapper class
  'modules/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


//todo move the CMB2 include stuff somewhere better
if ( file_exists(  __DIR__ . '/lib/cmb2/init.php' ) ) {
  require_once  __DIR__ . '/lib/cmb2/init.php';
} elseif ( file_exists(  __DIR__ . '/lib/CMB2/init.php' ) ) {
  require_once  __DIR__ . '/lib/CMB2/init.php';
}

// Begin autoloading code
//todo: Take the sage code above and factor it into the autoloader
spl_autoload_register( 'blackriver_autoloader' );
function blackriver_autoloader( $class_name ) {
  if ( false !== strpos( $class_name, 'Blackriver' ) ) {
    $classes_dir = realpath( get_template_directory() ) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
    $class_file = str_replace( '\\', DIRECTORY_SEPARATOR, $class_name ) . '.php';
    require_once $classes_dir . $class_file;
  }
}