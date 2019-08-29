<?php
/**
 * Managing Ajax request for users selection.
 *
 * Defines functions which handles ajax function
 * To fetch users as per requested parameters and provides
 * JSON data with total users.
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Admin;

/**
 * Managing Ajax request for users selection.
 *
 * Defines functions which handles ajax function
 * To fetch users as per requested parameters and provides
 * JSON data with total users.
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */
class Codeable_Ajax_Manager {

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
	 * Register the ajax action for fetching users,
	 * this will be used when performing Ajax action
	 * foe codaable users table sorting, filtering and pagination.
	 *
	 * @since       1.0.0
	 */
	public static function codeable_filter_user_callback() {

		// Setting up return response content type as JSON.
		header( 'Content-Type: application/json' );

		// Only send successful response if user have administrator capability and required arguments data is set.
		if ( true === current_user_can( 'administrator' ) && isset( $_POST ) ) {

			// Check the nonce for permission. no need to sanitize nonce since it's not entered by user in input field.
			if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( wp_unslash( $_POST['security'] ), 'for_user_filter_ajax_nonce' ) ) {

				// creating bad response to deny action because of nonce validation failing.
				$response = array(
					'status'  => 500,
					'content' => 'Permission Denied',
				);
				wp_die( wp_json_encode( $response ) );
			}

			$stored_ajax_data = $_POST;

			// Setting up required variables for last selected ajax actions.

			if ( isset( $stored_ajax_data['selected_role'] ) && ! empty( $stored_ajax_data['selected_role'] ) ) {
				$selected_role = sanitize_text_field( $stored_ajax_data['selected_role'] );
			} else {
				$selected_role = 'all';
			}

			if ( isset( $stored_ajax_data['records_per_page'] ) && ! empty( $stored_ajax_data['records_per_page'] ) ) {
				$records_per_page = (int) sanitize_text_field( $stored_ajax_data['records_per_page'] );
			} else {
				$records_per_page = 10;
			}

			if ( isset( $stored_ajax_data['current_page_number'] ) && ! empty( $stored_ajax_data['current_page_number'] ) ) {
				$current_page_number = (int) sanitize_text_field( $stored_ajax_data['current_page_number'] );
			} else {
				$current_page_number = 0;
			}

			if ( isset( $stored_ajax_data['selected_page_number'] ) && ! empty( $stored_ajax_data['selected_page_number'] ) ) {
				$selected_page_number = (int) sanitize_text_field( $stored_ajax_data['selected_page_number'] );
			} else {
				$selected_page_number = 0;
			}

			if ( isset( $stored_ajax_data['order_by'] ) && ! empty( $stored_ajax_data['order_by'] ) ) {
				$order_by = sanitize_text_field( $stored_ajax_data['order_by'] );
			} else {
				$order_by = 'user_login';
			}

			if ( isset( $stored_ajax_data['order'] ) && ! empty( $stored_ajax_data['order'] ) ) {
				$order = sanitize_text_field( $stored_ajax_data['order'] );
			} else {
				$order = 'ASC';
			}

			// Get All available Users array for Requested parameters.
			$requested_users_temp = Codeable_User_Fetcher::fetch_users( $selected_role, $records_per_page, $current_page_number, $selected_page_number, $order_by, $order );

			// Get All available Users array for Requested parameters.
			$requested_users = $requested_users_temp['all_requested_users'];

			// Get total Numbers of users, without applying paginations parameters so pagination's max number can be count.
			$total_users = $requested_users_temp['total_users'];

			// Creating Good Response with Users JSON array and total number of users, which are not caluclated based on applied parameters.
			$response = array(
				'status'      => 200,
				'content'     => wp_json_encode( $requested_users ),
				'total_users' => $total_users,
			);

		} else {

			// creating bad response to show failure.
			$response = array(
				'status'  => 500,
				'content' => 'Permission Denied',
			);
		}

		wp_die( wp_json_encode( $response ) );
	}



}
