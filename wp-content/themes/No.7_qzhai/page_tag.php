<?php
/*
Template Name: 标签页
*/
?>
<?php get_header(); ?>
            <?php div_cotent(); ?> 
      		<div id="index" class="bs uk-text-break">
      		<h1 class="h4"><?php the_title(); ?></h1>
      			<div id="list" class="tag">
      				<p class="date"><strong><?php bloginfo('name'); ?></strong>目前共有标签：  <?php echo $count_tags = wp_count_terms('post_tag'); ?>个  </p>
					    <?php wp_tag_cloud('smallest=14&largest=24&unit=px&number=5000');?>
					</div>
      		</div>
			<?php copyright('0');?>
            </div>
            <?php widget_Qzhai('page')?> 
            <?php copyright('1');?>
            </div>
<?php get_footer(); ?>