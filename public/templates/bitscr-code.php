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
		<?php wp_head(); ?>
    </head>
    <body style="background-color: white;">

<?php
$cid     = filter_input( INPUT_GET, 'cid', FILTER_SANITIZE_NUMBER_INT );
$content = get_the_content( null, true, get_post( $cid ) );
$content = apply_filters( 'the_content', $content );
echo html_entity_decode( $content );
wp_footer();