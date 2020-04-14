<?php
/**
 * Bitwise video create form
 */
?>
<div id="bitwise-video-form">
    <h3 class="bitwise-video">Videos <a class="bitwise-link" href="javascript:void(0)">Add New</a></h3>
	<?php
	$videos = WFFN_Core()->admin->get_funnels();

	$table = new WFFN_Funnels_Listing_Table();
	$table->render_trigger_nav();
	$table->search_box( 'Search Funnels' );
	$table->data = $funnels;
	$table->prepare_items();
	$table->display();
	?>
</div>