<?php
defined( 'ABSPATH' ) || exit; //Exit if accessed directly

/**
 * This class contain handle common functions for backend and frontend
 * Class Bitscr_Common
 */
class Bitscr_Common {
	private static $ins = null;

	private static $tbl_names = null;
	private static $data_store = null;

	/**
	 * Defining table names and starting session
	 */
	public static function init() {
		self::$tbl_names          = new stdClass;
		self::$tbl_names->content = 'bitscr_content';
		self::$tbl_names->courses = 'bitscr_courses';
		self::$data_store         = Bitscr_Core()->get_dataStore();
	}

	/**
	 * Set table for querying the db
	 *
	 * @param $type
	 */
	public static function set_table( $type ) {
		$table_set = self::$data_store->set_table( self::$tbl_names->$type );
		if ( ! $table_set ) {
			die( "'$type' Table does not exist" );
		}
	}

	/**
	 * Get current timestamp
	 * @return mixed
	 */
	public static function get_now() {
		return self::$data_store->now();
	}

	/**
	 * Get logged in user object
	 *
	 * @param $user_id
	 *
	 * @return bool|WP_User
	 */
	public static function get_logged_in_user( $user_id ) {
		return get_user_by( 'id', $user_id );
	}

	/**
	 * Update data in db from different classes
	 *
	 * @param $data
	 * @param $where
	 * @param $table_type
	 *
	 * @return mixed
	 */
	public static function update_data( $data, $where, $table_type ) {
		self::set_table( $table_type );

		return self::$data_store->update( $data, $where );
	}

	/**
	 * Insert data in db in given table
	 *
	 * @param $data
	 * @param $table_type
	 *
	 * @return mixed
	 */
	public static function insert_data( $data, $table_type ) {
		self::set_table( $table_type );

		return self::$data_store->insert( $data );
	}

	/**
	 * Get last inserted record id.
	 * @return mixed
	 */
	public static function get_insert_id() {
		return self::$data_store->insert_id();
	}

	/**
	 * @return mixed
	 */
	public static function get_last_error() {
		return self::$data_store->get_last_error();
	}

	/**
	 * Get a complete row from a bitsa tables by its id(primary key)
	 *
	 * @param $id
	 * @param $table_type
	 *
	 * @return mixed
	 */
	public static function get_data_by_id( $id, $table_type ) {
		self::set_table( $table_type );

		return self::$data_store->get_specific_row( 'id', $id );
	}

	/**
	 * Get a complete row from a bitscr tables by its sfwd_course_id
	 *
	 * @param $sfwd_course_id
	 * @param $table_type
	 *
	 * @return mixed
	 */
	public static function get_data_by_sfwd_course_id( $sfwd_course_id, $table_type ) {
		self::set_table( $table_type );

		return self::$data_store->get_specific_row( 'sfwd_course_id', $sfwd_course_id );
	}

	/**
	 * Get all data from a given bitsa tables
	 *
	 * @param $table_type
	 *
	 * @return mixed
	 */
	public static function get_all_data( $table_type ) {
		self::set_table( $table_type );
		$data_query = "SELECT * FROM {table_name}";

		return self::$data_store->get_results( $data_query );
	}

	/**
	 * Get a single column from all rows in a bitsa table
	 *
	 * @param $column
	 * @param $table_type
	 *
	 * @return mixed
	 */
	public static function get_single_column( $column, $table_type ) {
		self::set_table( $table_type );
		$data_query = "SELECT `$column` FROM {table_name}";

		return self::$data_store->get_results( $data_query );
	}

	/**
	 * Get single/multiple column(s) from single/multiple rows in a bitsa table
	 *
	 * @param $column_names
	 * @param $where_pairs
	 * @param $table_type
	 *
	 * @return mixed
	 */
	public static function get_multiple_data( $column_names, $where_pairs, $table_type ) {
		self::set_table( $table_type );

		return self::$data_store->get_specific_rows( $column_names, $where_pairs );
	}

