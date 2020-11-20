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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <!-- BuddyPress and bbPress Stylesheets are called in wp_head, if plugins are activated -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="background-color: white;">
<div class="bitscr-code-wrapper">
    <p class="bitscr-code">
        <?php the_content(); ?>
    </p>
</div>
<?php get_footer('bitscr');