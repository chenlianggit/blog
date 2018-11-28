<?php global $salong;
$blog_link    = $salong[ 'blog_link'];//博客链接
$gallery_link = $salong[ 'gallery_link'];//画廊链接
$video_link   = $salong[ 'video_link'];//画廊链接
/////////////////////////////////////////博客分类
if($salong['switch_blog_hierarchical']){ $blog_hierarchical=1; }else{ $blog_hierarchical=0; }//子分类形式显示
if($salong['switch_blog_show_count']){ $blog_show_count=1; }else{ $blog_show_count=0; }//显示数量
if($salong['blog_exclude_crumbs_cat']){ $blog_exclude_crumbs_cat = implode(',',$salong['blog_exclude_crumbs_cat']); }//排除分类
$blog_cat_orderby = $salong['blog_cat_orderby'];
$blog_cat_order = $salong['blog_cat_order'];
$blog_args=array( 'hierarchical'=> $blog_hierarchical,'title_li'=>'','show_count'=>$blog_show_count,'exclude'=>$blog_exclude_crumbs_cat,'orderby'=>$blog_cat_orderby,'order'=>$blog_cat_order);
/////////////////////////////////////////画廊分类
if($salong['switch_gallery_hierarchical']){ $gallery_hierarchical=1; }else{ $gallery_hierarchical=0; }//子分类形式显示
if($salong['switch_gallery_show_count']){ $gallery_show_count=1; }else{ $gallery_show_count=0; }//显示数量
if($salong['gallery_exclude_crumbs_cat']){ $gallery_exclude_crumbs_cat = implode(',',$salong['gallery_exclude_crumbs_cat']); }//排除分类
$gallery_cat_orderby = $salong['gallery_cat_orderby'];
$gallery_cat_order = $salong['gallery_cat_order'];
$gallery_args=array( 'hierarchical'=> $gallery_hierarchical,'title_li'=>'','taxonomy'=>'gallery-cat','show_count'=>$gallery_show_count,'exclude'=>$gallery_exclude_crumbs_cat,'orderby'=>$gallery_cat_orderby,'order'=>$gallery_cat_order);
/////////////////////////////////////////视频分类
if($salong['switch_video_hierarchical']){ $video_hierarchical=1; }else{ $video_hierarchical=0; }//子分类形式显示
if($salong['switch_video_show_count']){ $video_show_count=1; }else{ $video_show_count=0; }//显示数量
if($salong['video_exclude_crumbs_cat']){ $video_exclude_crumbs_cat = implode(',',$salong['video_exclude_crumbs_cat']); }//排除分类
$video_cat_orderby = $salong['video_cat_orderby'];
$video_cat_order = $salong['video_cat_order'];
$video_args=array( 'hierarchical'=> $video_hierarchical,'title_li'=>'','taxonomy'=>'video-cat','show_count'=>$video_show_count,'exclude'=>$video_exclude_crumbs_cat,'orderby'=>$video_cat_orderby,'order'=>$video_cat_order);

