<?php global $salong,$current_user;
$user_id    = $current_user->id;
$user_name  = $current_user->display_name;
$user_home = $salong['user_home'];
$user_menu=$salong[ 'user_menu'];

if ( class_exists( 'XH_Social' ) ){
    $login_url = '#login';
}else{
    $login_url  = wp_login_url($_SERVER['REQUEST_URI']);//登录
}
$register_url = wp_registration_url();
?>
<!--桌面-->
<header class="header">
   <section<?php if($salong['switch_header_show_hide']){ ?> id="header_main"<?php } ?> class="header_main">
        <?php if($salong['header_layout']=='default' ) { ?>
        <section class="wrapper">
            <?php } ?>
            <nav class="top-nav">
                <div class="top-menu left">
                    <ul class="menu">
                        <!--前台登录与注册-->
                        <?php if ( is_user_logged_in() ) { ?>
                        <?php global $wp_query;$current_user=wp_get_current_user(); ?>
                        <li class="menu-item menu-item-welcome">
                            <?php echo $current_user->display_name; ?>
                            <?php _e( '，欢迎再次光临本站！', 'salong'); ?>
                        </li>
                        <?php if($user_home){ ?>
                        <li class="menu-item menu-item-user menu-item-has-children">
                            <a href="<?php echo get_page_link($user_home); ?>" title="<?php echo $user_name; ?><?php echo get_page( $user_home )->post_title; ?>">
                                <?php echo salong_get_avatar($user_id,$user_name); echo __('个人中心','salong'); ?>
                            </a>
                            <ul class="sub-menu">
                                <?php foreach ($user_menu as $menu) { ?>
                                <li>
                                    <a href="<?php echo get_page_link($menu); ?>">
                                        <?php echo get_page( $menu )->post_title;?></a>
                                </li>
                                <?php } ?>
                                <li>
                                    <a href="<?php echo wp_logout_url($_SERVER['REQUEST_URI']);?>" title="<?php _e( '登出', 'salong'); ?>"><?php _e( '退出登录', 'salong'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if (class_exists('woocommerce') && $salong['switch_account']){ ?>
                        <li class="menu-item menu-item-account menu-item-has-children icon-user">
                            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php echo get_page(get_option('woocommerce_myaccount_page_id'))->post_title;?></a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo get_permalink(wc_get_page_id( 'cart' )); ?>"><?php echo get_page(wc_get_page_id( 'cart' ))->post_title;?></a>
                                </li>
                                <li>
                                    <a href="<?php echo get_permalink(wc_get_page_id( 'checkout' )); ?>"><?php echo get_page(wc_get_page_id( 'checkout' ))->post_title;?></a>
                                </li>
                                <li>
                                    <a href="<?php echo wp_logout_url(home_url());?>" title="<?php _e( '登出', 'salong'); ?>"><?php _e( '退出登录', 'salong'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php } else { ?>
                        <li class="menu-item menu-item-welcome">
                            <?php _e( '您好，欢迎访问本站！', 'salong'); ?>
                        </li>
                        <li class="menu-item menu-item-login">
                            <a class="user-login" href="<?php echo $login_url; ?>">
                                <i class="icon-login"></i>
                                <?php _e( '登录', 'salong'); ?>
                            </a>
                        </li>
                        <?php if(get_option( 'users_can_register')==1){ ?>
                        <li class="menu-item menu-item-reg">
                            <a href="<?php echo $register_url; ?>">
                                <i class="icon-plus-circled"></i>
                                <?php _e( '注册', 'salong' ); ?>
                            </a>
                        </li>
                        <?php } ?>
                        <?php } ?>
                        <?php if (class_exists( 'woocommerce' )){ ?>
                        <li class="menu-item menu-item-cart icon-basket">
                            <a class="cart-contents"><?php _e( '0 项目 - ¥0.00', 'salong' ); ?></a>
                        </li>
                        <?php } ?>
                        <!--前台登录与注册end-->
                    </ul>
                </div>
                <!--顶部菜单-->
                <?php wp_nav_menu( array( 'container_class'=>'top-menu right', 'theme_location' => 'top-menu' ,'items_wrap'=>'<ul class="menu">%3$s</ul>', 'fallback_cb'=>'Salong_top_nav_fallback') ); ?>
                <!--顶部菜单end-->
            </nav>
            <!--菜单-->
            <nav class="header-nav">
                <!--LOGO-->
                <h1>
                <a href="<?php echo get_home_url(); ?>" class="logo left" title="<?php bloginfo('name'); ?>-<?php bloginfo('description'); ?>"><img src="<?php echo $salong['logo']['url']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
                </h1>
                <!--LOGO-->
                <?php wp_nav_menu( array( 'container_class'=>'header-menu right', 'theme_location' => 'header-menu','items_wrap'=>'<ul class="menu">%3$s</ul>' , 'fallback_cb'=>'Salong_header_nav_fallback') ); ?>
            </nav>
            <!--菜单end-->
            <?php if($salong['header_layout']=='default' ) { ?>
        </section>
        <?php } ?>
    </section>
</header>
<!--桌面end-->
<!--网站头部下的广告-->
<?php if($salong['header_code']) { ?>
<section class="header_code wrapper">
    <?php echo $salong['header_code']; ?>
</section>
<?php } ?>