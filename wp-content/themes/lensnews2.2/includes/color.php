<?php
$root =dirname(dirname(dirname(dirname(dirname(__FILE__)))));
//echo $root; 
if ( file_exists( $root.'/wp-load.php' ) ) {
    require_once( $root.'/wp-load.php' );
} elseif ( file_exists( $root.'/wp-config.php' ) ) {
    require_once( $root.'/wp-config.php' );
}
header("Content-type: text/css; charset=utf-8");
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

global $salong;

$style_main = $salong['style_main_color'];
$style_hover = $salong['style_hover_color'];

if(isset($_GET['main_color']) and $_GET['main_color']){
   switch ($_GET['main_color']) {
     case 'color1.css':
       # code...
         $main_color=$style_main='#f72611';
         $style_hover='#c91d0d';

       break;

      case 'color2.css':
       # code...
         $style_main='#e1913c';
         $style_hover='#b47430';
       break;

      case 'color3.css':
       # code...
         $style_main='#e2c634';
         $style_hover='#b49e29';
      break;
      case 'color4.css':
       # code...
         $style_main='#7ebe24';
         $style_hover='#6ca718';
      break;
      case 'color5.css':
       # code...
         $style_main='#46b573';
         $style_hover='#38905c';
      break;
      case 'color6.css':
       # code...
         $style_main='#39b3be';
         $style_hover='#2d8f98';
      break;
      case 'color7.css':
       # code...
         $style_main='#0668bf';
         $style_hover='#015c92';
      break;
      case 'color8.css':
       # code...
         $style_main='#6758b7';
         $style_hover='#524692';
      break;
      case 'color9.css':
       # code...
         $style_main='#a552a4';
         $style_hover='#844183';
      break;
      case 'color10.css':
       # code...
         $style_main='#b83a60';
         $style_hover='#932e4c';
      break;
     
     default:
       # code...
       break;
   }
}


?>

/*****默认背景*****/
/**幻灯片**/
.swiper-pagination-bullet-active,
/**分页**/
.pagination .current,
/**ajax加载动画**/
.ias-spinner > div,
/**面包屑标题**/
.crumbs_wrap h3:before,
/**用户中心按钮**/
.contribute_form .submit,
/**搜索小工具按钮**/
.woocommerce-product-search input[type="submit"],
.widget_search #searchsubmit,
/**日历**/
#wp-calendar #today,
#wp-calendar #today a,
/**幻灯片文章导航**/
.swiper-slidepost-pagination span.swiper-pagination-bullet-active,
/**前台登录标题**/
.login_header,
/**前台登录按钮**/
.front_form #submit_button,
/**侧边搜索按钮**/
.search_form .search_btn,
/*不是商城页面购物车与结算*/
.buttons a.button,
/*按钮样式*/
.woocommerce button.button,
.woocommerce a.button,
.woocommerce input[type="submit"],
/*商城标题*/
.cart_totals h2:before,
form.woocommerce-checkout h3:before,
.woocommerce-MyAccount-content h3:before,
.woocommerce-MyAccount-content h2:before,
.woocommerce-Address-title h3:before,
/*价格筛选*/
.widget_price_filter .ui-slider-range,
.widget_price_filter .ui-slider-handle,
.widget_price_filter .price_slider_amount .button,
/*商城菜单*/
.woocommerce-MyAccount-navigation a,
/*移动导航菜单*/
.mobile-menu .menu > li:hover > a,
.mobile-menu .sub-menu > li.current-menu-item > a,
.mobile-menu .menu > li.current-menu-parent > a,
.mobile-menu .menu > li.current-menu-item > a,
.mobile-menu .menu > li.current-menu-item:before,
.mobile-menu .menu > li.current-menu-ancestor:before,
.mobile-menu .menu > li:hover:before,
/*登录*/
.login_main .xh-regbox .xh-btn-primary,
/*代码高亮*/
div.highlighting span.btn button
{background-color: <?php echo $style_main ?>}


