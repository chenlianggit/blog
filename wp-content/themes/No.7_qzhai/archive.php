<?php
	if(of_get('book_list')){
        $ban = array();
        foreach (of_get('book_list') as $k => $v) {
            if($v == 1){                                
                $ban[]= $k;
            }
        }
    }else{
    	$ban = array('qzhai');
    }    
    $cat = get_the_category();$category = $cat[0]->cat_ID;
?>
<?php get_header(); ?>
           <?php div_cotent(); ?> 
            		<div id="index" class="bs uk-text-break">
						    <h1 class="h4">
						    	<?php if ( is_category() ){ single_cat_title(); }?>
						    	<?php if ( is_year() ) { ?><?php the_time('Y年'); ?> 日志归档<?php } ?>
								<?php if ( is_month() ) { ?><?php the_time('Y年n月'); ?> 日志归档<?php } ?>
								<?php if ( is_day() ) { ?><?php the_time('Y年n月j日'); ?> 日志归档 - <?php bloginfo('name'); ?><?php } ?>
								<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php  single_tag_title("", true); ?><?php }  } ?>
						    </h1>
            			<div id="list">
        					<?php 
        					if(in_array($category, $ban) and is_category()){
						    	loop_book(of_get('is_widget'));
						    }else{
						    	index_loop();
						    }?>
						</div>
            		</div>
            		<ul class="uk-pagination">
					    <?php par_pagenavi(); ?>
					</ul>
				<?php copyright('0');?>
            </div>
            <?php if(!$is){widget_Qzhai('page');}?>
            
            <?php copyright('1');?>
        </div>
<?php get_footer(); ?>
