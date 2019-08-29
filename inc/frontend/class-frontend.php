<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Codeable_User_Table/
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Frontend;

use Codeable_Users_Table_Plugin as NS;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Codeable_User_Table/
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */
class Frontend {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/*
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// enqueue css file for codeable users table stying.
		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/codeable-users-table-plugin-frontend.css',
			array(),
			$this->version,
			'all'
		);

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/*
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// enqueue js file for table filter and pagination ajax functions.
		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/codeable-users-table-plugin-frontend.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		// localizing nonce for ajax actions.
		$ajax_nonce = wp_create_nonce( 'for_user_filter_ajax_nonce' );
		wp_localize_script(
			$this->plugin_name,
			'for_user_filter_ajax_nonce',
			$ajax_nonce
		);

		// localizaing translation strings.
		wp_localize_script(
			$this->plugin_name,
			'codeable_js_translation',
			array(
				'nousersforrole' => esc_html__( 'Sorry, There are no users for selected role.', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
			)
		);

		// some plugins elemenate WordPress defined ajax URL path so need to register it
		// localizing nonce for ajax actions.
		$codeable_ajax_url = admin_url( 'admin-ajax.php' );
		wp_localize_script(
			$this->plugin_name,
			'codeable_admin_ajax_url',
			$codeable_ajax_url
		);

	}

}
