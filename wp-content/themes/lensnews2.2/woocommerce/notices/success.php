<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! $messages ){
	return;
}
//global $wp_query;
//$cart_id      = get_option( 'woocommerce_cart_page_id' );
//$checkout_id  = get_option( 'woocommerce_checkout_page_id' );
//$page_id      = $wp_query->post->ID;
?>

<?php foreach ( $messages as $message ) : ?>
	<div class="woocommerce-message<?php if(is_singular('product')) { wow(); } ?>"><?php echo wp_kses_post( $message ); ?></div>
<?php endforeach; ?>
