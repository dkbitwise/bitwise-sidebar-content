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
		add_action( 'wp_ajax_bitscr_delete_content', array( $this, 'bitscr_delete_content' ) );

		add_action( 'admin_post_bitwise_content_form', array( $this, 'bitwise_add_content' ) );

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
		wp_enqueue_media();
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
		$edit_id = filter_input( INPUT_GET, 'edit', FILTER_SANITIZE_NUMBER_INT );
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

	public function bitscr_delete_content() {
		$posted_data = isset( $_POST ) ? bitscr_clean( $_POST ) : [];
		$content_id  = isset( $posted_data['content_id'] ) ? $posted_data['content_id'] : 0;
		$resp        = array(
			'success' => false,
		);
		if ( $content_id > 0 ) {
			$delete          = Bitscr_Common::delete_row( $content_id, 'content' );
			$resp['success'] = true;
			$resp['delete']  = $delete;

			$resp['redirect_url'] = esc_url( add_query_arg( array(
				'page' => 'bitwise-sidebar-content',
			), admin_url( 'admin.php' ) ) );
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

	public function bitwise_add_content() {
		if ( isset( $_POST['bitwise_content_form_nonce'] ) && wp_verify_nonce( $_POST['bitwise_content_form_nonce'], 'bitwise_content_form_nonce_val' ) ) {
			$content        = isset( $_POST['content'] ) ? $_POST['content'] : '';
			$posted_content = isset( $_POST ) ? bitscr_clean( $_POST ) : [];

			$content_obj    = new Bitwise_SC_Content();
			$content_id     = isset( $posted_content['content_id'] ) ? intval( $posted_content['content_id'] ) : 0;
			$content_name   = isset( $posted_content['content_name'] ) ? $posted_content['content_name'] : 0;
			$sfwd_course_id = isset( $posted_content['course'] ) ? $posted_content['course'] : 0;
			$sfwd_lesson_id = isset( $posted_content['lesson'] ) ? $posted_content['lesson'] : 0;
			$content_type   = isset( $posted_content['content_type'] ) ? $posted_content['content_type'] : '';
			$content_source = isset( $posted_content['content_source'] ) ? $posted_content['content_source'] : '';
			//$content        = isset( $posted_content['content'] ) ? $posted_content['content'] : '';
			$category       = isset( $posted_content['content_category'] ) ? $posted_content['content_category'] : '';
			$content_status = isset( $posted_content['content_status'] ) ? $posted_content['content_status'] : 'draft';

			if ( 'Code' === $content_type ) {
				$content = isset( $posted_content['bitsa_content'] ) ? $posted_content['bitsa_content'] : '';
				if ( ! empty( $content ) ) {
					//$content = apply_filters( 'bitscr_content_pre_save', $content );
					$content = stripslashes($content);
				}
			}

			if ( empty( $content_name ) && 'Code' !== $content_type ) {
				$url_arr    = explode( '/', $content );
				$url_length = is_array( $url_arr ) ? count( $url_arr ) : 0;

				if ( $url_length > 0 ) {
					$file         = $url_arr[ $url_length - 1 ];
					$content_name = pathinfo( $file, PATHINFO_FILENAME );
				}
			}

			$content_obj->set_id( $content_id );
			$content_obj->set_name( $content_name );
			$content_obj->set_sfwd_course_id( $sfwd_course_id );
			$content_obj->set_sfwd_lesson_id( $sfwd_lesson_id );
			$content_obj->set_type( $content_type );
			$content_obj->set_source( $content_source );
			$content_obj->set_content( $content );
			$content_obj->set_status( $content_status );
			$content_obj->set_category( $category );
			$content_obj->save( array() );

			if ( $content_id < 1 ) {
				$content_id = Bitscr_Common::get_insert_id();
			}

			$content_page = add_query_arg( array(
				'page' => 'bitwise-sidebar-content',
				'edit' => $content_id
			), admin_url( 'admin.php' ) );

			wp_safe_redirect( $content_page );
			exit();
		}
	}

	public function get_date_format() {
		return get_option( 'date_format', '' ) . ' ' . get_option( 'time_format', '' );
	}

	public function posts_per_page() {
		return 5;
	}

	public function content_categories() {
		return array( 'General', 'Excellent', 'Good', 'Average', 'Fair', 'Poor' );
	}
}
