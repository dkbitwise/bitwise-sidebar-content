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
		<?php
		$cid = filter_input( INPUT_GET, 'cid', FILTER_SANITIZE_NUMBER_INT );
		$bit_code = Bitscr_Common::get_multiple_columns( array( 'content' => 'code' ), array( 'id' => $cid ), 'content' );
		zwk_pc_debug($bit_code);
		$bit_code = apply_filters('content_save_pre',$bit_code[0]);
		zwk_pc_debug($bit_code);
		$post_data = array(
			'ID'           => 3815,
			'post_content' => $bit_code
		);
		wp_update_post( $post_data );
		$bit_code = apply_filters();
		the_content();

		the_content(); ?>
    </p>
</div>
<?php get_footer( 'bitscr' );