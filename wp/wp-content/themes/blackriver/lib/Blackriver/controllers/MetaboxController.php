<?php

namespace Blackriver\controllers;

class MetaboxController {
	protected $groups;
	protected $metabox_dir = '/lib/Blackriver/metaboxes';

	public function boot() {
		$this->groups = scandir( get_template_directory() . $this->metabox_dir );
		$this->register_metabox_groups($this->groups);
	}

	/**
	 * Registers the metaboxs in the metabox directory
	 */
	public function register_metabox_groups( $groups ) {

		foreach( $groups as $metabox ) {
			if( $metabox == '' || is_null( $metabox ) ) {
				return;
			}

			if( $metabox == '.' || $metabox == '..' ) {
				return;
			}

			require $this->container_path . $this->metabox_dir . $metabox;
			add_filter( 'cmb2_init', $metabox );
		}
	}
}