	/**
	 *  Get single/multiple column(s) from single/multiple rows in a bitsa table
	 *
	 * @param $column_names
	 * @param $where_pairs
	 * @param $table_type
	 *
	 * @return mixed
	 */
	public static function get_multiple_columns( $column_names, $where_pairs, $table_type ) {
		self::set_table( $table_type );

		return self::$data_store->get_specific_columns( $column_names, $where_pairs );
	}

	/**
	 * Delete a row
	 *
	 * @param $id
	 * @param $table_type
	 *
	 * @return mixed
	 */
	public static function delete_row( $id, $table_type ) {
		self::set_table( $table_type );

		return self::$data_store->delete( $id );
	}

	/**
	 * Delete multiple rows
	 *
	 * @param $where_key
	 * @param $where_value
	 * @param $table_type
	 */
	public static function delete_multiple_rows( $where_key, $where_value, $table_type ) {
		self::set_table( $table_type );
		$delete_query = "DELETE FROM {table_name} WHERE `$where_key`=" . $where_value;
		self::$data_store->delete_multiple( $delete_query );
	}

	/**
	 * To print data inside pre tags for debugging
	 *
	 * @param $data
	 */
	public static function pr( $data ) {
		echo "<pre>";
		print_r( $data );
		echo "</pre>";
	}

	/**
	 * To print data inside pre tags for debugging with a die
	 */
	public static function prd( $data, $msg = 'die12345' ) {
		echo "<pre>";
		print_r( $data );
		echo "</pre>";
		die( $msg );
	}

	/**
	 * Select the particular topic with user notes created by suresh on 23-6-2020
	 *
	 * @param $user_id
	 * @param $topicid
	 *
	 * @return array|object|null
	 */
	public static function selecttopicnotes( $user_id, $topicid ) {
		global $wpdb;
		$table = $wpdb->prefix . 'bitscr_notes';
		$notes = $wpdb->get_results( "SELECT * FROM $table WHERE (user_id = $user_id AND topic_id = $topicid)" );

		return $notes;
	}


	/**
	 * Select the particular user notes created by suresh on 23-6-2020
	 *
	 * @param $user_id
	 *
	 * @return array|object|null
	 */
	public static function selectusernotes( $user_id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'bitscr_notes';
		$notes = $wpdb->get_results( "SELECT * FROM $table WHERE (user_id = $user_id)" );

		return $notes;
	}

	/**
	 * Select all notes for admin users updated by suresh on 23-6-2020
	 */
	public static function selectallnotes() {
		global $wpdb;
		$table = $wpdb->prefix . 'bitscr_notes';
		$notes = $wpdb->get_results( "SELECT * FROM $table" );

		return $notes;
	}

	/**
	 * Delete notes for particular id updated by suresh on 23-6-2020
	 *
	 * @param $user_id
	 * @param $noteid
	 *
	 * @return bool|int
	 */
	public static function deletenotes( $user_id, $noteid ) {
		global $wpdb;
		$table = $wpdb->prefix . 'bitscr_notes';

		return $wpdb->query( "DELETE  FROM $table WHERE id = $noteid" );
	}


	/**
	 * Select the particular Note id with user notes created by suresh on 2-7-2020
	 *
	 * @param $user_id
	 * @param $noteid
	 *
	 * @return array|object|null
	 */
	public static function selectnotesbyid( $user_id, $noteid ) {
		global $wpdb;
		$table = $wpdb->prefix . 'bitscr_notes';
		$notes = $wpdb->get_results( "SELECT * FROM $table WHERE (user_id = $user_id AND id = $noteid)" );

		return $notes;
	}


