<?php
/*
            /$$            
    /$$    /$$$$            
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$ 
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/ 
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-08-31 14:33:30
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-09-30 10:17:29

*/

$site_logo = cs_get_option( 'site_logo' );
$site_logo_arr = wp_get_attachment_image_src( $site_logo, 'full' );
$site_logo_arr_mobile = wp_get_attachment_image_src( cs_get_option( 'site_logo_mobile' ), 'full' );

$header_layout = cs_get_option( 'header_layout' );
$header_layout = $header_layout == 'center' ? 'container' : 'container-fluid';

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8;IE=7, IE=EDGE, chrome=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<section class="mobile-overlay" id="mobile-overlay">
    <div class="mobile-search">
        <form role="search" method="get" class="mobile-search-form" action="">
            <label>
                <input type="search" class="mobile-search-field" placeholder="输入关键词…" value="" name="s">
            </label>
            <button type="submit" class="mobile-search-submit"><i class="icon icon-magnifier"></i></button>
        </form>        
    </div>
    <nav class="mobile-navigation">        
        <ul id="menu-main-menu" class="cosy-mobile-menu clearfix">
            <?php 
                if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('mobile-warp-nav') ) {  
                 wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'mobile-warp-nav', 'depth'=>2 ) ); 
              } else { 
                   echo '<li><a href="/wp-admin/nav-menus.php">请到[后台->外观->菜单]中设置菜单。</a></li>'; 
            } 
            ?>
        </ul>   
    </nav>
    <button id="mobile-close-icon" class="navbar-close">
        <i class="icon icon-close"></i>
    </button>
</section>
<div class="site">
    <?php if( cs_get_option('duang_all') ) : ?>
        <section class="main-preloader">
            <div class="preloader-inner">
                <div class="loader-inner ball-scale-multiple"><div></div><div></div><div></div></div>
            </div>
        </section>
    <?php endif; ?>
    <header class="nt-header navbar <?php echo cs_get_option( 'mobile_header_layout' ); ?>">
        <div class="<?php echo $header_layout; ?>">
            <div class="navbar-header">
                <?php 
                    $logo_url = !empty( $site_logo_arr[0] ) ? $site_logo_arr[0] :  get_template_directory_uri().'/static/images/logo.png'; 
                    $logo_mobile_url = !empty( $site_logo_arr_mobile[0] ) ? $site_logo_arr_mobile[0] :  get_template_directory_uri().'/static/images/logo-mobile.png';
                ?>
                <a class="navbar-brand" href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>" style="background-image: url(<?php echo $logo_url; ?>);"><?php bloginfo( 'name' ); ?></a>
                <a class="navbar-brand mobile-navbar-brand hidden-md hidden-lg" href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>" style="background-image: url(<?php echo $logo_mobile_url; ?>);"><?php bloginfo( 'name' ); ?></a>
                <form method="get" class="searchform header-search" action="/" >
                    <div class="navbar-search">
                        <input class="form-control" type="text" value="" name="s" placeholder="输入关键词后回车...">
                        <i id="navbar-search-submit" class="icon icon-magnifier"></i>
                    
                    </div>
                </form>
            </div>

            <div class="navbar-collapse hidden-xs hidden-sm">
                <ul class="navbar-nav">
            	      <?php 
                		    if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('head-nav') ) {  
    	                     wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'head-nav', 'depth'=>2 ) ); 
    	                  } else { 
    	                       echo '<li><a href="/wp-admin/nav-menus.php">请到[后台->外观->菜单]中设置菜单。</a></li>'; 
    	                } 
                	    ?>
                </ul>
                
            </div>
            <div class="mobile-navbar row hidden-md hidden-lg">
                <ul class="navbar-nav">
                      <?php 
                            if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('mobile-nav') ) {  
                             wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'mobile-nav', 'depth'=>1 ) ); 
                          } else { 
                               echo '<li><a href="/wp-admin/nav-menus.php">请到[后台->外观->菜单]中设置菜单。</a></li>'; 
                        } 
                        ?>
                </ul>
                <button type="button" class="navbar-toggle mobile-navbar-toggle" id="mobile-menu-icon">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
        </div>
    </header>  	