/****默认颜色*****/
/**菜单当前状态**/
.sub-menu > li.current-menu-ancestor > a,
.sub-menu > li.current-menu-item > a,
ul.menu > li.current-menu-ancestor > a,
ul.menu > li.current-menu-item > a,
ul.menu > li:hover > a,
ul.menu > li.current-menu-ancestor:before,
ul.menu > li.current-menu-ancestor:after,
ul.menu > li.current-menu-item:before,
.top-menu ul.menu > li.current-menu-ancestor:after,
ul.menu > li.current-menu-item:after,
ul.menu > li:hover:after,
.top-menu ul.menu > li:hover:after,
ul.menu > li:hover:before,
/******高亮显示******/
.top-menu > ul > li[class^="icon-"].light:before,
.top-menu > ul > li[class*="icon-"].light:before,
.top-menu > ul > li.light a,
/**面包屑分类当前状态**/
.crumbs_wrap ul.children .current-cat > a,
/**内容a标签**/
.entry .content-post a,
/**用户中心菜单当前状态**/
.wpuf .widget_nav_menu ul li.current-menu-item:before,
.wpuf .widget_nav_menu ul li.current-menu-item a,
/**关于本站小工具标题**/
.widget_salong_about .about h3,
/**QQ交流群小工具标题**/
.widget_salong_qqqun .sidebar_title h3,
/**每日一句小工具标题**/
.widget_salong_word .sidebar_title h3,
/**toggle当前状态**/
.toggle-box-head .icon-toggle.active:before,
.gdl-toggle-box .toggle-box-head span.active,
/**tabs当前状态**/
#tabs li.current a,
/*A标签*/
.woocommerce-info a,
.woocommerce-error a,
.woocommerce-message a,
.woocommerce-MyAccount-content a ,
/*商城tabs*/
.woocommerce-tabs ul li.active a,
/*商城菜单*/
.woocommerce-MyAccount-navigation ul li.is-active a,
/*付款方式*/
#payment a.about_paypal,
/*评论*/
.commentlist .comment_body .comment_btn a:hover
{color: <?php echo $style_main ?>}

/**输入框选中状态**/
textarea:focus,
input:focus,
/**分页**/
.pagination .current,
/**幻灯片文章导航**/
.swiper-slidepost-pagination span.swiper-pagination-bullet-active,
/*价格筛选*/
.widget_price_filter .ui-slider-handle,
/*登录*/
.login_main .xh-regbox .xh-btn-primary
{border-color:<?php echo $style_main ?>}


.box:before
{border-top-color:<?php echo $style_main ?>}

/*我的帐户P标签*/
.woocommerce-MyAccount-content > p
{border-left-color:<?php echo $style_main ?>}


/*菜单搜索*/
.header-menu > ul > li.menu-item-search > a:hover i,
/*二级菜单经过*/
.sub-menu li a:hover,
/*幻灯片经过*/
.swiper-gallery .swiper-button:hover,
.slide-home .swiper-button:hover,
.swiper-pagination-bullet:hover,
/*公告按钮*/
.bulletin .swiper-button:hover,
/*置顶文章更多*/
.sticky a.more i:hover,
/*画廊按钮*/
.gallery_popup a.btn:hover,
/*分页*/
.pagination a:hover,
/*文章点赞打赏分享*/
.post-social > div:hover,
/*分享按钮*/
.post-social .share_icon > a:hover,
/*用户中心按钮*/
p.login-submit #wp-submit:hover,
p.submit #wp-submit:hover,
.wpuf ul.wpuf-form .wpuf-submit #wpuf-post-draft:hover,
.wpuf ul.wpuf-form .wpuf-submit input[type="submit"]:hover,
.wpuf ul.wpuf-form li .wpuf-fields #wpuf-insert-image-container a#wpuf-insert-image:hover,
.wpuf ul.wpuf-form li .wpuf-fields a.file-selector:hover,
/*搜索小工具按钮*/
.woocommerce-product-search input[type="submit"]:hover,
.searchform #searchsubmit:hover,
/*日历*/
#wp-calendar td a:hover,
#wp-calendar #today a:hover,
/*标签*/
.sltags a:hover,
/*社交登录按钮*/
.social_login a:hover,
/*弹窗登录*/
.front_form #submit_button:hover,
/*搜索按钮*/
.search_form .search_btn:hover,
/*侧边按钮*/
#back-to-top:hover,
.footer-popup .side_btn:hover,
/*商城计算运费*/
.shipping-calculator-button:hover,
.woocommerce input[type="submit"]:hover,
.woocommerce button.button:hover,
.woocommerce a.button:hover,
/*购物车小工具*/
.widget_shopping_cart_content .button:hover,
/*价格筛选*/
.widget_price_filter .price_slider_amount .button:hover,
/*商城菜单*/
.woocommerce-MyAccount-navigation a:hover,
/*订单取消按钮*/
.woocommerce-MyAccount-content td.order-actions a.cancel:hover,
/*首页加入购物车按钮*/
.product_img a.added_to_cart:hover,
.product_img a.button:hover,
/*投稿按钮*/
.contribute_form .submit:hover,
.contribute_form .reset:hover,
/*点赞收藏按钮*/
.post-like > a:hover,
.post-like > span:hover,
/*登录*/
.login_main .xh-regbox .xh-btn-primary:hover,
/*代码高亮*/
div.highlighting span.btn button:hover
{background-color: <?php echo $style_hover ?>}

