<?php
namespace Blackriver\controllers;

class ModuleController {

	protected $modules = [];
	protected $loader;

	public function __construct( $loader, $modules ) {

		$this->loader = $loader;
		$this->modules = $modules;
	}

	public function boot() {
		$this->loader->add_action( 'after_setup_theme', array( $this, 'load_modules' ), 100 );
	}

	public function load_modules() {
		dd('hello from the module loader');
	}
}
