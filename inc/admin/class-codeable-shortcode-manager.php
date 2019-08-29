<?php
/**
 * Codeable User Table Shortcode Management
 *
 * Contain code to assign proper attributes in shortcode function
 * Defines shortcode View file for HTML rendering.
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Admin;

use Codeable_Users_Table_Plugin\Inc\Core as Core;

/**
 * Codeable User Table Shortcode Management
 *
 * Contain code to assign proper attributes in shortcode function
 * Defines shortcode View file for HTML rendering.
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */
class Codeable_Shortcode_Manager {

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
	 * Make New shortcode for Listing users.
	 *
	 * @since       1.0.0
	 */
	public function make_shortcodes() {

		add_shortcode( 'codeablelistusers', array( $this, 'users_lisitng_simple_shortcode_func' ) );

	}

	/**
	 * Hooked Function of codeablelistusers shortcode
	 * Check permision and set proper attributes to shortcode
	 * Define HTML view of Listing users  and return buffered HTML output.
	 *
	 * @since       1.0.0
	 * @param       type array  $atts                        array of passed shortcode arguments.
	 * @param       type string $content                     content between opening and closing shortcode.
	 * @param       type string $tag                         Tag name for shortcode.
	 * @return      type string  $output                      Buffered String of generated output.
	 */
	public function users_lisitng_simple_shortcode_func( $atts = [], $content = null, $tag = 'codeablelistusers' ) {

		// Check if user have administrator capability.
		if ( true === current_user_can( 'administrator' ) ) {
			// changing attributes to lowercase so if user added capital letter by mistake, it won't effect code.
			$atts = array_change_key_case( (array) $atts, CASE_LOWER );

			$defaults['shortcode-view'] = $this->plugin_name . '-codeablelistusers-simple';
			$defaults['orderby']        = 'user_login';
			$defaults['order']          = 'ASC';
			$defaults['role']           = 'all';
			$defaults['showfilter']     = 'show';
			$defaults['per_page']       = 10;

			// Replacing Default shortcode attributes value to user's provided attribute values.
			$args = shortcode_atts( $defaults, $atts, 'codeablelistusers' );

			$hide_filter_bar = false;
			if ( true === isset( $args['showfilter'] ) && 'hide' === $args['showfilter'] ) {
				$hide_filter_bar = true;
			}

			$selected_role    = $args['role'];
			$records_per_page = (int) $args['per_page'];
			if ( $records_per_page < 2 ) {
				$records_per_page = 2;
			}
			$current_page_number  = 0;
			$selected_page_number = 0;
			$order_by             = $args['orderby'];
			$order                = $args['order'];

			// Get All available Roles on current WordPress site.
			$all_roles = Core\Global_Functions::get_role_names();

			$requested_users_temp = Codeable_User_Fetcher::fetch_users( $selected_role, $records_per_page, $current_page_number, $selected_page_number, $order_by, $order );

			// Get All available Users array for Requested parameters.
			$requested_users = $requested_users_temp['all_requested_users'];

			// Get total Numbers of users, without applying paginations parameters so pagination's max number can be count.
			$total_users = $requested_users_temp['total_users'];

			// Finding Maximum Number Of user range which can be shown on current page.
			if ( isset( $requested_users ) ) {
				$current_showing_max_range = count( $requested_users );
			} else {
				$current_showing_max_range = 0;
			}

			// Finding Minimum Number Of user range which can be shown on current page.
			if ( isset( $requested_users ) && ! empty( $requested_users ) ) {
				$current_showing_min_range = $current_page_number + 1;
			} else {
				$current_showing_min_range = 0;
			}

			// start buffering.
			ob_start();

			// includes Codeable User listing view's HTML.
			include Core\Global_Functions::codeable_users_table_plugin_get_view( $args['shortcode-view'] );

			// Storing buffered data to variable.
			$output = ob_get_contents();

			// Clean Buffer.
			ob_end_clean();
		} else {
			$output = __( 'Sorry, you are not authorized to view users.', $this->plugin_text_domain );
		}

		// Returning HTML string of Output HTML.
		return $output;
	}

}
