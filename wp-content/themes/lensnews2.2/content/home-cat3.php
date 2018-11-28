<?php global $salong;
$hometagsorderby=$salong[ 'home_tag_orderby'];
$hometagsorder=$salong[ 'home_tag_order'];

/*分类列表1*/
$cat_tax_name1 = $salong['cat3_taxonomy_name1'];
if($cat_tax_name1 == 'post'){
    $post_type1 = 'post';
    $cat_tax1  = 'category';
    $tag_tax1  = 'post_tag';
    $category1  = $salong[ 'post_cat3_list1'];
    $tag1       = $salong[ 'post_cat3_tag1'];
}else if($cat_tax_name1 == 'gallery'){
    $post_type1 = 'gallery';
    $cat_tax1  = 'gallery-cat';
    $tag_tax1  = 'gallery-tag';
    $category1  = $salong[ 'gallery_cat3_list1'];
    $tag1       = $salong[ 'gallery_cat3_tag1'];
}else if($cat_tax_name1 == 'video'){
    $post_type1 = 'video';
    $cat_tax1  = 'video-cat';
    $tag_tax1  = 'video-tag';
    $category1  = $salong[ 'video_cat3_list1'];
    $tag1       = $salong[ 'video_cat3_tag1'];
}

/*分类列表2*/
$cat_tax_name2 = $salong['cat3_taxonomy_name2'];
if($cat_tax_name2 == 'post'){
    $post_type2 = 'post';
    $cat_tax2  = 'category';
    $tag_tax2  = 'post_tag';
    $category2  = $salong[ 'post_cat3_list2'];
    $tag2       = $salong[ 'post_cat3_tag2'];
}else if($cat_tax_name2 == 'gallery'){
    $post_type2 = 'gallery';
    $cat_tax2  = 'gallery-cat';
    $tag_tax2  = 'gallery-tag';
    $category2  = $salong[ 'gallery_cat3_list2'];
    $tag2       = $salong[ 'gallery_cat3_tag2'];
}else if($cat_tax_name2 == 'video'){
    $post_type2 = 'video';
    $cat_tax2  = 'video-cat';
    $tag_tax2  = 'video-tag';
    $category2  = $salong[ 'video_cat3_list2'];
    $tag2       = $salong[ 'video_cat3_tag2'];
}

