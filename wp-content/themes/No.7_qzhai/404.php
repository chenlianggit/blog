<?php get_header(); ?>
            <?php div_cotent(); ?> 
            		<div id="index" class="bs">
            			<article id="article" class="uk-article">
					       <?php 
                                          if(of_get('diy_404')){
                                                echo of_get('diy_404');
                                          }else{
                                                echo '<p class="_404">没发现什么...</p>';
                                          }
                                    ?>
					</article>	   
            		</div>
				<?php copyright('0');?>
            </div>
            <?php widget_Qzhai('page')?> 
            <?php copyright('1');?>
        </div>
<?php get_footer(); ?>
