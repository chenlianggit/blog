<?php global $salong; ?>

<section class="new wrapper scroll4">
    <section class="cat-wrap<?php if(!wp_is_mobile()) { ?> left<?php } ?>">
        <section class="box<?php triangle();wow(); ?>">
            <!--标题-->
            <section class="home_title">
                <h3 class="left"><?php echo $salong['new_title']; ?></h3>
                <?php if($salong[ 'new_tag']) { ?>
                <section class="title-tag right">
                    <ul>
                        <?php $hometagsorderby=$salong[ 'home_tag_orderby']; $hometagsorder=$salong[ 'home_tag_order']; $newtag=implode( ',',$salong[ 'new_tag']); $args=array( 'include'=> $newtag,'orderby'=>$hometagsorderby, 'order'=>$hometagsorder);$tags = get_tags($args);foreach ($tags as $tag) { ?>
                        <li>
                            <a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php _e( '查看'); ?> <?php echo $tag->name;?> <?php _e( '标签下的文章'); ?>">
                                <?php echo $tag->name; ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php if ($salong[ 'new_link']) { ?>
                    <a href="<?php $new_link = $salong['new_link']; ?><?php echo get_page_link($new_link); ?>" class="home_button" title="<?php _e( '查看更多', 'salong' ); ?>"><i class="icon-plus-circled"></i></a>
                    <?php } ?>
                </section>
                <?php } ?>
            </section>
            <!--标题end-->
            <section class="new_list">
                <ul class="layout_ul ajaxposts">
                    <?php $exclude_new_cat=$salong[ 'exclude_new_cat']; $paged=( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;$args=array( 'post_type'=> 'post','ignore_sticky_posts' => 1,'category__not_in'=> $exclude_new_cat,'paged' => $paged ); $wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
                    <li class="layout_li ajaxpost<?php wow(); ?>">
                        <?php get_template_part( 'content/list', 'post'); ?>
                    </li>
                    <?php endwhile;endif; ?>
                    <!-- 分页 -->
                    <?php posts_pagination(); ?>
                    <?php wp_reset_query(); ?>
                </ul>
            </section>
        </section>
    </section>
    <!--边栏-->
    <?php if(!wp_is_mobile()) { ?>
    <?php if(is_active_sidebar('sidebar-4')) { ?>
    <aside class="sidebar right">
        <section class="cat4_sidebar">
            <?php dynamic_sidebar( __( '首页最新文章', 'salong') ); ?>
        </section>
        <?php if(wp_is_mobile()){ $mb=0;} else { $mb=32;} ?>
        <script>
            // 边栏随窗口移动
            $(function () {
                if ($(".cat4_sidebar").length > 0) {
                    $('.cat4_sidebar').scrollChaser({
                        wrapper: '.scroll4',
                        offsetTop: 40
                    });
                }
            });
        </script>
    </aside>
    <!--边栏end-->
    <div class="sf4"></div>
    <?php } else { ?>
    <aside class="sidebar right"><article class="sidebar_widget widget_salong_init box<?php triangle();wow(); ?>"><div class="sidebar_title"><h3><?php _e('温馨提示','salong'); ?></h3></div><div class="init"><a href="<?php echo get_home_url(); ?>/wp-admin/widgets.php"><?php _e('请到后台外观——小工具中添加小工具到<br><strong>首页最新文章</strong>边栏中。','salong'); ?></a></div></article></aside>
    <?php } } ?>
</section>