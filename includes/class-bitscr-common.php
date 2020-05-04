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

		self::$data_store = Bitscr_Core()->get_dataStore();
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
}

/**
 * Initializing the common class
 */
Bitscr_Common::init();
