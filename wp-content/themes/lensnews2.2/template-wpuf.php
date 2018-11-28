<?php
/*
Template Name: 用户中心页面
*/
get_header();?>
           <?php get_template_part( 'content/center', 'header'); ?>
            <!-- 内容 -->
            <section class="wpuf-wrap box<?php triangle();wow(); ?>">
                <!-- 获取文章 -->
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <!-- 文章内容 -->
                <div class="content-post">
                    <?php the_content(); ?>
                </div>
                    <!-- 分页 -->
                    <?php endwhile; endif; ?>
            </section>
            <!-- 内容end -->
    </section>
</section>
<!-- 主体内容end -->
<?php get_footer(); ?>