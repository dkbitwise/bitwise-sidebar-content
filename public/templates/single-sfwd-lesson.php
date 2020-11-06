<?php
/**
 * The Template for displaying all single topics.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
    <!-- BuddyPress and bbPress Stylesheets are called in wp_head, if plugins are activated -->
	<?php wp_head(); ?>
</head>

<?php
global $rtl;
$logo         = ( boss_get_option( 'logo_switch' ) && boss_get_option( 'boss_logo', 'id' ) ) ? '1' : '0';
$inputs       = ( boss_get_option( 'boss_inputs' ) ) ? '1' : '0';
$boxed        = boss_get_option( 'boss_layout_style' );
$header_style = boss_get_option( 'boss_header' ); ?>

<body <?php body_class(); ?> data-logo="<?php echo $logo; ?>" data-inputs="<?php echo $inputs; ?>" data-rtl="<?php echo ( $rtl ) ? 'true' : 'false'; ?>" data-header="<?php echo $header_style; ?>" style="background-color: white;">

<?php do_action( 'buddyboss_before_header' ); ?>

<div id="scroll-to"></div>
<?php
$logo_small_id = boss_get_option( 'boss_small_logo', 'id' );
$logo_small    = wp_get_attachment_image( $logo_small_id, 'full', '', array( 'class' => 'boss-logo small' ) ); ?>

<header id="masthead" class="site-header" data-infinite="<?php echo ( boss_get_option( 'boss_activity_infinite' ) ) ? 'on' : 'off'; ?>">

    <div class="header-wrap">
        <div class="header-outher">
            <div class="header-inner">
				<?php get_template_part( 'template-parts/header-fluid-layout-column' ); ?>
				<?php if ( '1' == $header_style ) { ?>
					<?php get_template_part( 'template-parts/header-middle-column' ); ?>
				<?php } ?>
				<?php get_template_part( 'template-parts/header-profile' ); ?>
            </div><!-- .header-inner -->
        </div><!-- .header-wrap -->
    </div><!-- .header-outher -->

    <div id="mastlogo">
		<?php get_template_part( 'template-parts/header-logo' ); ?>
        <p class="site-description"><?php bloginfo( 'description' ); ?></p>
    </div><!-- .mastlogo -->

</header><!-- #masthead -->

<?php do_action( 'buddyboss_after_header' ); ?>

<?php get_template_part( 'template-parts/header-mobile' ); ?>
<div id="panels" class="<?php echo ( boss_get_option( 'boss_adminbar' ) ) ? 'with-adminbar' : ''; ?>">

	<?php
	$course_id = learndash_get_course_id();
	$get_post  = get_post( $course_id );
	$lessonid  = learndash_get_lesson_id();

	$bit_course_content = Bitscr_Common::get_multiple_data( array(), array( 'sfwd_lesson_id' => $lessonid ), 'content' );

	$videos = wp_list_filter( $bit_course_content, array( 'type' => 'Video', 'status' => 'published' ) );
	$helps  = wp_list_filter( $bit_course_content, array( 'type' => 'Help', 'status' => 'published' ) ); ?>

    <div class="bit_info_btn btn121" data-toggle="tooltip" data-placement="left">
        <div class="content_btns">
            <a href="javascript:void(0);" class="bttn videos_btn" data-tab="videos">VIDEOS</a>

            <a href="javascript:void(0);" class="bttn help_btn" data-tab="help">DOCUMENTS</a>
            <a href="javascript:void(0);" class="bttn notes_btn" data-tab="notes">NOTES</a>
        </div>
    </div>

    <div class="info_wrapp">
        <div class="thumbnail">
            <a href="javascript:void(0);" class="com_close close bt_box_shadow info_close"><i class="fa fa-times" aria-hidden="true"></i></a>
            <ul class="nav nav-pills">
                <li><a class="nav_link" data-toggle="pill" href="#videos">VIDEOS</a></li>
                <li><a class="nav_link" data-toggle="pill" href="#help">DOCUMENTS</a></li>
                <li><a class="nav_link" data-toggle="pill" href="#notes">NOTES</a></li>
            </ul>
            <div class="tab-content">
                <div id="videos" class="tab-pane fade">
                    <h3>ALL VIDEOS</h3>
                    <p><small style="color:#4e9a06;"><strong><?php echo count( $videos ); ?></strong> VIDEOS CURRENTLY AVAILABLE</small></p>
                    <ul class="sidebar_list">
						<?php $vcount = 0;
						foreach ( $videos as $video ) {
							$vcount ++; ?>
                            <li>
                                <a data-group="video_content" class="html5lightbox" href="<?php echo $video['content_url'] ?>" title="<?php echo $video['name'] ?>">
                                    <h3><?php echo "($vcount) " . $video['name'] ?></h3>
                                </a>
                            </li>
							<?php
						} ?>
                    </ul>
                </div>
                <div id="notes" class="tab-pane fade">
					<?php
					/*********************************************************/
					//Notes Tab content updated by suresh on 22-6-2020
					/*********************************************************/
					$current_user = wp_get_current_user();

					$current_post_type = get_post_type( $course_id );
					$lessonid          = learndash_get_lesson_id();
					$current_lesson_id = $lessonid;
					$id                = get_the_ID();
					$oldnotes          = Bitscr_Common::selecttopicnotes( $current_user->ID, $id );
					$allnotes          = Bitscr_Common::selectusernotes( $current_user->ID );
					$allowed_roles     = array( 'administrator' ); ?>

                    <form id="bitwisescr-course-note" action="" method="post">
                        <input type="hidden" name="bitwisescr-note-user-id" id="bitwisescr-note-user-id" value="<?php echo $current_user->ID; ?>">
                        <input type="hidden" name="bitwisescr-note-current-lesson-id" id="bitwisescr-note-current-lessson-id" value="<?php echo $current_lesson_id; ?>">
                        <input type="hidden" name="bitwisescr-note-current-course-id" id="bitwisescr-note-current-course-id" value="<?php echo $course_id; ?>">
                        <input type="hidden" name="bitwisescr-note-current-topic-id" id="bitwisescr-note-current-topic-id" value="<?php the_ID(); ?>">
                        <input type="hidden" name="bitwisescr-note-current-post-type" id="bitwisescr-note-current-post-type" value="<?php echo $current_post_type; ?>">
                        <input type="hidden" name="bitwisescr-note-id" id="bitwisescr-note-id" value="<?php the_ID(); ?>">
                        <div id="bitwisescr-note-title-fieldnew">
                            <input type="text" name="bitwisescr-note-title" id="bitwisescr-note-titlenew" value="<?php if ( isset( $oldnotes[0]->title ) ) {
								echo $oldnotes[0]->title;
							} else {
								echo get_the_title();
							} ?>" placeholder="">
                        </div>
						<?php
						if ( isset( $oldnotes[0]->content ) ) {
							$body = stripslashes( $oldnotes[0]->content );
						} else {
							$body = '';
						}
						$args = array(
							'media_buttons' => false,
							'textarea_name' => 'bitwisescr-note-body',
							'editor_height' => 175,
							'quicktags'     => false,
							'teeny'         => true,
							'quicktags'     => false,
						);

						wp_editor( $body, 'bitwisescr-note-body', $args ); //use the wp_editor for notes form
						?>
                        <div id="bitwisescr-note-actions-wrapper">
                            <ul id="bitwisescr-note-actions">
                                <li><a href="javascript:void(0)" id="bitwisescr-note-submit"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></li>
                                <li>
                                    <a href="javascript:void(0)" class="bitwisescr-notes-print-shortcode" data-note="<?php the_ID(); ?>" title="<?php echo 'Print'; ?>"><i class="fa fa-print" aria-hidden="true"></i></a>
                                    <div id="learndash-print-notes-new"></div>
                                </li>

								<?php if ( isset( $oldnotes[0]->content ) ) { ?>
                                    <li>
                                        <a href="javascript:void(0)" class="downloadword" data-note="<?php echo $oldnotes[0]->id; ?>" title="<?php echo 'Download'; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                    </li>
                                    <li style="margin-right: 20px;"><a data-group="notes_content" class="html5lightbox" href="#notesdiv"><i class="fa fa-sticky-note" aria-hidden="true"></i></a></li>
								<?php } ?>
                            </ul>
                        </div>
                        <p id="nt-utility-links" class="all-notes">
                            <a class="html5lightbox" href="#allnotesdiv"><i class="fa fa-files-o"></i> Manage Notes</a>
                        </p>
                    </form>
					<?php foreach ( $oldnotes as $oldnote ) { ?>
                        <form id="singlesubmit<?php echo $oldnote->id; ?>" method="get" action="">
                            <input type="hidden" name="lds-bulk-action-item[<?php echo $oldnote->topic_id; ?>]" id="singledownload" value="<?php echo $oldnote->topic_id; ?>">
                        </form>
					<?php } ?>
                    <div id="allnotesdiv" style="display:none;">
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
                                        <th><?php esc_html_e( 'Notes', 'sfwd-lms' ); ?></th>
										<?php
										if ( array_intersect( $allowed_roles, $current_user->roles ) ) {
											?>
                                            <th><?php esc_html_e( 'User', 'sfwd-lms' ); ?></th>
										<?php } ?>

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
                                <ul class="pagination"></ul>

                            </form>
                        </div>


						<?php foreach ( $allnotes as $oldnote ) { ?>
                            <form id="singlesubmit<?php echo $oldnote->id; ?>" method="get" action="">
                                <input type="hidden" name="lds-bulk-action-item[<?php echo $oldnote->topic_id; ?>]" value="<?php echo $oldnote->topic_id; ?>">
                            </form>
						<?php } ?>

                    </div>
                    <div id="notesdiv" style="display:none;">

                        <div class="lightboxcontainer">
							<?php if ( isset( $oldnotes[0]->content ) ) {
								$oldnotes[0]->content = str_replace( "'", "\'", $oldnotes[0]->content );
								?>
                                <h3 class="notestitle"> <?php echo $oldnotes[0]->title; ?></h3>
                                <div class="notescontent"><?php echo $oldnotes[0]->content; ?></div>
							<?php } ?>
                        </div>
                    </div>
                </div>
                <div id="help" class="tab-pane fade">
                    <h3>ALL DOCUMENTS</h3>
                    <p><small style="color:#4e9a06;"><strong><?php echo count( $helps ); ?></strong> HELPS CURRENTLY AVAILABLE</small></p>
                    <ul class="sidebar_list">
						<?php $hcount = 0;
						foreach ( $helps as $help ) {
							$hcount ++; ?>
                            <li>
                                <a title="<?php echo $help['name'] ?>" data-group="help_content" class="example-image-link html5lightbox" href="<?php echo $help['content_url'] ?>">
                                    <h3><?php echo "($hcount) " . $help['name'] ?></h3>
                                </a>
                            </li>
							<?php
						} ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="courses_btns">
    <a href="javascript:void(0);" class="bttn completed_btn" data-tab="courses">MY COURSES</a>
    <a href="javascript:void(0);" class="bttn inprogress_btn" data-tab="lessons">LESSONS</a>
    <a href="javascript:void(0);" class="bttn click_begin_btn" data-tab="in-progress">IN PROGRESS</a>
