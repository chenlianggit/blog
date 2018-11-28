<?php
/*
Template Name: 日志存档
*/
?>
<?php get_header(); ?>
            <?php div_cotent(); ?> 
            		<div id="index" class="bs uk-text-break">
						    <h1 class="h4"><?php the_title(); ?></h1>
            			<div id="list">
        					<p class="date"><strong><?php bloginfo('name'); ?></strong>目前共有文章：  <?php echo $hacklog_archives->PostCount();?>篇  </p>
    						<?php echo $hacklog_archives->PostList();?>
						</div>
            		</div>
				<?php copyright('0');?>
            </div>
            <?php widget_Qzhai('page')?> 
            <?php copyright('1');?>
            </div>
<?php get_footer(); ?>
