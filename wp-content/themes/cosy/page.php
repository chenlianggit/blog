<?php

/*
            /$$            
    /$$    /$$$$            
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$ 
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/ 
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-09-05 20:44:04
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-09-06 21:53:42

*/
get_header();
?>
<section class="nt-warp">
    <div class="container">
        <?php if ( cs_get_option('breadcrumbs') && function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-9">
                <main class="l-main">
                    <div class="m-post">
                        <?php
                  					if ( have_posts() ) : 
                  					while ( have_posts() ) : the_post(); 
                  			?>
                            <div class="post-title">
                                <h1><?php the_title(); ?></h1>
                            </div>
                            <article class="post-content">
                                <?php the_content(); ?>
                            </article>
                          <?php 
                						endwhile;
                					endif;
                				?>     
                    </div>
                </main>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 hidden-xs">
                <aside class="l-sidebar">
                    <?php get_sidebar('page'); ?>
                </aside>
            </div>
        </div>
    </div>
</section>
<?php 
get_footer();