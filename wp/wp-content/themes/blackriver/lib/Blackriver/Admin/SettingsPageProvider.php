<?php

namespace Blackriver\Admin;

use Blackriver\ServiceProvider;

class SettingsPageProvider extends ServiceProvider{


	public function boot()
	{
		dd("Hello from SettingsPageProvider::boot!");
	}
	/**
	 * Register the service provider
	 * @return void
	 */
	public function register( )
	{
		$this->container->singleton( 'settings_page', function( $app ){
			return new SettingsPage( array(
				'is_parent' => true,
				'parent_slug' => 'options-general.php',
				'page_title' => 'Blackriver',
				'menu_title' => 'Blackriver',
				'capability' => 'manage_options',
				'menu_slug' => 'blackriver-settings',
				'option_group' => 'blackriver_option_group',
				'option_name' => 'blackriver_option_name',
				'metabox_id' => 'blackriver_metabox'
			) );
		});
	}
}