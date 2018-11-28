<?php
/*
Template Name: 购物车与结算
*/ 
get_header(); ?>
<!-- 主体内容 -->
<article class="crumbs-normal crumbs_shop">
    <h2><?php the_title(); ?></h2>
    <div class="bg"></div>
</article>
<section class="container">
    <article class="wrapper">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
        <!-- 文章end -->
        <?php endwhile; endif; ?>
    </article>
</section>
<!-- 主体内容end -->
<?php get_footer(); ?>