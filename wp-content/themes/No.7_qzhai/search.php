<?php get_header(); ?>
            <?php div_cotent(); ?> 
      		<div id="index" class="bs uk-text-break">
      			<h4><?php the_search_query(); ?> - 搜索结果</h4>
      			<div id="list">
						<?php index_loop();?>
      			</div>
      		</div>
				<ul class="uk-pagination">
				    <?php par_pagenavi(); ?>
				</ul>
			<?php copyright('0');?>
            </div>
            <?php widget_Qzhai('page')?> 
            <?php copyright('1');?>
            </div>
<?php get_footer(); ?>
