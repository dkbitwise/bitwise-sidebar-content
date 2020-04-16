<?php
/**
 * Bitwise video create form
 */
$content_url = add_query_arg( array(
	'page'    => 'bitwise-sidebar-content',
	'add_new' => true
), admin_url( 'admin.php' ) );

?>
<div class="bitwise-content-form" id="bitwise-content-form">
    <h3 class="bitwise-content">Contents <a class="bitwise-link" href="<?php echo esc_url( $content_url ) ?>">Add Content</a></h3>
	<?php
	if ( isset( $_GET['add_new'] ) && $_GET['add_new'] ) { ?>
        <form class="bitwise-content-form-table">
            <table>
                <tr>
                    <td>Select a Course</td>
                    <td>
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
                    <td>
                        <label><input checked type="radio" name="content_type" value="video">Video</label>
                        <label><input type="radio" name="content_type" value="help">Help</label>
                    </td>
                </tr>
                <tr>
                    <td>Select content source</td>
                    <td>
                        <label><input checked type="radio" name="content_source" value="LMS">LMS</label>
                        <label><input type="radio" name="content_source" value="quiz">Quiz Engine</label>
                    </td>
                </tr>
                <tr>
                    <td>Enter Content URL</td>
                    <td><input type="text" name="content_url"></td>
                </tr>
                <tr>
                    <td>OR</td>
                </tr>
                <tr>
                    <td>Upload</td>
                    <td><input type="file" name="content_file"></td>
                </tr>
                <tr>
                    <td><input class="primary button-primary" type="submit" value="Submit"></td>
                </tr>

            </table>
        </form>
	<?php }
	/*$videos = get_videos();

	$table = new Video_Listing_Table();
	$table->render_trigger_nav();
	$table->search_box( 'Search Videos' );
	$table->data = $videos;
	$table->prepare_items();
	$table->display();*/
	?>

</div>