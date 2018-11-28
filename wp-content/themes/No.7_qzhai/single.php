<?php get_header(); ?>
            <?php div_cotent(); ?>
            		<div id="index" class="bs uk-text-break">
            			<article id="article" class="uk-article">
						    <h1 class="uk-article-title"><?php the_title(); ?>	</h1>
						
					    	<ul class="singlenav uk-breadcrumb">
					    		<li>
					    			<!-- <i class="uk-icon-calendar"></i>  -->
					    			<i class="iconfont icon-rili"></i> 
					    			<?php the_time('Y-m-d');?>
				    			</li>
					    		<li><?php post_views(); ?></li>
					    		<li>
					    			<!-- <i class="uk-icon-commenting-o"></i> -->
					    			<i class="iconfont icon-liaotian"></i>
					    			<?php comments_popup_link('0', '1', '%', '', ''); ?>
				    			</li>
					    		<?php do_action('breadcrumb_qzhai');?>
					    		<?php if(of_get('is_like')){?>
					    		<li>
					    			<!-- <i class="uk-icon-heart-o"></i>  -->
					    			<i class="iconfont icon-shoucang"></i> 
					    			<?php if( get_post_meta($post->ID,'bigfa_ding',true) ){ echo get_post_meta($post->ID,'bigfa_ding',true);} else { echo '0';}?></li>
					    		<?php }?>
					    	</ul>
						    <?php
								while ( have_posts() ) : the_post();
	
								the_content();
			
								endwhile;
							?>
							<?php 
								if(of_get('is_reward') and !of_get('is_like'))
								reward_qzhai();
							?>
							<?php 
								if(of_get('is_like')){
							?>
							<div class="like_qzhai">
								<div class="like_men_qzhai">
									<?php f_qzhai();?>
									<a href="javascript:;" 
							         		data-action="ding" 
							         		data-id="<?php the_ID(); ?>"
							         		cl = '0'
							         		class="favorite<?php if(isset($_COOKIE['bigfa_ding_'.$post->ID])) echo ' done';?>" 
							         		> 
							         		<i class='uk-icon-heart'
							         		title="<?php if( get_post_meta($post->ID,'bigfa_ding',true) ){ echo get_post_meta($post->ID,'bigfa_ding',true) .'人喜欢';} else { echo '还没有喜欢的人';}?>"
					         				data-uk-tooltip="{pos:'bottom'}"
							         		></i>
							        </a>
							        <em class="em01"><i class='iconfont icon-shoucang'></i></em>
							        <em class="em02"><i class='iconfont icon-shoucang'></i></em>
							        <em class="em03"><i class='iconfont icon-shoucang'></i></em>
							        <em class="em04"><i class='iconfont icon-shoucang'></i></em>
							        <em class="em05"><i class='iconfont icon-shoucang'></i></em>
								</div>
							</div>
							<?php } ?>
							<div class="tags uk-clearfix">
								<div class="tags uk-float-left"><?php the_tags('<i class="iconfont icon-jiagebiaoqian"></i> ',',',''); ?></div>				
								<div class="uk-float-right"></div>					
							</div>
							<?php do_action('single_middle_qzhai');?>

						</article>
						    <?php if ( comments_open() || get_comments_number() ) {?>
							<div id="qzhai_comments">
								<?php comments_template(); ?>
							</div>
							<?php }?>	
						

            		</div>
				<?php copyright('0');?>
            </div>
       		<?php widget_Qzhai('single')?> 
       		<?php copyright('1');?>
	        </div>
<?php get_footer(); ?>
