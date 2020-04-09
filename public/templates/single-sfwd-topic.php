`<?php
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- BuddyPress and bbPress Stylesheets are called in wp_head, if plugins are activated -->
	<?php wp_head(); ?>
</head>
<style type="text/css">
    @media only screen and (min-width: 481px) {
        header#masthead {
            box-sizing: border-box;
            position: fixed;
            width: 100%;
            margin-top: -25px !important;
        }
    }

    .header-navigation > div > ul {
        height: 35px !important;
        list-style: none;
        margin: 0;
        overflow: hidden;
        padding: 0;
        text-align: right;
        padding-top: 10px;
    }

    .site-header .header-inner .right-col {
        display: table-cell;
        float: none;
        padding-top: 10px;
    }

    body #mastlogo {
        min-height: 50px !important;
        padding: 0px 18px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .entry-content h2 {
        margin: 14px 0;
    }

    .grassblade {
        margin-top: -30px;
    }

    body {
        background-color: inherit !important;
    }

    .cpMainContainer {
        background-color: inherit !important;
    }

    #cpDocument {
        background-color: inherit !important;
    }

    .btn121 {
        background: #4e9a05;
        position: fixed;
        right: 0px;
        top: 230px;
        right: -45px;
    }

    .lf {
        right: 0px;
    }

    .btn121 a {
        color: #fff;
    }

    .btn121:hover {
        right: 0px;
    }

    .btn1211 {
        background: #ff8503;
        position: fixed;
        right: 0px;
        top: 270px;
        right: -105px;
    }

    .bttn.helpbtn .fa {
        border: none;
        border-radius: 100%;
        padding: 3px 7px;
        font-size: 15px;
    }

    .btn1211:hover {
        right: 0px;
    }

    .btn1211 a {
        color: #fff;
    }
</style>

<?php
global $rtl;
$logo         = ( boss_get_option( 'logo_switch' ) && boss_get_option( 'boss_logo', 'id' ) ) ? '1' : '0';
$inputs       = ( boss_get_option( 'boss_inputs' ) ) ? '1' : '0';
$boxed        = boss_get_option( 'boss_layout_style' );
$header_style = boss_get_option( 'boss_header' ); ?>

<body <?php body_class(); ?> data-logo="<?php echo $logo; ?>" data-inputs="<?php echo $inputs; ?>" data-rtl="<?php echo ( $rtl ) ? 'true' : 'false'; ?>" data-header="<?php echo $header_style; ?>" style="background-color: white;">

<?php do_action( 'buddyboss_before_header' ); ?>

<div id="scroll-to"></div>
<?php $logo_small_id = boss_get_option( 'boss_small_logo', 'id' );
$logo_small          = wp_get_attachment_image( $logo_small_id, 'full', '', array( 'class' => 'boss-logo small' ) ); ?>

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

    <div class="bit_info_btn btn121" data-toggle="tooltip" data-placement="left">
        <div class="content_btns">
            <a href="javascript:void(0);" class="bttn videos_btn" data-tab="courses">VIDEOS</a>
            <a href="javascript:void(0);" class="bttn notes_btn" data-tab="lessons">NOTES</a>
            <a href="javascript:void(0);" class="bttn help_btn" data-tab="in-progress">HELP</a>
        </div>
    </div>

    <div class="info_wrapp">
        <a href="#" class="info_close"><i class="fa fa-times" aria-hidden="true"></i></a>
        <div class="thumbnail bt_box_shadow">
            <h4 style="padding-top:10px; text-align: center; font-size: 15px;">HELP</h4>
            <hr style="margin-top:10px; margin-bottom:10px;">
			<?php echo '<iframe style="height:585px;" src="' . get_stylesheet_directory_uri() . '/help.html" data-slidepanel="panel" class="wdm-panel-btn fa fa-question-circle"></iframe>'; ?>
        </div>
    </div>

	<?PHP /*
		        <div class="bit_com_btn btn1211" data-toggle="tooltip" data-placement="left">

				<a href="#"  class="bttn communitybtn 1"><i class="fa fa-users" aria-hidden="true"></i>COMMUNITY&nbsp;&nbsp;</a>
			</div>
			<div class="com_wrapp">
				<a href="#" class="com_close"><i class="fa fa-times" aria-hidden="true"></i></a>
				<div class="thumbnail bt_box_shadow">
					<h4 style="padding-top:10px; text-align: center; font-size: 15px;"> COMMUNITY </h4><hr style="margin-top:10px; margin-bottom:10px;">
					<?php $forum_site = ($_SERVER['HTTP_HOST'] == 'bitwise.academy')? 'forum.bitwise.academy' : $_SERVER['HTTP_HOST'].'/forum'; ?>
					<?php echo '<iframe style="height:750px; width:100%" src="//'.$forum_site.'/bitwise/?auth=sso"></iframe>' ;?>
				</div>
					</div>
*/ ?>

    <div class="courses_btns">
        <a href="#" class="bttn completed_btn" data-tab="courses">MY COURSES</a>
        <a href="#" class="bttn inprogress_btn" data-tab="lessons">LESSONS</a>
        <a href="#" class="bttn click_begin_btn" data-tab="in-progress">IN PROGRESS</a>
    </div>

    <div class="sideBar_wrapp">
        <a href="#" class="close"><i class="fa fa-times" aria-hidden="true"></i></a>
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
						$get_data = get_post( $course );

						// $short_description 	= ( is_plugin_active('learndash-course-grid/learndash-course-grid.php') && isset( $course_options['sfwd-courses_course_short_description'] ) ) ?  $course_options['sfwd-courses_course_short_description'] :  get_the_excerpt($course);
						// var_dump(wp_html_excerpt( $get_data->post_content, 150 ));
						?>
                        <li>
                            <p class="title">
								<?php if ( learndash_get_course_prerequisite_enabled( $course ) ){ ?>
                                <strong>
                            <p class="color:grey;"><?php echo $get_data->post_title; ?></p></strong>
							<?php } else { ?>
                                <strong><a href="<?php echo learndash_get_course_prerequisite_enabled( $course ) ? '' : ( get_permalink( $course ) ) ?>"><?php echo $get_data->post_title; ?></a></strong>
							<?php } ?>
                            </p>
                            <!-- <p class="title"><strong><a href="<?php echo learndash_get_course_prerequisite_enabled( $course ) ? '' : ( get_permalink( $course ) ) ?>"><?php echo $get_data->post_title; ?></a></strong></p> -->
                            <!-- <p>The Angular framework makes it easy to build dynamic web applications with expressive HTML.</p> -->
                            <p><?php echo wp_html_excerpt( $get_data->post_content, 150 ); ?></p>
                            <p><?php //echo get_the_excerpt($get_data->post_content);?></p>
                            <!-- <p class="entry-content"><?php echo htmlspecialchars_decode( do_shortcode( $short_description ) ); ?></p> -->
                            <!-- <span class="completed_tag tag" style="font-size:14px;"><?php echo do_shortcode( '[learndash_course_progress course_id = ' . $course . ' user_id = ' . get_current_user_id() . ']' ); ?></span>
 -->
                            <!-- <span class="bit_course_progress" ><?php echo do_shortcode( '[bit_ld_course_progress course_id = ' . $course . ' user_id = ' . get_current_user_id() . ']' ); ?></span> -->
                            <span class="bit_course_progress"><?php echo bit_ld_course_progress( get_current_user_id(), $course ); ?></span>
							<?php //var_dump($course);?>
                        </li>
					<?php }

					?>

                </ul>
            </div>
            <div id="lessons" class="tab-pane fade">
				<?php $course_id = learndash_get_course_id();
				$get_post        = get_post( $course_id );
				?>
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
                <!-- <p style="color:#4e9a06;"><small>Lesson 4 on Introduction on tools</small></p>
				<div class="prcentage_bar">47  %</div> -->
                <span class="bit_course_progress"><?php echo bit_ld_course_progress( get_current_user_id(), learndash_get_course_id() ); ?></span>
                <!-- <span class="completed_tag tag content" style="font-size:14px; color:green;"><?php echo do_shortcode( '[learndash_course_progress course_id = ' . learndash_get_course_id() . ' user_id = ' . get_current_user_id() . ']' ); ?></span> -->
                <h3>TOPICS</h3>
                <ul>
					<?php $topics = apply_filters( 'boss_edu_topic_list', learndash_get_topic_list( $lesson_id ) );
					// var_dump($topics);
					?>
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
                    <li style="color: black;"><?php echo $quizzes[1]['post']->post_title; ?></li>
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

					<?php comments_template( '', true ); ?>

				<?php endwhile; ?>

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

<script type="text/javascript">
    var navId = "masthead"
    var time = 7000;
    $('#' + navId).attr('data-visible', "time");
    $('body').mousemove(function () {
        if ($('#' + navId).attr('data-visible') == "mouse") {
            $('#' + navId).fadeIn(500);
            $("#move").addClass("mt-35", 500);
            $("#move1").addClass("m-15", 500);
            $("header").removeClass("mt-35", 500);
            $("header").addClass("m-0", 500);
            $('#' + navId).attr('data-visible', "time")
        }

    })
    window.setInterval(function () {
        if ($('#' + navId).attr('data-visible') == "time") {
            $('#' + navId).fadeOut(700);
            $("#move").removeClass("mt-35", 700);
            $("#move1").removeClass("mt-35", 700);
            $("header").removeClass("m-0", 700);
            $("header").addClass("m-15", 700);
            $('#' + navId).attr('data-visible', "mouse")
        }
    }, time);
</script>

<!-- <script type="text/javascript">
	var navId1 = "mt-35"
	var time = 7000;
	$('#' + navId1).attr('data-visible', "time");
	$('body').mousemove(function() {
		if ($('#' + navId1).attr('data-visible') == "mouse") {
			$('#' + navId1).fadeIn(2000);
			$('#' + navId1).attr('data-visible', "time")
		}

	})
	window.setInterval(function() {
		if ($('#' + navId1).attr('data-visible') == "time") {
			$('#' + navId1).fadeOut(1000);
			$('#' + navId1).attr('data-visible', "mouse")
		}
	}, time);
</script> -->

<script>
    $(".com_close").click(function () {
        $(this).show(" .active_side_bar").delay(400).show("slide", {direction: "right"}, 1200);
    });
    $(document).ready(function () {
        var active = "europa-view";
        $('.info_close').click(function () {
            var divname = this.name;
            $("#" + ".bt_box_shadow").hide("slide", {direction: "right"}, 1200);
            $("#" + ".bt_box_shadow").delay(400000).show("slide", {direction: "right"}, 1200);
            active = ".bt_box_shadow";
        });
    });
    $(function () {
        $('.com_close').click(function () {
            $(this).toggleClass('active');
            $('.active_side_bar').delay(400000).show("slide", {direction: "right"}, 1200);
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

</body>
</html>
