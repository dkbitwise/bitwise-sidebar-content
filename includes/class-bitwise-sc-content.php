<?php
defined( 'ABSPATH' ) || exit; //Exit if accessed directly

/**
 * Bitwise_SC_Content class
 */
class Bitwise_SC_Content {
	private static $ins = null;

	private $id = 0;
	private $name = '';
	private $sfwd_course_id = 0;
	private $sfwd_lesson_id = 0;
	private $content_url = '';
	private $type = '';
	private $source = '';
	private $category = 0;
	private $status = '';
	private $date_added = '0000-00-00 00:00:00';

	public $obj_type;

	/**
	 * Bitwise_SC_Content constructor.
	 *
	 * @param int $id
	 */
	public function __construct( $id = 0 ) {
		$this->obj_type = 'content';
		if ( $id > 0 ) {
			$db_data = Bitscr_Common::get_data_by_id( $id, $this->obj_type );
			if ( is_array( $db_data ) && count( $db_data ) > 0 ) {
				foreach ( is_array( $db_data ) ? $db_data : array() as $s_key => $s_value ) {
					$this->{$s_key} = $s_value;
				}
			}
		}
	}

	/**
	 * @return Bitwise_SC_Content|null
	 */
	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self;
		}

		return self::$ins;
	}

	/**
	 * Setter function for course id
	 *
	 * @param $id
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * Setter function for course name
	 *
	 * @param $name
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * Setter function for course id
	 *
	 * @param $name
	 */
	public function set_sfwd_course_id( $sfwd_course_id ) {
		$this->sfwd_course_id = $sfwd_course_id;
	}

	/**
	 *  Setter function for learndash lesson id
	 *
	 * @param $lesson_id
	 */
	public function set_sfwd_lesson_id( $lesson_id ) {
		$this->sfwd_lesson_id = $lesson_id;
	}

	/**
	 * Setter function for content url
	 *
	 * @param $content_url
	 */
	public function set_content_url( $content_url ) {
		$this->content_url = $content_url;
	}

	/**
	 * @param $type
	 */
	public function set_type( $type ) {
		$this->type = $type;

	}

	/**
	 * @param $source
	 */
	public function set_source( $source ) {
		$this->source = $source;
	}

	/**
	 * Setter function for school added date
	 *
	 * @param $date_added
	 */
	public function set_date_added( $date_added ) {
		$this->date_added = $date_added;
	}

	/**
	 * @param $category
	 */
	public function set_category( $category ) {
		$this->category = $category;
	}

	/**
	 * @param $status
	 */
	public function set_status( $status ) {
		$this->status = $status;
	}

	/**
	 * Getter function for course id
	 * @return int
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Getter function for course name
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Getter function for learndash course id
	 * @return string
	 */
	public function get_sfwd_course_id() {
		return $this->sfwd_course_id;
	}

	/**
	 * Getter function for learndash course id
	 * @return int
	 */
	public function get_sfwd_lesson_id() {
		return $this->sfwd_lesson_id;
	}

	/**
	 * Getter function for content url
	 * @return string
	 */
	public function get_content_url() {
		return $this->content_url;
	}

	/**
	 * Getter function for type
	 * @return string
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * Getter function for source
	 * @return string
	 */
	public function get_source() {
		return $this->source;
	}

	/**
	 * Getter function for status
	 * @return string
	 */
	public function get_status() {
		return $this->status;
	}

	/**
	 * Getter function for category
	 * @return string
	 */
	public function get_category() {
		return $this->category;
	}

	/**
	 * Getter function for school date added
	 * @return string
	 */
	public function get_date_added() {
		return $this->date_added;
	}

	/**
	 * Adding a new content
	 *
	 * @param array $setData
	 *
	 * @return mixed
	 */
	public function save( $setData = array() ) {
		foreach ( is_array( $setData ) ? $setData : array() as $s_key => $s_value ) {
			$this->{$s_key} = $s_value;
		}

		$data                   = array();
		$data['name']           = $this->get_name();
		$data['sfwd_course_id'] = $this->get_sfwd_course_id();
		$data['sfwd_lesson_id'] = $this->get_sfwd_lesson_id();
		$data['content_url']    = $this->get_content_url();
		$data['type']           = $this->get_type();
		$data['source']         = $this->get_source();
		$data['category']       = $this->get_category();
		$data['status']         = $this->get_status();
		$data['date_added']     = ( '0000-00-00 00:00:00' === $this->get_date_added() ) ? Bitscr_Common::get_now() : $this->get_date_added();

		$db_course_id = $this->get_id();
		Bitscr_Core()->admin->log( "Content Data for content_id: $db_course_id: " . print_r( $data, true ) );

		if ( ! empty( $db_course_id ) && $db_course_id > 0 ) {
			return Bitscr_Common::update_data( $data, array( 'id' => $db_course_id ), $this->obj_type );
		}

		Bitscr_Common::insert_data( $data, $this->obj_type );
		$inserted_id = Bitscr_Common::get_insert_id();
		Bitscr_Core()->admin->log( "Inserted content id: $inserted_id: " . print_r( Bitscr_Common::get_last_error(), true ) );

		return $inserted_id;
	}

	/**
	 * Get all courses list
	 * @return array|object|null
	 */
	public function bitscr_content_list() {
		$paged  = isset( $_GET['paged'] ) ? absint( wc_clean( $_GET['paged'] ) ) : 0;  // phpcs:ignore WordPress.Security.NonceVerification
		$search = $_GET['s'];

		$limit = Bitscr_Core()->admin->posts_per_page();

		$table_name = 'bitscr_content';
		$data_store = Bitscr_Core()->get_dataStore();
		$data_store->set_table( $table_name );

		$sql_query      = "SELECT * FROM {table_name}";
		$sql_query      .= " WHERE 1=1";
		$found_contents = Bitscr_Core()->get_dataStore()->get_results( $sql_query );

		if ( $search ) {
			$sql_query .= "   and name LIKE  '%$search%'";
		}

		if ( count( $found_contents ) > $limit ) {
			$paged     = ( $paged > 0 ) ? ( $paged - 1 ) : $paged;
			$sql_query .= " LIMIT " . $limit * $paged . ", " . $limit;
		}

		$contents = Bitscr_Core()->get_dataStore()->get_results( $sql_query );
		$items    = array();

		foreach ( $contents as $content ) {
			$content_rul = add_query_arg( array(
				'page' => 'bitwise-sidebar-content',
				'edit' => $content['id'],
			), admin_url( 'admin.php' ) );

			$row_actions = array();

			$row_actions['edit'] = array(
				'action' => 'edit',
				'text'   => __( 'Edit', 'bitwise-sidebar-content' ),
				'link'   => $content_rul,
				'attrs'  => '',
			);

			$row_actions['delete'] = array(
				'action' => 'delete',
				'text'   => __( 'Delete', 'bitwise-sidebar-content' ),
				'link'   => 'javascript:void(0);',
				'attrs'  => 'class="bitscr-delete-content" data-content-id="' . $content['id'] . '" id="bitscr_delete_' . $content['id'] . '"',
			);

			$sfwd_course_id = isset( $content['sfwd_course_id'] ) ? $content['sfwd_course_id'] : 0;
			$sfwd_lesson_id = isset( $content['sfwd_lesson_id'] ) ? intval( $content['sfwd_lesson_id'] ) : 0;

			$course_data = Bitscr_Common::get_multiple_columns( array( 'id' => 'bit_course_id' ), array( 'sfwd_course_id' => $sfwd_course_id ), 'courses' );

			$bit_course_id  = isset( $course_data['bit_course_id'] ) ? $course_data['bit_course_id'] : 0;
			$bit_course_obj = new Bitscr_Course( $bit_course_id );
			$lessons        = ( $bit_course_obj instanceof Bitscr_Course ) ? $bit_course_obj->get_sfwd_lessons() : [];

			$lesson_name = array_key_exists( $sfwd_lesson_id, $lessons ) ? $lessons[ $sfwd_lesson_id ] : '';
			
			if($content['status'] == 1)
			{
				$status = "Published";
			}
			else
			{
				$status = "Draft";
			}

			$items[] = array(
				'id'          => $content['id'],
				'name'        => $content['name'],
				'type'        => $content['type'],
				'lesson_name' => $lesson_name,
				'source'      => $content['source'],
				'status'      => $status,
				'category'    => $content['category'],
				'date_added'  => $content['date_added'],
				'row_actions' => $row_actions,
			);
		}

		$found_posts          = array( 'found_posts' => count( $found_contents ) );
		$found_posts['items'] = $items;

		return $found_posts;
	}
}