	/**
	 * Select the user notes with limit for pagination created by suresh on 2-7-2020
	 *
	 * @param $search_str
	 * @param $limit
	 * @param $offset
	 * @param $user_id
	 * @param $current_page
	 *
	 * @return false|string
	 */
	public static function selectusernoteswithlimit( $search_str, $limit, $offset, $user_id, $current_page ) {

		global $wpdb;
		$table       = $wpdb->prefix . 'bitscr_notes';
		$total_query = "SELECT count(id) FROM $table";
		if ( $user_id > 0 ) {
			$total_query .= " WHERE (user_id = $user_id)";
		}
		//$total = $wpdb->get_var( "SELECT count(id) FROM $table WHERE (user_id = $user_id)" );
		$total = $wpdb->get_var( $total_query );

		$note_query   = "SELECT * FROM $table";
		$search_query = "SELECT count(id) FROM  $table";
		if ( $user_id > 0 ) {
			$note_query   .= " where user_id=$user_id";
			$search_query .= " where user_id=$user_id";
		}
		if ( ! empty( $search_str ) ) {
			if ( $user_id > 0 ) {
				$note_query   .= " and";
				$search_query .= " and";
			} else {
				$note_query   .= " where";
				$search_query .= " where";
			}

			$note_query   .= " $search_str";
			$search_query .= " $search_str";
		}
		$note_query   .= " ORDER by added DESC  LIMIT $limit OFFSET $offset";
		$search_query .= " ORDER by added DESC";

		$note_list    = $wpdb->get_results( $note_query );
		$search_found = $wpdb->get_var( $wpdb->prepare( $search_query ) );
		$pages        = ceil( $search_found / $limit );

		if ( $note_list ):
			$html  = '';
			$cuser = wp_get_current_user();
			foreach ( $note_list as $oldnote ) {
				global $post;
				$title = $oldnote->title;
				$html  .= '<tr>
                        <td style="text-align: center;"><input type="checkbox" id="lds-bulk-action-item' . $oldnote->topic_id . '" name="lds-bulk-action-item[' . $oldnote->topic_id . ']" value="' . $oldnote->topic_id . '"></td>
                        <td id="post-' . $oldnote->id . '">
                        <p><strong><label class="html5lightbox"  for="lds-bulk-action-item' . $oldnote->topic_id . '" >' . esc_html( $title ) . '</label></strong></p>
                        <p>Location:<a href="' . esc_url( get_the_permalink( $oldnote->course_id ) ) . '">' . get_the_title( $oldnote->course_id ) . '</a> &raquo; 
						<a href="' . esc_url( get_the_permalink( $oldnote->lesson_id ) ) . '">' . get_the_title( $oldnote->lesson_id ) . '</a> &raquo;
						<a href="' . esc_url( get_the_permalink( $oldnote->topic_id ) ) . '">' . get_the_title( $oldnote->topic_id ) . '</a> 
						</p></td>';
				if ( array_intersect( $allowed_roles, $current_user->roles ) ) {
					$user = get_user_by( 'id', $oldnote->user_id );
					$html .= '<td><small>' . $user->display_name . '</small></td>';
				}

				$html .= '<td><small>' . date( 'd M Y', strtotime( $oldnote->added ) ) . '</small></td>
                            <td style="text-align: right; width: 125px"><a href="#" style="padding:5px;" class="bitwisescr-notes-print-shortcode" title="print" data-note="' . $oldnote->topic_id . '"><i class="fa fa-print" aria-hidden="true"></i></a>
                            <a href="javascript:void(0)" style="padding:5px;" title="download" class="downloadword" data-note="' . $oldnote->id . '"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                            <a href="javascript:void(0)" style="padding:5px;" title="delete" class="bitwisescr-notes-delete-note" data-note="' . $oldnote->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </td>
                        </tr>	<div id="notesdiv' . $oldnote->id . '" style="display:none;">
							 <div class="lightboxcontainer">';
				if ( $oldnote->content ) {
					$html .= '<h3>' . $oldnote->title . '</h3>' . $oldnote->content;
				}
				$html .= '</div>
  						</div>';
			}
		else:
			$html = ' <tr><td colspan="5"><p class="ldnt-alert">No notes found</p></td>
                    </tr>';
		endif;

		//Return the list of notes with pagination detail updated by suresh on 8-7-2020
		return json_encode( array(
			'status'       => true,
			'data'         => $html,
			'total'        => $total,
			'displaying'   => count( $note_list ),
			'current_page' => $current_page,
			'per_page'     => $limit,
			'pages'        => $pages
		) );
		exit;
	}

	public function selectallnoteswithlimit( $search_str, $limit, $offset, $current_page ) {
		$user_id = 0;

		return self::selectusernoteswithlimit( $search_str, $limit, $offset, $user_id, $current_page );
	}
}

/**
 * Initializing the common class
 */
Bitscr_Common::init();
