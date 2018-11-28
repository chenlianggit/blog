<?php get_header(); ?>
<?php global $salong;
$appkey       = $salong['appkey'];
$client_id    = $salong['client_id'];
$youku_player = $salong['switch_youku_player'];
$youku_id     = get_post_meta($post->ID, "youku_id", true);
$video_url    = get_post_meta($post->ID, "video_url", true);
$video_img    = get_post_meta($post->ID, "video_img", true);
$video_height = get_post_meta($post->ID, "video_height", true);
?>
<section class="container wrapper">
    <?php get_template_part( 'content/content', 'crumbs'); ?>
    <?php if ( have_posts() ) { ?>
    <!--视频-->
    <section class="video_top<?php wow(); ?>">
        <div id="videojj" style="height:<?php echo $video_height; ?>px"></div>
        <?php if ($youku_player && $youku_id) { ?>
        <script type="text/javascript" src="//player.youku.com/jsapi"></script>
        <script type="text/javascript">
            player = new YKU.Player('videojj', {
                styleid: '0',
                client_id: '<?php echo $client_id; ?>',
                vid: '<?php echo $youku_id; ?>',
                newPlayer: true,
                show_related: false,
                wmode: 'opaque'
            });

        </script>
        <?php }else{ ?>
        <script type="text/javascript" src="//cytroncdn.videojj.com/latest/Iva.js"></script>
        <script type="text/javascript">
            var ivaInstance = new Iva(
                'videojj', //父容器id
                {
                    appkey: '<?php echo $appkey; ?>', //必填，请在控制台查看应用标识
                    <?php if ($youku_id) { ?>
                    video: 'http://v.youku.com/v_show/id_<?php echo $youku_id; ?>==.html',
                    <?php } else { ?>
                    video: '<?php echo $video_url; ?>',
                    <?php } ?>
                    title: '<?php the_title(); ?>', //选填，建议填写方便后台数据统计
                    cover: '<?php echo $video_img; ?>', //选填，视频封面url
                    vnewsEnable: false, //是否开启新闻推送功能，默认为true
                    <?php if($salong['switch_autoplay']){ ?>
                    autoplay: true, //选填，是否自动播放，默认为false
                    <?php } if($salong['switch_autoFormat']){ ?>
                    autoFormat: true, //选填，是否自动选择最高清晰度，默>认为false
                    <?php } ?>
                    rightHand: false, //选填，是否开启右键菜单，默认为false
                    bubble: false, //选填，是否开启云泡功能，默认为true
                    tagTrack: false, //选填，云链是否跟踪，默认为false
                    tagShow: false, //选填，云链是否显示，默认为false
                    editorEnable: false, // 选填，当用户登录之后，是否允许加载编辑器，默认为true
                    vorEnable: false, // 选填，是否允许加载灵悟，默认为true
                    vorStartGuideEnable: false //选填， 是否启用灵悟新人引导，默认为true
                }
            );

        </script>
        <?php } ?>
    </section>
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
            <?php if($salong[ 'switch_vsocial']) { get_template_part( 'content/post', 'social'); } ?>
        </article>
        <?php get_template_part( 'content/video', 'info'); ?>
        <?php if($salong[ 'switch_vprevnext']) { get_template_part( 'content/single', 'prevnext'); } ?>
        <!-- 版权 -->
        <?php get_template_part( 'content/single', 'copyright'); ?>
    </section>
    <?php } ?>
    <!-- 作者 -->
    <?php if($salong[ 'switch_vauthor']) { get_template_part( 'content/single', 'author'); } ?>
    <!-- 相关文章 -->
    <?php if($salong[ 'switch_vrelated']) { get_template_part( 'content/video', 'related'); } ?>
    <!-- 画廊列表 -->
    <?php if($salong[ 'switch_vhotlike']) { get_template_part( 'content/video', 'hotlike'); } ?>
    <!-- 评论 -->
    <?php if (in_array( 'video', $salong[ 'switch_comment'])) { comments_template(); } ?>
</section>
<?php get_footer(); ?>
