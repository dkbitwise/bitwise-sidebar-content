<?php
/**
 * Bitwise video create form
 */
$content_url = add_query_arg( array(
	'page'    => 'bitwise-sidebar-content',
	'add_new' => true
), admin_url( 'admin.php' ) );
?>
<div class="bitwise-content-form wrap" id="bitwise-content-form">
    <h1 class="bitwise-content wp-heading-inline">Contents <a class="page-title-action bitwise-link" href="<?php echo esc_url( $content_url ) ?>">Add New<span class="wp-spin spinner"></span></a></h1>
	<?php
	$categories = Bitscr_Core()->admin->content_categories();
	//$codes      = Bitscr_Core()->admin->all_codes();
	if ( ( isset( $_GET['add_new'] ) && $_GET['add_new'] ) || $edit_id > 0 ) {
		$content = new Bitwise_SC_Content( $edit_id );
		if ( $content instanceof Bitwise_SC_Content ) {
			$sfwd_course_id = $content->get_sfwd_course_id();
			$sfwd_lesson_id = $content->get_sfwd_lesson_id();
			$course_data    = Bitscr_Common::get_multiple_columns( array( 'id' => 'bit_course_id' ), array( 'sfwd_course_id' => $sfwd_course_id ), 'courses' );
			$bit_course_id  = isset( $course_data['bit_course_id'] ) ? $course_data['bit_course_id'] : 0;
			$bit_course_obj = new Bitscr_Course( $bit_course_id );
			$lessons        = ( $bit_course_obj instanceof Bitscr_Course ) ? $bit_course_obj->get_sfwd_lessons() : [];
			$c_type         = $content->get_type();
			$c_target       = $content->get_source();
			$c_status       = $content->get_status();
			$c_category     = $content->get_category();
			$content_url    = $content->get_content_url();
			$c_name         = $content->get_name();

			$content_id  = is_numeric( $content_url ) ? abs( $content_url ) : 0;
			$content_url = ( $content_id > 0 ) ? '' : $content_url;

		} ?>
        <form name="bitsc_content_from" class="bitwise-content-form-table" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
            <input type="hidden" name="action" value="bitwise_content_form">
            <input type="hidden" name="bitwise_content_form_nonce" value="<?php echo wp_create_nonce( 'bitwise_content_form_nonce_val' ) ?>">
            <input type="hidden" name="content_id" value="<?php echo $edit_id ?>">
            <table class="bitwise-content-table-form">
                <tr>
                    <td>Select a Course</td>
                    <td class="select-course">
                        <select id="bitscr_course" name="course" required>
                            <option value="0">Select a course</option>
							<?php
							foreach ( $courses as $course ) { ?>
                                <option data-course_id="<?php echo $course['id'] ?>" <?php echo selected( $bit_course_id, $course['id'] ) ?> value="<?php echo $course['sfwd_course_id'] ?>"><?php echo $course['name'] ?></option>
								<?php
							} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td class="select-status">
                        <select required id="bitscr_status" name="content_status">
                            <option value="0">Select a Status</option>
                            <option <?php echo selected( 'draft', $c_status ) ?> value="draft">Draft</option>
                            <option <?php echo selected( 'published', $c_status ) ?> value="published">Published</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td class="select-category">
                        <select required id="bitscr_category" name="content_category">
                            <option value="-1">Select a Category</option>
							<?php
							foreach ( $categories as $category_id => $category ) { ?>
                                <option <?php echo selected( $category_id, $c_category ) ?> value="<?php echo esc_attr( $category_id ) ?>"><?php echo esc_html( $category ); ?></option>
							<?php }
							?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Enter the content title</td>
                    <td><input required value="<?php echo $c_name; ?>" type="text" name="content_name"/></td>
                </tr>
                <tr>
                    <td>Select a Lesson</td>
                    <td>
                        <select required id="bitscr_lessons" name="lesson">
                            <option value="0">Select a lesson</option>
							<?php
							foreach ( $lessons as $lesson_id => $lesson_name ) { ?>
                                <option <?php echo selected( $lesson_id, $sfwd_lesson_id ); ?> value="<?php echo $lesson_id; ?>"><?php echo $lesson_name; ?></option>
							<?php }
							?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Select content target</td>
                    <td class="bitscr-label">
                        <label><input <?php echo checked( $c_target, 'LMS' ) ?> checked type="radio" name="content_source" value="LMS">LMS</label>
                        <label><input <?php echo checked( $c_target, 'Quiz' ) ?> type="radio" name="content_source" value="Quiz">Quiz Engine</label>
                        <label><input <?php echo checked( $c_target, 'Both' ) ?> type="radio" name="content_source" value="Both">Both</label>
                    </td>
                </tr>
                <tr>
                    <td>Select content type</td>
                    <td class="bitscr-label">
                        <label><input <?php echo checked( $c_type, 'Video' ) ?> checked type="radio" name="content_type" value="Video">Video</label>
                        <label><input <?php echo checked( $c_type, 'Help' ) ?> type="radio" name="content_type" value="Help">Help</label>
                        <label><input <?php echo checked( $c_type, 'Code' ) ?> type="radio" name="content_type" value="Code">Code</label>
                    </td>
                </tr>

                <tr class="bitscr-code-snippet bitscr-hide">
                    <td>Select a code snippet</td>
                    <td>
						<?php
						wp_dropdown_pages( [
							'post_type'         => 'bitsc_code',
							'echo'              => 1,
							'option_none_value' => 0,
							'show_option_none'  => 'Select a Code',
							'name'              => 'bitsc_code_id',
							'selected'          => $content_id
						] );
						?>
                    </td>
                </tr>

                <tr class="bitscr-content-url">
                    <td>Enter Content URL</td>
                    <td><input value="<?php echo $content_url; ?>" id="content_url" type="text" name="content_url"/></td>
                </tr>
                <tr class="bitscr-content-or">
                    <td>OR</td>
                </tr>
                <tr class="bitscr-content-upload">
                    <td>Upload</td>
                    <td><input id="upload_image_button" type="button" class="button-secondary" value="Upload the Content"/></td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="bitwise-content">
                        <input class="primary button-primary" type="button" value="Submit">
                    </td>
                </tr>

            </table>
        </form>
	<?php } else {
		$contents = Bitscr_Core()->bit_sc_content->bitscr_content_list();
		$table    = new Bitscr_Content_Table();
		$table->render_trigger_nav();
		$table->data = $contents; ?>

        <form method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
			<?php if ( isset( $table ) ) : ?>
				<?php $table->prepare_items() ?>
				<?php //$table->search_box('Search', 'search_id'); //Needs To be called after $myRequestTable->prepare_items() ?>
				<?php $table->display() ?>
			<?php endif; ?>
        </form>
		<?php
	} ?>
</div>