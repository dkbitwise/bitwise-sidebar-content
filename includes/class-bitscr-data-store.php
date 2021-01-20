<?php
defined( 'ABSPATH' ) || exit; //Exit if accessed directly

/**
 * This class contain data for bitsa environment
 * Class Bitscr_Data_Store
 */
class Bitscr_Data_Store {

	static $primary_key = 'id';
	static $count = 20;
	/**
	 * @var wpdb
	 */
	static $wp_db;

	public $table_name;

	static function init() {
		global $wpdb;
		self::$wp_db = $wpdb;
	}

	/**
	 * To get a row fom db of passed object type like school, class, student etc.
	 *
	 * @param $value
	 *
	 * @return array|object|void|null
	 */
	public function get( $value ) {
		return self::$wp_db->get_row( $this->_fetch_sql( $value ), ARRAY_A );
	}

	/**
	 * Set table name to get query the result
	 *
	 * @param $tbl_name
	 *
	 * @return bool
	 */
	public function set_table( $tbl_name ) {
		global $wpdb;
		$option_key = '_bit_scr_created_tables_' . str_replace( '.', '_', BITSC_DB_VERSION );

		$db_tables    = get_option( $option_key, array() );
		$abs_tbl_name = $wpdb->prefix . $tbl_name;
		if ( ! in_array( $abs_tbl_name, $db_tables, true ) ) {
			return false;
		}

		$this->table_name = $tbl_name;

		return true;
	}

	/**
	 * Retrieve custom result from DB
	 *
	 * @param $value
	 *
	 * @return string|void
	 */
	private function _fetch_sql( $value ) {

		$sql = sprintf( 'SELECT * FROM %s WHERE %s = %%s', $this->get_table(), static::$primary_key );

		return self::$wp_db->prepare( $sql, $value );
	}

	/**
	 * Get the table name by prefixing the wpdb prefix
	 * @return string
	 */
	private function get_table() {
		return self::$wp_db->prefix . $this->table_name;
	}

	/**
	 * Insert a new record into DB like school, class etc.
	 *
	 * @param $data
	 */
	public function insert( $data ) {
		self::$wp_db->insert( $this->get_table(), $data );
	}

	/**
	 * Updating the data in db for given data and where conditions
	 *
	 * @param $data
	 * @param $where
	 *
	 * @return false|int
	 */
	public function update( $data, $where ) {
		return self::$wp_db->update( $this->get_table(), $data, $where );
	}

	/**
	 * Delete a row from the DB
	 *
	 * @param $value
	 *
	 * @return bool|int
	 */
	public function delete( $value ) {

		$sql = sprintf( 'DELETE FROM %s WHERE %s = %%s', $this->get_table(), static::$primary_key );

		return self::$wp_db->query( self::$wp_db->prepare( $sql, $value ) );
	}

	/**
	 * Get last inserted data id
	 * @return int
	 */
	public function insert_id() {

		return self::$wp_db->insert_id;
	}

	/**
	 * Getting the current timestamp
	 * @return false|string
	 */
	public function now() {
		return self::time_to_date( time() );
	}

	/**
	 * Converting timestamp to human readable date
	 *
	 * @param $time
	 *
	 * @return false|string
	 */
	public function time_to_date( $time ) {
		return gmdate( 'Y-m-d H:i:s', $time );
	}

	/**
	 * Converting date to timestamp
	 *
	 * @param $date
	 *
	 * @return false|int
	 */
	public function date_to_time( $date ) {
		return strtotime( $date . ' GMT' );
	}

	/**
	 * Retuning the total number of rows fetched from db in a query
	 * @return int
	 */
	public function num_rows() {

		return self::$wp_db->num_rows;
	}

	/**
	 * Retrieving an specific row by passing the where conditions.
	 *
	 * @param $where_key
	 * @param $where_value
	 *
	 * @return array|object|void|null
	 */
	public function get_specific_row( $where_key, $where_value ) {
		$query = "SELECT * FROM " . $this->get_table() . " WHERE $where_key = '$where_value'";

		return self::$wp_db->get_row( $query, ARRAY_A );
	}

