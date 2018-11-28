<?php
/* WooCommerce custom hooks and functions used by the theme */

// Disable WooCommerce styles
define('WOOCOMMERCE_USE_CSS', false);

// Update cart contents when added via AJAX */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
    $cart_count = WC()->cart->get_cart_contents_count(); ?>
    
	<a class="cart-contents" href="<?php if($cart_count == 0) { echo get_permalink( wc_get_page_id( 'shop' ) ); } else { echo WC()->cart->get_cart_url(); } ?>" title="<?php if($cart_count == 0) { _e( '购物车为空','salong' ); } else { _e( '查看购物车','salong'); } ?>"><?php echo sprintf (_n( '%d 项目', '%d 项目', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
	<!--迷你购物车-->
      <div class="widget_shopping_cart_content">
       <?php wc_get_template( 'cart/mini-cart.php' ); ?>
       </div>
   <!--迷你购物车-->
	<?php $fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}
?>