</div>

<div class="sideBar_wrapp">
    <a href="javascript:void(0);" class="close"><i class="fa fa-times" aria-hidden="true"></i></a>
    <ul class="nav nav-pills">
        <li><a class="nav_link" data-toggle="pill" href="#courses">COURSES</a></li>
        <li><a class="nav_link" data-toggle="pill" href="#lessons">LESSONS</a></li>
        <li><a class="nav_link" data-toggle="pill" href="#in-progress">IN PROGRESS</a></li>
    </ul>

    <div class="tab-content">
        <div id="courses" class="tab-pane fade">
            <h3>ALL COURSES</h3>
			<?php
			$user_id    = get_current_user_id();
			$getCourses = learndash_user_get_enrolled_courses( $user_id, true );
			$courses    = array_reverse( $getCourses ); ?>

            <p><small style="color:#4e9a06;"><strong><?php echo count( $getCourses ); ?></strong> COURSES CURRENTLY AVAILABLE</small></p>
            <ul class="sidebar_list">
				<?php
				foreach ( $courses as $course ) {
					$get_data = get_post( $course ); ?>
                    <li>
                        <p class="title">
							<?php if ( learndash_get_course_prerequisite_enabled( $course ) ){ ?>
                            <strong>
                        <p class="color:grey;"><?php echo $get_data->post_title; ?></p></strong>
						<?php } else { ?>
                            <strong><a href="<?php echo learndash_get_course_prerequisite_enabled( $course ) ? '' : ( get_permalink( $course ) ) ?>"><?php echo $get_data->post_title; ?></a></strong>
						<?php } ?>
                        </p>
                        <p><?php echo wp_html_excerpt( $get_data->post_content, 150 ); ?></p>

                        <span class="bit_course_progress"><?php echo bit_ld_course_progress( get_current_user_id(), $course ); ?></span>
                    </li>
				<?php } ?>
            </ul>
        </div>
        <div id="lessons" class="tab-pane fade">
            <h3><?php echo $get_post->post_title; ?></h3>
			<?php $lessons = apply_filters( 'boss_edu_course_lessons_list', learndash_get_course_lessons_list( $course_id ), true ); ?>
            <p style="color:#4e9a06;"><small><?php echo count( $lessons ); ?> Lessons on <?php echo $get_post->post_title; ?></small></p>
            <ul class="sidebar_list">
				<?php foreach ( $lessons as $lesson ) { ?>
                    <li>
						<?php // var_dump($lesson);?>
                        <p class="title"><strong><a href='<?php echo get_permalink( $lesson['post']->ID ) ?>'><?php echo $lesson['post']->post_title; ?></a></strong></p>
                        <p></p>
                        <p>The Angular framework makes it easy to build dynamic web applications with expressive HTML. </p>
						<?php if ( $lesson['status'] !== 'notcompleted' ) { ?>
                            <span class="completed_tag tag">COMPLETED</span>
						<?php } else { ?>
                            <span class="pending_tag tag">PENDING</span>
						<?php } ?>

                    </li>
				<?php } ?>

            </ul>
        </div>
        <div id="in-progress" class="tab-pane fade">
            <h2>CONTENT</h2>

			<?php
			$get_course = get_post( learndash_get_course_id() );
			$lesson_id  = get_post_meta( get_the_ID(), "lesson_id", true ); ?>
            <span class="bit_course_progress"><?php echo bit_ld_course_progress( get_current_user_id(), learndash_get_course_id() ); ?></span>
            <h3>TOPICS</h3>
            <ul>
				<?php $topics = apply_filters( 'boss_edu_topic_list', learndash_get_topic_list( $lesson_id ) ); ?>
				<?php foreach ( $topics as $topic ) {
					if ( $topic->ID == get_the_ID() ) {
						?>
                        <a href="<?php echo get_permalink( $topic->ID ); ?>">
                            <li style="color:#4d9905"><?php echo $topic->post_title; ?></li>
                        </a>
					<?php } else {
						?>
                        <a href="<?php echo get_permalink( $topic->ID ); ?>">
                            <li><?php echo $topic->post_title; ?></li>
                        </a>
					<?php }
				} ?>
            </ul>
            <h3>QUIZ</h3>
			<?php
			$quiz_status = learndash_is_quiz_notcomplete( get_current_user_id(), array( $topic->ID ) );
			$quizzes     = learndash_get_lesson_quiz_list( $lesson_id, get_current_user_id(), true ); ?>
            <ul>
                <li style="color: black;"><?php echo ( count( $quizzes ) > 1 ) ? $quizzes[1]['post']->post_title : ''; ?></li>
            </ul>
        </div>
    </div>

