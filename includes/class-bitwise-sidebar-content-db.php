<?php
defined( 'ABSPATH' ) || exit; //Exit if accessed directly

/**
 * Class Bitwise_Sidebar_Content_DB
 */
class Bitwise_Sidebar_Content_DB {

	/**
	 * instance of class
	 * @var null
	 */
	private static $ins = null;
	/**
	 * WPDB instance
	 *
	 * @since 2.0
	 *
	 * @var $wp_db
	 */
	protected $wp_db;
	/**
	 * Character collation
	 *
	 * @since 2.0
	 *
	 * @var string
	 */
	protected $charset_collate;
	/**
	 * Max index length
	 *
	 * @since 2.0
	 *
	 * @var int
	 */
	protected $max_index_length = 191;

	/**
	 * Bitsa_DB_Tables constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->wp_db = $wpdb;
		//add_action( 'plugins_loaded', array( $this, 'add_if_needed' ) );
	}

	/**
	 * @return Bitwise_Sidebar_Content_DB|null
	 */
	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self;
		}

		return self::$ins;
	}

	/**
	 * Add bitwise custom tables if they are missing
	 *
	 * @since 2.0
	 */
	public function add_if_needed() {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$missing_tables = $this->find_missing_tables();

		if ( empty( $missing_tables ) || count( $missing_tables ) < 1 ) {
			return;
		}

		$search = $this->wp_db->prefix;
		foreach ( $missing_tables as $table ) {
			call_user_func( array( $this, str_replace( $search, '', $table ) ) );
		}
	}

	/**
	 * Find all missing Bitwise content sidebar table
	 *
	 * @return array
	 */
	protected function find_missing_tables() {

		$db_tables = get_option( '_bit_scr_created_tables', array() );

		$missing_tables = array();
		foreach ( $this->get_tables_list() as $table ) {
			if ( ! in_array( $table, $db_tables, true ) ) {
				$missing_tables[] = $table;
			}
		}

		return $missing_tables;
	}

	/**
	 * Get the list of bitwise tables, with wp_db prefix
	 *
	 * @return array
	 * @since 2.0
	 *
	 */
	protected function get_tables_list() {
		$all_tables = array();
		$tables     = array(
			'bitscr_video',
			'bitscr_help',
			'bitscr_notes',
		);
		foreach ( $tables as &$table ) {
			$all_tables[] = $this->wp_db->prefix . $table;
		}

		return $all_tables;
	}

	/**
	 * Add bitsa_school table
	 */
	public function bitscr_video() {
		$collate = '';

		if ( $this->wp_db->has_cap( 'collation' ) ) {
			$collate = $this->wp_db->get_charset_collate();
		}
		$values_table = "CREATE TABLE `" . $this->wp_db->prefix . "bitscr_video` (
				`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,				
				`video_url` VARCHAR(200) NOT NULL,
				`type` VARCHAR(200) NOT NULL,
				`date_added` DATETIME DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `id` (`id`)
                ) " . $collate . ";";

		dbDelta( $values_table );

		$tables = get_option( '_bit_scr_created_tables', array() );

		array_push( $tables, $this->wp_db->prefix . 'bitsa_schools' );
		$tables = array_unique( $tables );
		update_option( '_bit_scr_created_tables', $tables );
	}

	/**
	 * Add bitscr_help table
	 */
	public function bitscr_help() {
		$collate = '';

		if ( $this->wp_db->has_cap( 'collation' ) ) {
			$collate = $this->wp_db->get_charset_collate();
		}
		$values_table = "CREATE TABLE `" . $this->wp_db->prefix . "bitscr_help` (
				`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				`help_doc_url` VARCHAR(20) NOT NULL,
				`type` VARCHAR(20) NOT NULL,
				`date_added` DATETIME DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `id` (`id`)
                ) " . $collate . ";";

		dbDelta( $values_table );

		$tables = get_option( '_bit_scr_created_tables', array() );

		array_push( $tables, $this->wp_db->prefix . 'bitsa_teachers' );
		$tables = array_unique( $tables );
		update_option( '_bit_scr_created_tables', $tables );
	}

	/**
	 * Add bitsa_classrooms table
	 */
	public function bitscr_notes() {
		$collate = '';

		if ( $this->wp_db->has_cap( 'collation' ) ) {
			$collate = $this->wp_db->get_charset_collate();
		}

		$values_table = "CREATE TABLE `" . $this->wp_db->prefix . "bitscr_notes` (
				`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				`notes_doc_url` VARCHAR(20) NOT NULL,
				`date_added` DATETIME DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `id` (`id`)
                ) " . $collate . ";";

		dbDelta( $values_table );

		$tables = get_option( '_bit_scr_created_tables', array() );

		array_push( $tables, $this->wp_db->prefix . 'bitsa_classrooms' );
		$tables = array_unique( $tables );
		update_option( '_bit_scr_created_tables', $tables );
	}
}
