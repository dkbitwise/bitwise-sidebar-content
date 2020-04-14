<?php
defined( 'ABSPATH' ) || exit; //Exit if accessed directly

/**
 * Video entity class
 * Class Bitwise_Videos
 */
class Bitwise_Videos {
	private static $ins = null;

	/**
	 * @var $id
	 */
	public $id = 0;
	public $video_url = '';
	public $type = '';
	public $date_added = '';

	/**
	 * Bitwise_Videos constructor.
	 *
	 * @param int $id
	 */
	public function __construct( $id = 0 ) {
		$this->id = $id;
	}

	/**
	 * @return Bitwise_Videos|null
	 */
	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self;
		}

		return self::$ins;
	}

	/**
	 * @return int
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * @param $id
	 */
	public function set_id( $id ) {
		$this->id = empty( $id ) ? $this->id : $id;
	}

	/**
	 * @return string
	 */
	public function get_video_url() {
		return $this->video_url;
	}

	/**
	 * @param $video_url
	 */
	public function set_video_url( $video_url ) {
		$this->video_url = $video_url;
	}

	/**
	 * @return string
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * @param $type
	 */
	public function set_type( $type ) {
		$this->type = $type;
	}

	public function get_date_added() {
		return $this->date_added;
	}

	public function set_date_added( $date_added ) {
		return $this->date_added = $date_added;
	}

	/**
	 * @param array $data
	 *
	 * @return int
	 */
	public function save( $data = array() ) {
		if ( count( $data ) > 0 ) {
			foreach ( $data as $col => $value ) {
				$this->$col = $value;
			}
		}
		$video_data               = array();
		$video_data['video_url']  = $this->get_video_url();
		$video_data['type']       = $this->get_type();
		$video_data['date_added'] = $this->get_date_added();

		$video_id = $this->get_id();

		if ( $video_id > 0 ) {
			$updated = $this->get_dB()->update( $video_data, array( 'id' => $video_id ) );

			return false === $updated ? $updated : $video_id;
		}
		$video_id = get_dB()->insert_id();

		return $video_id;
	}
}
