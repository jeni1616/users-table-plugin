<?php
/**
 * Fetching WordPress Users with various parameters
 *
 * Define Function to Fetch Users based on provided
 * Parameters which includes role, orderby, offset,
 * record per page, it also return total number of
 * users without applying pagination paramaters to
 * calculate total avilable pages.
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Admin;

/**
 * Fetching WordPress Users with various parameters
 *
 * Define Function to Fetch Users based on provided
 * Parameters which includes role, orderby, offset,
 * record per page, it also return total number of
 * users without applying pagination paramaters to
 * calculate total avilable pages.
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */
class Codeable_User_Fetcher {

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
	 * Get Users according to provided parameters and returns array with
	 * users array and total users without considering pagination arguments to count total pages.
	 *
	 * @since       1.0.0
	 * @param       string $selected_role           Specific Role selected for fetching user, default all.
	 * @param       int    $records_per_page        Number of records to show on page, default 10.
	 * @param       int    $current_page_number     Currently shown page number.
	 * @param       int    $selected_page_number    User selected page Index in pagination.
	 * @param       string $order_by                Orderby display_name or user_name.
	 * @param       string $order                   Order Ascending or Descending, values ASC or DESC.
	 */
	public static function fetch_users( $selected_role = '', $records_per_page = 10, $current_page_number = 1, $selected_page_number = 0, $order_by = 'user_login', $order = 'ASC' ) {

		$offset = $records_per_page * $selected_page_number;

		// Check Role selection.
		if ( 'all' !== $selected_role ) {
			$role_in = array( $selected_role );
		} else {
			$role_in = array();
		}

		// Include only required fields.
		$fields_to_return = array(
			'user_login',
			'display_name',
			'user_email',
		);

		// intial arguments settings.
		$args = array(
			'blog_id'  => $GLOBALS['blog_id'],
			'role__in' => $role_in,
			'orderby'  => $order_by,
			'order'    => $order,
			'offset'   => $offset,
			'search'   => '',
			'number'   => $records_per_page,
			'fields'   => $fields_to_return,
		);

		// Query to Find Users according to arguments.
		$user_query = new \WP_User_Query( $args );

		// Get Users Query Result.
		$all_requested_users = (array) $user_query->get_results(); // return: array of WP_User objects.

		// Get total number of users without applying offsets parameter, this is not same as count($all_requested_users).
		$total_users = $user_query->get_total();

		// Contain both $all_requested_users and $total_users in single array.
		$data = array(
			'all_requested_users' => $all_requested_users,
			'total_users'         => $total_users,
		);

		return $data;

	}


}
