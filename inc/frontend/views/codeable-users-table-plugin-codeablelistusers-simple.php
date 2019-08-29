<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @package    Codeable_User_Table/
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

use Codeable_Users_Table_Plugin\Inc\Core as Core;
use Codeable_Users_Table_Plugin as NS;

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="codeable_usertable_wrapper">
	<div class="codeable_loader hide_loader"></div>
<?php

// creating Filter Section.
if ( false === $hide_filter_bar ) {
	?>
	<ul class="codeable_user_filter">
		<?php
			echo '<li><a href="' . esc_url( '#' ) . '" class="' . esc_attr( 'codeable-user-filter-link ' . Core\Global_Functions::codeable_check_is_exist_or_not( esc_attr( 'all' ), esc_attr( $selected_role ) ) ) . '" data-role="all">' . esc_html__( 'All Roles', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ) . '</a></li>';
		foreach ( $all_roles as $role_slug => $single_role ) {
			echo '<li><a href="' . esc_url( '#' ) . '" class="' . esc_attr( 'codeable-user-filter-link ' . Core\Global_Functions::codeable_check_is_exist_or_not( esc_attr( $selected_role ), esc_attr( $role_slug ) ) ) . '" data-role="' . esc_attr( $role_slug ) . '">' . esc_html( $single_role ) . '</a></li>';
		}
		?>
	</ul>
	<?php
}
?>

<!-- Fake Form for data storage required to see last pages, selected roles etc -->
<form action="" class="fake_form">
	<input type="hidden" name="selected_role" class="selected_role" value="<?php echo esc_html( $selected_role ); ?>">
	<input type="hidden" name="records_per_page" class="records_per_page" value="<?php echo esc_html( $records_per_page ); ?>">
	<input type="hidden" name="current_page_number" class="current_page_number" value="<?php echo esc_html( $current_page_number ); ?>">
	<input type="hidden" name="selected_page_number" class="selected_page_number" value="<?php echo esc_html( $selected_page_number ); ?>">
	<input type="hidden" name="order_by" class="order_by" value="<?php echo esc_html( $order_by ); ?>">
	<input type="hidden" name="order" class="order" value="<?php echo esc_html( $order ); ?>">
</form>


<!-- Creating Initial page load table -->
<table id="users_simple_list">
	<thead>
	<tr>
		<th>
			<span class="label_span"><?php echo esc_html__( 'User Name', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?></span>
			<span class="ascending_ar <?php echo esc_attr( Core\Global_Functions::hide_default_sorting_column( 'user_login', 'ASC', $order_by, $order, $current_showing_max_range ) ); ?>" data-coltype="user_login"></span>
			<span class="descending_ar <?php echo esc_attr( Core\Global_Functions::hide_default_sorting_column( 'user_login', 'DESC', $order_by, $order, $current_showing_max_range ) ); ?>" data-coltype="user_login"></span>
		</th>
		<th>
			<span class="label_span"><?php echo esc_html__( 'Display Name', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?></span>
			<span class="ascending_ar <?php echo esc_attr( Core\Global_Functions::hide_default_sorting_column( 'display_name', 'ASC', $order_by, $order, $current_showing_max_range ) ); ?>" data-coltype="display_name"></span>
			<span class="descending_ar <?php echo esc_attr( Core\Global_Functions::hide_default_sorting_column( 'display_name', 'DESC', $order_by, $order, $current_showing_max_range ) ); ?>" data-coltype="display_name"></span>
		</th>
		<th>
			<span class="label_span"><?php echo esc_html__( 'Email', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?></span>
		</th>
	</tr>
	</thead>
	<tbody>
	<?php

	// creating html string for table's body section.
	$html_string = '';
	if ( isset( $requested_users ) && ! empty( $requested_users ) ) {
		foreach ( $requested_users as $single_user ) {

			$html_string .= '<tr>';
			$html_string .= '<td class="user_login">' . esc_html( $single_user->user_login ) . '</td>';
			$html_string .= '<td class="display_name">' . esc_html( $single_user->display_name ) . '</td>';
			$html_string .= '<td class="user_email">' . esc_html( $single_user->user_email ) . '</td>';
			$html_string .= '</tr>';
		}
	} else {
			$html_string .= '<tr><td align="center"  colspan="3">' . esc_html__( 'Sorry, There are no users for selected role.', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ) . '</td></tr>';
	}


	echo wp_kses(
		$html_string,
		array(
			'tr' => array(),
			'td' =>
				array(
					'src'     => array(),
					'alt'     => array(),
					'class'   => array(),
					'align'   => array(),
					'colspan' => array(),
				),
		)
	);


	?>
	</tbody>
</table>

<!-- create record counter -->
<div class="codeable_users_pagination">

	<div class="record_shower">
		<?php
		// Showing Record Counter section.

		echo sprintf(
			wp_kses(
				/* translators: %s: Minimum range */
				__( 'Showing <div class="current_showing_min_range">%1$d</div> to <div class="current_showing_max_range">%2$d</div> of <div class="total_users_range">%3$d</div> users', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
				array(
					'div' => array(
						'class' => array(),
					),
				)
			),
			esc_attr( $current_showing_min_range ),
			esc_attr( $current_showing_max_range ),
			esc_attr( $total_users )
		);

		?>
	</div>

	<!-- create Pagination section -->
	<div class="pagination_section">
		<?php

		// creating html string for table's pagination section.
		$pagination_html = '';

		if ( isset( $total_users ) && $total_users > $records_per_page ) {
			$total_page_needed = ceil( $total_users / $records_per_page );
			$pagination_html  .= '<ul class="codeable_user_table_page_numbers">';
			for ( $page_num = 1; $page_num <= $total_page_needed; $page_num++ ) {

				if ( ( $current_page_number + 1 ) === $page_num ) {
					$activeclass = 'active';
				} else {
					$activeclass = '';
				}

				$pagination_class_name = 'codeable-pagination-link ' . $activeclass;
				$pagination_html      .= '<li><a href="' . esc_url( '#' ) . '" class="' . esc_attr( $pagination_class_name ) . '" data-pagenum="' . esc_attr( ( $page_num - 1 ) ) . '">' . esc_html( $page_num ) . '</a></li>';
			}
			$pagination_html .= '</ul>';
		}

		echo wp_kses(
			$pagination_html,
			array(
				'ul' => array(
					'class' => array(),
				),
				'a'  =>
					array(
						'href'         => array(),
						'data-pagenum' => array(),
						'class'        => array(),
					),
				'li' =>
					array(
						'class' => array(),
					),
			)
		);

		?>
	</div>
</div>
</div>
