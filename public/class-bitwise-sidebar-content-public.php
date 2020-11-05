<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bitwiseacademy.com/
 * @since      1.0.0
 *
 * @package    Bitwise_Sidebar_Content
 * @subpackage Bitwise_Sidebar_Content/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bitwise_Sidebar_Content
 * @subpackage Bitwise_Sidebar_Content/public
 * @author     Bitwise <https://bitwiseacademy.com/>
 */
class Bitwise_Sidebar_Content_Public {

	private static $ins = null;
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 * Bitwise_Sidebar_Content_Public constructor.
	 */
	public function __construct() {


		// action to insert the notes updated by suresh 
		add_action( 'wp_ajax_bitsa_notes_process', [ __CLASS__, 'bitsa_notes_process' ] );


		// action download the notes updated by suresh
		add_action( 'wp_ajax_bitsa_notes_download', [ __CLASS__, 'bitsa_notes_download' ] );

		// action delete notes based on topic id updated by suresh on 23-6-2020
		add_action( 'wp_ajax_bitsa_notes_delete', [ __CLASS__, 'bitsa_notes_delete' ] );


		// action print the notes based on topic id updated by suresh on 23-6-2020
		add_action( 'wp_ajax_bitsa_print_note', [ __CLASS__, 'bitsa_print_note' ] );


		// action to display the notes with pagination updated by suresh
		add_action( 'wp_ajax_bitsa_get_notes_withlimit', [ __CLASS__, 'bitsa_get_notes_withlimit' ] );


	}


