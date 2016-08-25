<?php
namespace Blackriver\controllers;

class ExtensionController {

	protected $shortcode_dir;
	protected $post_type_dir;
	protected $widget_dir;
	protected $template_functions_dir;

	public function __construct( $container_path ) {
		$this->container_path = $container_path;
		$this->shortcode_dir = '/lib/Blackriver/shortcodes/';
		$this->post_type_dir = '/lib/Blackriver/post-types/';
		$this->widget_dir = '/lib/Blackriver/widgets/';
		$this->template_functions_dir = '/lib/Blackriver/template-functions/';
	}

	public function boot() {
		$shortcodes = scandir( get_template_directory() . $this->shortcode_dir );
		$this->register_shortcodes( $shortcodes );

		$post_types = scandir( get_template_directory() . $this->post_type_dir );
		$this->register_posts( $post_types );

		$widgets = scandir( get_template_directory() . $this->widget_dir );
		$this->register_widgets( $widgets );

		$template_functions = scandir( get_template_directory() . $this->template_functions_dir );
		$this->register_template_functions( $template_functions );

		add_action( 'after_switch_theme', function() {
			flush_rewrite_rules();
		});
	}

	private function directory_check( $files ) {

	}

	/**
	 * @param $file string The file name to be included
	 * @param $dir string The directory the file can be found in
	 */
	public function register_type( $file, $dir ) {
		if( $file == '' || is_null( $file ) ) {
			return;
		}
		if( $file != '.' && $file != '..' ) {
			require $this->container_path . $dir . $file;
		}
	}

	/**
	 * Loop through and register the shortcodes in the shortcode directory
	 * @param $shortcodes array List off all shortcode filenames
	 */
	public function register_shortcodes( $shortcodes ) {
		foreach( $shortcodes as $code )
		{
			$this->register_type( $code, $this->shorcode_dir );
		}
	}
	/**
	 * Loop through and register the custom post types in the shortcode directory.
	 * @param $post_types array List of all the custom post type filenames
	 */
	public function register_posts( $post_types ) {
		foreach( $post_types as $type )
		{
			$this->register_type( $type, $this->post_type_dir );
		}
	}
	/**
	 * @param $template_functions
	 */
	public function register_template_functions( $template_functions ) {
		foreach( $template_functions as $function )
		{
			$this->register_type( $function, $this->template_functions_dir );
		}
	}
	/**
	 * Loop through and register the widgets  in the widget directory
	 * @param $widgets array List of all the widgets filenames
	 */
	public function register_widgets( $widgets ) {
		foreach( $widgets as $widget )
		{
			if( $widget == '.' || $widget == '..' ) {
				return;
			}

			$this->register_type( $widget, $this->widget_dir );
			if( !$widget == '' && !is_null( $widget ) ) {
				add_action( 'widgets_init', function() use ($widget) {
					register_widget( $widget );
				} );
			}
		}
	}
}