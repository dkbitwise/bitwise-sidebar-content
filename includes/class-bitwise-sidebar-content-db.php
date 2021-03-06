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
	protected $option_key = '';

	/**
	 * Bitsa_DB_Tables constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->wp_db      = $wpdb;
		$this->option_key = '_bit_scr_created_tables_' . str_replace( '.', '_', BITSC_DB_VERSION );

		add_action( 'plugins_loaded', array( $this, 'add_if_needed' ) );
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

		$db_tables = get_option( $this->option_key, array() );

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
			'bitscr_content',
			'bitscr_courses',
			'bitscr_notes', //Added extra table for Notes updated by suresh on 26-6-2020
		);
		foreach ( $tables as &$table ) {
			$all_tables[] = $this->wp_db->prefix . $table;
		}

		return $all_tables;
	}

	/**
	 * Add bitsa_school table
	 */
	public function bitscr_content() {
		$collate = '';

		if ( $this->wp_db->has_cap( 'collation' ) ) {
			$collate = $this->wp_db->get_charset_collate();
		}
		$values_table = "CREATE TABLE `" . $this->wp_db->prefix . "bitscr_content` (
				`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(200),
				`sfwd_course_id` BIGINT(20) UNSIGNED NOT NULL,		
				`sfwd_lesson_id` BIGINT(20) UNSIGNED NOT NULL,		
				`content_url` VARCHAR(200) NOT NULL,
				`category` TINYINT UNSIGNED NOT NULL DEFAULT 0,
				`type` VARCHAR(200) NOT NULL,
				`source` VARCHAR(200) NOT NULL,
				`status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
				`date_added` DATETIME DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `id` (`id`)
                ) " . $collate . ";";

		dbDelta( $values_table );

		$tables = get_option( $this->option_key, array() );

		$tables[] = $this->wp_db->prefix . 'bitscr_content';
		$tables   = array_unique( $tables );
		update_option( $this->option_key, $tables );
	}

	/**
	 * Add bitsa_courses table
	 */
	public function bitscr_courses() {
		$collate = '';

		if ( $this->wp_db->has_cap( 'collation' ) ) {
			$collate = $this->wp_db->get_charset_collate();
		}
		$values_table = "CREATE TABLE `" . $this->wp_db->prefix . "bitscr_courses` (
				`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(200),
				`sfwd_course_id` BIGINT(20) UNSIGNED NOT NULL,
				`sfwd_lessons` TEXT,
				PRIMARY KEY (`id`),
				KEY `id` (`id`)
                ) " . $collate . ";";

		dbDelta( $values_table );

		$tables = get_option( $this->option_key, array() );

		$tables[] = $this->wp_db->prefix . 'bitscr_courses';
		$tables   = array_unique( $tables );
		update_option( $this->option_key, $tables );
	}

	/**
	 * Add bitsa_notes table updated by suresh on 26-6-2020
	 */
	public function bitscr_notes() {
		$collate = '';

		if ( $this->wp_db->has_cap( 'collation' ) ) {
			$collate = $this->wp_db->get_charset_collate();
		}
		$values_table = "CREATE TABLE `" . $this->wp_db->prefix . "bitscr_notes` 
		( `id` INT NOT NULL AUTO_INCREMENT ,
		`user_id` BIGINT(23) NOT NULL , 
		`course_id` BIGINT(23) NOT NULL ,
		`lesson_id` BIGINT(23) NOT NULL , 
		`topic_id` BIGINT(23) NOT NULL , 
		`content` TEXT NOT NULL , 
		`title` VARCHAR(256) NOT NULL , 
		`added` TIMESTAMP NOT NULL ,		
		PRIMARY KEY (`id`),
		KEY `id` (`id`)
		) " . $collate . ";";

		dbDelta( $values_table );

		$tables   = get_option( $this->option_key, array() );
		$tables[] = $this->wp_db->prefix . 'bitscr_notes';
		$tables   = array_unique( $tables );
		update_option( $this->option_key, $tables );
	}
}

Bitwise_Sidebar_Content_DB::get_instance();