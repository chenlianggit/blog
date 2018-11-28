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
  	@Last Modified time: 2017-11-13 14:17:39

*/
date_default_timezone_set('PRC');

class Aggregation_Posts extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'Aggregation_Posts',
			'description' => '文章聚合',
		);
		parent::__construct( 'Aggregation_Posts', '文章聚合', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		extract($args);
		$num   = $instance['num'];
		$who   = $instance['who'];
		$days  = $instance['days'];
		$style = $instance['style'];
		$strtotime = strtotime('-'.$days.' days');
		$title = apply_filters('widget_name', $instance['title']);


		switch ($who) {
			case 'new_posts':
				$args = array(
					'type'                => 'post',
					'showposts'           => $num,				          
					'ignore_sticky_posts' => 1
				);
				break;

			case 'random_posts':
				$args = array(
					'type'                => 'post',
					'showposts'           => $num,
					'orderby'             => 'rand',				          
					'ignore_sticky_posts' => 1
				);
				break;

			case 'comment_posts':
				$args = array(
					'type'                => 'post',
					'showposts'           => $num,
					'orderby'             => 'comment_count',				          
					'ignore_sticky_posts' => 1,
					'date_query'          => array(
						array(
							'before' => date( 'Y-m-d H:i:s', time() ),
						),
						array(
							'after' => date( 'Y-m-d H:i:s', $strtotime ),
						),
					),
				);
				break;
			
			case 'like_posts':
				$args = array(
					'type'                => 'post',
					'showposts'           => $num,
					'orderby'             => 'meta_value_num',
					'meta_key'            => 'suxing_ding',				          
					'ignore_sticky_posts' => 1,
					'date_query'          => array(

						array(
							'before' => date( 'Y-m-d H:i:s', time() ),
						),
						array(
							'after' => date( 'Y-m-d H:i:s', $strtotime ),
						),
			
					),
				);
				break;

			case 'views_posts':
				$args = array(
					'type'                => 'post',
					'showposts'           => $num,
					'orderby'             => 'meta_value_num',
					'meta_key'            => 'views',				          
					'ignore_sticky_posts' => 1,
					'date_query'          => array(
						array(
							'before' => date( 'Y-m-d H:i:s', time() ),
						),
						array(
							'after' => date( 'Y-m-d H:i:s', $strtotime ),
						),
					),
				);
				break;

			default:
				$args = null;
				break;
		}

		if( $args ){
			query_posts($args);
		}

?>		
		<div class="widget widget_top_entries">      
			<h3 class="widget-title"><?php echo $title; ?></h3>
			<?php
				if( $style == 'min_img' ){
					$w = 70;
					$h = 70;
					echo '<ul>';
				}else{
					$w = 309;
					$h = 140;
					echo '<ul class="styel02">';
				}
				if( $args ){ 
					if (have_posts()) :

					    while (have_posts()) :
					    	the_post(); update_post_caches($posts);
					    	$post = get_post();
			?>

							<li class="clearfix">
								<a href="<?php the_permalink(); ?>">
                                	<div class="thumbnail pull-right">
                                    
                                        <img <?php echo is_lazysizes(); ?>src="<?php echo timthumb( post_thumbnail_src(), array( 'w' => $w, 'h' => $h ) ) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                          
                                	</div>
	                                <div class="content">
	                                    <h5 class="title">
	                                        <?php the_title(); ?>
	                                    </h5>
	                                    <div class="meta">
	                                    <?php 
	                                    	switch ($who) {

												case 'comment_posts':
													echo sprintf('<i class="%s"></i> %s', 'icon icon-bubble', $post->comment_count );
													break;
												
												case 'like_posts':
													$pnum = get_post_meta($post->ID,'suxing_ding',true);
													$pnum = $pnum ? $pnum : 0;
													echo sprintf('<i class="%s"></i> %s', 'icon icon-heart', $pnum );
													break;

												case 'views_posts':
													$pnum = get_post_meta($post->ID,'views',true);
													$pnum = $pnum ? $pnum : 0;
													echo sprintf('<i class="%s"></i> %s', 'icon icon-eye', $pnum );
													break;

												default:
													echo sprintf('<i class="%s"></i> %s', 'icon icon-clock', timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) );
													break;
											}
											unset($pnum);
	                                    ?>
	                                    </div>
	                                  
	                                </div>
	                            </a>
                            </li>

			<?php
						endwhile;
						wp_reset_query();

					else :
						echo '<li><p>暂时没有文章！</p></li>';
					endif;
				}else{
					echo '<li><p>暂时没有文章！</p></li>';
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
				'title' => '聚合文章',
				'num'   => 4,
				'days'  => 7,
				'who'   => 'new_posts',
				'style' => 'min_img',
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
		<p>
			<label> 显示样式：
				<select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
					<option <?php mi_selected( $instance['style'], 'min_img' ); ?> value="min_img">小图模式</option>
					<option <?php mi_selected( $instance['style'], 'max_img' ); ?> value="max_img">大图模式</option>
				</select>
			</label>
		</p>
		<p>
			<label> 显示什么：
				<select class="widefat mi_select_handle" id="<?php echo $this->get_field_id('who'); ?>" name="<?php echo $this->get_field_name('who'); ?>">
					<option <?php mi_selected( $instance['who'], 'new_posts' ); ?> value="new_posts">最新文章</option>
					<option <?php mi_selected( $instance['who'], 'random_posts' ); ?> value="random_posts">随机文章</option>
					<option <?php mi_selected( $instance['who'], 'comment_posts' ); ?> value="comment_posts">评论最多</option>
					<option <?php mi_selected( $instance['who'], 'like_posts' ); ?> value="like_posts">点赞最多</option>
					<option <?php mi_selected( $instance['who'], 'views_posts' ); ?> value="views_posts">浏览最多</option>
				</select>
			</label>
		</p>
		<?php if( $instance['who'] == 'new_posts' || $instance['who'] == 'random_posts' ){ ?>
		<p id="<?php echo $this->get_field_id('who'); ?>-box" style="display: none">
		<?php }else{ ?>
		<p id="<?php echo $this->get_field_id('who'); ?>-box">
		<?php } ?>
			<label>
				显示
				<input class="tiny-text" id="<?php echo $this->get_field_id('days'); ?>" name="<?php echo $this->get_field_name('days'); ?>" type="number" step="1" min="4" value="<?php echo $instance['days']; ?>" />
				<span>
				<?php 
					switch ($instance['who']) {
						case 'comment_posts':
							echo '天内评论最多的文章';
							break;
						
						case 'like_posts':
							echo '天内点赞最多的文章';
							break;
						case 'views_posts':
							echo '天内浏览最多的文章';
							break;
						default:
							break;
					}
				?>
				</span>		
			</label>
		</p>
<?php
	}

}
add_action( 'widgets_init', create_function('', 'return register_widget("Aggregation_Posts");'));

function mi_selected( $t, $i ){
	if( $t == $i ){
		echo 'selected';
	}
}

/**
 * 加载一段JS
 */
function mi_select_handle() {  
?>
	<script>

		jQuery( document ).ready( function() {
			if( jQuery('.mi_select_handle').length > 0 ){
				jQuery('.mi_select_handle').each(function(index, el) {
					mi_select_handle( jQuery(this).attr('id') );
				});
			}

		});

		jQuery(document).on('change', '.mi_select_handle', function(event) {
			event.preventDefault();
			mi_select_handle( jQuery(this).attr('id') );
		});

		function mi_select_handle( id ){
			var selected = jQuery('#'+id+' option:selected');
			if( selected.val() == 'comment_posts' || selected.val() == 'like_posts' || selected.val() == 'views_posts' ){
				jQuery('#'+id+'-box label span').text( ' 天内' + selected.text() + '的文章' );
		 		jQuery('#'+id+'-box').show();

		 	}else{
		 		jQuery('#'+id+'-box').hide();
		 	}
		}
	</script>
<?php
}  
add_action( 'admin_footer', 'mi_select_handle' );

