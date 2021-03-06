<?php

namespace Blackriver\providers;

use Blackriver\controllers\ActionFilterController;
use Blackriver\ServiceProvider;

class ActionFilterControllerProvider extends ServiceProvider {

	public function boot() {
	}

	public function register() {
		$this->container->singleton( 'action_filter_controller', function( $app ) {
			static $action_loader;
			if( null !== $action_loader ) {
				return $action_loader;
			}
			$action_loader = new ActionFilterController();
			return $action_loader;
		});
	}
}