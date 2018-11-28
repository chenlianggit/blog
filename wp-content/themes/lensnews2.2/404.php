<?php get_header(); ?>
<?php global $salong; ?>
<section class="container wrapper box">
    <article class="page404">
        <h2><?php echo $salong['404_title']; ?></h2>
        <p>
            <?php echo $salong['404_desc']; ?>
        </p>
        <?php if($salong['switch_404_search']) { ?>
        <article class="search">
            <h3><i class="icon-search-1"></i><?php _e( '按文章类型进行搜索', 'salong' ); ?></h3>
            <form method="get" class="search_form" action="<?php echo get_home_url(); ?>">
                <select name="post_type" class="search_type">
                    <option value="post">
                        <?php _e( '文章', 'salong' ); ?>
                    </option>
                    <?php if (in_array( 'gallery', $salong[ 'switch_post_type'])) { ?>
                    <option value="gallery">
                        <?php _e( '画廊', 'salong' ); ?>
                    </option>
                    <?php } if (in_array( 'video', $salong[ 'switch_post_type'])) { ?>
                    <option value="video">
                        <?php _e( '视频', 'salong' ); ?>
                    </option>
                    <?php } if (class_exists( 'woocommerce' )){ ?>
                    <option value="product">
                        <?php _e( '产品', 'salong' ); ?>
                    </option>
                    <?php } ?>
                </select>
                <input class="text_input" type="text" placeholder="<?php _e( '输入关键字…', 'salong' ); ?>" name="s" id="s" />
                <input type="submit" class="search_btn" id="searchsubmit" value="<?php _e( '搜索', 'salong' ); ?>" />
            </form>
        </article>
        <?php } ?>
    </article>
</section>
<?php get_footer(); ?>