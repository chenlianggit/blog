<?php 
if (! defined ( 'ABSPATH' ))
    exit (); // Exit if accessed directly

$data = WShop_Temp_Helper::get('atts','templates');
$atts = $data['atts'];
$content = $data['content'];
    
$post_id = isset($atts['post_id'])?$atts['post_id']:null;
if(!$post_id){return null;}

$download = new WShop_Download($post_id);
if(!$download->is_load()){
    return null;
}

$is_validate = apply_filters('wshop_download_is_validate_get_data', false,$atts);
if($is_validate){
    return $download->downloads;
}

if(WShop::instance()->payment->is_validate_get_pay_per_view($post_id,isset($atts['roles'])?explode(',', $atts['roles']):null)){
    return $download->downloads;
}

$product = new WShop_Product($atts['post_id']);
if(!$product->is_load()){
    ?><span style="color:red;">[商品未设置价格或未启用在线支付！]</span><?php
    return;
}

?>
<div class="mod-ct">
    <div class="amount"><?php echo $product->get_single_price(true)?></div>
    <div>
       <a href="javascript:void(0);" class="xh-btn xh-btn xh-btn-danger xh-btn-lg">立即支付</a>
    </div>
   
    <div class="tip">
    <span class="dec dec-left"></span>
    <span class="dec dec-right"></span>
    
    <div class="tip-text">
    	<p><img src="<?php echo WSHOP_URL?>/assets/image/suo.png" style="vertical-align: middle;" alt=""> 以下内容需要付费查看，支付后可见</p>
    </div>
    </div>
</div>

<div class="wshop-pay-button" id="wshop-modal-downloads" >
	<div class="cover"></div>
	<div class="mod-ct">

<div class="amount">￥1099.00 <span>元</span></div>
<div class="qr-image" id="qrcode" title="https://myun.tenpay.com/mqq/pay/qrcode.html?_wv=1027&amp;_bid=2183&amp;t=5Ve02deb0ad03febe6e2f4d1f66c71a5">
<img style="width:220px;height:220px" src="data:image/png;base64,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" title="请使用微信“扫一扫”"></div>
 
<div class="channel center">
        请使用 <i class="icon alipay"></i>支付宝 或 <i class="icon weixin"></i>微信 扫码支付
    </div>

<div class="tip">
<span class="dec dec-left"></span>
<span class="dec dec-right"></span>

<div class="tip-text">
<p> <img src="<?php echo WSHOP_URL?>/assets/image/suo.png" style="vertical-align: middle;" alt=""> 以下内容需要付费查看，支付后可见</p>

</div>
</div>

</div>
</div>
<?php 

return WShop::instance()->WP->requires(WSHOP_DIR, 'button-purchase.php',array(
    'content'=>$content,
    'atts'=>$atts
));
?>