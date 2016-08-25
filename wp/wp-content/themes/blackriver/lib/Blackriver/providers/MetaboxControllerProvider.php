<?php
namespace Blackriver\providers;

use Blackriver\controllers\MetaboxController;
use Blackriver\ServiceProvider;

class MetaboxControllerProvider extends ServiceProvider {

	public function boot() {
		dd('booted');
	}

	public function register()
	{
		$this->container->singleton( 'metabox_controller', function( $app ) {
			return new MetaboxController( );
		});
	}
}