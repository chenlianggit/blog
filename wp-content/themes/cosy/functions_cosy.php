<?php

function static_load() {

	
    wp_register_style( 'simple-line-icons', get_template_directory_uri() . '/static/simple-line-icons/css/simple-line-icons.css', array(), THEME_VERSION, 'all' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/static/font/css/font-awesome.min.css', array(), THEME_VERSION, 'all' );
    wp_register_style( 'animate', get_template_directory_uri() . '/static/css/animate.min.css', array(), THEME_VERSION, 'all' );
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/static/css/bootstrap.min.css', array(), THEME_VERSION, 'all' );
	wp_register_style( 'reset', get_template_directory_uri() . '/static/css/reset.css', array(), THEME_VERSION, 'all' );
	wp_register_style( 'style', get_stylesheet_uri() , array(), THEME_VERSION, 'all' );
    wp_register_style( 'magnific', get_template_directory_uri() . '/static/css/magnific-popup.css', array(), THEME_VERSION, 'all' );

	wp_register_script( 'jQuery', get_template_directory_uri() . '/static/js/jquery.min.js', '', THEME_VERSION, true ); 

	wp_register_script( 'bootstrap', get_template_directory_uri() . '/static/js/bootstrap.min.js', array('jQuery'), THEME_VERSION, true ); 
    wp_register_script( 'carousel', get_template_directory_uri() . '/static/js/owl.carousel.min.js', array('jQuery'), THEME_VERSION, true ); 
	wp_register_script( 'magnific', get_template_directory_uri() . '/static/js/jquery.magnific-popup.min.js', array('jQuery'), THEME_VERSION, true ); 
    wp_register_script( 'stickysidebar', get_template_directory_uri() . '/static/js/theia-sticky-sidebar.min.js', array('jQuery'), THEME_VERSION, true ); 
	wp_register_script( 'plugins', get_template_directory_uri() . '/static/js/plugins.min.js', array('jQuery'), THEME_VERSION, true ); 
	wp_register_script( 'suxing', get_template_directory_uri() . '/static/js/suxing.me.js', array('jQuery'), THEME_VERSION, true ); 
	wp_register_script( 'dami', get_template_directory_uri() . '/static/js/dami.js', array('jQuery'), THEME_VERSION, true ); 
	wp_register_script( 'comments', get_template_directory_uri() . '/core/functions/ajax-comment/ajax-comment.js', array('jQuery'), THEME_VERSION, true );

    if( is_single() ){
        $post_extend = get_post_meta( get_the_ID(), 'post_extend', true );
        $post_extend = wp_parse_args( (array) $post_extend, array( 
            'post_layout' => 'one',
        ));
        $post_style = $post_extend['post_layout'];
    } else {
        $post_style = 0;
    }
	wp_localize_script( 'jQuery', 'globals', 
		array(
            "ajax_url"             => admin_url("admin-ajax.php"),
            "url_theme"            => get_template_directory_uri(),
            'image_popup'          => is_single() || is_page() ? cs_get_option('image_popup') ? cs_get_option('image_popup') : 'disable' : 'null',
            'new_comment_position' => get_option( 'comment_order', true ),
            'single'               => ( is_single() ? 1 : 0 ),
            'post_style'           => $post_style,
            'home'                 => ( is_home() ? 1 : 0 ),
            'page'                 => ( is_page() ? 1 : 0 ),
		) 
	);
	if( !is_admin() ){
        if( cs_get_option('icon_cdn') ){
            wp_enqueue_style( 'simple-line-icons-upyun', '//cdn.bootcss.com/simple-line-icons/2.4.1/css/simple-line-icons.min.css', array(), THEME_VERSION, 'all' );
            wp_enqueue_style( 'font-awesome-upyun', '//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), THEME_VERSION, 'all' );
        } else {
            wp_enqueue_style( 'simple-line-icons' );
            wp_enqueue_style( 'font-awesome' );
        }

        wp_enqueue_style( 'animate' );


        wp_enqueue_style( 'bootstrap' );
        wp_enqueue_style( 'reset' );
        wp_enqueue_style( 'style' );

		wp_deregister_script( 'jquery' );

    	wp_enqueue_script( 'jQuery' ); 
        wp_enqueue_script( 'bootstrap' ); 
        wp_enqueue_script( 'plugins' ); 

        if( is_home() ){
            wp_enqueue_script( 'carousel' );
        }

        if( is_single() ){
            if( $post_extend['post_layout'] == 'five' ){
                wp_enqueue_script( 'carousel' );
            }
        }

        if( is_singular() && cs_get_option('image_popup') != 'disable' ){
            wp_enqueue_style( 'magnific' );
            wp_enqueue_script( 'magnific' );
        }
    	
        if( is_single() ){
            $post_extend = get_post_meta( get_the_ID(), 'post_extend', true );
            if( isset($post_extend['post_layout']) ){
                $template_name = $post_extend['post_layout'];
            }else{
                $template_name = 'one';
            }
            if( $template_name == 'one' || $template_name == 'two' || $template_name == 'three' || $template_name == 'six'){
                wp_enqueue_script( 'stickysidebar' ); 
            }
        } 
        
    	wp_enqueue_script( 'suxing' );    	
    	wp_enqueue_script( 'dami' ); 

    	if ( is_singular() ){ 
            wp_enqueue_script( 'comments' );

        }

    }

}
add_action('wp_enqueue_scripts', 'static_load');

function mi_head(){
	
	// 图片延迟加载JS
	if( cs_get_option('images_lazysizes') ){
		$GLOBALS['images_lazysizes'] = true;
		echo sprintf('<script src="%s" async=""></script>', get_template_directory_uri() . '/static/js/lazysizes.min.js');
	}
	$ico = cs_get_option('site_favicon');
	if( isset( $ico ) && !empty( $ico ) ){
		$ico = wp_get_attachment_image_src( $ico, 'full' );
		$ico = $ico[0];
		echo sprintf('
			<link rel="shortcut icon" type="image/x-icon" href="%s" />
			<link rel="bookmark" type="image/x-icon" href="%s" />
		', $ico, $ico);
	}

}
add_action( 'wp_head', 'mi_head', 1 );

/**
 * 判断是否延迟加载图片
 * @return boolean [description]
 */
function is_lazysizes(){
	if( isset( $GLOBALS['images_lazysizes'] ) ){
		return 'class="lazyload" data-';
	}
}


//输出缩略图地址
function post_thumbnail_src( $post = null ){
	if( $post === null ){
    	global $post;
	}

   	if( has_post_thumbnail( $post ) ){    //如果有特色缩略图，则输出缩略图地址
        $post_thumbnail_src = get_post_thumbnail_id($post->ID);
    } else {
        $post_thumbnail_src = '';
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        if(!empty($matches[1][0])){

        	global $wpdb;
        	$att = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid LIKE '%s'", $matches[1][0] ) );

        	if( $att ){
        		$post_thumbnail_src = $att->ID; 
        	}else{
        		$post_thumbnail_src = $matches[1][0]; 
        	}
            
        }else{

        	$site_default_img = cs_get_option('site_default_img');
			if( isset( $site_default_img ) && !empty( $site_default_img ) ){

				$post_thumbnail_src = $site_default_img;

			}else{
				$post_thumbnail_src = get_template_directory_uri().'/static/images/default.jpg';
			}

        }
    }
    return $post_thumbnail_src;
}

/**
 * 图像裁切
 */


function timthumb( $src, $size = null, $set = null ){

	$modular = cs_get_option('thumbnail_handle');

	if( is_numeric( $src ) ){
		if( $modular == 'timthumb_mi' ){
			$src = image_downsize( $src, $size['w'].'-'.$size['h'] );
		}else{
			$src = image_downsize( $src, 'full' );
		}
		$src = $src[0];
	}

	if( $set == 'original' ){
		return $src;
	}

	if( $modular == 'timthumb_php' || empty($modular) || $set == 'tim' ){

		return get_stylesheet_directory_uri().'/timthumb.php?src='.$src.'&h='.$size["h"].'&w='.$size['w'].'&zc=1&a=c&q=100&s=1';

	}else{
		return $src;
	}	

} 

/**
 * 小工具注册
 */
function dm_widgets_init() {
    register_sidebar( array(
        'name'          => '全站侧栏',
        'id'            => 'sidebar-all',
        'description'   => '优先级最高的侧栏',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => '文章页-样式一侧栏',
        'id'            => 'sidebar-one',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => '文章页-样式二侧栏',
        'id'            => 'sidebar-two',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => '文章页-样式三侧栏',
        'id'            => 'sidebar-three',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => '文章页-视频样式侧栏',
        'id'            => 'sidebar-six',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => '页面侧栏',
        'id'            => 'sidebar-page',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'dm_widgets_init' );

/**
 * body class 设置
 */
add_filter( 'body_class', 'custom_class' );
function custom_class( $classes ) {

    if( is_single() ){

    	$post_extend = get_post_meta( get_the_ID(), 'post_extend', true );
		if( $post_extend ){
			$template_name = $post_extend['post_layout'];
		}else{
			$template_name = 'one';
		}

		switch ($template_name) {
			case 'two':
				$classes[] = 'post-style02';
				break;
			
			case 'three':
				$classes[] = 'post-style03';
				break;

			case 'four':
				$classes[] = 'post-style03';
				break;

			case 'five':
				$classes[] = 'post-style03';
				break;
			default:
				# code...
				break;
		}
    }

 	if( is_home() ){

 		$index_single_layout = cs_get_option( 'index_single_layout' );

 		if( $index_single_layout == 'card' ) {
 			$classes[] = 'layout-grid';
 		}
 	}

    return $classes;

}
/**
 * 图片结构改造
 */
function img_del_p_tag( $content ) {

	return preg_replace_callback( '/(<p>.*?<img.*?<\/p>)/', function($m){
		return str_replace( '</p>', '</div>', str_replace( '<p>', '<div class="post-image">', $m[0] ) );
	}, $content );

}
add_filter( 'the_content', 'img_del_p_tag' );