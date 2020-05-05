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
				wp_enqueue_style( 'bitwise_lightbox_css', plugin_dir_url( __FILE__ ) . 'css/lightbox.min.css', array(), '1.0.0', 'all' );
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
				wp_enqueue_script( 'bitwise_sidebar_content_public_js', plugin_dir_url( __FILE__ ) . 'js/bitwise-sidebar-content-public.js', array( 'jquery' ), '1.0.0', false );
				//wp_enqueue_script( 'bitwise_sidebar_min_jquery', plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_jquery_1_10_2', plugin_dir_url( __FILE__ ) . 'js/jquery-1.10.2.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_jquery_ui', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_featherlight_min', plugin_dir_url( __FILE__ ) . 'js/featherlight.min.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_featherlight_gallery', plugin_dir_url( __FILE__ ) . 'js/featherlight.gallery.min.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_sidebar_slidepanel', plugin_dir_url( __FILE__ ) . 'js/jquery.slidepanel.js', array(), '1.0.0', false );
				wp_enqueue_script( 'bitwise_lightbox_jqeury', plugin_dir_url( __FILE__ ) . 'js/lightbox-plus-jquery.min.js', array(), '1.0.0', false );
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
}
