<?php
namespace Blackriver\Admin;

class UserController {

	protected $loader;

	public function __construct( $loader ) {

		$this->loader = $loader;
	}

	public function boot()
	{
		$this->loader->add_action( 'after_setup_theme', $this, 'register_hooks' );
	}

	public function register_hooks()
	{
		dd('client');
		$client = add_role(
			'Client',
			__( 'Client' ),
			array(
				'read' => true,
				'edit_posts' => true,
				'delete_posts' => true,
			)
		);
	}
}
