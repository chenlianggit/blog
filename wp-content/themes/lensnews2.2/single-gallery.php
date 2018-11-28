<?php get_header(); ?>
<?php global $salong; ?>
<section class="container wrapper">
    <?php get_template_part( 'content/content', 'crumbs'); ?>
    <?php if ( have_posts() ) { ?>
    <?php if(get_post_meta($post->ID, "gallery_list", true)) { ?>
    <?php get_template_part( 'content/gallery', 'grid'); ?>
    <?php }else{ ?>
    <?php get_template_part( 'content/slides', 'gallery'); ?>
    <?php } ?>
    <section class="custompost box<?php triangle();wow(); ?>">
        <article class="entry">
            <?php while ( have_posts() ) : the_post(); ?>
            <!-- 标题与信息 -->
            <header class="post-head">
                <h2>
                    <?php the_title(); ?>
                </h2>
            </header>
            <!-- 文章内容 -->
            <div class="content-post">
                <?php the_content(); ?>
            </div>
            <?php endwhile; ?>
            <!-- 分页 -->
            <section class="pagination">
                <?php salong_link_pages(); ?>
            </section>
            <!-- 点赞按钮 -->
            <?php if($salong[ 'switch_gsocial']) { get_template_part( 'content/post', 'social'); } ?>
        </article>
        <?php get_template_part( 'content/gallery', 'info'); ?>
        <?php if($salong[ 'switch_gprevnext']) { get_template_part( 'content/single', 'prevnext'); } ?>
        <!-- 版权 -->
        <?php get_template_part( 'content/single', 'copyright'); ?>
    </section>
    <?php } ?>
    <!-- 作者 -->
    <?php if($salong[ 'switch_gauthor']) { get_template_part( 'content/single', 'author'); } ?>
    <!-- 相关文章 -->
    <?php if($salong[ 'switch_grelated']) { get_template_part( 'content/gallery', 'related'); } ?>
    <!-- 画廊列表 -->
    <?php if($salong[ 'switch_ghotlike']) { get_template_part( 'content/gallery', 'hotlike'); } ?>
    <!-- 评论 -->
    <?php if (in_array( 'gallery', $salong[ 'switch_comment'])) { comments_template(); } ?>
</section>
<?php get_footer(); ?>
