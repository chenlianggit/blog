<?php get_header(); ?>
<?php global $salong; ?>
<section class="container wrapper">
    <?php get_template_part( 'content/content', 'crumbs'); ?>
    <section class="content<?php if(!wp_is_mobile() && !get_post_meta($post->ID, "no_sidebar", true)) { echo ' content_left'; } ?>">
        <section class="content-wrap">
            <article class="entry box<?php triangle();wow(); ?>">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <!-- 标题与信息 -->
                <header class="post-head">
                    <h2><?php the_title(); ?></h2>
                    <?php get_template_part( 'content/blog', 'info'); ?>
                </header>
                <!-- 广告 -->
                <?php ad_single(); ?>
                <!-- 文章内容 -->
                <div class="content-post">
                    <?php the_content(); ?>
                </div>
                <?php endwhile; endif; ?>
                <!-- 分页 -->
                <section class="pagination">
                    <?php salong_link_pages(); ?>
                </section>
                <!-- 按钮 -->
                <?php if($salong[ 'switch_social']) { get_template_part( 'content/post', 'social'); } ?>
                <!-- 版权 -->
                <?php get_template_part( 'content/single', 'copyright'); ?>
            </article>
            <!-- 作者 -->
            <?php if($salong[ 'switch_author']) { get_template_part( 'content/single', 'author'); } ?>
            <!-- 上下篇 -->
            <?php if($salong[ 'switch_prevnext']) { get_template_part( 'content/single', 'prevnext'); } ?>
            <!-- 相关文章 -->
            <?php if($salong[ 'switch_related']) { get_template_part( 'content/single', 'related'); } ?>
            <!-- 广告 -->
            <?php ad_related(); ?>
            <?php if($salong[ 'switch_hotlike']) { get_template_part( 'content/single', 'hotlike'); } ?>
            <?php if (in_array( 'post', $salong[ 'switch_comment'])) { comments_template(); } ?>
        </section>
        <!-- 博客边栏 -->
        <?php get_sidebar(); ?>
        <!-- 博客边栏end -->
    </section>
</section>
<?php get_footer(); ?>