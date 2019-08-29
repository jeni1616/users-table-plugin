<?php
/**
 * The core plugin class.
 *
 * Defines internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * @package    Codeable_User_Table/CoreFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Core;

use Codeable_Users_Table_Plugin as NS;
use Codeable_Users_Table_Plugin\Inc\Admin as Admin;
use Codeable_Users_Table_Plugin\Inc\Frontend as Frontend;

/**
 * The core plugin class.
 *
 * Defines internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * @package    Codeable_User_Table/CoreFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */
class Init {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_base_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_basename;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The text domain of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $plugin_text_domain;

	/**
	 * Initialize and define the core functionality of the plugin.
	 */
	public function __construct() {

		$this->plugin_name                = NS\CODEABLE_USERS_TABLE_PLUGIN;
		$this->version                    = NS\CODEABLE_USERS_TABLE_VERSION;
				$this->plugin_basename    = NS\CODEABLE_USERS_TABLE_BASENAME;
				$this->plugin_text_domain = NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Loads the following required dependencies for this plugin.
	 *
	 * - Loader - Orchestrates the hooks of the plugin.
	 * - Internationalization_I18n - Defines internationalization functionality.
	 * - Admin - Defines all hooks for the admin area.
	 * - Frontend - Defines all hooks for the public side of the site.
	 *
	 * @access    private
	 */
	private function load_dependencies() {
		$this->loader = new Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	private function set_locale() {

		$plugin_i18n = new Internationalization_I18n( $this->plugin_text_domain );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @access    private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin\Admin( $this->plugin_name, $this->version, $this->plugin_text_domain );

		// enqueuing styles and scripts for plugin's admin operations.
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// adding sub menu for plugin's info page in settings Page of WordPress admin panel.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'codeable_create_subsetting_menu_function' );

		// adding action to regsiter shortcode.
		$shortcode_manager = new Admin\Codeable_Shortcode_Manager( $this->plugin_name, $this->version, $this->plugin_text_domain );
		$this->loader->add_action( 'init', $shortcode_manager, 'make_shortcodes' );

		// Registering Ajax Action for user table operations.
		$ajax_manager = new Admin\Codeable_Ajax_Manager( $this->plugin_name, $this->version, $this->plugin_text_domain );
		$this->loader->add_action( 'wp_ajax_codeable_filter_user_ajax_action', $ajax_manager, 'codeable_filter_user_callback' );

		// Registering Action for creating Guternberg Block for users table.
		$gutenberg_block_manager = new Admin\Codeable_Guternberg_Block_Manager( $this->plugin_name, $this->version, $this->plugin_text_domain );
		$this->loader->add_action( 'init', $gutenberg_block_manager, 'create_listusers_gutenberg_block' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @access    private
	 */
	private function define_public_hooks() {

		// enqueuing styles and scripts for plugin's public operations.
		$plugin_public = new Frontend\Frontend( $this->plugin_name, $this->version, $this->plugin_text_domain );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}



}