</div>
<div class="page-full-width">
    <div id="primary" class="site-content">
        <div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
                <article style="padding-top: 10px; margin-left:20px; margin-right: 20px;" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-content bt-content-pad">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'boss-learndash' ), 'after' => '</div>' ) ); ?>
                    </div>
                    <footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'boss-learndash' ), '<span class="edit-link">', '</span>' ); ?>
                    </footer>
                </article>
				<?php comments_template( '', true );
			endwhile; ?>
        </div>
    </div>
</div>
</div>

<footer id="colophon" role="contentinfo">
	<?php get_template_part( 'template-parts/footer-widgets' ); ?>
    <div class="footer-inner-bottom">
        <div class="footer-inner">
			<?php get_template_part( 'template-parts/footer-copyright' ); ?>
			<?php get_template_part( 'template-parts/footer-links' ); ?>
        </div><!-- .footer-inner -->
    </div><!-- .footer-inner-bottom -->
	<?php do_action( 'bp_footer' ) ?>
</footer><!-- #colophon -->
<?php wp_footer(); ?>
<?php
/****************************************************************/
//Added by Vignesh R to backtrace topic template on Sep 24th 2020
/****************************************************************/
$logdate = new DateTime( "now", new DateTimeZone( 'America/Los_Angeles' ) );
$d       = date( "j-M-Y H:i:s e" );
$user    = wp_get_current_user();

$traces = "[" . $d . "] Topic template Backtrace @ " . $logdate->format( 'm-d-Y H:i:s' ) . " - Userid #" . $user->ID . " " . print_r( wp_debug_backtrace_summary( null, 0, false ), true ) . "\n";
//bw_customlog($traces,"trace");
?>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip()
        /* $(".com_close").click(function () {
			 $(this).show(".active_side_bar").delay(400).show("slide", {direction: "right"}, 1200);
		 });*/
        $('.com_close').click(function () {
            //$(this).toggleClass('active');
            //$('.active_side_bar').delay(400).show("slide", {direction: "right"}, 400);
            $('.active_side_bar').addClass('bitscr_hide');
        });
    });
</script>
</body>
</html>

