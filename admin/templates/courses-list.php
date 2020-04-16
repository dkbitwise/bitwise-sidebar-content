<?php
/**
 * Bitsa Synced courses
 */
defined( 'ABSPATH' ) || exit; //Exit if accessed directly
$course_url = add_query_arg( array(
	'page'   => 'bitscr_lms_courses',
	'action' => 'update',
), admin_url( 'admin.php' ) ); ?>
<hr class="wp-header-end">
<table class="bitscr-courses">
    <caption>
        <h3 class="bitscr_crs_sync"><?php esc_html_e( 'Bitwise LMS Courses', 'bitsa' ) ?>
            <a href="<?php echo esc_url( $course_url ); ?>" class="button button-primary"><?php esc_html_e( 'Sync Courses', 'bitwise-sidebar-content' ); ?></a></h3>
    </caption>
    <thead>
	<?php
	if ( count( $courses ) > 0 ) { ?>
        <tr>
            <th><?php esc_html_e( 'Serial No.:', 'bitsa' ) ?></th>
            <th><?php esc_html_e( 'LMS Course ID:', 'bitsa' ) ?></th>
            <th><?php esc_html_e( 'Course Name:', 'bitsa' ) ?></th>
        </tr>
	<?php } ?>
    </thead>
    <tbody>
	<?php
	foreach ( $courses as $c_key => $course ) { ?>
        <tr>
            <td><?php echo esc_html( $c_key + 1 ) ?></td>
            <td><?php echo esc_html( $course['sfwd_course_id'] ) ?></td>
            <td><?php echo esc_html( $course['name'] ); ?></td>
        </tr>
	<?php }
	if ( count( $courses ) < 1 ) { ?>
        <tr>
            <td><?php esc_html_e( 'There are no courses.' ) ?></td>
        </tr>
	<?php } ?>
    </tbody>
</table>