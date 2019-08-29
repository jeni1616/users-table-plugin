<?php
/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation
 * It checks minimum version of PHP required to run this plugin.
 *
 * @package    Codeable_User_Table/CoreFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Core;

use Codeable_Users_Table_Plugin as NS;
/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation
 * It checks minimum version of PHP required to run this plugin.
 *
 * @package    Codeable_User_Table/CoreFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */
class Activator {

	/**
	 * Activate function, hooked with register_activation_hook
	 *
	 * This function will run on plugin activation, it checks minimum version of PHP required by
	 * Plugin and exit if PHP version on server is less than 5.6.0
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$min_php = '5.6.0';

		// Check PHP Version and deactivate & die if it doesn't meet minimum requirements.
		if ( version_compare( PHP_VERSION, $min_php, '<' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die(
				sprintf(
					esc_html__( 'This plugin requires a minmum PHP Version of %s ', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
					esc_html( $min_php )
				)
			);
		}

	}

}
