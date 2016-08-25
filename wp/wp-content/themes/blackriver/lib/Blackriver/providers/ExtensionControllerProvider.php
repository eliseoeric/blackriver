<?php
namespace Blackriver\providers;

use Blackriver\controllers\ExtensionController;
use Blackriver\ServiceProvider;

class ExtensionControllerProvider extends ServiceProvider {

	public function boot()
	{

	}

	public function register()
	{
		$this->container->singleton( 'extention_contoller', function( $app ) {
			return new ExtensionController( $app['path'] );
		});
	}

}