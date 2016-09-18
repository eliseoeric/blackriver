<?php

namespace Blackriver\providers;

use Blackriver\Admin\DashboardController;
use Blackriver\Admin\UserController;
use Blackriver\ServiceProvider;

class DashboardControllerProvider extends ServiceProvider {

	public function boot() {
	}

	public function register() {
		$this->container->singleton( 'dashboard_controller', function( $app ) {
			return new DashboardController(
				$app['action_filter_controller']
			);
		});

		$this->container->singleton( 'user_controller', function( $app ) {
			return new UserController(
				$app['action_filter_controller']
			);
		});
	}
}