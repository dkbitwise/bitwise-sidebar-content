<?php
/**
 * Bitwise video create form
 */
$content_url = add_query_arg( array(
	'page'    => 'bitwise-sidebar-content',
	'add_new' => true
), admin_url( 'admin.php' ) ); ?>

<div class="bitwise-content-form" id="bitwise-content-form">
    <h3 class="bitwise-content">Contents <a class="bitwise-link" href="<?php echo esc_url( $content_url ) ?>">Add Content<span class="wp-spin spinner"></span></a></h3>
	<?php
	if ( isset( $_GET['add_new'] ) && $_GET['add_new'] ) { ?>
        <form class="bitwise-content-form-table" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
            <input type="hidden" name="action" value="bitwise_content_form">
            <input type="hidden" name="bitwise_content_form_nonce" value="<?php echo wp_create_nonce( 'bitwise_content_form_nonce_val' ) ?>">
            <table class="bitwise-content-table-form">
                <tr>
                    <td>Select a Course</td>
                    <td class="select-course">
                        <select id="bitscr_course" name="course">
                            <option value="0">Select a course</option>
							<?php
							foreach ( $courses as $course ) { ?>
                                <option value="<?php echo $course['id'] ?>"><?php echo $course['name'] ?></option>
								<?php
							} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Select a Lesson</td>
                    <td>
                        <select id="bitscr_lessons" name="lesson">
                            <option value="0">Select a lesson</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Select content type</td>
                    <td class="bitscr-label">
                        <label><input checked type="radio" name="content_type" value="Video">Video</label>
                        <label><input type="radio" name="content_type" value="Help">Help</label>
                    </td>
                </tr>
                <tr>
                    <td>Select content target</td>
                    <td class="bitscr-label">
                        <label><input checked type="radio" name="content_source" value="LMS">LMS</label>
                        <label><input type="radio" name="content_source" value="Quiz">Quiz Engine</label>
                        <label><input type="radio" name="content_source" value="Both">Both</label>
                    </td>
                </tr>
                <tr>
                    <td>Enter Content URL</td>
                    <td><input id="content_url" type="text" name="content_url"/></td>
                </tr>
                <tr>
                    <td>OR</td>
                </tr>
                <tr>
                    <td>Upload</td>
                    <td><input id="upload_image_button" type="button" class="button-secondary" value="Upload the Content"/></td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="bitwise-content">
                        <input class="primary button-primary" type="submit" value="Submit">
                    </td>
                </tr>

            </table>
        </form>
	<?php } else {
		$contents = Bitscr_Core()->bit_sc_content->bitscr_content_list();
		$table    = new Bitscr_Content_Table();
		$table->render_trigger_nav();
		//$table->search_box( 'Search contents' );
		$table->data = $contents;
		$table->prepare_items();
		$table->display();
	} ?>

</div>