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
  	@Date:   2017-09-11 11:13:39
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-09-11 11:14:04

*/
?>
<div class="post-navigation">
<?php 
	$prev_post = get_previous_post(false,'');
	$next_post = get_next_post(false,'');

	$prev_class = empty($next_post) ? 'col-xs-12 col-sm-12 col-md-12' : 'col-xs-12 col-sm-6 col-md-6';
	$next_class = empty($prev_post) ? 'col-xs-12 col-sm-12 col-md-12' : 'col-xs-12 col-sm-6 col-md-6 pull-right';
?>
    <div class="row">
        <?php if( !empty($prev_post) ){ ?>
        <a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="prev <?php echo $prev_class; ?>">
            <i class="icon icon-arrow-left-circle"></i>
           
            <?php echo $prev_post->post_title; ?>
        </a>
        <?php } ?>
        <?php if( !empty($next_post) ){ ?>
            <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="next <?php echo $next_class; ?>">
                <i class="icon icon-arrow-right-circle"></i>
                
                <?php echo $next_post->post_title; ?>
            </a>
        <?php } ?>
    </div>
</div>