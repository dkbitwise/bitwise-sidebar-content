<?php
defined( 'ABSPATH' ) || exit; //Exit if accessed directly

/**
 * Bitscr_Course class
 */
class Bitscr_Course {
	private static $ins = null;

	private $id = 0;
	private $name = '';
	private $sfwd_course_id = 0;
	private $sfwd_lessons = [];

	public $obj_type;

	/**
	 * Bitscr_Course constructor.
	 *
	 * @param int $id
	 */
	public function __construct( $id = 0 ) {
		$this->obj_type = 'courses';
		if ( $id > 0 ) {
			$db_data = Bitscr_Common::get_data_by_id( $id, $this->obj_type );
			if ( is_array( $db_data ) && count( $db_data ) > 0 ) {
				foreach ( is_array( $db_data ) ? $db_data : array() as $s_key => $s_value ) {
					if ( 'sfwd_lessons' === $s_key ) {
						$this->{$s_key} = empty( $s_value ) ? [] : json_decode( $s_value, true );
					} else {
						$this->{$s_key} = $s_value;
					}
				}
			}
		}
	}

	/**
	 * @return Bitscr_Course|null
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
	 *  Setter function for learndash course id
	 *
	 * @param $sfwd_course_id
	 */
	public function set_sfwd_course_id( $sfwd_course_id ) {
		$this->sfwd_course_id = $sfwd_course_id;
	}

	/**
	 *  Setter function for lesson
	 *
	 * @param $lessons
	 */
	public function set_sfwd_lessons( $lessons ) {
		$this->sfwd_lessons = $lessons;
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
	 * @return int
	 */
	public function get_sfwd_course_id() {
		return $this->sfwd_course_id;
	}

	/**
	 * Getter function for learndash lessons
	 * @return array
	 */
	public function get_sfwd_lessons() {
		return $this->sfwd_lessons;
	}


	/**
	 * Adding a new course data
	 *
	 * @param array $setData
	 *
	 * @return mixed
	 */
	public function save( $setData = array() ) {
		foreach ( is_array( $setData ) ? $setData : array() as $s_key => $s_value ) {
			$this->{$s_key} = $s_value;
		}

		$lessons = $this->get_sfwd_lessons();
		$lessons = empty( $lessons ) ? $lessons : json_encode( $lessons );

		$data                   = array();
		$data['name']           = $this->get_name();
		$data['sfwd_course_id'] = $this->get_sfwd_course_id();
		$data['sfwd_lessons']   = $lessons;

		$db_course_id = $this->get_id();
		Bitscr_Core()->admin->log( "Course Data for course_id: $db_course_id: " . print_r( $data, true ) );

		if ( ! empty( $db_course_id ) && $db_course_id > 0 ) {
			return Bitscr_Common::update_data( $data, array( 'id' => $db_course_id ), $this->obj_type );
		}

		Bitscr_Common::insert_data( $data, $this->obj_type );
		$inserted_id = Bitscr_Common::get_insert_id();
		Bitscr_Core()->admin->log( "Inserted course id: $inserted_id: " . print_r( Bitscr_Common::get_last_error(), true ) );

		return $inserted_id;
	}

	/**
	 * Get all courses list
	 * @return array|object|null
	 */
	public function bitscr_courses_list() {
		$update     = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
		$db_courses = Bitscr_Common::get_all_data( $this->obj_type );
		$result     = false;

		if ( 'update' === $update ) {
			$args         = array(
				'post_status'   => 'publish',
				'post_type'     => 'sfwd-courses',
				'post_per_page' => '-1'
			);
			$sfwd_courses = new WP_Query( $args );
			if ( $sfwd_courses->post_count > 0 ) {
				foreach ( $sfwd_courses->posts as $sfwd_course ) {
					$existing = false;
					foreach ( $db_courses as $db_key => $db_course ) {
						if ( $sfwd_course->ID === intval( $db_course['sfwd_course_id'] ) ) {
							if ( $sfwd_course->post_title !== $db_course['name'] ) {
								$this->set_id( $db_course['id'] );
								$this->set_name( $sfwd_course->post_title );
								$this->set_sfwd_course_id( $sfwd_course->ID );
								$result = $this->save( array() );
							}
							$existing = true;
							break;
						}
					}

					if ( false === $existing ) {
						$this->set_name( $sfwd_course->post_title );
						$this->set_sfwd_course_id( $sfwd_course->ID );

						$lessons      = learndash_get_lesson_list( $sfwd_course->ID );
						$sfwd_lessons = [];
						foreach ( $lessons as $lesson ) {
							$sfwd_lessons[ $lesson->ID ] = $lesson->post_title;
						}

						$this->set_sfwd_lessons( $sfwd_lessons );
						$result = $this->save( array() );
					}

					if ( false !== $result && ! is_wp_error( $result ) ) {
						//echo "<br>Result: " . $result;
					}
				}
			}
		}

		return Bitscr_Common::get_all_data( $this->obj_type );

	}
}
