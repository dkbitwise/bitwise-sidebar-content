<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>bitWise Academy - Help</title>

    <!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
</head>
<body>
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
</body>
</html>