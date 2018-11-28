<?php
class bigfa_widget3 extends WP_Widget {
    function __construct() {
        $widget_ops = array('description' => '列出站点最近的评论');
        parent::__construct('rencent_comments', '最新评论', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']);
        $email = strip_tags($instance['email']);
        echo $before_widget.$before_title.$title.$after_title;
        ?>
        <ul class="uk-list com">
            <?php
            $comments = get_comments(array(
                'number'=>5,
                'status'=>'approve',
                'author__not_in'=>1,
                'type' => 'comment',
            ));
            global $comment;
            foreach ($comments as $key => $comment) {

                $output .= '<li class="uk-clearfix">
                              <a href="' . get_comment_link() . '">' . get_avatar($comment->comment_author_email,36) . '
                              <div class="author">'  . $comment->comment_author . '</div>
                              <div class="content">' . $trimmed_content = wp_trim_words($comment->comment_content,28, '...') . '</div>
                              </a>
                            </li>';
            }
            echo $output;
            ?>
        </ul>

        <?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = strip_tags($new_instance['limit']);
        $instance['email'] = strip_tags($new_instance['email']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => '', 'email' => ''));
        $title = esc_attr($instance['title']);
        $limit = strip_tags($instance['limit']);
        $email = strip_tags($instance['email']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">显示数量：(最好5个以下) <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
        <?php
    }
}
add_action('widgets_init', 'bigfa_widget3_init');
function bigfa_widget3_init() {
    register_widget('bigfa_widget3');
}

class bigfa_widget6 extends WP_Widget {
    function __construct() {
        $widget_ops = array('description' => '配合主题样式，字体大小统一');
        parent::__construct('popular_tags', '标签云', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']);
        echo $before_widget.$before_title.$title.$after_title;
        ?>
        <div class="post-tags">
            <?php
            wp_tag_cloud( array(
                    'unit' => 'px',
                    'smallest' => 12,
                    'largest' => 12,
                    'number' => $limit,
                    'format' => 'flat',
                    'orderby' => 'count',
                    'order' => 'DESC'
                )
            );
            ?>
        </div>

        <?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = strip_tags($new_instance['limit']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => ''));
        $title = esc_attr($instance['title']);
        $limit = strip_tags($instance['limit']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">显示数量：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
        <?php
    }
}
add_action('widgets_init', 'bigfa_widget6_init');
function bigfa_widget6_init() {
    register_widget('bigfa_widget6');
}

add_action('widgets_init', function(){
return register_widget("qzhai_img");
});
class qzhai_img extends WP_Widget {
    function __construct() {
        parent::__construct('qzhai_img', '单图链接 ', array( 'description' => '单张图片链接'));
    }
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $src = $instance['src'];
        $url = $instance['url'];
        $title = $instance['title'];

        echo '<li class="adimg">';
        if($title != ''){
            echo '<h4>'.$title.'</h4>';
        }
            echo '<a href="'.$url.'" target="_blank" ><img src="'.$src.'"></a>';
        echo '</li>';


    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['src'] = $new_instance['src'];
        $instance['url'] = $new_instance['url'];
        return $instance;
    }
    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array(
            'title' => '',
            'src' => '',
            'url' => '',

            )
        );
        $title = $instance['title'];
        $src = $instance['src'];
        $url = $instance['url'];

?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题(可以为空)</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('src'); ?>">背景图片:</label><br />
            <input type="hidden" name="<?php echo $this->get_field_name('src'); ?>" id="<?php echo $this->get_field_id('src'); ?>" value="<?php echo $src; ?>" />
            <input class="button" onClick="bl_open_uploader(this, 'image_src')" id="bluth_image_upload" value="上传" />
        </p>
        <p class="image_src">
            <img src="<?php echo $src; ?>" style="width:100%;">
        </p>
        <hr style="background:#ddd;height: 1px;margin: 15px 0px;border:none;">
        <p>
            <label for="<?php echo $this->get_field_id('url'); ?>">链接:</label><br />
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo $url; ?>">
        </p>

<?php
    }
}
if(!function_exists('hrw_enqueue')){
    function hrw_enqueue()
    {
      wp_enqueue_media();
      wp_enqueue_script('hrw', get_template_directory_uri().'/js/admin-script.js', array('jquery'), null, true);
    }
    add_action('admin_enqueue_scripts', 'hrw_enqueue');
}
?>
