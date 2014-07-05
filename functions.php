<?php
	
	automatic_feed_links();
	
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}
	
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
    }
    
	function register_my_menus() {
		register_nav_menus(
			array(
				'header-menu-left' => __( 'Header Menu Left' ),
				'header-menu-right' => __( 'Header Menu Right' )
			)
		);
	}
	add_action( 'init', 'register_my_menus' );
	
	add_action( 'init', 'create_post_type' );
	function create_post_type() {
		register_post_type( 'apps',
			array(
				'labels' => array(
					'name' => __( 'Apps' ),
					'singular_name' => __( 'App' )
				),
				'supports' => array( 
					'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 
				),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'apps')
			)
		);
	}
	
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'apps' ) );

	add_filter('widget_text', 'do_shortcode');
	add_filter('the_excerpt', 'do_shortcode');
	
	add_filter('post_gallery', 'my_post_gallery', 10, 2);
	function my_post_gallery($output, $attr) {
	    global $post;
	    if (isset($attr['orderby'])) {
	        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
	        if (!$attr['orderby'])
	            unset($attr['orderby']);
	    }
	    extract(shortcode_atts(array(
	        'order' => 'ASC',
	        'orderby' => 'menu_order ID',
	        'id' => $post->ID,
	        'itemtag' => 'dl',
	        'icontag' => 'dt',
	        'captiontag' => 'dd',
	        'columns' => 3,
	        'size' => 'thumbnail',
	        'include' => '',
	        'exclude' => ''
	    ), $attr));
	    $id = intval($id);
	    if ('RAND' == $order) $orderby = 'none';
	    if (!empty($include)) {
	        $include = preg_replace('/[^0-9,]+/', '', $include);
	        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));	
	        $attachments = array();
	        foreach ($_attachments as $key => $val) {
	            $attachments[$val->ID] = $_attachments[$key];
	        }
	    }
	    if (empty($attachments)) return '';
	    $output = "<div class=\"images\">\n";
	    $output .= "<ul>\n";
	    foreach ($attachments as $id => $attachment) {
	        $img = wp_get_attachment_image_src($id, 'full');
			$output .= "<li>\n";
	        $output .= "<img src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"\" />\n";
	        $output .= "</li>\n";
	    }
	    $output .= "</ul>\n";
	    $output .= "</div>\n";
	    return $output;
	}

?>