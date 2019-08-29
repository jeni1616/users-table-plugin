<?php
/**
 * Register Global Functions of plugin.
 *
 * This Class contains class which can be used from
 * entire plugin, all functions are defined as static
 * so you do not require to create object of this class
 * to use those function.
 *
 * @package    Codeable_User_Table/GlobalFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Core;

use Codeable_Users_Table_Plugin as NS;
use Codeable_Users_Table_Plugin\Inc\Admin as Admin;
use Codeable_Users_Table_Plugin\Inc\Frontend as Frontend;

/**
 * Register Global Functions of plugin.
 *
 * This Class contains class which can be used from
 * entire plugin, all functions are defined as static
 * so you do not require to create object of this class
 * to use those function.
 *
 * @package    Codeable_User_Table/GlobalFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */
class Global_Functions {



	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	private $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	private $version;

	/**
	 * The text domain of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_text_domain    Text domain of the plugin.
	 */
	private $plugin_text_domain;

	/**
	 * Initialize and define the core functionality of the plugin.
	 *
	 * @param      string $plugin_name    The string used to uniquely identify this plugin.
	 * @param      string $version    The current version of the plugin.
	 * @param      string $plugin_text_domain    Text domain of the plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain ) {

		$this->plugin_name        = $plugin_name;
		$this->version            = $version;
		$this->plugin_text_domain = $plugin_text_domain;

	}

	/**
	 * Returns the path to a template file
	 *
	 * Looks for the file in these directories, in this order:
	 *      Current theme
	 *      Parent theme
	 *      Current theme templates folder
	 *      Parent theme templates folder
	 *      This plugin
	 *
	 * To use a custom list template in a theme, copy the
	 * file from public/templates into a templates folder in your
	 * theme. Customize as needed, but keep the file name as-is. The
	 * plugin will automatically use your custom template file instead
	 * of the ones included in the plugin.
	 *
	 * @param   string $name           The name of a template file.
	 * @return  string                      The path to the template.
	 */
	public static function codeable_users_table_plugin_get_template( $name ) {

		$template = '';

		$locations[] = "{$name}.php";
		$locations[] = "/templates/{$name}.php";

		/**
		 * Filter the locations to search for a template file
		 *
		 * @param   array       $locations          File names and/or paths to check
		 */
		apply_filters( 'codeable_usertable_template_paths', $locations );

		$template = locate_template( $locations, true );

		if ( empty( $template ) ) {

			$template = plugin_dir_path( dirname( __FILE__ ) ) . 'public/templates/' . $name . '.php';

		}

		return $template;

	}


	/**
	 * Returns the path to a View file
	 *
	 * Looks for the file in  CODEABLE_USERS_TABLE_FRONT_END_PATH/view/
	 *
	 * It will search for provided file name and include it
	 * as view for requested resource.
	 *
	 * @param   string $name                The name of a view file.
	 * @return  string                      The path to the view.
	 */
	public static function codeable_users_table_plugin_get_view( $name ) {

		if ( ! empty( $name ) ) {
			$view = NS\CODEABLE_USERS_TABLE_FRONT_END_PATH . 'views/' . $name . '.php';
		} else {
			$view = false;
		}

		return $view;

	}

	/**
	 * Get WordPress user roles.
	 *
	 * Returns current WordPress site's Role name with their key
	 *
	 * @return   array $codeable_wp_roles                 Object of roles key and name pairs.
	 */
	public static function get_role_names() {
		return \WP_Roles()->get_names();
	}

	/**
	 * Check if current value is selected value or not.
	 *
	 * Returns active only if current value is same as selected value.
	 *
	 * @param   string $first_val                 First value to be checked.
	 * @param   string $second_val                Second value to be checked.
	 * @return  string                            active class or empty string.
	 */
	public static function codeable_check_is_exist_or_not( $first_val, $second_val ) {
		if ( $first_val === $second_val ) {
			return esc_attr( 'active' );
		} else {
			return '';
		}
	}

	/**
	 * Hide Default codeable user table sorting columns.
	 *
	 * Check varous parameter to see if current column is default sorting column(display_name/user_name) or not.
	 *
	 * @param   string $current_orderby              Orderby parameter - display_name/user_name.
	 * @param   string $current_order                Order parameter - ASC/DESC for ascending or descending.
	 * @param   string $default_orderby              Default Orderby selection.
	 * @param   string $default_order                Default Order selection.
	 * @param   string $current_showing_max_range    Max numberth which cab be shown on current page.
	 * @return  string                               hidecol class or empty string.
	 */
	public static function hide_default_sorting_column( $current_orderby, $current_order, $default_orderby, $default_order, $current_showing_max_range ) {
		if ( $current_orderby === $default_orderby && $current_order === $default_order || $current_showing_max_range < 1 ) {
			return esc_attr( 'hidecol' );
		}
	}


}
