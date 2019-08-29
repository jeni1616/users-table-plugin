<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin and will show info
 * on WordPress setting's sub page to provide info about plugin usages.
 *
 * @package    Codeable_User_Table/AdminFunctions
 * @author     Denish Patel <leafletpixels@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @since      1.0.0
 */

namespace Codeable_Users_Table_Plugin\Inc\Admin;

use Codeable_Users_Table_Plugin as NS;
?>

<div class="codeable_infopage_wrapper">

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h2>
	<?php
		echo esc_html__( 'Codeable Users Table', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN );
	?>
</h2>
<p>
	<?php
	echo sprintf(
		'This Page will guide you about how to show user\'s table <b>%s</b> OR <b>%s</b>',
		esc_html__( 'With shortcode', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
		esc_html__( 'Gutenberg Block', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN )
	);
	?>
</p>

<h3>
	<?php
		echo esc_html__( '1: With Gutenberg Block', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN );
	?>
</h3>

<hr/>

<ol>
	<li>
		<?php
		echo sprintf(
			wp_kses(
				/* translators: %s %s: Image Url, Alt text */
				__( 'Add or edit your page and add new gutenberg block. <img src="%1$s" alt="%2$s">', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
				array(
					'img' => array(
						'src' => array(),
						'alt' => array(),
					),
				)
			),
			esc_url( NS\CODEABLE_USERS_TABLE_BACK_END_PATH . '/images/gutenberg1.jpg' ),
			esc_attr( 'gutenberg 1' )
		);

		?>
	</li>
	<li><?php echo esc_html__( 'Add gutenberg users table in your page.', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?> </li>
	<li>
		<?php
		echo sprintf(
			wp_kses(
				/* translators: %s %s: Image Url, Alt text */
				__( 'Select your newly added block and select settings as per your need. <img src="%1$s" alt="%2$s">', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
				array(
					'img' => array(
						'src' => array(),
						'alt' => array(),
					),
				)
			),
			esc_url( NS\CODEABLE_USERS_TABLE_BACK_END_PATH . '/images/gutenberg2.jpg' ),
			esc_attr( 'gutenberg 2' )
		);
		?>
	<ul>
		<li>
			<?php
			echo sprintf(
				/* translators: %s: Order by text */
				'You can set <b>%s</b> option to order users by username or display name',
				esc_html__( 'Order By', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN )
			);
			?>
		</li>
		<li>
			<?php
				echo sprintf(
					/* translators: %s: Order text */
					'You can set <b>%s</b> option to order users in ascending or descending order.',
					esc_html__( 'Order', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN )
				);
				?>
			</li>
		<li>
			<?php
				echo sprintf(
					/* translators: %s: Record per page text */
					'You can set <b>%s</b> option to show specific number of records on each page.',
					esc_html__( 'Record per page', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN )
				);
				?>
		</li>
		<li>
			<?php
				echo sprintf(
					/* translators: %s %s: Role selection, avilability */
					'In <b>%s</b> You can set All Roles or the specific roles that you want to display<br/>
                            Please Note that Filter bar will be <b>%s</b> if you choose specific roles instead of all, since you only wanted<br/>
                            To show specific roles.',
					esc_html__( 'Which specific Role you want to show', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
					esc_html__( 'not available', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN )
				);
				?>
		</li>
		<li>
			<?php
				echo sprintf(
					/* translators: %s: Role Filter */
					'You can enable or disable Filter bar in <b>%s</b> option',
					esc_html__( 'Show Role Filter', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN )
				);
				?>
		</li>
	</ul>
</ol>



<h3>
	<?php
		echo esc_html__( '2: With Shortcode', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN );
	?>
</h3>

<hr/>

<ul>
	<li>
		<?php
		echo sprintf(
			wp_kses(
				/* translators: %s %s: shortcode image, shortcode text */
				__( 'Add or edit your page and add new shortcode widget block. <img src="%1$s" alt="%2$s">', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
				array(
					'img' => array(
						'src' => array(),
						'alt' => array(),
					),
				)
			),
			esc_url( NS\CODEABLE_USERS_TABLE_BACK_END_PATH . '/images/shortcode1.jpg' ),
			esc_attr( 'shortcode 1' )
		);
		?>
		</li>
	<li>
		<?php
		echo sprintf(
			wp_kses(
				/* translators: %s: shortcode tag */
				__( 'Add codeableusers shortcode which is: <pre><code>%s</code></pre>', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
				array(
					'pre'  => array(),
					'code' => array(),
				)
			),
			esc_attr( '[codeablelistusers]' )
		);
		?>
	</li>
	<li>
		<?php
			echo esc_html__( 'You can use parameters in above shortcode, please check description of each shortcode option listed below:', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN );
		?>
			<table class="codeable_info_table">
				<thead>
					<th><?php echo esc_html__( 'Parameter', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?></th>
					<th><?php echo esc_html__( 'Description', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?></th>
					<th><?php echo esc_html__( 'Example', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?></th>
				</thead>
				<tbody>
				<tr>
					<td>orderby</td>
					<td><?php echo esc_html__( 'option to order users by username or display name', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?></td>
					<td>
						<?php
						echo sprintf(
							wp_kses(
								/* translators: %s: shortcode tag */
								__( 'To order by display name: <pre><code>%s</code></pre>', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
								array(
									'pre'  => array(),
									'code' => array(),
								)
							),
							esc_attr( '[codeablelistusers orderby="display_name"]' )
						);
						echo esc_html__( 'OR ', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN );
						echo sprintf(
							wp_kses(
								/* translators: %s: shortcode tag */
								__( 'To order by user name: <pre><code>%s</code></pre>', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
								array(
									'pre'  => array(),
									'code' => array(),
								)
							),
							esc_attr( '[codeablelistusers orderby="user_login"]' )
						);
						?>
					</td>
				</tr>
				<tr>
					<td>order</td>
					<td><?php echo esc_html__( 'option to order users in ascending or descending order.', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?> </td>
					<td>
						<?php
						echo sprintf(
							wp_kses(
								/* translators: %s: shortcode tag */
								__( 'To order ascending: <pre><code>%s</code></pre>', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
								array(
									'pre'  => array(),
									'code' => array(),
								)
							),
							esc_attr( '[codeablelistusers order="ASC"]' )
						);
						echo esc_html__( 'OR ', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN );
						echo sprintf(
							wp_kses(
								/* translators: %s: shortcode tag */
								__( 'To order descendingshow: <pre><code>%s</code></pre>', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
								array(
									'pre'  => array(),
									'code' => array(),
								)
							),
							esc_attr( '[codeablelistusers order="DESC"]' )
						);
						?>
					</td>
				</tr>
				<tr>
					<td>role</td>
					<td>
						<?php
						echo sprintf(
							wp_kses(
								/* translators: %s: shortcode tag */
								__( 'You can set All Roles or the specific roles that you want to display<br/> Please Note that Filter bar will be <b>%s</b> <br/>if you choose specific roles instead of all', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
								array(
									'b'  => array(),
									'br' => array(),
								)
							),
							esc_attr( 'not available', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN )
						);
						?>
						</td>
					<td>
						<?php
						echo sprintf(
							wp_kses(
								/* translators: %s: shortcode tag */
								__( 'To show All Roles: <pre><code>%s</code></pre>', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
								array(
									'pre'  => array(),
									'code' => array(),
								)
							),
							esc_attr( '[codeablelistusers role="all"]' )
						);

						echo sprintf(
							wp_kses(
								/* translators: %s: shortcode tag */
								__( 'To show specific roles: <pre><code>%s</code></pre>', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
								array(
									'pre'  => array(),
									'code' => array(),
								)
							),
							esc_attr( '[codeablelistusers role="author"]' )
						);

						?>
					</td>
				</tr>
				<tr>
					<td>showfilter</td>
					<td><?php echo esc_html__( 'You can enable or disable Filter bar with this option', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?> </td>
					<td>
						<?php
						echo sprintf(
							wp_kses(
								'<pre><code>%s</code></pre>',
								array(
									'pre'  => array(),
									'code' => array(),
								)
							),
							esc_attr( '[codeablelistusers showfilter="show"]' )
						);
						echo esc_html__( 'OR ', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN );
						echo sprintf(
							wp_kses(
								'<pre><code>%s</code></pre>',
								array(
									'pre'  => array(),
									'code' => array(),
								)
							),
							esc_attr( '[codeablelistusers showfilter="hide"]' )
						);
						?>
					</td>
				</tr>
				<tr>
					<td>per_page</td>
					<td><?php echo esc_html__( 'option to show specific number of records on each page', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ); ?> </td>
					<td>
						<?php
						echo sprintf(
							wp_kses(
								'<pre><code>%s</code></pre>',
								array(
									'pre'  => array(),
									'code' => array(),
								)
							),
							esc_attr( '[codeablelistusers per_page="12"]' )
						);
						?>
					</td>
				</tr>
				</tbody>
			</table>
	</li>
	<li>
			<?php

			/* translators: %s: Shortcode tag */
			echo sprintf(
				wp_kses(
					/* translators: %s: shortcode tag */
					__( 'You can use multiple parameter together, example:<pre><code>%s</code></pre>', NS\CODEABLE_USERS_TABLE_TEXT_DOMAIN ),
					array(
						'pre'  => array(),
						'code' => array(),
					)
				),
				esc_attr(
					'[codeablelistusers per_page="12" showfilter="show" role="all"]'
				)
			);

			/* translators: %s: Shortcode Image, Shortcode text, Shortcode alt */
			echo sprintf(
				wp_kses(
					'<img src="%s" alt="%s" class="%s">',
					array(
						'img' =>
											array(
												'src'   => array(),
												'alt'   => array(),
												'class' => array(),
											),
					)
				),
				esc_url( NS\CODEABLE_USERS_TABLE_BACK_END_PATH . '/images/shortcode2.jpg' ),
				esc_attr( 'shortcode 2' ),
				esc_attr( 'shortcode2img' )
			);
			?>
    </li>
</ul>

</div>
