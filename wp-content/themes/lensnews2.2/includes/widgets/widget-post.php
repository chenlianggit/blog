<?php
/*
聚合文章小工具
*/

class SlongPosts extends WP_Widget {

/*  构造函数
/* ------------------------------------ */
	function __construct() {
		parent::__construct( false, __('Salong-文章聚合','salong'), array('description' => __('文章聚合小工具','salong'), 'classname' => 'widget_salong_posts') );;	
	}
	
/*  小工具
/* ------------------------------------ */
	public function widget($args, $instance) {
		extract( $args );
		$instance['title']?NULL:$instance['title']='';
		$title = apply_filters('widget_title',$instance['title']);
		$output = $before_widget."\n";
		if($title)
			$output .= $before_title.$title.$after_title;
		ob_start();
	
?>

	<?php
        if($instance['posts_orderby'] == 'votes_count') { $meta_key = 'votes_count'; $orderby = 'meta_value_num'; } else { $meta_key = ''; $orderby = $instance['posts_orderby'];}
		$posts = new WP_Query( array(
			'showposts'				=> $instance['posts_num'],
			'cat'					=> $instance['posts_cat_id'],
			'ignore_sticky_posts'	=> true,
            'meta_key'              => $meta_key,
			'orderby'				=> $orderby,
			'order'					=> 'desc',
			'date_query' => array(
				array(
					'after' => $instance['posts_time'],
				),
			),
		) );
	?>
    <ul class="<?php if(!$instance[ 'posts_thumb'] && !$instance['posts_category'] && !$instance['posts_date'] && !$instance['posts_like']) { ?>no-info<?php }else{ ?><?php if(!$instance[ 'posts_thumb']) { ?>no-thumb<?php } ?><?php if(!$instance['posts_category'] && !$instance['posts_date'] && !$instance['posts_like']) { ?> no-info<?php } } ?>">
        <?php if ( $posts->have_posts() ) : while ( $posts->have_posts() ) : $posts->the_post();
        global $post,$salong;
        $commentcount = get_comments_number();//评论数量
        if(get_post_meta($post->ID, "votes_count", true)){
            $votes_count0 = get_post_custom_values( "votes_count");//点赞数量
            $votes_count = $votes_count0[0];
        }else{
            $votes_count = '0';
        }
        ?>
        <li>
            <?php if(!$instance[ 'posts_category'] && !$instance[ 'posts_date'] && !$instance[ 'posts_like']) { ?>
            <a href="<?php the_permalink() ?>" title="<?php the_title(); ?><?php if($instance['posts_orderby'] == 'comment_count') { echo '&nbsp;'; printf( _n( '有(1)条评论', '有(%s)条评论', $commentcount, 'salong' ), $commentcount ); } else { echo '&nbsp;'; printf( __( '有(%s)人点赞', 'salong' ), $votes_count ); } ?>"<?php echo new_open_link(); ?>>
                <?php the_title(); ?>
            </a>
            <?php } else { ?>
            <article class="postlist">
                <?php if($instance[ 'posts_thumb']) { //启用缩略图 ?>
                <figure>
                    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?><?php if($instance['posts_orderby'] == 'comment_count') { echo '&nbsp;'; printf( _n( '有(1)条评论', '有(%s)条评论', $commentcount, 'salong' ), $commentcount ); }else { echo '&nbsp;'; printf( __( '有(%s)人点赞', 'salong' ), $votes_count ); } ?>"<?php echo new_open_link(); ?>>
                        <?php if( $salong['thumb_mode']== 'timthumb'){ post_thumbnail(); }else{ widget_post_thumbnail(); } ?>
                    </a>
                </figure>
                <?php } ?>
                <h3>
                    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?><?php if($instance['posts_orderby'] == 'comment_count') { echo '&nbsp;'; printf( _n( '有(1)条评论', '有(%s)条评论', $commentcount, 'salong' ), $commentcount ); }else { echo '&nbsp;'; printf( __( '有(%s)人点赞', 'salong' ), $votes_count ); } ?>"<?php echo new_open_link(); ?>><?php the_title(); ?></a>
                </h3>
                <div class="homeinfo">
                    <!--分类-->
                    <?php if($instance[ 'posts_category']) { ?><span class="category<?php if(!$instance[ 'posts_date']) { ?>no-date<?php } ?>"><?php the_category(', ') ?></span>
                    <?php } ?>
                    <!--时间-->
                    <?php if($instance[ 'posts_date']) { ?><span class="date"><?php the_time('Y-m-d'); ?></span>
                    <?php } ?>
                    <!--点赞-->
                    <?php if($instance[ 'posts_like']) { ?>
                    <?php if($instance['posts_orderby'] == 'comment_count') { ?>
                    <span class="comment"><i class="icon-comment"></i><?php if(post_password_required() || 'open'!=$post->comment_status){echo get_post($post->ID)->comment_count;}else{comments_popup_link('0', '1', '%');} ?></span>
                    <?php } else { ?>
                    <?php echo getPostLikeLinkList(get_the_ID());?>
                    <?php } ?>
                    <?php } ?>
                </div>
            </article>
            <?php } ?>
        </li>
		<?php endwhile; endif; ?>
		<?php wp_reset_query(); ?>
    </ul>

<?php
		$output .= ob_get_clean();
		$output .= $after_widget."\n";
		echo $output;
	}
	
/*  更新小工具
/* ------------------------------------ */
	public function update($new,$old) {
		$instance = $old;
		$instance['title'] = strip_tags($new['title']);
		$instance['posts_thumb'] = $new['posts_thumb']?1:0;
		$instance['posts_category'] = $new['posts_category']?1:0;
		$instance['posts_date'] = $new['posts_date']?1:0;
		$instance['posts_like'] = $new['posts_like']?1:0;
		$instance['posts_num'] = strip_tags($new['posts_num']);
		$instance['posts_cat_id'] = strip_tags($new['posts_cat_id']);
		$instance['posts_orderby'] = strip_tags($new['posts_orderby']);
		$instance['posts_time'] = strip_tags($new['posts_time']);
		return $instance;
	}

/*  小工具表单
/* ------------------------------------ */
	public function form($instance) {
		// 默认设置
		$defaults = array(
			'title' 			=> __('文章聚合','salong'),
			'posts_thumb' 		=> 1,
			'posts_category'	=> 1,
			'posts_date'		=> 1,
			'posts_like'		=> 1,
			'posts_num' 		=> '4',
			'posts_cat_id' 		=> '0',
			'posts_orderby' 	=> 'date',
			'posts_time' 		=> '0',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	<style>
	.widget .widget-inside .postform { width: 100%; }
	</style>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('posts_thumb'); ?>" name="<?php echo $this->get_field_name('posts_thumb'); ?>" <?php checked( (bool) $instance["posts_thumb"], true ); ?>>
			<label for="<?php echo $this->get_field_id('posts_thumb'); ?>"><?php _e('显示缩略图，下面三项全不勾选，缩略图也将不显示','salong'); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('posts_category'); ?>" name="<?php echo $this->get_field_name('posts_category'); ?>" <?php checked( (bool) $instance["posts_category"], true ); ?>>
			<label for="<?php echo $this->get_field_id('posts_category'); ?>"><?php _e('显示分类','salong'); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('posts_date'); ?>" name="<?php echo $this->get_field_name('posts_date'); ?>" <?php checked( (bool) $instance["posts_date"], true ); ?>>
			<label for="<?php echo $this->get_field_id('posts_date'); ?>"><?php _e('显示日期','salong'); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('posts_like'); ?>" name="<?php echo $this->get_field_name('posts_like'); ?>" <?php checked( (bool) $instance["posts_like"], true ); ?>>
			<label for="<?php echo $this->get_field_id('posts_like'); ?>"><?php _e('显示评论、点赞或收藏按钮','salong'); ?></label>
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_num"); ?>"><?php _e('文章数量：','salong'); ?></label>
			<input style="width:100%;" id="<?php echo $this->get_field_id("posts_num"); ?>" name="<?php echo $this->get_field_name("posts_num"); ?>" type="number" value="<?php echo absint($instance["posts_num"]); ?>" size='3' />
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_cat_id"); ?>"><?php _e('分类：','salong'); ?></label>
			<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("posts_cat_id"), 'selected' => $instance["posts_cat_id"], 'show_option_all' => __('全部','salong'), 'show_count' => true ) ); ?>
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_orderby"); ?>"><?php _e('排序：','salong'); ?></label>
			<select style="width: 100%;" id="<?php echo $this->get_field_id("posts_orderby"); ?>" name="<?php echo $this->get_field_name("posts_orderby"); ?>">
			  <option value="date"<?php selected( $instance["posts_orderby"], "date" ); ?>><?php _e('日期','salong'); ?></option>
			  <option value="title"<?php selected( $instance["posts_orderby"], "title" ); ?>><?php _e('标题','salong'); ?></option>
			  <option value="comment_count"<?php selected( $instance["posts_orderby"], "comment_count" ); ?>><?php _e('热评','salong'); ?></option>
			  <option value="votes_count"<?php selected( $instance["posts_orderby"], "votes_count" ); ?>><?php _e('点赞','salong'); ?></option>
			  <option value="rand"<?php selected( $instance["posts_orderby"], "rand" ); ?>><?php _e('随机','salong'); ?></option>
			</select>	
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_time"); ?>"><?php _e('时间：','salong'); ?></label>
			<select style="width: 100%;" id="<?php echo $this->get_field_id("posts_time"); ?>" name="<?php echo $this->get_field_name("posts_time"); ?>">
			  <option value="0"<?php selected( $instance["posts_time"], "0" ); ?>><?php _e('全部','salong'); ?></option>
			  <option value="1 year ago"<?php selected( $instance["posts_time"], "1 year ago" ); ?>><?php _e('一年','salong'); ?></option>
			  <option value="1 month ago"<?php selected( $instance["posts_time"], "1 month ago" ); ?>><?php _e('一月','salong'); ?></option>
			  <option value="1 week ago"<?php selected( $instance["posts_time"], "1 week ago" ); ?>><?php _e('一周','salong'); ?></option>
			  <option value="1 day ago"<?php selected( $instance["posts_time"], "1 day ago" ); ?>><?php _e('一天','salong'); ?></option>
			</select>	
		</p>

<?php

}

}

/*  注册小工具
/* ------------------------------------ */
if ( ! function_exists( 'salong_register_widget_posts' ) ) {

	function salong_register_widget_posts() { 
		register_widget( 'SlongPosts' );
	}
	
}
add_action( 'widgets_init', 'salong_register_widget_posts' );
