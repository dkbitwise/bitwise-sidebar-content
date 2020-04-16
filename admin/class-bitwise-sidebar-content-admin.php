<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bitwiseacademy.com/
 * @since      1.0.0
 *
 * @package    Bitwise_Sidebar_Content
 * @subpackage Bitwise_Sidebar_Content/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bitwise_Sidebar_Content
 * @subpackage Bitwise_Sidebar_Content/admin
 * @author     Bitwise <https://bitwiseacademy.com/>
 */
class Bitwise_Sidebar_Content_Admin {

	private static $ins = null;

	public $bitscr_main;

	public $logger;

	/**
	 * Initialize the class and set its properties.
	 * Bitwise_Sidebar_Content_Admin constructor.
	 */
	public function __construct() {
		//Enable/disable the logging from query params
		add_action( 'admin_init', [ $this, 'enable_disable_logging' ] );

		add_action( 'wp_ajax_bitscr_get_lessons', array( $this, 'bitscr_get_lessons' ) );
	}

	/**
	 * Creating an instance of this class
	 * @return Bitwise_Sidebar_Content_Admin|null
	 */
	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self;
		}

		return self::$ins;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( Bitscr_Core()->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'css/bitwise-sidebar-content-admin.css', array(), Bitscr_Core()->get_version(), 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( Bitscr_Core()->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'js/bitwise-sidebar-content-admin.js', array( 'jquery' ), Bitscr_Core()->get_version(), false );
	}

	public function admin_sidebar_menu() {
		add_menu_page( __( 'Personalized Content', 'bitwise-sidebar-content' ), 'Personalized Content', 'manage_options', 'bitwise-sidebar-content', array(
			$this,
			'bitsa_sidebar_content'
		), 'dashicons-welcome-learn-more', 18 );

		add_submenu_page( 'bitwise-sidebar-content', __( 'LMS Courses', 'bitwise-sidebar-content' ), __( 'LMS Courses', 'bitwise-sidebar-content' ), 'manage_options', 'bitscr_lms_courses', array(
			$this,
			'bitscr_lms_courses'
		) );
	}

	/**
	 * Showing content adding form
	 */
	public function bitsa_sidebar_content() {
		$courses = Bitscr_Core()->bitscr_courses->bitscr_courses_list();
		require_once __DIR__ . '/templates/bitwise-content.php';
	}

	/**
	 * Showing and syncing the LMS Courses
	 */
	public function bitscr_lms_courses() {
		$courses = Bitscr_Core()->bitscr_courses->bitscr_courses_list();
		require_once __DIR__ . '/templates/courses-list.php';
	}

	/**
	 * Enable or disable the logging using query params
	 */
	public function enable_disable_logging() {
		$enable = filter_input( INPUT_GET, 'bitscr_logging_enabled', FILTER_SANITIZE_STRING );
		if ( ! empty( $enable ) && in_array( $enable, [ 'yes', 'no' ], true ) ) {
			update_option( 'bitscr_logging_enabled', $enable );
		}
	}

	public function bitscr_get_lessons() {
		$posted_data = isset( $_POST ) ? bitscr_clean( $_POST ) : [];
		$course_id   = isset( $posted_data['course_id'] ) ? $posted_data['course_id'] : 0;
		$resp        = array(
			'success' => false,
			'lessons' => []
		);
		if ( $course_id > 0 ) {
			$course          = new Bitscr_Course( $course_id );
			$lessons         = $course->get_sfwd_lessons();
			$resp['success'] = true;
			$resp['lessons'] = $lessons;
		}
		wp_send_json( $resp );
	}

	/**
	 * Write a message to log in WC log tab if logging is enabled
	 *
	 * @param string $context
	 * @param string $message
	 */
	public function log( $message, $context = "Info" ) {
		$logging_enabled = get_option( 'bitscr_logging_enabled', false );
		if ( empty( $logging_enabled ) || 'yes' !== $logging_enabled ) {
			return;
		}
		if ( class_exists( 'WC_Logger' ) && ! is_a( $this->logger, 'WC_Logger' ) ) {
			$this->logger = new WC_Logger();
		}
		$log_message = $context . ' - ' . $message;

		if ( class_exists( 'WC_Logger' ) ) {
			$this->logger->add( 'bitscr', $log_message );
		}

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( $log_message );
		}
	}

}