?>
<?php if ($category1 || $category2){ ?>
<section class="cat wrapper scroll3">
    <section class="cat-wrap<?php if(!wp_is_mobile()) { ?> left<?php } ?>">
        <!--分类列表1-->
        <?php if ($category1){
        foreach ($category1 as $cat1list1) {?>
        <section class="box<?php triangle();wow(); ?>">
            <!--标题-->
            <section class="home_title">
                <h3 class="left"><?php $get_category = get_terms(array('include'=>$cat1list1,'taxonomy'=>$cat_tax1)); echo $get_category[0]->name;?></h3>
                <?php if($tag1) { ?>
                <section class="title-tag right">
                    <ul>
                        <?php $cat1tag1=implode( ',',$tag1); $args=array( 'include'=> $cat1tag1,'taxonomy'=>$tag_tax1,'orderby'=>$hometagsorderby, 'order'=>$hometagsorder);$tags = get_terms($args);foreach ($tags as $tag) { ?>
                        <li>
                            <a href="<?php echo get_term_link( $tag->term_id ); ?>" title="<?php _e( '查看','salong'); ?> <?php echo $tag->name;?> <?php _e( '标签下的文章','salong'); ?>">
                                <?php echo $tag->name; ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <a href="<?php echo get_term_link( (int)$cat1list1, $cat_tax1 );?>" class="home_button" title="<?php _e( '查看更多', 'salong' ); ?><?php echo get_cat_name($cat1list1);?>"><i class="icon-plus-circled"></i></a>
                </section>
                <?php } ?>
            </section>
            <!--标题end-->
            <section class="cat3_list1">
                <ul class="layout_ul">
                    <?php $cat1count1=$salong[ 'cat3_count1']; $args=array( 'post_type'=> $post_type1,'posts_per_page' => $cat1count1,'ignore_sticky_posts' => 1,'tax_query' => array( array( 'taxonomy' => $cat_tax1, 'field' => 'id', 'terms' => $cat1list1 ))); $wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : $count = 1; while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                    <li class="layout_li">
                        <?php get_template_part( 'content/post', 'grid'); ?>
                    </li>
                    <?php endwhile;endif; ?>
                    <?php wp_reset_query(); ?>
                </ul>
            </section>
        </section>
        <?php } ?>
        <?php } ?>
        <!--分类列表1-->
        <!--分类列表2-->
        <?php if ($category2){
        foreach ($category2 as $cat1list2) {?>
        <section class="box<?php triangle();wow(); ?>">
            <!--标题-->
            <section class="home_title">
                <h3 class="left"><?php $get_category = get_terms(array('include'=>$cat1list2,'taxonomy'=>$cat_tax2)); echo $get_category[0]->name;?></h3>
                <?php if($tag2) { ?>
                <section class="title-tag right">
                    <ul>
                        <?php $cat1tag2=implode( ',',$tag2); $args=array( 'include'=> $cat1tag2,'taxonomy'=>$tag_tax2,'orderby'=>$hometagsorderby, 'order'=>$hometagsorder);$tags = get_terms($args);foreach ($tags as $tag) { ?>
                        <li>
                            <a href="<?php echo get_term_link( $tag->term_id ); ?>" title="<?php _e( '查看','salong'); ?> <?php echo $tag->name;?> <?php _e( '标签下的文章','salong'); ?>">
                                <?php echo $tag->name; ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <a href="<?php echo get_term_link( (int)$cat1list2, $cat_tax2 );?>" class="home_button" title="<?php _e( '查看更多', 'salong' ); ?><?php echo get_cat_name($cat1list2);?>"><i class="icon-plus-circled"></i></a>
                </section>
                <?php } ?>
            </section>
            <!--标题end-->
            <section class="cat3_list2">
                <ul class="layout_ul">
                    <?php $cat1count2=$salong[ 'cat3_count2']; $args=array( 'post_type'=> $post_type2,'posts_per_page' => $cat1count2,'ignore_sticky_posts' => 1,'tax_query' => array( array( 'taxonomy' => $cat_tax2, 'field' => 'id', 'terms' => $cat1list2 ))); $wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : $count = 1; while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                    <li class="layout_li">
                        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
                    <?php endwhile;endif; ?>
                    <?php wp_reset_query(); ?>
                </ul>
            </section>
        </section>
        <?php } ?>
        <?php } ?>
        <!--分类列表2-->
        <!-- 广告 -->
        <?php ad_cat3(); ?>
    </section>
    <!--边栏-->
    <?php if(!wp_is_mobile()) { ?>
    <?php if(is_active_sidebar('sidebar-3')) { ?>
    <aside class="sidebar right">
        <section class="cat3_sidebar">
            <?php dynamic_sidebar( __( '首页分类模块3', 'salong') ); ?>
        </section>
        <?php if(wp_is_mobile()){ $mb=0;} else { $mb=32;} ?>
        <script>
            // 边栏随窗口移动
            $(function () {
                if ($(".cat3_sidebar").length > 0) {
                    $('.cat3_sidebar').scrollChaser({
                        wrapper: '.scroll3',
                        offsetTop: 40
                    });
                }
            });
        </script>
    </aside>
    <!--边栏end-->
    <div class="sf3"></div>
    <?php } else { ?>
    <aside class="sidebar right"><article class="sidebar_widget widget_salong_init box<?php triangle();wow(); ?>"><div class="sidebar_title"><h3><?php _e('温馨提示','salong'); ?></h3></div><div class="init"><a href="<?php echo get_home_url(); ?>/wp-admin/widgets.php"><?php _e('请到后台外观——小工具中添加小工具到<br><strong>首页分类模块3</strong>边栏中。','salong'); ?></a></div></article></aside>
    <?php } } ?>
</section>
<?php } ?>