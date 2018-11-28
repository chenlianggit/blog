<?php get_header(); global $salong; ?>
<article class="crumbs_page">
    <h2><?php the_title(); ?></h2>
    <div class="bg"></div>
</article>
<!-- 主体内容 -->
<section class="container wrapper">
    <!-- 内容 -->
    <!-- 获取文章 -->
    <article class="entry box<?php triangle();wow(); ?>">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="content-post">
            <?php the_content(); ?>
        </div>
        <!-- 文章end -->
        <?php endwhile; endif; ?>
        <!-- 获取文章end -->
    </article>
    <!-- 内容end -->
</section>
<!-- 主体内容end -->
<?php get_footer(); ?>