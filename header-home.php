<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<?php if (is_search()) { ?>
		<meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>
	
	<title>
		<?php
			if (function_exists('is_tag') && is_tag()) {
			single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
			elseif (is_archive()) {
			wp_title(''); echo ' Archive - '; }
			elseif (is_search()) {
			echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
			elseif (!(is_404()) && (is_single()) || (is_page())) {
			wp_title(''); echo ' - '; }
			elseif (is_404()) {
			echo 'Not Found - '; }
			if (is_home()) {
			bloginfo('name'); echo ' - '; bloginfo('description'); }
			else {
			bloginfo('name'); }
			if ($paged>1) {
			echo ' - page '. $paged; }
		?>
	</title>
	
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/main.css" media="screen" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<header id="header">
	<div class="wrapper">
		<?php wp_nav_menu( array( 'theme_location' => 'header-menu-left' ) ); ?>
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<?php wp_nav_menu( array( 'theme_location' => 'header-menu-right' ) ); ?>
	</div>
</header>

<section id="banner">
	<nav>
		<p class="prev">Previous</p>
		<p class="next">Next</p>
	</nav>
	<div class="slides">
		<?php
		  query_posts( array( 'post_type' => 'apps' ) );
		  if ( have_posts() ) : while ( have_posts() ) : the_post();
		?>
		<div class="slide" style="background: <?php echo get_post_meta($post->ID, 'Background', true); ?>; box-shadow: inset 0 -200px 0 <?php echo get_post_meta($post->ID, 'Background Alternate', true); ?>;">
			<div class="wrapper">
				<?php the_excerpt(); ?>
				<div class="copy">
					<?php the_content(); ?>
					<a class="appstore" href="<?php echo get_post_meta($post->ID, 'Appstore Link', true); ?>" title="Available on the Apple Appstore">Available on the Apple Appstore</a>
				</div>
			</div>
		</div>
		<?php endwhile; endif; wp_reset_query(); ?>
	</div>	
</section>