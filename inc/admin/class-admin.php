<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */
class Admin {
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
	 * The text domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_text_domain    The text domain of this plugin.
	 */
	private $plugin_text_domain;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.0.0
	 * @param       string $plugin_name        The name of this plugin.
	 * @param       string $version            The version of this plugin.
	 * @param       string $plugin_text_domain The text domain of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain ) {

		$this->plugin_name        = $plugin_name;
		$this->version            = $version;
		$this->plugin_text_domain = $plugin_text_domain;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		global $my_admin_page;
		$screen = get_current_screen();
		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// enqueue stylesheet file for dynamic gutenberg block preview in WordPress page editor.
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/codeable-users-table-plugin-admin.css', array(), $this->version, 'all' );

		// enqueue stylesheet file only for required settings page.
		$required_page_id = 'settings_page_' . $this->plugin_name . '_codeable_usertable';
		if ( $screen->id === $required_page_id ) {
			wp_enqueue_style( $this->plugin_name . 'infopage', plugin_dir_url( __FILE__ ) . 'css/codeable-users-table-plugin-infopage-admin.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/*
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	}

	/**
	 * Create a Submenu under WordPress setting page to provide info about plugin's usage
	 *
	 * @since       1.0.0
	 */
	public function codeable_create_subsetting_menu_function() {

		add_options_page(
			apply_filters( $this->plugin_name . '_settings_codeable_usertable', esc_html__( 'Codeable User Table', $this->plugin_text_domain ) ),
			apply_filters( $this->plugin_name . '_settings_codeable_usertable', esc_html__( 'Codeable User Table', $this->plugin_text_domain ) ),
			'manage_options',
			$this->plugin_name . '_codeable_usertable',
			array( $this, 'render_codeable_usertable_infopage' )
		);

	}

	/**
	 * Render a Submenu under WordPress setting page to provide info about plugin's usage
	 *
	 * @since       1.0.0
	 */
	public function render_codeable_usertable_infopage() {
		include plugin_dir_path( __FILE__ ) . 'views/codeable-usertable-infopage.php';
	}

}
