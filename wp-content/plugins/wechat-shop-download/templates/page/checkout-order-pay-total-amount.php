<?php 
if (! defined('ABSPATH')) {
    exit();
}

$data = WShop_Temp_Helper::clear('atts','templates');
$context = $data['context'];
$symbol =WShop_Currency::get_currency_symbol(WShop::instance()->payment->get_currency());
?>
<script type="text/javascript">
	jQuery(function($){
		window.wshop_view_<?php echo $context?>={
			total_amount:0,
			extra_amount:[],
			
			symbol:'<?php echo $symbol;?>',	

			//初始化钩子函数
			init:function(){
				
				$(document).bind('wshop_<?php echo $context?>_on_amount_change',function(e){
					var view =window.wshop_view_<?php echo $context?>;
					$(document).trigger('wshop_<?php echo $context?>_display_amount',view);
	    		});
	    		
				$(document).bind('wshop_<?php echo $context?>_display_amount',function(e,view){
					
					//处理total_amount
					view.total_amount=0;
					$(document).trigger('wshop_<?php echo $context?>_init_amount_before',view);
					var extra_amount_pre =view.extra_amount;
					
					//处理extra_amount
					view.extra_amount=[];
					$(document).trigger('wshop_<?php echo $context?>_init_amount',view);
					
					//计算折扣
					var extra_amount=0;
					for(var i=0;i<view.extra_amount.length;i++){
						var amount0 =view.extra_amount[i];
						extra_amount+=amount0.amount;
					}

					view.total_amount = view.total_amount+extra_amount;

					//整合 extra_amount_pre，extra_amount
					for(var i=0;i<extra_amount_pre.length;i++){
						view.extra_amount.push(extra_amount_pre[i]);
					}
					
					//在这个钩子内，对总金额进行处理
					$(document).trigger('wshop_<?php echo $context?>_init_amount_after',view);
					//TODO 把折扣信息（extra_amount）显示出来
					//...
					$(document).trigger('wshop_<?php echo $context?>_show_amount',view);
	    		});
			}
		}
		window.wshop_view_<?php echo $context?>.init();
		$(document).trigger('wshop_<?php echo $context?>_on_amount_change');
	});
</script>