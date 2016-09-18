<?php
namespace Blackriver\Admin;

class DashboardController {

	protected $loader;

	public function __construct( $loader ) {

		$this->loader = $loader;
	}

	public function boot() {
		$this->loader->add_action( 'after_setup_theme', $this, 'register_hooks', 100 );
//		$this->loader->add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
	}


	public function  register_hooks()
	{
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
	}

	public function admin_footer_text()
	{
		echo '<span id="footer-thankyou">Designed and managed by <a href="https://www.thinkgeneric.com">Think Generic</a>.</span>';
	}


}