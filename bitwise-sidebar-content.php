<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bitwiseacademy.com/
 * @since             1.0.0
 * @package           Bitwise_Sidebar_Content
 *
 * @wordpress-plugin
 * Plugin Name:       Bitwise Sidebar Content
 * Plugin URI:        https://bitwiseacademy.com/
 * Description:       Show sidebar tabs on topic page to show videos, notes and help content.
 * Version:           1.0.0
 * Author:            Bitwise
 * Author URI:        https://bitwiseacademy.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bitwise-sidebar-content
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BITWISE_SIDEBAR_CONTENT_VERSION', '1.0.0' );
define( 'BITSCR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bitwise-sidebar-content-activator.php
 */
function activate_bitwise_sidebar_content() {
	require_once __DIR__ . '/includes/class-bitwise-sidebar-content-activator.php';
	Bitwise_Sidebar_Content_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bitwise-sidebar-content-deactivator.php
 */
function deactivate_bitwise_sidebar_content() {
	require_once __DIR__ . '/includes/class-bitwise-sidebar-content-deactivator.php';
	Bitwise_Sidebar_Content_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bitwise_sidebar_content' );
register_deactivation_hook( __FILE__, 'deactivate_bitwise_sidebar_content' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require __DIR__ . '/includes/class-bitwise-sidebar-content.php';



function bitscr_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'bitscr_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}



	/*********************************************************/
		//Download the notes updated by suresh on 22-6-2020
	/*********************************************************/

	/**
	 * download notes for topic updated by suresh 
	 * @param int user_id
	 * @param int course_id
	 * @param int lesson_id
	 * @param int topic_id
	 */
	add_action( 'template_redirect', 'bitsa_notes_download' );
	function bitsa_notes_download(){
	 global $wpdb;
	  if(isset($_GET['lds-bulk-action-item'])){ // check bulk download or not
	  
	   ob_start();
	  	require __DIR__ . '/tcpdf/tcpdf.php';
	 	$notesids 	= $_GET['lds-bulk-action-item'];
		$current_user	= wp_get_current_user();
		$filename 		= sanitize_title( $current_user->display_name ) . '-notes.pdf';
		$allowed_roles = array('administrator');
		$user_id     = $current_user->ID;
		$table = $wpdb->prefix.'bitscr_notes';
	if(isset($_GET['lds-bulk-action-item'])){
			  $currenttopicid = $_GET['lds-bulk-action-item'];
			 foreach($currenttopicid as $key => $value){
			  $oldnotes[]=Bitscr_Common::selecttopicnotes( $user_id,$value); //save all notes for bulk download
			  }
	}else{
			
	   if( array_intersect($allowed_roles, $current_user->roles ) ) {  //check if the user role have admin access
				$oldnotes=Bitscr_Common::selectallnotes();   //get all the notes for admin 
    			$filename 		= 'all-notes.pdf';
    
    		  } else{
	 			 $oldnotes=Bitscr_Common::selectusernotes( $user_id); //Select the notes for particular user
    		  }
	 		 }
	 	$filename 		= sanitize_title( $current_user->display_name ). '-notes.pdf';
	 	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		 require_once(dirname(__FILE__).'/lang/eng.php');
		  $pdf->setLanguageArray($l);
		}
		
		$pdf->AddPage();
		$html = '<!doctype html><html><head><meta charset="utf-8"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>'.esc_html($current_user->display_name).'</title></head><body>';
		foreach($oldnotes as $oldnote){ 
		$html.='<h1>'.esc_html($oldnote[0]->title).'</h1>'.wpautop($oldnote[0]->content).'
				<p>Location: 
				<a href="' . esc_url( get_the_permalink($oldnote[0]->course_id) ) .'">' . get_the_title($oldnote[0]->course_id) . '</a> &raquo; 
				<a href="' . esc_url( get_the_permalink($oldnote[0]->lesson_id) ) .'">' . get_the_title($oldnote[0]->lesson_id) . '</a> &raquo;
				<a href="' . esc_url( get_the_permalink($oldnote[0]->topic_id) ) .'">' . get_the_title($oldnote[0]->topic_id) . '</a>
				</p><br><hr><br>';

		 }
		$html.='</body>
		</html>';
		$pdf->writeHTML($html, true, 0, true, 0);
		$pdf->lastPage();
		$pdf->Output($filename, 'D');
		ob_end_flush(); 
		exit();
	
	 }
	
		
	}
    /*********************************************************/
		//View the notes updated by suresh on 23-6-2020
	/*********************************************************/


	add_shortcode('viewnotes', 'bitsa_notes_viewnotes');

     /**
	 * View All notes  updated by suresh 23-6-2020
	 * @param int user_id
	 * @param int course_id
	 * @param int lesson_id
	 * @param int topic_id
	 */
	 
	
	function bitsa_notes_viewnotes(){
	
		wp_enqueue_script( 'bitwise_sidebar_content_public_js', plugin_dir_url( __FILE__ ) . '/public/js/bitwise-sidebar-content-public.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'learndash_sidebar_content_public_js', plugin_dir_url( __FILE__ ) . '/public/js/nt_notes.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'learndash_sidebar_print_public_js', plugin_dir_url( __FILE__ ) . '/public/js/nt_notes_lib.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'bitwise_lightbox_html5view', plugin_dir_url( __FILE__ ) . 'public/html5lightbox/html5lightbox.js', array(), '1.0.0', false );	
		
		wp_enqueue_style( 'bitwise_sidebar_content_public', plugin_dir_url( __FILE__ ) . 'public/css/bitwise-sidebar-content-public.css', array(), '1.0.0', 'all' );
			
	    global $wpdb;
		$current_user	= wp_get_current_user();
		$allowed_roles = array('administrator');
     	$user_id     = $current_user->ID;
		$table = $wpdb->prefix.'bitscr_notes';
		if(isset($_GET['currenttopicid'])){
			  $currenttopicid = $_GET['currenttopicid'];
			  $oldnotes=Bitscr_Common::selecttopicnotes( $user_id,$currenttopicid);
			 }else{
			 if( array_intersect($allowed_roles, $current_user->roles ) ) {  //check if the user have admin access
   
    			$oldnotes=Bitscr_Common::selectallnotes();
    		} else{
	 			$oldnotes=Bitscr_Common::selectusernotes( $user_id);  //select the notes for particular user
    		 }
			 }
		 ?>
		<div class="searchdiv">
            <div class="notes_list_filter show_drpd">
                <label>Show
                <select class="data_display">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                </select> entries</label>
         </div>
		<div class="col-md-6 auto nogap notes_list_filter pull-right">
        <input class="form-control form-control-sm ml-3 w-75 search" type="text" placeholder="Search" aria-label="Search">
        </div>
        </div> 
        <div class="notes_list_tablediv">
		<form action="" method="get">
         <table class="notes-listing notes_list_table">
            <thead>
                <tr style="background-color: black;color: white;">
                    <th>&nbsp;</th>
                    <th><?php esc_html_e('Notes','sfwd-lms'); ?></th>
                     <?php
                             if( array_intersect($allowed_roles, $current_user->roles ) ) { 
                            ?>
                        <th><?php esc_html_e( 'User', 'sfwd-lms' ); ?></th>
                        <?php }?>
                    
                    <th><?php esc_html_e( 'Date', 'sfwd-lms' ); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            	</tbody>
            	<tfoot>
            	<tr>
            	<td colspan="5">
                <input type="submit" name="lds-bulk-download" class="lds-bulk-download" value="<?php esc_attr_e( 'Download Selected', 'sfwd-lms' ); ?>" type="submit">
                </td>
                </tr>
            </tfoot>
        </table>

        <div class="displaying_message"></div>
		<ul class="pagination">  </ul>

       </form></div>
</div>

    <?php foreach($oldnotes as $oldnote){?>
    	<form id="singlesubmit<?php echo $oldnote->id;?>" method="get" action="">
       <input type="hidden" name="lds-bulk-action-item[<?php echo $oldnote->topic_id; ?>]"  value="<?php echo $oldnote->topic_id; ?>">
         </form>
<?php }
	}
