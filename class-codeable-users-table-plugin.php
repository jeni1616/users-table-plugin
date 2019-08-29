<?php
/**
 * The plugin file consist code
 * Which instantiation main plugin class
 * as well as register plugin activation
 * and deactivation hooks.
 *
 * @link              https://codeable.io
 * @since             1.0.0
 * @package           Codeable_Users_Table_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Codeable Users Table Plugin
 * Plugin URI:        https://codeable.io/codeable-users-table-plugin-url/
 * Description:       This plugin will list out WordPress site's users in table, it also provides facility of sorting asceding or desceding by display name or user name of users, pagination etc.
 * Version:           1.0.0
 * Author:            Denish Patel
 * Author URI:        https://codeable.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       codeable-users-table-plugin
 * Domain Path:       /languages
 */

namespace Codeable_Users_Table_Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Constants
 */

define( __NAMESPACE__ . '\NS', __NAMESPACE__ . '\\' );

define( NS . 'CODEABLE_USERS_TABLE_PLUGIN', 'codeable-users-table-plugin' );

define( NS . 'CODEABLE_USERS_TABLE_VERSION', '1.0.0' );

define( NS . 'CODEABLE_USERS_TABLE_FRONT_END_PATH', plugin_dir_path( __FILE__ ) . 'inc/frontend/' );

define( NS . 'CODEABLE_USERS_TABLE_BACK_END_PATH', plugin_dir_url( __FILE__ ) . 'inc/admin/' );

define( NS . 'CODEABLE_USERS_TABLE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define( NS . 'CODEABLE_USERS_TABLE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( NS . 'CODEABLE_USERS_TABLE_BASENAME', plugin_basename( __FILE__ ) );

define( NS . 'CODEABLE_USERS_TABLE_TEXT_DOMAIN', 'codeable-users-table-plugin' );


/**
 * Autoload Classes
 */

require_once CODEABLE_USERS_TABLE_PLUGIN_DIR . 'inc/libraries/autoloader.php';

/**
 * Register Activation and Deactivation Hooks
 * This action is documented in inc/core/class-activator.php
 */

register_activation_hook( __FILE__, array( NS . 'Inc\Core\Activator', 'activate' ) );

/**
 * The code that runs during plugin deactivation.
 * This action is documented inc/core/class-deactivator.php
 */

register_deactivation_hook( __FILE__, array( NS . 'Inc\Core\Deactivator', 'deactivate' ) );


/**
 * Plugin Singleton Container
 *
 * Maintains a single copy of the plugin app object
 *
 * @since    1.0.0
 */
class Codeable_Users_Table_Plugin {

	/**
	 * The instance of the plugin.
	 *
	 * @since    1.0.0
	 * @var      Init $init Instance of the plugin.
	 */
	private static $init;
	/**
	 * Loads the plugin
	 *
	 * @access    public
	 */
	public static function init() {

		if ( null === self::$init ) {
			self::$init = new Inc\Core\Init();
			self::$init->run();
		}

		return self::$init;
	}

}

/**
 * Begins execution of the plugin
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Also returns copy of the app object so 3rd party developers
 * can interact with the plugin's hooks contained within.
 **/
function codeable_users_table_plugin_init() {
		return Codeable_Users_Table_Plugin::init();
}

$min_php = '5.6.0';

// Check the minimum required PHP version and run the plugin.
if ( version_compare( PHP_VERSION, $min_php, '>=' ) ) {
		codeable_users_table_plugin_init();
}
