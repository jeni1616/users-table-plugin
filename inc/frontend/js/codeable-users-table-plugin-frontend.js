(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * The file is enqueued from inc/frontend/class-frontend.php.
	 */

	jQuery( document ).ready(
		function() {

			jQuery( ".codeable-user-filter-link" ).click(
				function(event) {
					event.preventDefault();
					var users_role = jQuery( this ).data( "role" );
					jQuery( ".selected_role" ).val( users_role ).change();
					apply_defaults_parameter();
					jQuery( ".codeable-user-filter-link" ).removeClass( "active" );
					jQuery( ".codeable-pagination-link" ).removeClass( "active" );
					fire_fetch_users_ajax_request( true );

				}
			);

			jQuery( "body" ).on(
				'click',
				'.codeable-pagination-link',
				function(event) {
					event.preventDefault();
					var selected_page_number = jQuery( this ).data( "pagenum" );
					jQuery( ".codeable-pagination-link" ).removeClass( "active" );
					jQuery( ".selected_page_number" ).val( selected_page_number ).change();
					fire_fetch_users_ajax_request();
				}
			);

			jQuery( ".ascending_ar" ).click(
				function(event) {
					var orderby = jQuery( this ).data( "coltype" );
					jQuery( ".order_by" ).val( orderby ).change();
					jQuery( ".order" ).val( "ASC" ).change();
					jQuery( ".selected_page_number" ).val( 0 ).change();
					jQuery( ".codeable-pagination-link" ).removeClass( "active" );
					fire_fetch_users_ajax_request();
				}
			);

			jQuery( ".descending_ar" ).click(
				function(event) {
					var orderby = jQuery( this ).data( "coltype" );
					jQuery( ".order_by" ).val( orderby ).change();
					jQuery( ".order" ).val( "DESC" ).change();
					jQuery( ".selected_page_number" ).val( 0 ).change();
					jQuery( ".codeable-pagination-link" ).removeClass( "active" );
					fire_fetch_users_ajax_request();
				}
			);

		}
	);

	function fire_fetch_users_ajax_request(enable_change_pagination=false) {

		// Show loader.
		show_codeable_loader();

		var selected_role        = jQuery( ".selected_role" ).val();
		var records_per_page     = jQuery( ".records_per_page" ).val();
		var current_page_number  = jQuery( ".current_page_number" ).val();
		var selected_page_number = jQuery( ".selected_page_number" ).val();
		var order_by             = jQuery( ".order_by" ).val();
		var order                = jQuery( ".order" ).val();

		var data = {
			'action': 'codeable_filter_user_ajax_action',
			'security': for_user_filter_ajax_nonce,
			'selected_role': selected_role,
			'records_per_page': records_per_page,
			'current_page_number': current_page_number,
			'selected_page_number': selected_page_number,
			'order_by': order_by,
			'order': order
		};

		jQuery.post(
			codeable_admin_ajax_url,
			data,
			function(response) {
				if ( typeof response.content != "undefined" && 200 === response.status ) {

					jQuery( ".ascending_ar,.descending_ar" ).removeClass( "hidecol" ).addClass( "showcol" );
					if ( order === "ASC") {
						jQuery( "body .ascending_ar" ).each(
							function (index, el) {
								var currentCol = jQuery( this );
								if ( currentCol.data( "coltype" ) == order_by ) {
									currentCol.removeClass( "showcol" ).addClass( "hidecol" );
								}
							}
						);
					} else if ( order === "DESC" ) {
						jQuery( "body .descending_ar" ).each(
							function (index, el) {
								var currentCol = jQuery( this );
								if ( currentCol.data( "coltype" ) == order_by ) {
									currentCol.removeClass( "showcol" ).addClass( "hidecol" );
								}
							}
						);
					}

					jQuery( "body .codeable-user-filter-link" ).each(
						function(index, el) {
							var currentFilter = jQuery( this );
							if ( currentFilter.data( "role" ) == selected_role ) {
								currentFilter.addClass( "active" );
							}
						}
					);

					var current_page_total_records = format_codeable_user_table( response.content );
					if ( true === enable_change_pagination ) {
						change_pagination( response.total_users,records_per_page );
					}

					jQuery( "body .codeable-pagination-link" ).each(
						function(index, el) {
							var currentPage = jQuery( this );
							if ( currentPage.data( "pagenum" ) == selected_page_number ) {
								currentPage.addClass( "active" );
							}
						}
					);

					if ( response.total_users && response.total_users > 0 ) {
						var min = (parseInt( selected_page_number, 10 ) * parseInt( records_per_page, 10 )) + 1;
					} else {
						var min = 0;
					}

					var maxcouldbe = min + ( parseInt( records_per_page, 10 ) - 1 );

					if ( response.total_users < maxcouldbe ) {
						var max = response.total_users;
					} else {
						var max = maxcouldbe;
					}

					jQuery( ".current_showing_min_range" ).text( min );
					jQuery( ".current_showing_max_range" ).text( max );
					jQuery( ".total_users_range" ).text( response.total_users );

					// hide loader.
					hide_codeable_loader();
				} else {
					// fail table.
					var emptyar = [];
					format_codeable_user_table( emptyar );

					// hide loader.
					hide_codeable_loader();
				}
			}
		);
	}

	function hide_codeable_loader() {
		jQuery( ".codeable_loader" ).addClass( "hide_loader" ).removeClass( "show_loader" );
	}

	function show_codeable_loader() {
		jQuery( ".codeable_loader" ).removeClass( "hide_loader" ).addClass( "show_loader" );
	}

	function apply_defaults_parameter() {
		jQuery( ".records_per_page" ).val();
		jQuery( ".current_page_number" ).val( 0 ).change();
		jQuery( ".selected_page_number" ).val( 0 ).change();
		jQuery( ".order_by" ).val( "user_login" ).change();
		jQuery( ".order" ).val( "ASC" ).change();
	}

	function format_codeable_user_table(users_raw_data) {
		const users_data    = JSON.parse( users_raw_data );
		var table_body_html = '';

		if ( codeable_isEmpty( users_data ) ) {
			table_body_html = '<tr><td align="center"  colspan="3">' + codeable_js_translation.nousersforrole + '</td></tr>';
			jQuery( ".ascending_ar,.descending_ar" ).removeClass( "showcol" ).addClass( "hidecol" );
		} else {
			$.each(
				users_data,
				function (index, user) {
					table_body_html += '<tr>';
					table_body_html += '<td class="user_login">' + user.user_login + '</td>';
					table_body_html += '<td class="display_name">' + user.display_name + '</td>';
					table_body_html += '<td class="user_email">' + user.user_email + '</td>';
					table_body_html += '</tr>';
				}
			);

		}
		jQuery( "#users_simple_list tbody" ).html( table_body_html );

		return users_data.length;
	}

	function change_pagination(total_users, records_per_page) {

		var pagination_list_html = "";
		let page_num             = 1;

		if ( typeof total_users != "undefined" && total_users > records_per_page ) {
			var total_page_needed = Math.ceil( total_users / records_per_page );
			pagination_list_html += '<ul class="codeable_user_table_page_numbers">';
			for ( page_num; page_num <= total_page_needed; page_num++) {
				pagination_list_html += '<li><a href="#" class="codeable-pagination-link" data-pagenum="' + (page_num - 1) + '">' + page_num + '</a></li>';
			}
			pagination_list_html += '</ul>';

		}

		jQuery( ".pagination_section" ).html( pagination_list_html );

	}

	function codeable_isEmpty(obj) {
		for (var key in obj) {
			if ( obj.hasOwnProperty( key ) ) {
				return false;
			}
		}
		return true;
	}

})( jQuery );
