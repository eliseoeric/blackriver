<?php
namespace Blackriver\Admin;

abstract class WpSubPage{
	protected $settings_page_props;
	protected $title;
	private $menu_slug;
	private $metabox_id;
	private $options_page;


	public function __construct( $settings_page_props ) {
		$this->settings_page_props = $settings_page_props;
		$this->title = $settings_page_props['page_title'];
		$this->menu_slug = $settings_page_props['menu_slug'];
		$this->metabox_id = $settings_page_props['metabox_id'];
	}

	public function boot()
	{
		add_action( 'admin_menu', array( $this, 'add_menu_and_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
	}

	public function  add_menu_and_page()
	{
		//if page is a parent
		if($this->settings_page_props['is_parent'])
		{
			$this->options_page = add_menu_page(
				$this->title,
				$this->title,
				$this->settings_page_props['capability'],
				$this->menu_slug,
				array( $this, 'render_settings_page' ),
				$this->settings_page_props['dashicon']
			);
		}
		else {
			$this->options_page = add_submenu_page(
//				$this->title, // this needs to be the parent title/slug
				$this->title,
				$this->title,
				$this->settings_page_props['capability'],
				$this->menu_slug,
				array( $this, 'render_settings_page' )
			);
		}

		// Include the CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles--{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	public function register_settings()
	{
		register_setting(
			$this->settings_page_props['option_group'],
			$this->settings_page_props['option_name']
		);
	}

	public function add_options_page_metabox()
	{
		// hook in our save notices
		add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );
	}

	public function settings_notices( $object_id, $updated )
	{
		if ( $object_id !== $this->menu_slug || empty( $updated ) ) {
			return;
		}

		add_settings_error( $this->menu_slug . '-notices', '', __('Settings updated.', 'blackriver' ), 'updated' );
		settings_errors( $this->menu_slug . '-notices' );
	}

	public function render_settings_page()
	{
		?>
		<div class="wrap cmb2-options-page <?php echo $this->settings_page_props['menu_slug'] ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->menu_slug ); ?>
		</div>
		<?php
	}

	public function __get( $field )
	{
		// Allowed fields to be retrieved
		if( in_array( $field, array( 'metabox_id', 'title', 'options_page', 'menu_slug' ), true ) )
		{
			return $this->{$field};
		}

		throw new \Exception( 'Invalid Property '  . $field );

	}

}