	/**
	 * Creating an instance of this class
	 * @return Bitwise_Sidebar_Content_Public|null
	 */
	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self;
		}

		return self::$ins;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		global $post;
		$post_id = isset( $post->ID ) ? $post->ID : 0;
		if ( $post_id > 0 ) {
			$post_type = isset( $post->post_type ) ? $post->post_type : '';
			if ( 'sfwd-topic' === $post_type ) {
				wp_enqueue_style( 'bitwise_sidebar_content_public', plugin_dir_url( __FILE__ ) . 'css/bitwise-sidebar-content-public.css', array(), '1.0.0', 'all' );
				wp_enqueue_style( 'bitwise_sidebar_content_featherlight', plugin_dir_url( __FILE__ ) . 'css/featherlight.gallery.min.css', array(), '1.0.0', 'all' );
				wp_enqueue_style( 'bitwise_sidebar_content_featherlight_min', plugin_dir_url( __FILE__ ) . 'css/featherlight.min.css', array(), '1.0.0', 'all' );
				wp_enqueue_style( 'bitwise_sidebar_content_slidepanel', plugin_dir_url( __FILE__ ) . 'css/jquery.slidepanel.css', array(), '1.0.0', 'all' );
				wp_enqueue_style( 'bitwise_sidebar_content_jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), '1.0.0', 'all' );

				//Add style sheet for Notes using learndash notes style updated by suresh
				wp_enqueue_style( 'bitwise_sidebar_notes_css', plugin_dir_url( __FILE__ ) . 'css/note.css', array(), '1.0.0', 'all' );
				//	wp_enqueue_style( 'bitwise_sidebar_notes_fontawesomcss', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), '1.0.0', 'all' );
			}
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $post;
		$post_id = isset( $post->ID ) ? $post->ID : 0;
		if ( $post_id > 0 ) {
			$post_type = isset( $post->post_type ) ? $post->post_type : '';
			if ( 'sfwd-topic' === $post_type ) {
				wp_enqueue_script( 'bitwise_sidebar_content_public_js', plugin_dir_url( __FILE__ ) . 'js/bitwise-sidebar-content-public.js', array( 'jquery' ), '1.0.0'.time(), false );
				//wp_enqueue_script( 'bitwise_sidebar_min_jquery', plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_jquery_1_10_2', plugin_dir_url( __FILE__ ) . 'js/jquery-1.10.2.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_jquery_ui', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_featherlight_min', plugin_dir_url( __FILE__ ) . 'js/featherlight.min.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_featherlight_gallery', plugin_dir_url( __FILE__ ) . 'js/featherlight.gallery.min.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_slidepanel', plugin_dir_url( __FILE__ ) . 'js/jquery.slidepanel.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_lightbox_html5', plugin_dir_url( __FILE__ ) . 'html5lightbox/html5lightbox.js', array(), '1.0.0', false );

				//Add script files for New notes using learndash notes js updated by suresh
				wp_enqueue_script( 'learndash_sidebar_content_public_js', plugin_dir_url( __FILE__ ) . 'js/nt_notes.js', array( 'jquery' ), '1.0.0', false );
				wp_enqueue_script( 'learndash_sidebar_print_public_js', plugin_dir_url( __FILE__ ) . 'js/nt_notes_lib.js', array( 'jquery' ), '1.0.0', false );
			}
		}

	}

	/**
	 * @param $template
	 *
	 * @return string
	 */
	public function bit_sico_include_custom_topic_template( $template ) {
		global $post;
		$post_id = isset( $post->ID ) ? $post->ID : 0;
		if ( $post_id > 0 ) {
			$post_type = isset( $post->post_type ) ? $post->post_type : '';
			if ( 'sfwd-topic' === $post_type ) {
				$template = plugin_dir_path( __FILE__ ) . 'templates/single-sfwd-topic.php';
			}
		}

		return $template;
	}


	/**
	 * Print notes for topic updated by suresh on 24-6-2020
	 *
	 * @param int note id
	 *
	 *
	 */


	function bitsa_print_note() {

		$currenttopicid = $_POST['note_id'];

		$current_user = wp_get_current_user();
		$user_id      = $current_user->ID;

		$oldnotes = Bitscr_Common::selecttopicnotes( $user_id, $currenttopicid );


		$post_content = '<h1>' . $oldnotes[0]->title . '</h1>' . $oldnotes[0]->content;

		wp_send_json_success( array( 'success' => true, 'data' => $post_content ) );
		wp_die();

	}


	/**
	 * Delete notes for topic updated by suresh on 23-6-2020
	 *
	 * @param int note id
	 *
	 *
	 *
	 */
	public static function bitsa_notes_delete() {
		$noteid = $_POST['note_id'];

		$current_user = wp_get_current_user();
		$user_id      = $current_user->ID;

		return $deletenote = Bitscr_Common::deletenotes( $user_id, $noteid );


	}

	/**
	 * Update and Add notes for topic updated by suresh
	 *
	 * @param int user_id
	 * @param int course_id
	 * @param int lesson_id
	 * @param int topic_id
	 */

	public static function bitsa_notes_process() {
		global $wpdb;
		$user_id         = $_POST['formData']['userId'];
		$title           = $_POST['formData']['title'];
		$currentLessonId = $_POST['formData']['currentLessonId'];
		$currentcourseid = $_POST['formData']['currentcourseid'];
		$currenttopicid  = $_POST['formData']['currenttopicid'];
		$content_source  = $_POST['formData']['body'];

		$data = array( 'title' => $title, 'course_id' => $currentcourseid, 'topic_id' => $currenttopicid, 'user_id' => $user_id, 'lesson_id' => $currentLessonId, 'content' => $content_source );

		$table = $wpdb->prefix . 'bitscr_notes';

		$oldnotes = Bitscr_Common::selecttopicnotes( $user_id, $currenttopicid );
		if ( $oldnotes[0]->id ) {
			$updatedata['content'] = $_POST['formData']['body'];
			$updatedata['title']   = $_POST['formData']['title'];
			$where['id']           = $oldnotes[0]->id;
			$updateid              = $wpdb->update( $table, $updatedata, $where );
			$my_id                 = $wpdb->insert_id;
			wp_send_json_success( array( 'success' => true, 'title' => $updatedata['title'], 'content' => $updatedata['content'], 'data' => $my_id ) );
			wp_die();

		} else {


			$wpdb->insert( $table, $data );
			$my_id = $wpdb->insert_id;
			wp_send_json_success( array( 'success' => true, 'title' => $data['title'], 'content' => $data['content'], 'data' => $my_id ) );
			wp_die();
		}

	}


	/**
	 * Get the notes content with pagination update by suresh
	 * @return mixed
	 */
	public static function bitsa_get_notes_withlimit() {
		global $wpdb;
		$limit        = isset( $_POST['filter']['data_display'] ) ? $_POST['filter']['data_display'] : 2;
		$current_page = isset( $_POST['filter']['current_page'] ) ? $_POST['filter']['current_page'] : 1;
		$offset       = ( $current_page - 1 ) * $limit;
		$search       = isset( $_POST['filter']['search'] ) ? $_POST['filter']['search'] : '';

		$search_str = '';
		if ( $search != '' ) {
			$search     = sanitize_text_field( $search );
			$search_str = "( (title) like '%$search%' or (content) like '%$search%'  )";
		}

		$current_user  = wp_get_current_user();
		$allowed_roles = array( 'administrator' );
		$user_id       = $current_user->ID;
		$table         = $wpdb->prefix . 'bitscr_notes';
		if ( isset( $_REQUEST['currenttopicid'] ) ) {
			$currenttopicid = $_REQUEST['currenttopicid'];

			return $oldnotes = Bitscr_Common::selecttopicnoteswithlimit( $search_str, $limit, $offset, $user_id, $currenttopicid, $current_page );
		} else {
			if ( array_intersect( $allowed_roles, $current_user->roles ) ) {
				return $oldnotes = Bitscr_Common::selectallnoteswithlimit( $search_str, $limit, $offset, $current_page );
			} else {
				$oldnotes = Bitscr_Common::selectusernoteswithlimit( $search_str, $limit, $offset, $user_id, $current_page );
				echo $oldnotes;
				exit;
			}
		}
	}
}
