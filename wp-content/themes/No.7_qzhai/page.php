<?php get_header(); ?>
            <?php div_cotent(); ?> 
            		<div id="index" class="bs uk-text-break">
            			<article id="article" class="uk-article">
						    <h1 class="uk-article-title"><?php the_title(); ?></h1>
						    <?php 
								while ( have_posts() ) : the_post();
	
								the_content();
			
								endwhile;
							?>
						</article>
						    <?php if ( comments_open() || get_comments_number() ) {?>
							<div id="qzhai_comments">
								<?php comments_template(); ?>
							</div>
							<?php }?>
            		</div>
				<?php copyright('0');?>
            </div>
            <?php widget_Qzhai('page')?> 
            
            <?php copyright('1');?>
        </div>
<?php get_footer(); ?>
