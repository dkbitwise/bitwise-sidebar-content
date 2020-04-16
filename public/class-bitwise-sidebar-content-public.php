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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
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

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bitwise_Sidebar_Content_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bitwise_Sidebar_Content_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bitwise-sidebar-content-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bitwise_Sidebar_Content_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bitwise_Sidebar_Content_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bitwise-sidebar-content-public.js', array( 'jquery' ), $this->version, false );

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