	/**
	 * Retrieving multiple rows by passing the where conditions.
	 *
	 * @param $column_names
	 * @param $where_pairs
	 *
	 * @return array|object|null
	 */
	public function get_specific_rows( $column_names, $where_pairs ) {
		$sql_query = "SELECT ";

		if ( is_array( $column_names ) && count( $column_names ) > 0 ) {
			foreach ( $column_names as $column_name => $column_alias ) {
				$sql_query .= "$column_name as $column_alias ";
				if ( next( $column_names ) ) {
					$sql_query .= ", ";
				}
			}
		} else {
			$sql_query .= " * ";
		}

		$sql_query .= "FROM " . $this->get_table();

		if ( is_array( $where_pairs ) && count( $where_pairs ) > 0 ) {
			$sql_query .= " WHERE 1 = 1";
			foreach ( $where_pairs as $where_key => $where_value ) {
				if(is_array($where_value)){
					$sql_query .= " AND " . $where_key . " IN (".implode(',',$where_value).")";
				}else{
					$sql_query .= " AND " . $where_key . " = '$where_value'";
				}
			}
		}

		return self::$wp_db->get_results( $sql_query, ARRAY_A );
	}

	/**
	 * Get specific columns from DB
	 *
	 * @param $column_names
	 * @param $where_pairs
	 *
	 * @return array|object|void|null
	 */
	public function get_specific_columns( $column_names, $where_pairs ) {

		$sql_query = "SELECT ";

		if ( is_array( $column_names ) && count( $column_names ) > 0 ) {
			foreach ( $column_names as $column_name => $column_alias ) {
				$sql_query .= "$column_name as $column_alias ";
			}
		} else {
			$sql_query .= " * ";
		}

		$sql_query .= "FROM " . $this->get_table();

		/*if ( is_array( $where_pairs ) && count( $where_pairs ) > 0 ) {
			$sql_query .= " WHERE 1 = 1";
			foreach ( $where_pairs as $where_key => $where_value ) {
				$sql_query .= " AND " . $where_key . " = '$where_value'";
			}
		}
echo $sql_query;*/
if ( is_array( $where_pairs ) && count( $where_pairs ) > 0 ) {
$sql_query .= " WHERE 1 = 1";
foreach ( $where_pairs as $where_key => $where_value ) {
if(is_array($where_value)){
$sql_query .= " AND " . $where_key . " IN ".implode(',',$where_value);
}else{
$sql_query .= " AND " . $where_key . " = '$where_value'";
}
}
}

		return self::$wp_db->get_row( $sql_query, ARRAY_A );
	}

	/**
	 * Get results from DB based on query
	 *
	 * @param $query
	 *
	 * @return array|object|null
	 */
	public function get_results( $query ) {

		$query   = str_replace( '{table_name}', $this->get_table(), $query );
		$results = self::$wp_db->get_results( $query, ARRAY_A );

		return $results;
	}

	/**
	 * Get a row from db based on query
	 *
	 * @param $query
	 *
	 * @return array|object|void|null
	 */
	public function get_row( $query ) {

		$query   = str_replace( '{table_name}', $this->get_table(), $query );
		$results = self::$wp_db->get_row( $query, ARRAY_A );

		return $results;
	}

	/**
	 * Delete multiple rows from the db
	 *
	 * @param $query
	 */
	public function delete_multiple( $query ) {

		$query = str_replace( '{table_name}', $this->get_table(), $query );
		self::$wp_db->query( $query );
	}

	/**
	 * Updating multiple rows using queries
	 *
	 * @param $query
	 */
	public function update_multiple( $query ) {

		$query = str_replace( '{table_name}', $this->get_table(), $query );
		self::$wp_db->query( $query );
	}

	public function get_last_error() {
		return self::$wp_db->last_error;
	}
}

Bitscr_Data_Store::init();
