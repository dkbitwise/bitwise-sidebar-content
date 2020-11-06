<?php
defined( 'ABSPATH' ) || exit; //Exit if accessed directly

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Bitscr_Content_Table extends WP_List_Table {
	public $per_page = 5;
	public $data;
	public $meta_data;
	public $date_format;

	/**
	 * Constructor.
	 * @since  1.0.0
	 */
	public function __construct( $args = array() ) {
		parent::__construct( array(
			'singular' => 'Content',
			'plural'   => 'Contents',
			'ajax'     => false,
		) );

		$this->data        = array();
		$this->date_format = Bitscr_Core()->admin->get_date_format();
		$this->per_page    = 5;
		// Make sure this file is loaded, so we have access to plugins_api(), etc.
		require_once( ABSPATH . '/wp-admin/includes/plugin-install.php' );

		parent::__construct( $args );
	}

	/**
	 * Text to display if no content are present.
	 * @return  void
	 * @since  1.0.0
	 */
	public function no_items() {
		echo esc_html__( 'No content available.', 'bitwise-sidebar-content' );
	}

	public function column_name( $item ) {
		$edit_link     = $item['row_actions']['edit']['link'];
		$column_string = '<div><strong>';

		$column_string .= '<a href="' . $edit_link . '" class="row-title">' . $item['name'] . '</a>';
		$column_string .= '</strong>';

		$column_string .= "<div style='clear:both'></div></div>";

		$column_string .= '<div class=\'row-actions\'>';

		$item_last     = array_keys( $item['row_actions'] );
		$item_last_key = end( $item_last );
		foreach ( $item['row_actions'] as $k => $action ) {
			$column_string .= '<span class="' . $action['action'] . '"><a href="' . $action['link'] . '" ' . $action['attrs'] . ' >' . $action['text'] . '</a>';

			if ( $k !== $item_last_key ) {
				$column_string .= ' | ';
			}
			$column_string .= '</span>';
		}
		$column_string .= '</div>';

		return ( $column_string );
	}

	public function column_lesson( $item ) {
		return $item['lesson_name'];
	}

	public function column_type( $item ) {
		return $item['type'];
	}

	public function column_source( $item ) {
		return isset( $item['source'] ) ? $item['source'] : '';
	}

	public function column_status( $item ) {
		return isset( $item['status'] ) ? $item['status'] : 'draft';
	}

	public function column_date_added( $item ) {
		return $item['date_added'];
	}

	/**
	 * Prepare an array of items to be listed.
	 * @return array Prepared items.
	 * @since  1.0.0
	 */
	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );

		$total_items = $this->data['found_posts'];

		$searchcol = array( 'name' );

		$this->set_pagination_args( array(
			'total_items'    => $total_items, //WE have to calculate the total number of items
			'per_page'       => $this->per_page, //WE have to determine how many items to show on a page
			'search'         => $_REQUEST["s"],
			'search_columns' => $searchcol
		) );

		$this->items = $this->data['items'];
	}

	/**
	 * Retrieve an array of columns for the list table.
	 * @return array Key => Value pairs.
	 * @since  1.0.0
	 */
	public function get_columns() {
		$columns = array(
			'name'       => __( 'Content Title', 'bitwise-sidebar-content' ),
			'lesson'     => __( 'Lesson', 'bitwise-sidebar-content' ),
			'type'       => __( 'Type', 'bitwise-sidebar-content' ),
			'source'     => __( 'Target', 'bitwise-sidebar-content' ),
			'status'     => __( 'Status', 'bitwise-sidebar-content' ),
			'date_added' => __( 'Date Added', 'bitwise-sidebar-content' ),
		);

		return $columns;
	}


	public function get_table_classes() {
		$get_default_classes = parent::get_table_classes();
		array_push( $get_default_classes, 'bitscr-instance-table' );

		return $get_default_classes;
	}

	public function single_row( $item ) {
		$tr_class = 'bitscr-content';
		echo '<tr class="' . esc_attr( $tr_class ) . '">';
		$this->single_row_columns( $item );
		echo '</tr>';
	}

	/**
	 * Generate the table navigation above or below the table
	 *
	 * @param string $which
	 *
	 * @since 3.1.0
	 *
	 */
	public function display_tablenav( $which ) { ?>
        <div class="tablenav <?php echo esc_attr( $which ); ?>">

			<?php if ( $this->has_items() ) : ?>
                <div class="alignleft actions bulkactions">
					<?php $this->bulk_actions( $which ); ?>
                </div>
			<?php
			endif;
			$this->extra_tablenav( $which );
			$this->pagination( $which );
			?>

            <br class="clear"/>
        </div>
		<?php
	}
}
