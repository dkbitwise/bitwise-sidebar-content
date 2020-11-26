<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://bitwiseacademy.com/
 * @since      1.0.0
 *
 * @package    Bitwise_Sidebar_Content
 * @subpackage Bitwise_Sidebar_Content/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin.
 *
 * @since      1.0.0
 * @package    Bitwise_Sidebar_Content
 * @subpackage Bitwise_Sidebar_Content/includes
 * @author     Bitwise <https://bitwiseacademy.com/>
 */
class Bitwise_Sidebar_Content {

	/**
	 * @var null
	 */
	public static $_instance = null;


	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	public $admin;

	public $bitscr_courses;

	public $bit_sc_content;

	public $public;

	public $data_store;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BITWISE_SIDEBAR_CONTENT_VERSION' ) ) {
			$this->version = BITWISE_SIDEBAR_CONTENT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bitwise-sidebar-content';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Orchestrates the hooks of the plugin.
	 * - Bitwise_Sidebar_Content_i18n. Defines internationalization functionality.
	 * - Bitwise_Sidebar_Content_Admin. Defines all hooks for the admin area.
	 * - Bitwise_Sidebar_Content_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once __DIR__ . '/class-bitwise-sidebar-content-i18n.php';

		/**
		 * The class responsible for handling DB operations
		 */
		require_once __DIR__ . '/class-bitscr-data-store.php';

		require_once __DIR__ . '/class-bitscr-common.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once dirname( __DIR__ ) . '/admin/class-bitwise-sidebar-content-admin.php';
		$this->admin = Bitwise_Sidebar_Content_Admin::get_instance();

		/**
		 * The class responsible for creating required tables if they are missing
		 */
		require_once __DIR__ . '/class-bitwise-sidebar-content-db.php';

		require_once __DIR__ . '/class-bitscr-content-table.php';


		require_once __DIR__ . '/class-bitscr-course.php';
		$this->bitscr_courses = Bitscr_Course::get_instance();

		require_once __DIR__ . '/class-bitwise-sc-content.php';
		$this->bit_sc_content = Bitwise_SC_Content::get_instance();

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once dirname( __DIR__ ) . '/public/class-bitwise-sidebar-content-public.php';
		$this->public = Bitwise_Sidebar_Content_Public::get_instance();

	}

	/**
	 * Creating a new instance of this class
	 * @return Bitwise_Sidebar_Content|null
	 */
	public static function get_instance() {
		if ( null === self::$_instance ) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bitwise_Sidebar_Content_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Bitwise_Sidebar_Content_i18n();
		add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ) );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = $this->admin;

		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $plugin_admin, 'admin_sidebar_menu' ) );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = $this->public;
		add_action( 'wp_enqueue_scripts', array($plugin_public, 'enqueue_styles' ));
		add_action( 'wp_enqueue_scripts', array($plugin_public, 'enqueue_scripts' ));
		add_filter( 'boss_learndash_locate_template',array( $plugin_public, 'bitsc_include_custom_topic_template' ));
		add_filter( 'page_template',array( $plugin_public, 'bitscr_code_template' ));
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * @return Bitsa_Data_Store
	 */
	public function get_dataStore() {
		if ( empty( $this->data_store ) ) {
			$class            = apply_filters( 'bitsa_data_store_class', 'Bitscr_Data_Store' );
			$this->data_store = new $class();
		}

		return $this->data_store;
	}
}

if ( ! function_exists( 'Bitscr_Core' ) ) {
	/**
	 * @return Bitwise_Sidebar_Content|null
	 */
	function Bitscr_Core() {
		return Bitwise_Sidebar_Content::get_instance();

	}
}

$GLOBALS['Bitscr_Core'] = Bitscr_Core();
