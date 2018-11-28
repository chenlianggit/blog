<?php
/*
Template Name: 我的帐户
*/ 
get_header(); ?>
<?php if ( have_posts() ){ ?>
<?php if(is_user_logged_in()){ ?>
<article class="crumbs-menu crumbs_shop">
    <h2><?php the_title(); ?></h2>
    <?php do_action( 'woocommerce_account_navigation' ); ?>
    <div class="bg"></div>
</article>
<?php } else { ?>
<article class="crumbs-normal crumbs_shop">
    <h2><?php _e( 'Login', 'woocommerce' ); ?></h2>
    <div class="bg"></div>
</article>
<?php } ?>
<!-- 主体内容 -->
<section class="container">
    <article class="wrapper">
       <?php while ( have_posts() ) : the_post(); ?><?php the_content(); ?><?php endwhile; ?>
    </article>
</section>
<!-- 主体内容end -->
<?php } ?>
<?php get_footer(); ?>