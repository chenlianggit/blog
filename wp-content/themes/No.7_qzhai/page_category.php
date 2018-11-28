<?php
/*
Template Name: 分类存档
*/
?>
<?php get_header(); ?>
            <?php div_cotent(); ?> 
            		<div id="index" class="bs uk-text-break">
						    <h1 class="h4"><?php the_title(); ?></h1>
                			<div id="list" class="category">
                            <p class="date"><strong><?php bloginfo('name'); ?></strong>目前共有分类：<?php echo $count_categories = wp_count_terms('category'); ?>   </p>
        					<?php
                                $args=array(
                                    'orderby' => 'name',
                                    'order' => 'ASC'
                                );
                                $categories=get_categories($args);
                                foreach($categories as $category) {
                                    echo '<a href="' . get_category_link( $category->term_id ) . '" title="'. $category->description . '" ' . ' data-uk-tooltip>' . $category->name.' ('. $category->count . ')</a> ';
                                }
                            ?>
    						</div>
            		</div>
				<?php copyright('0');?>
            </div>
            <?php widget_Qzhai('page')?>  
            <?php copyright('1');?>
            </div>
<?php get_footer(); ?>
