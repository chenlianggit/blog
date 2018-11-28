<?php global $salong,$current_user;
$user_id        = $current_user->ID;//登录用户ID
$user_name      = $current_user->display_name;
$register_page  = $salong['register_page'];
if($register_page){
    $register_url = get_permalink($register_page);
}else{
    $register_url = wp_registration_url();
}
?>
<!--移动-->
<!--边栏-->
<aside class="mobile_aside mobile_menu">
    <!--菜单-->
    <nav class="mobile-nav">
        <?php wp_nav_menu( array( 'container_class'=> 'mobile-menu', 'theme_location' => 'mobile-menu' , 'fallback_cb'=>'Salong_mobile_nav_fallback') ); ?>
    </nav>
    <!--菜单end-->
</aside>
<aseide class="mobile_aside mobile_user">
    <!--前台登录与注册-->
    <?php if ( is_user_logged_in() ) { ?>
    <nav class="mobile-nav">
        <section class="mobile_avatar">
            <?php echo salong_get_avatar($user_id,$user_name); ?>
            <span><?php echo $user_name; ?></span>
            <?php if (class_exists( 'woocommerce' )){
            $cart_count = WC()->cart->get_cart_contents_count();
            ?>
            <p>
                <a href="<?php if($cart_count == 0) { echo get_permalink( wc_get_page_id( 'shop' ) ); } else { echo WC()->cart->get_cart_url(); } ?>" title="<?php if($cart_count == 0) { _e( '购物车为空','salong' ); } else { _e( '查看购物车','salong'); } ?>"><i class="icon-basket"></i><?php echo sprintf (_n( '%d 项目', '%d 项目', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
            </p>
            <?php } ?>
        </section>
        <?php wp_nav_menu( array( 'container_class'=> 'mobile-menu', 'theme_location' => 'user-menu' , 'fallback_cb'=>'Salong_user_nav_fallback') ); ?>
    </nav>
    <?php } else { ?>
    <section class="login-reg">
        <section class="mobile_avatar">
            <img src="<?php echo $salong['avatar_loading']['url']; ?>" alt="<?php bloginfo('name'); ?>">
            <?php _e( '您好，欢迎光临！', 'salong'); ?>
        </section>
        <ul>

            <li>
                <a class="user-login" href="#login">
                    <i class="icon-login"></i>
                    <?php _e( '登录', 'salong'); ?>
                </a>
            </li>
            <?php if(get_option( 'users_can_register')==1){ ?>
            <li>
                <a href="<?php echo $register_url; ?>">
                    <i class="icon-plus-circled"></i>
                    <?php _e( '注册', 'salong' ); ?>
                </a>
            </li>
            <?php } ?>
            <?php if (class_exists( 'woocommerce' )){
            $cart_count = WC()->cart->get_cart_contents_count();
            ?>
            <li>
                <a href="<?php if($cart_count == 0) { echo get_permalink( wc_get_page_id( 'shop' ) ); } else { echo WC()->cart->get_cart_url(); } ?>" title="<?php if($cart_count == 0) { _e( '购物车为空','salong' ); } else { _e( '查看购物车','salong'); } ?>"><i class="icon-basket"></i><?php echo sprintf (_n( '%d 项目', '%d 项目', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
            </li>
            <?php } ?>
        </ul>
    </section>
    <?php } ?>
    <!--前台登录与注册end-->
</aseide>
<!--边栏end-->
<section id="content-container">
    <div class="popup_bg"></div>
    <header class="mobile_header">
       <section<?php if($salong['switch_header_show_hide']){ ?> id="header_main"<?php } ?> class="mheader_main">
        <!--按钮-->
        <i class="icon-menu"></i>
        <i class="icon-user"></i>
        <!--按钮end-->
        <!--LOGO-->
        <h1>
        <a href="<?php echo get_home_url(); ?>" class="logo" title="<?php bloginfo('description'); ?>-<?php bloginfo('name'); ?>"><img src="<?php echo $salong['logo']['url']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
        </h1>
        <!--LOGOend-->
        </section>
    </header>
    <!--移动end-->