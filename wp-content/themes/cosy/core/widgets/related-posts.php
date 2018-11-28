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
  	@Date:   2017-09-11 15:45:50
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-13 14:18:11

*/

class Related_Posts extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'Related_Posts',
			'description' => '显示相关的文章，只在文章页面生效！',
		);
		parent::__construct( 'Related_Posts', '相关文章', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if( !is_single() ){
			return false;
		}
		extract($args);
		$num = $instance['num'];
		$title = apply_filters('widget_name', $instance['title']);

		global $post;
		$post_tags = wp_get_post_tags($post->ID);
		$cats = wp_get_post_categories($post->ID);
		if( $post_tags ){
			
			$tags = array();
			foreach ($post_tags as $value) {
				$tags[] = $value->term_id;
			}

			$args = array(
				'type'                => 'post',
				'tag__in'             => $tags,
				'post__not_in'        => array($post->ID),
				'showposts'           => $num,				          
				'ignore_sticky_posts' => 1
			);

		}else{

			$args = array(
				'type'                => 'post',
				'category__in'        => $cats,
				'post__not_in'        => array( $post->ID ),
				'showposts'           => $num,
				'ignore_sticky_posts' => 1
			);

		}

		if( $args ){
			query_posts($args);
		}
?>
		<div id="recent-posts-4" class="widget widget_related_posts">      
            <h3 class="widget-title"><?php echo $title; ?></h3>      
            <ul class="row">
            <?php
            	if( $args ){ 
	            	if (have_posts()) :
					    while (have_posts()) :
					      the_post(); update_post_caches($posts);
            ?>
                <li class="col-xs-12 col-sm-6 col-md-6">
                    <a href="<?php the_permalink(); ?>">
                        <img <?php echo is_lazysizes(); ?>src="<?php echo timthumb(post_thumbnail_src(), array( 'w' => '150', 'h' => '150' ) ) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                        <div class="content">
                            <p><?php the_title(); ?></p>
                        </div>
                    </a>
                </li>
            <?php 
	            		endwhile;
	            		wp_reset_query(); 
	            	else :
	            		echo '<li><p>暂时没有相关的文章！</p></li>';
	            	endif;
	            }else{
	            	echo '<li><p>暂时没有相关的文章！</p></li>';
	            }
            ?>   
            </ul>
        </div>
<?php		
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
				'title' => '相关文章',
				'num'   => 4,
			) 
		);
?>
		<p>
			<label> 标题：
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label> 显示数量：
				<input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="number" step="1" min="4" value="<?php echo $instance['num']; ?>" />
			</label>
		</p>
<?php
	}

}
add_action( 'widgets_init', create_function('', 'return register_widget("Related_Posts");'));