/*a标签*/
a:hover,
a:active,
/*info*/
.homeinfo a:hover,
/*置顶文章更多*/
.sticky a.more:hover span,
/*分类标签*/
.title-tag a:hover,
/*标题*/
.postgrid h2 a:hover,
/*分类列表*/
.cat3_list2 ul li:hover a,
.cat3_list2 ul li:hover:before,
/*画廊标题*/
.gallery_popup h2 a:hover,
/*文章列表标题*/
.post_main h2 a:hover,
/*info*/
.postinfo a:hover,
/*面包屑*/
.crumbs a:hover,
/*面包屑分类*/
.crumbs_wrap > ul > li > a:hover,
/*自定义文章info*/
.custompost_info a:hover,
/*文章a标签*/
.entry .content-post a:hover,
/*文章版权*/
.post_declare p a:hover,
/*文章目录*/
.entry .content-post .catalogue_list a:hover,
/*友情链接*/
#link-page ul li a:hover,
/*用户中心按钮*/
.wpuf table.wpuf-table .wpuf_title a:hover,
.wpuf table.wpuf-table .wpuf_btn a:hover,
/*用户中心菜单*/
.wpuf .widget_nav_menu ul li:hover a,
/*商城分类*/
.product-categories > li:hover:before,
/*相关标签文章简码*/
.related_tagposts ul li:hover:before,
/*无边栏与信息*/
ul.no-info li:hover:before,
/*页面*/
.widget_pages ul li:hover:before,
/*友情链接*/
.widget_links ul li:hover:before,
/*最新文章*/
.widget_recent_entries ul li:hover:before,
/*自定义菜单*/
.widget_nav_menu ul li:hover:before,
/*功能*/
.widget_meta ul li:hover:before,
/*文章归档*/
.widget_archive ul li:hover:before,
/*分类目录*/
.widget_categories ul li:hover:before,
/*公告*/
.widget_salong_bulletins ul li:hover:before,
/*文章幻灯片按钮*/
.slidepost_btn .swiper-button:hover,
/*页脚a标签*/
.footer a:hover,
/*商城A标签*/
.woocommerce a:hover,
/*产品信息*/
.product_info h3:hover,
/*登录*/
.login_main .login_reg a:hover
{color: <?php echo $style_hover ?>}


/*菜单搜索*/
.header-menu > ul > li.menu-item-search > a:hover i,
/*公告按钮*/
.bulletin .swiper-button:hover,
/*置顶文章更多*/
.sticky a.more i:hover,
/*分页*/
.pagination a:hover,
/*读者墙*/
.readers-list li a:hover,
/*登录*/
.login_main .xh-regbox .xh-btn-primary:hover
{border-color:<?php echo $style_hover ?>}


/*二级菜单顶部*/
.sub-menu,
/*面包屑子分类*/
.crumbs_wrap ul li ul.children
{border-top-color:<?php echo $style_hover ?>}


/*二级菜单图标*/
.crumbs_wrap > ul > li > ul.children:before,
.top-menu > ul.menu > li > ul.sub-menu:before,
.header-menu > ul.menu > li > ul.sub-menu:before
{border-bottom-color:<?php echo $style_hover ?>}



