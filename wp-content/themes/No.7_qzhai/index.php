<?php get_header(); ?>
        <?php div_cotent(); ?> 
        		<div id="index" class="bs uk-text-break">
        			<h4><?php echo of_get('index_list_text')? of_get('index_list_text') :'最新文章';?></h4>
        			<div id="list">
						<?php index_loop();?>
        			</div>
        		</div>
				<ul class="uk-pagination">
				    <?php par_pagenavi(); ?>
				</ul>

				<?php copyright('0');?>

            </div> 
            <?php widget_Qzhai('home')?> 

            <?php copyright('1');?>

        </div>  
<?php get_footer(); ?>
