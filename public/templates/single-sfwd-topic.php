<?php
/**
 * The Template for displaying all single posts.
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

	$bit_course_content = Bitscr_Common::get_multiple_data( array(), array( 'sfwd_course_id' => $course_id ), 'content' );

	$videos = wp_list_filter( $bit_course_content, array( 'type' => 'Video' ) );
	$helps  = wp_list_filter( $bit_course_content, array( 'type' => 'Help' ) );

	$images = array( 'jpg', 'jpeg', 'png', 'gif' );
	$docs   = array( 'csv', 'docs', 'xlms', 'ppt', 'pdf' );

	?>

    <div class="bit_info_btn btn121" data-toggle="tooltip" data-placement="left">
        <div class="content_btns">
            <a href="javascript:void(0);" class="bttn videos_btn" data-tab="videos">VIDEOS</a>
            <a href="javascript:void(0);" class="bttn notes_btn" data-tab="notes">NOTES</a>
            <a href="javascript:void(0);" class="bttn help_btn" data-tab="help">HELP</a>
        </div>
    </div>

    <div class="info_wrapp">
        <div class="thumbnail bt_box_shadow">
            <a href="javascript:void(0);" class="com_close close"><i class="fa fa-times" aria-hidden="true"></i></a>
            <ul class="nav nav-pills">
                <li><a class="nav_link" data-toggle="pill" href="#videos">VIDEOS</a></li>
                <li><a class="nav_link" data-toggle="pill" href="#notes">NOTES</a></li>
                <li><a class="nav_link" data-toggle="pill" href="#help">HELP</a></li>
            </ul>
            <div class="tab-content">
                <div id="videos" class="tab-pane fade">
                    <h3>All Videos</h3>
                    <p><small style="color:#4e9a06;"><strong><?php echo count( $videos ); ?></strong> VIDEOS CURRENTLY AVAILABLE</small></p>
                    <ul class="sidebar_list">
						<?php
						foreach ( $videos as $video ) {
							$file_ext = pathinfo( $video['content_url'], PATHINFO_EXTENSION );
							$c_type   = in_array( $file_ext, $images, true ) ? 'image' : 'video';
							$c_type   = in_array( $file_ext, $docs, true ) ? 'document' : $c_type; ?>

                            <li>
                                <p class="bit-video-link title">
                                    <strong><a data-c_type="<?php echo $c_type; ?>" data-url="<?php echo $video['content_url'] ?>" class="open_new_links" href="javascript:void(0);"><?php echo $video['name'] ?></a></strong>
                                </p>
                            </li>
							<?php
						} ?>
                    </ul>
                </div>
                <div id="notes" class="tab-pane fade">
                    <p class="bit-notes">NOTES content</p>
                </div>
                <div id="help" class="tab-pane fade">
                    <h3>All Help Contents</h3>
                    <p><small style="color:#4e9a06;"><strong><?php echo count( $helps ); ?></strong> HELPS CURRENTLY AVAILABLE</small></p>
                    <ul class="sidebar_list">
						<?php
						foreach ( $helps as $help ) {
							$file_ext = pathinfo( $help['content_url'], PATHINFO_EXTENSION );
							$images   = array( 'jpg', 'jpeg', 'png', 'gif' );
							$c_type   = in_array( $file_ext, $images, true ) ? 'image' : 'video';
							$c_type   = in_array( $file_ext, $docs, true ) ? 'document' : $c_type;
							?>
                            <li>
                                <p class="bit-video-link title">
                                    <strong><a data-c_type="<?php echo $c_type; ?>" data-url="<?php echo $help['content_url'] ?>" class="open_new_links" href="javascript:void(0);"><?php echo $help['name'] ?></a></strong>
                                </p>
                            </li>
							<?php
						} ?>
                    </ul>
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
        $('.content_btns').on('click', function () {
            $('.active_side_bar').removeClass('bitscr_hide');
        });

    });
</script>
</body>
</html>
