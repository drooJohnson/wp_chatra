<?php

/**
 * The settings of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    Wppb_Demo_Plugin
 * @subpackage Wppb_Demo_Plugin/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class Wp_Chatra_Admin_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPPB Demo' menu.
	 */
	public function setup_plugin_options_menu() {

		//Add the menu to the Plugins set of menu items
  	add_menu_page(
  			__('Chatra', 'chatra'),
  			__('Chatra', 'chatra'),
  			'manage_options',
  			'chatra_settings',
				array($this, 'render_settings_page_content')
		);
		// add_menu_page(
		// 	'WP Chatra Options', 					// The title to be displayed in the browser window for this page.
		// 	'WP Chatra Options',					// The text to be displayed for this menu item
		// 	'manage_options',					// Which type of users can see this menu item
		// 	'wp_chatra_options',			// The unique ID - that is, the slug - for this menu item
		// 	array( $this, 'render_settings_page_content')				// The name of the function to call when rendering this menu's page
		// );

	}

	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function default_input_options() {

		$defaults = array(
			'chatra_public_key'		=>	''
		);

		return $defaults;

	}

	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content() {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'WP Chatra Options', 'wp_chatra' ); ?></h2>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">
				<?php

				settings_fields( 'wp_chatra_settings' );
				do_settings_sections( 'wp_chatra_settings' );

				submit_button();

				?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}


	/**
	 * This function provides a simple description for the Input Examples page.
	 *
	 * It's called from the 'wppb-demo_theme_initialize__options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function wp_chatra_settings_callback() {
		$options = get_option('wp_chatra_settings');
		// var_dump($options);
		echo '<p>' . __( 'Enter the public key or ChatraID found at the bottom of <a href="https://app.chatra.io/settings/general">your settings page</a>.', 'wp_chatra' ) . '</p>';
	} // end general_options_callback


	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_settings() {
		//delete_option('wp_chatra_settings');
		if( false == get_option( 'wp_chatra_settings' ) ) {
			$default_array = $this->default_input_options();
			update_option( 'wp_chatra_settings', $default_array );
		} // end if

		add_settings_section(
			'wp_chatra_settings_section',
			__( 'Chatra Settings', 'wp_chatra' ),
			array( $this, 'wp_chatra_settings_callback'),
			'wp_chatra_settings'
		);

		add_settings_field(
			'chatra_public_key',
			__( 'Public Key/Chatra-ID', 'wp_chatra' ),
			array( $this, 'public_key_input_callback'),
			'wp_chatra_settings',
			'wp_chatra_settings_section'
		);

		register_setting(
			'wp_chatra_settings',
			'wp_chatra_settings',
			array( $this, 'validate_inputs')
		);

	}



	public function public_key_input_callback() {

		$options = get_option( 'wp_chatra_settings' );

		// Render the output
		echo '<input type="text" id="chatra_public_key" name="wp_chatra_settings[chatra_public_key]" value="' . $options['chatra_public_key'] . '" />';

	} // end public_key_input_callback


	public function validate_inputs( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = sanitize_text_field( strip_tags( stripslashes( $input[ $key ] ) ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_inputs', $output, $input );

	} // end validate_inputs




}