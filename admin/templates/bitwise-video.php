<?php
/**
 * Bitwise video create form
 */
$videos_url = add_query_arg( array(
	'page'    => 'bitwise-sidebar-content',
	'add_new' => true
), admin_url( 'admin.php' ) );
?>
<div id="bitwise-video-form">
    <h3 class="bitwise-video">Videos <a class="bitwise-link" href="<?php echo esc_url( $videos_url ) ?>">Add New</a></h3>
	<?php
	if ( isset( $_GET['add_new'] ) && $_GET['add_new'] ) { ?>
        <table>
            <tr>
                <td>Enter Video URL</td>
                <td><input type="text" name="video_url"></td>
            </tr>
            <tr>
                <td>OR</td>
            </tr>
            <tr>
                <td>Upload</td>
                <td><input type="file" name="video_file"></td>
            </tr>
            <tr>
                <td><input class="primary button-primary" type="submit" value="Submit"></td>
            </tr>

        </table>
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