?>
<section class="crumbs_wrap box<?php triangle();wow(); ?>">
    <!--画廊分类-->
    <?php if(is_tax( 'gallery-cat') || is_tax( 'gallery-tag')){ ?>
    <h3>
        <?php echo $wp_query->queried_object->name; ?>
    </h3>
    <?php if($salong[ 'switch_gallery_crumbs']){ ?>
    <?php if(wp_is_mobile()){ ?>
    <?php wp_dropdown_categories('show_option_none='.__('选择分类','salong').'&hide_empty=1&show_count=1&hierarchical=1&taxonomy=gallery-cat&value_field=slug&selected=value_field'); ?>
    <?php }else{ ?>
    <ul>
        <li>
            <a href="<?php echo get_page_link($gallery_link); ?>">
                <?php _e( '全部', 'salong' ); ?>
                <?php if($salong[ 'switch_gallery_show_count']){ ?>(
                <?php echo wp_count_posts( 'gallery')->publish; ?>)
                <?php } ?>
            </a>
        </li>
        <?php wp_list_categories($gallery_args);?>
    </ul>
    <?php } ?>
    <?php }else{ ?>
    <p>
        <?php echo category_description(); ?>
    </p>
    <?php } ?>
    <!--画廊-->
    <?php } else if(is_page_template( 'template-gallery.php' )){ ?>
    <h3>
        <?php the_title(); ?>
    </h3>
    <?php if(wp_is_mobile()){ ?>
    <?php wp_dropdown_categories('show_option_none='.__('选择分类','salong').'&hide_empty=1&show_count=1&hierarchical=1&taxonomy=gallery-cat&value_field=slug&selected=value_field'); ?>
    <?php }else{ ?>
    <ul>
        <li class="<?php if(is_page_template( 'template-gallery.php' )){ ?>current-cat<?php } ?>">
            <a href="<?php echo get_page_link($gallery_link); ?>">
                <?php _e( '全部', 'salong' ); ?>
                <?php if($salong[ 'switch_gallery_show_count']){ ?>(
                <?php echo wp_count_posts( 'gallery')->publish; ?>)
                <?php } ?>
            </a>
        </li>
        <?php wp_list_categories($gallery_args);?>
    </ul>
    <?php } ?>
    <!--视频分类-->
    <?php } else if(is_tax( 'video-cat') || is_tax( 'video-tag')){ ?>
    <h3>
        <?php echo $wp_query->queried_object->name; ?>
    </h3>
    <?php if($salong[ 'switch_video_crumbs']){ ?>
    <?php if(wp_is_mobile()){ ?>
    <?php wp_dropdown_categories('show_option_none='.__('选择分类','salong').'&hide_empty=1&show_count=1&hierarchical=1&taxonomy=video-cat&value_field=slug&selected=value_field'); ?>
    <?php }else{ ?>
    <ul>
        <li>
            <a href="<?php echo get_page_link($video_link); ?>">
                <?php _e( '全部', 'salong' ); ?>
                <?php if($salong[ 'switch_video_show_count']){ ?>(
                <?php echo wp_count_posts( 'video')->publish; ?>)
                <?php } ?>
            </a>
        </li>
        <?php wp_list_categories($video_args);?>
    </ul>
    <?php } ?>
    <?php }else{ ?>
    <p>
        <?php echo category_description(); ?>
    </p>
    <?php } ?>
    <!--视频-->
    <?php } else if(is_page_template( 'template-video.php' )){ ?>
    <h3>
        <?php the_title(); ?>
    </h3>
    <?php if(wp_is_mobile()){ ?>
    <?php wp_dropdown_categories('show_option_none='.__('选择分类','salong').'&hide_empty=1&show_count=1&hierarchical=1&taxonomy=video-cat&value_field=slug&selected=value_field'); ?>
    <?php }else{ ?>
    <ul>
        <li class="<?php if(is_page_template( 'template-video.php' )){ ?>current-cat<?php } ?>">
            <a href="<?php echo get_page_link($video_link); ?>">
                <?php _e( '全部', 'salong' ); ?>
                <?php if($salong[ 'switch_video_show_count']){ ?>(
                <?php echo wp_count_posts( 'video')->publish; ?>)
                <?php } ?>
            </a>
        </li>
        <?php wp_list_categories($video_args);?>
    </ul>
    <?php } ?>
    <!--文章分类-->
    <?php } else if(is_category()){ ?>
    <h3>
        <?php echo $wp_query->queried_object->name; ?>
    </h3>
    <?php if($salong[ 'switch_blog_crumbs']){ ?>
    <?php if(wp_is_mobile()){ ?>
    <?php wp_dropdown_categories('show_option_none='.__('选择分类','salong').'&hide_empty=1&show_count=1&hierarchical=1&taxonomy=category'); ?>
    <?php }else{ ?>
    <ul>
        <li>
            <a href="<?php echo get_page_link($blog_link); ?>">
                <?php _e( '全部', 'salong' ); ?>
                <?php if($salong[ 'switch_blog_show_count']){ ?>(
                <?php echo wp_count_posts( 'post')->publish; ?>)
                <?php } ?>
            </a>
        </li>
        <?php wp_list_categories($blog_args);?>
    </ul>
    <?php } ?>
    <?php }else{ ?>
    <p>
        <?php echo category_description(); ?>
    </p>
    <?php } ?>
    <!--博客-->
    <?php } else if(is_page_template( 'template-blog.php' ) || is_page_template( 'template-sticky.php' ) || is_page_template( 'template-like.php' ) || is_page_template( 'template-hot.php' ) || is_tag() || is_category() || is_author() || is_date()){ ?>
    <h3>
        <?php if(is_tag()){
    printf(__( '%s 的标签存档' , 'salong' ), single_tag_title( '', false ) );
} else if(is_author()) {
    global $author;$userdata = get_userdata($author);echo $before ;printf(__( '%s 的所有文章' , 'salong' ),  $userdata->display_name );
} else if(is_year()) {
    printf(__( '%s 的所有文章' , 'salong' ),  get_the_time(__('Y年','salong')) );
} else if(is_month()) {
    printf(__( '%s 的所有文章' , 'salong' ),  get_the_time(__('Y年m月','salong')) );
} else if(is_day()) {
    printf(__( '%s 的所有文章' , 'salong' ),  get_the_time(__('Y年m月d日','salong')) );
} else {
    the_title();
} ?>
    </h3>
    <?php if(wp_is_mobile()){ ?>
    <?php wp_dropdown_categories('show_option_none='.__('选择分类','salong').'&hide_empty=1&show_count=1&hierarchical=1&taxonomy=category'); ?>
    <?php }else{ ?>
    <ul>
        <li class="<?php if(is_page_template( 'template-blog.php' )){ ?>current-cat<?php } ?>">
            <a href="<?php echo get_page_link($blog_link); ?>">
                <?php _e( '全部', 'salong' ); ?>
                <?php if($salong[ 'switch_blog_show_count']){ ?>(
                <?php echo wp_count_posts( 'post')->publish; ?>)
                <?php } ?>
            </a>
        </li>
        <?php wp_list_categories($blog_args); ?>
    </ul>
    <?php } ?>
    <?php } else if(is_search()){ ?>
    <h3>
        <?php printf(__( '%s 的搜索结果' , 'salong' ),  get_search_query()); ?>
    </h3>
    <?php salong_breadcrumbs(); ?>
    <?php } ?>
    <?php if(is_singular( 'video')){ ?>
    <?php $terms=get_the_terms( $post->ID , 'video-cat' ); ?>
    <?php } else if(is_singular( 'gallery')){ ?>
    <?php $terms=get_the_terms( $post->ID , 'gallery-cat' ); ?>
    <?php } else if(is_singular( 'product')){ ?>
    <?php $terms=get_the_terms( $post->ID , 'product_cat' ); ?>
    <?php } else { ?>
    <?php $terms=get_the_category(); ?>
    <?php } ?>
    <?php if(is_single()){ ?>
    <h3>
        <?php echo $terms[0]->name; ?>
    </h3>
    <?php salong_breadcrumbs(); ?>
    <?php } ?>
    <!--移动端显示分类选择 js 代码-->
    <?php if(wp_is_mobile()){ ?>
    <script type="text/javascript">
		<!--
		var dropdown = document.getElementById("cat");
		function onCatChange() {
            if ( dropdown.options[dropdown.selectedIndex].value != '-1' ) {
                <?php if(is_page_template( 'template-gallery.php' ) || is_tax( 'gallery-cat') || is_tax( 'gallery-tag')){ ?>
                location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?gallery-cat="+dropdown.options[dropdown.selectedIndex].value;
                <?php }else if(is_page_template( 'template-video.php' ) || is_tax( 'video-cat') || is_tax( 'video-tag')){ ?>
                location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?video-cat="+dropdown.options[dropdown.selectedIndex].value;
                <?php }else{ ?>
                location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?cat="+dropdown.options[dropdown.selectedIndex].value;
                <?php } ?>
            }
		}
		dropdown.onchange = onCatChange;
		-->
	</script>
    <?php } ?>
</section>
