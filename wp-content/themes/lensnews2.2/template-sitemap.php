<?php
/*
Template Name: Sitemap
*/
global $salong; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Sitemap -
        <?php echo bloginfo( 'name'); ?>
    </title>
    <meta name="keywords" content="SiteMap,<?php bloginfo( 'name'); ?>,网站地图" />
    <meta name="generator" content="萨龙龙 SiteMap Generator" />
    <meta name="author" content="萨龙龙" />
    <meta name="copyright" content="<?php echo get_home_url(); ?>" />
    <style type="text/css">
        /** 全局设置 **/
        
        @charset "utf-8";
        html,
        body,
        header,
        nav,
        section,
        h1,
        h2,
        h3,
        h4,
        ul {
            margin: 0;
            padding: 0;
            border: 0;
            background: transparent;
        }
        
        h1,
        h2,
        h3,
        h4 {
            line-height: 24px;
            font-weight: normal;
            color: #333;
            text-rendering: optimizelegibility;
        }
        
        h1 {
            font-size: 24px;
        }
        
        h2 {
            font-size: 18px;
        }
        
        h3 {
            font-size: 16px;
        }
        
        h4 {
            font-size: 15px;
        }
        
        header,
        section,
        footer,
        nav {
            display: block;
        }
        
        a {
            color: #666;
        }
        
        a:hover,
        a:active {
            outline: 0;
            color: #cf2079;
        }
        
        a,
        a:hover {
            text-decoration: none;
        }
        
        a {
            -moz-transition: ease-in-out 0.5s;
            -webkit-transition: ease-in-out 0.5s;
            -o-transition: ease-in-out 0.5s;
            -ms-transition: ease-in-out 0.5s;
            transition: ease-in-out 0.5s;
        }
        
        body {
            background-color: #fff;
            font: 13px Verdana, 微软雅黑, Geneva, sans-serif;
            overflow-x: hidden;
            overflow-y: scroll;
            line-height: 24px;
            color: #666;
        }
        /***************网站地图**************/
        
        .sitemap {
            background-color: #f8f8f8;
            width: 96%;
            margin: 20px auto 0;
        }
        
        .sitemap > header,
        .sitemap > nav,
        .sitemap > section,
        .sitemap > footer {
            background-color: #fff;
            border: 1px #eee solid;
            margin-bottom: 20px;
            padding: 20px;
        }
        /********标题********/
        
        .sitemap h1 {
            text-align: center;
        }
        
        .sitemap h3 {
            margin-bottom: 12px;
            border-bottom: 1px #eee solid;
            padding-bottom: 12px;
        }
        /********标题end********/
        /********列表********/
        
        .sitemap ul {
            margin-left: 18px;
        }
        
        .sitemap ul li {
            margin: 12px 0;
            padding-bottom: 8px;
            font-size: 12px;
            color: #999;
            border-bottom: 1px #eee dashed;
        }
        
        .sitemap ul li a {
            font-size: 13px;
        }
        
        .sitemap ul li time {
            float: right;
            color: #bbb;
        }
        /********列表end********/
        /********标签********/
        
        .sitemap .tag {
            text-align: justify;
        }
        
        .sitemap .tag a {
            display: inline-block;
            margin: 0 4px;
        }
        
        .sitemap .tag a span {
            margin-left: 4px;
            color: #999;
            font-size: 12px;
        }
        /********标签end********/
        /********页脚********/
        
        footer {
            text-align: center;
            line-height: 28px;
        }
        /********页脚end********/
        /********响应式********/
        
        @media only screen and (max-width: 480px) {
            .sitemap {
                width: 98%;
            }
            .sitemap > header,
            .sitemap > nav,
            .sitemap > section,
            .sitemap > footer {
                padding: 12px 8px;
            }
            .sitemap ul {
                margin-left: 0;
                list-style: none;
            }
            .sitemap ul li {
                list-style-type: none;
            }
            .sitemap .single ul li a {
                width: 100%;
                display: block;
                overflow: hidden;
                -ms-text-overflow: ellipsis;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .sitemap ul li time {
                display: none;
            }
        }
        /********响应式end********/
    </style>
</head>
<?php flush(); ?>
<?php global $salong; $sitemap_post_count = $salong['sitemap_post_count']; $sitemap_tag_count = $salong['sitemap_tag_count']; ?>

<body class="sitemap">
    <header>
        <h1><?php echo sprintf(__('%s的站点地图','salong'),bloginfo( 'name')); ?></h1>
    </header>
    <!--导航-->
    <nav>
        <a href="<?php echo get_home_url(); ?>">
            <?php echo bloginfo( 'name'); ?>
        </a> &raquo; SiteMap</nav>
    <!--文章-->
    <section class="list single">
        <h3><?php _e('文章','salong'); ?></h3>
        <ul>
            <?php $args=array( 'post_type'=> 'post','ignore_sticky_posts' => 1,'posts_per_page'=>$sitemap_post_count );$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank">
                    <?php the_title(); ?>
                </a>
                <time>
                    <?php the_time( 'Y-m-d') ?>
                </time>
            </li>
            <?php endwhile;endif; ?>
        </ul>
    </section>
    <?php if (in_array( 'gallery', $salong[ 'switch_post_type'])) { ?>
    <!--画廊-->
    <section class="list single">
        <h3><?php _e('画廊','salong'); ?></h3>
        <ul>
            <?php $args=array( 'post_type'=> 'gallery','ignore_sticky_posts' => 1,'posts_per_page'=>$sitemap_post_count );$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank">
                    <?php the_title(); ?>
                </a>
                <time>
                    <?php the_time( 'Y-m-d') ?>
                </time>
            </li>
            <?php endwhile;endif; ?>
        </ul>
    </section>
    <?php } if (in_array( 'video', $salong[ 'switch_post_type'])) { ?>
    <!--视频-->
    <section class="list single">
        <h3><?php _e('视频','salong'); ?></h3>
        <ul>
            <?php $args=array( 'post_type'=> 'video','ignore_sticky_posts' => 1,'posts_per_page'=>$sitemap_post_count );$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank">
                    <?php the_title(); ?>
                </a>
                <time>
                    <?php the_time( 'Y-m-d') ?>
                </time>
            </li>
            <?php endwhile;endif; ?>
        </ul>
    </section>
    <?php } if (class_exists('woocommerce')) { ?>
    <!--产品-->
    <section class="list single">
        <h3><?php _e('产品','salong'); ?></h3>
        <ul>
            <?php $args=array( 'post_type'=> 'product','ignore_sticky_posts' => 1,'posts_per_page'=>$sitemap_post_count );$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank">
                    <?php the_title(); ?>
                </a>
                <time>
                    <?php the_time( 'Y-m-d') ?>
                </time>
            </li>
            <?php endwhile;endif; ?>
        </ul>
    </section>
    <?php } if (in_array( 'bulletin', $salong[ 'switch_post_type'])) { ?>
    <!--公告-->
    <section class="list single">
        <h3><?php _e('公告','salong'); ?></h3>
        <ul>
            <?php $args=array( 'post_type'=> 'bulletin','ignore_sticky_posts' => 1,'posts_per_page'=>$sitemap_post_count );$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank">
                    <?php the_title(); ?>
                </a>
                <time>
                    <?php the_time( 'Y-m-d') ?>
                </time>
            </li>
            <?php endwhile;endif; ?>
        </ul>
    </section>
    <?php } ?>
    <!--文章分类目录-->
    <section class="list">
        <h3><?php _e('文章分类目录','salong'); ?></h3>
        <ul>
            <?php $blog_args=array( 'taxonomy'=>'category','hierarchical'=> 0,'show_count'=> 1,'orderby'=>'ID','order'=>'DESC','title_li'=>''); echo wp_list_categories( $blog_args );?>
        </ul>
    </section>
    <?php if (in_array( 'gallery', $salong[ 'switch_post_type'])) { ?>
    <!--画廊分类目录-->
    <section class="list">
        <h3><?php _e('画廊分类目录','salong'); ?></h3>
        <ul>
            <?php $blog_args=array( 'taxonomy'=>'gallery-cat','hierarchical'=> 0,'show_count'=> 1,'orderby'=>'ID','order'=>'DESC','title_li'=>''); echo wp_list_categories( $blog_args );?>
        </ul>
    </section>
    <?php } if (in_array( 'video', $salong[ 'switch_post_type'])) { ?>
    <!--视频分类目录-->
    <section class="list">
        <h3><?php _e('视频分类目录','salong'); ?></h3>
        <ul>
            <?php $blog_args=array( 'taxonomy'=>'video-cat','hierarchical'=> 0,'show_count'=> 1,'orderby'=>'ID','order'=>'DESC','title_li'=>''); echo wp_list_categories( $blog_args );?>
        </ul>
    </section>
    <?php } if (class_exists('woocommerce')) { ?>
    <!--产品分类目录-->
    <section class="list">
        <h3><?php _e('产品分类目录','salong'); ?></h3>
        <ul>
            <?php $blog_args=array( 'taxonomy'=>'product_cat','hierarchical'=> 0,'show_count'=> 1,'orderby'=>'ID','order'=>'DESC','title_li'=>''); echo wp_list_categories( $blog_args );?>
        </ul>
    </section>
    <?php } ?>
    <!--页面-->
    <section class="list">
        <h3><?php _e('页面','salong'); ?></h3>
        <ul>
            <?php $args=array( 'post_type'=> 'page','ignore_sticky_posts' => 1,'posts_per_page'=>-1 );$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank">
                    <?php the_title(); ?>
                </a>
            </li>
            <?php endwhile;endif; ?>
        </ul>
    </section>
    <?php $post_args=array( 'order'=> 'DESC', 'taxonomy' => 'post_tag', 'orderby' => 'count', 'number' => $sitemap_tag_count ); $post_tags_list = get_terms($post_args); if ($post_tags_list) { ?>
    <!--文章标签-->
    <section class="tag">
        <h3><?php _e('文章标签','salong'); ?></h3>
        <?php foreach($post_tags_list as $tag) { ?>
        <a href="<?php echo get_tag_link($tag); ?>" title="<?php printf( __( '标签 %s 下有 %s 篇文章' , 'salong' ), esc_attr($tag->name), esc_attr($tag->count) ); ?>" target="_blank">
            <?php echo $tag->name; ?><span>(<?php echo $tag->count; ?>)</span></a>
        <?php } ?>
    </section>
    <?php } $gallery_args=array( 'order'=> 'DESC', 'taxonomy' => 'gallery-tag', 'orderby' => 'count', 'number' => $sitemap_tag_count ); $gallery_tags_list = get_terms($gallery_args);if (in_array( 'gallery', $salong[ 'switch_post_type']) && $gallery_tags_list) { ?>
    <!--画廊标签-->
    <section class="tag">
        <h3><?php _e('画廊标签','salong'); ?></h3>
        <?php foreach($gallery_tags_list as $tag) { ?>
        <a href="<?php echo get_tag_link($tag); ?>" title="<?php printf( __( '标签 %s 下有 %s 篇画廊' , 'salong' ), esc_attr($tag->name), esc_attr($tag->count) ); ?>" target="_blank">
            <?php echo $tag->name; ?><span>(<?php echo $tag->count; ?>)</span></a>
        <?php } ?>
    </section>
    <?php } $video_args=array( 'order'=> 'DESC', 'taxonomy' => 'video-tag', 'orderby' => 'count', 'number' => $sitemap_tag_count ); $video_tags_list = get_terms($video_args);if (in_array( 'video', $salong[ 'switch_post_type']) && $video_tags_list) { ?>
    <!--视频标签-->
    <section class="tag">
        <h3><?php _e('视频标签','salong'); ?></h3>
        <?php foreach($video_tags_list as $tag) { ?>
        <a href="<?php echo get_tag_link($tag); ?>" title="<?php printf( __( '标签 %s 下有 %s 篇视频' , 'salong' ), esc_attr($tag->name), esc_attr($tag->count) ); ?>" target="_blank">
            <?php echo $tag->name; ?><span>(<?php echo $tag->count; ?>)</span></a>
        <?php } ?>
    </section>
    <?php } $product_args=array( 'order'=> 'DESC', 'taxonomy' => 'product_tag', 'orderby' => 'count', 'number' => $sitemap_tag_count ); $product_tags_list = get_terms($product_args);if (class_exists('woocommerce') && $product_tags_list) { ?>
    <!--产品标签-->
    <section class="tag">
        <h3><?php _e('产品标签','salong'); ?></h3>
        <?php foreach($product_tags_list as $tag) { ?>
        <a href="<?php echo get_tag_link($tag); ?>" title="<?php printf( __( '标签 %s 下有 %s 篇产品' , 'salong' ), esc_attr($tag->name), esc_attr($tag->count) ); ?>" target="_blank">
            <?php echo $tag->name; ?><span>(<?php echo $tag->count; ?>)</span></a>
        <?php } ?>
    </section>
    <?php } ?>
    <footer>
        <?php echo sprintf( __( '查看站点首页: <a href="%s">%s</a>' , 'salong' ), esc_attr(get_bloginfo( 'url')), esc_attr(get_bloginfo( 'name'))); ?>
        <br>
        <?php echo $salong[ 'copyright_text']; ?>
        <?php if (class_exists( 'GoogleSitemapGeneratorLoader' )){ ?>.
        <a href="<?php echo get_home_url(); ?>/sitemap.xml">
            <?php _e( 'XML SiteMap', 'salong' ); ?>
        </a>
        <?php } ?>
        <br>
        Powered by&nbsp;<a href="https://yfdxs.com">萨龙龙</a>&nbsp;XML SiteMap Generator&nbsp;
        <?php _e( '最后更新：', 'salong'); ?>
        <?php $last=$wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-m-d G:i:s', strtotime($last[0]->MAX_m));echo $last; ?>
    </footer>
</body>

</html>