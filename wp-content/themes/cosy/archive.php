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
  	@Date:   2017-09-05 19:33:30
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-18 00:18:10

*/
get_header();

global $wp_query;

if ( have_posts() ) :
	if( is_category() ) :
		$queried_object = get_queried_object(); 
		$term_id = $queried_object->term_id;

		$term_data = get_term_meta( $term_id, '_custom_category_options', true );
		$term_data = wp_parse_args( (array) $term_data, array( 
				'sticky_posts' => false,
				'sticky_style' => 'default',
			) 
		);

		if( $term_data['sticky_style'] == 'default' ) {
			$class = 'class="container"';
		} else {
			$class = 'class="container-fluid pd10"';
		}

		if( $term_data['sticky_posts'] ) :

			$sticky_posts = new WP_Query(
				array(
					'showposts' => 4,
					'post__in'   => get_option('sticky_posts'),
					'cat'       => $term_id,
				)
			);
			if ( count(get_option('sticky_posts')) > 0 ) :
?>
				<div class="l-stickys">
					<div <?php echo $class; ?>>
				   		<div class="row rw10">
						<?php while( $sticky_posts->have_posts() ) : $sticky_posts->the_post(); ?>
					        <div class="col-xs-12 col-sm-3 col-md-3 pd10">
						        <div class="item">
					       			<div class="image" style="background-image:url(<?php echo timthumb( post_thumbnail_src(),null,'original'); ?>)"></div>
					       			<div class="sticky"><span>推荐阅读</span></div>
						            <div class="content">
						                <h2 class="title"><?php the_title(); ?></h2>
						                <div class="data">
								            <span class="u-time"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span>
								            <span class="u-view"><i class="icon icon-eye"></i><?php post_views('',''); ?></span>
								            <span class="u-comment"><i class="icon icon-bubble"></i><?php echo $post->comment_count; ?></span>
								            <span class="u-like"><i class="icon icon-heart"></i><?php if( get_post_meta($post->ID,'suxing_ding',true) ){ echo get_post_meta($post->ID,'suxing_ding',true); } else {echo '0';}?></span>
								        </div>
						            </div>
						            <a class="permalink" href="<?php the_permalink(); ?>"  target="_blank"><?php the_title(); ?></a>
						        </div>
					        </div>
						<?php endwhile; ?>
				        </div>
				   	</div>
				</div>

<?php
			endif;
		wp_reset_postdata();
		endif;
	endif; 
?>

<?php 
if( is_category() || is_archive() && !is_author() && !is_tag() && !is_tax('special') ){
	$term_data = get_term_meta( $cat, '_custom_category_options', true );
	$term_data = wp_parse_args( (array) $term_data, array( 
			'cat_layout' => 'card',
		) 
	);
	$layout = $term_data['cat_layout'] == 'full' ? $term_data['cat_layout'] : 'card';
}
?>

<section class="nt-warp nt-warp-full <?php $term_data['cat_layout'] == 'card-4' ? printf('nt-warp-raw') : ''; ?>">
    <div class="container">
        <div class="introduction">
			<h5>
			<?php 
				if( is_category() || is_archive() && !is_author() && !is_tag() && !is_tax('special') ){
					echo '<i class="icon icon-notebook"></i> '.$wp_query->queried_object->name;
					$tpage = 'cat';
					$query = $cat;
				}else if( is_tag() ){
					echo '<i class="icon icon-tag"></i> '.$wp_query->queried_object->name;
					$layout = cs_get_option('tag_layout') ? cs_get_option('tag_layout') : 'full';
					$tpage = 'tag';
					$query = $wp_query->queried_object->name;
				}else if( is_search() ){
					echo '<i class="icon icon-magnifier"></i> '.$wp_query->query['s'];
					$layout = cs_get_option('search_layout') ? cs_get_option('search_layout') : 'full';
					$tpage = 'search';
					$query = $wp_query->query['s'];
				}else if( is_author() ){
					echo '<i class="icon icon-user"></i> '.$wp_query->query['author_name'];
					$layout = cs_get_option('author_layout') ? cs_get_option('author_layout') : 'full';
					$tpage = 'author';
					$query = $wp_query->query['author_name'];
				}else if( is_tax('special') ){
					echo '<i class="icon icon-layers"></i> '.$wp_query->queried_object->name;
					$layout = cs_get_option('tag_layout') ? cs_get_option('tag_layout') : 'full';
					$tpage = 'tax';
					$query = $wp_query->queried_object->name;
				}else{
					$layout = 'card';
				}
				
			?>
			</h5>
            <p><i class="icon icon-docs"></i> <?php echo $wp_query->found_posts; ?>篇文章</p>
        </div>
       	
        <main class="l-main">
            <div class="m-post-list row d-archive">              
            <?php
            	$GLOBALS['mii'] = 1; 	        
    			while ( have_posts() ) : the_post();
    				get_template_part( 'template-parts/loop', $layout );
    				$GLOBALS['mii']++;
    			endwhile;    			
            ?>
            </div>
            <?php 
		    	if( cs_get_option('other_ajax_load') != 1 ) {
		    		the_posts_pagination( array(
						'prev_text'=>'<i class="fa fa fa-angle-left"></i>',
						'next_text'=>'<i class="fa fa fa-angle-right"></i>',
						'screen_reader_text' =>'',
						'mid_size' => 1,
					) );
		    	}else{
		    ?>
            <div class="m-ajax-load">
		        <div class="post-loading"><span></span><span></span><span></span><span></span><span></span></div>
		        <?php if( $GLOBALS["wp_query"]->max_num_pages > 1 ){ ?>
		        <button data-page="<?php echo $tpage; ?>" data-query="<?php echo $query; ?>" data-action="ajax_load_posts" data-paged="2" data-append="d-archive" class="btn btn-default dm-ajax-load">加载更多</button>
		        <?php } ?>
		    </div>
		    <?php } ?>
        </main>
        
    </div>
</section>
<?php else : ?>
<section class="nt-warp">
    <div class="container">
		<div class="data-null">
		    <p><i class="icon-null"></i></p>
		    <p>抱歉，没有你要找的内容...</p>
		    <div class="data-search">
		        <form role="search" method="get" action="/">
		            <div class="form-group">
		                <input type="search" class="form-control" name="s" id="s" placeholder="键入要搜索的关键词">
		                <button type="submit" class="btn btn-primary btn-search"><i class="fa fa-search"></i></button>
		            </div>
		        </form>
		    </div>
		</div>
	</div>
</section>
<?php
endif; 
get_footer();