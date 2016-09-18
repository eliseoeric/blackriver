<?php
namespace Blackriver\providers;

use Blackriver\controllers\ModuleController;
use Blackriver\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider {

	protected $modules = [
		'clean-up',
		'nav-walker',
		'nice-search',
		'jquery-cdn',
		'relative-urls'
	];

	public function boot() {
	}

	public function register() {
		$this->container->singleton( 'module_controller', function( $app ) {

			return new ModuleController(
				$app['action_filter_controller'],
				$this->modules
			);
		});
	}
}