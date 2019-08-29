<?php
/**
 * Creates Gutenberg Block for Codeable users table
 *
 * Defines Function to Register new Gutenberg Block
 * for Codeable users table
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Admin;

use Codeable_Users_Table_Plugin as NS;
use Codeable_Users_Table_Plugin\Inc\Core as Core;
use Codeable_Users_Table_Plugin\Inc\Admin as Admin;

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
class Codeable_Guternberg_Block_Manager {

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
	 * Map shortcode parameters And
	 * Create Gutenberg Block for Codeable users table
	 *
	 * @since       1.0.0
	 */
	public function create_listusers_gutenberg_block() {

		// Return if WordPress do not have enabled Gutenberg.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		// creating codeable user table's shortcode object to map it with Gutenberg block.
		$shortcode_manager = new Admin\Codeable_Shortcode_Manager( $this->plugin_name, $this->version, $this->plugin_text_domain );

		wp_register_script(
			'codeable-listuser-gutenberg-block',
			NS\CODEABLE_USERS_TABLE_BACK_END_PATH . '/js/codeable-listuser-gutenberg-block.js',
			array(
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-components',
				'wp-editor',
			),
			'1.0.0',
			false
		);

		$all_roles = Core\Global_Functions::get_role_names();

		// localizing available Roles on current WordPress site.
		wp_localize_script( 'codeable-listuser-gutenberg-block', 'roles_available', $all_roles );

		// Register New Gutenberg Block for Codeable users table.
		register_block_type(
			'codeable-listuser-gutenberg-block/user-table',
			array(
				'editor_script'   => 'codeable-listuser-gutenberg-block',
				'render_callback' => [ $shortcode_manager, 'users_lisitng_simple_shortcode_func' ],
				'attributes'      => [
					'orderby'    => [
						'default' => 'user_login',
						'type'    => 'string',
					],
					'order'      => [
						'default' => 'ASC',
						'type'    => 'string',
					],
					'role'       => [
						'default' => 'all',
						'type'    => 'string',
					],
					'per_page'   => [
						'default' => 10,
						'type'    => 'integer',
					],
					'showfilter' => [
						'default' => 'show',
						'type'    => 'string',
					],

				],
			)
		);

	}


}
