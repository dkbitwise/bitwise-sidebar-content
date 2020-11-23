<?php

/**
 * Fired during plugin activation
 *
 * @link       https://bitwiseacademy.com/
 * @since      1.0.0
 *
 * @package    Bitwise_Sidebar_Content
 * @subpackage Bitwise_Sidebar_Content/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bitwise_Sidebar_Content
 * @subpackage Bitwise_Sidebar_Content/includes
 * @author     Bitwise <https://bitwiseacademy.com/>
 */
class Bitwise_Sidebar_Content_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$check_page_exist = get_page_by_path( 'bitsc_code_template', 'OBJECT', 'page' );
		if ( empty( $check_page_exist ) ) {
			$page_id = wp_insert_post( array(
				'comment_status' => 'close',
				'ping_status'    => 'close',
				'post_title'     => ucwords( 'bitsc_code_template' ),
				'post_name'      => 'bitsc_code_template',
				'post_status'    => 'publish',
				'post_content'   => '',
				'post_type'      => 'page',
			) );
		}
	}

}
