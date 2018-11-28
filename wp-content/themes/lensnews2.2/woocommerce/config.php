<?php

//设置促销的位置
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 );
//把列表评论放在价格后面
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );
//把文章评论放在价格后面
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );
//移除META
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// 移除WooCommerce默认面包屑
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

//让palpay支持人民币
add_filter( 'woocommerce_paypal_supported_currencies', 'enable_custom_currency' );
function enable_custom_currency($currency_array) {
  $currency_array[] = 'CNY';
  return $currency_array;
}

// ajax添加到购物车
if (class_exists( 'woocommerce' )) {
    require_once get_template_directory() . '/woocommerce/hooks.php';
}

// 在主题中声明对WooCommerce的支持
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

// 禁用 WooCommerce样式
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// WooCommerce相关产品数量
add_filter( 'woocommerce_output_related_products_args', 'wc_custom_related_products_args' );
function wc_custom_related_products_args( $args ){
    global $salong;
    $args = array(
        'posts_per_page' => $salong['product_related_count'],
        'orderby' => 'rand'
    );
    return $args;
}

//为商城添加图片延迟加载
if( $salong['switch_lazyload']== true ){
if (!function_exists('woocommerce_template_loop_product_thumbnail')) {
    function woocommerce_template_loop_product_thumbnail() {
        global $salong;
        $llwoo_image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'shop_catalog');
        $llwoo_placeholder = $salong['thumb_loading']['url'];
        $llwoo_placeholder_fallback = woocommerce_placeholder_img_src();
        if (!empty($llwoo_placeholder)) {
            echo '<img src="' . $llwoo_placeholder . '" data-original="' . $llwoo_image_src[0] . '">';
        } else {
            echo '<img src="' . $llwoo_placeholder_fallback . '" data-original="' . $llwoo_image_src[0] . '">';
        }
    }

}
}

if($salong['switch_woo_fields']){
    /*我的帐户*/
    /*去除姓和名的必填属性*/
    add_filter( 'woocommerce_save_account_details_required_fields', 'salong_account_required_fields');
    function salong_account_required_fields($fields){
        unset($fields['account_first_name']);
        unset($fields['account_last_name']);
        return $fields;
    }

    /*保存nickname的代码*/
    add_action( 'woocommerce_save_account_details', 'salong_woocommerce_save_account_details' );
    function salong_woocommerce_save_account_details( $user_id ) {
        update_user_meta( $user_id, 'nickname', $_POST[ 'account_nickname' ] );
    }

    /*删除结算表单*/
    add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
    function custom_override_checkout_fields( $fields ) {
        //unset($fields['order']['order_comments']);
        unset( $fields['billing']['billing_country'] );
        //unset( $fields['billing']['billing_first_name'] );
        unset( $fields['billing']['billing_last_name'] );
        unset( $fields['billing']['billing_company'] );
        //  unset( $fields['billing']['billing_address_1'] );
        unset( $fields['billing']['billing_address_2'] );
        unset( $fields['billing']['billing_city'] );
        unset( $fields['billing']['billing_state'] );
        unset( $fields['billing']['billing_postcode'] );
        //unset($fields['billing']['billing_email']);
        //unset( $fields['billing']['billing_phone'] );
        $fields['billing']['billing_first_name']['class'] = array('form-row-wide');
        $fields['billing']['billing_first_name']['label'] = __('姓名','salong');
        $fields['billing']['billing_address_1']['label'] = __('详细地址','salong');
        return $fields;
    }

    /*结算页面*/
    add_filter( 'woocommerce_billing_fields', 'wc_npr_filter_email', 10, 1 );
    function wc_npr_filter_email( $address_fields ) {
        $address_fields['billing_country']['required'] = false;
        $address_fields['billing_address_2']['required'] = false;
        $address_fields['billing_email']['required'] = false;
        return $address_fields;
    }

    //移除我的账户相关页面

    add_filter ( 'woocommerce_account_menu_items', 'misha_remove_my_account_links' );
    function misha_remove_my_account_links( $menu_links ){
        unset( $menu_links['edit-address'] ); // Addresses
        //unset( $menu_links['dashboard'] ); // Dashboard
        //unset( $menu_links['payment-methods'] ); // Payment Methods
        //unset( $menu_links['orders'] ); // Orders
        //unset( $menu_links['downloads'] ); // Downloads
        //unset( $menu_links['edit-account'] ); // Account details
        //unset( $menu_links['customer-logout'] ); // Logout
        return $menu_links;
    }
}