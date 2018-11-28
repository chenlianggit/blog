<?php
// 萨龙网络简码
// https://salongweb.com

add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');


// 一、图标框
////////////////////////////////////////////////////////////

//1.信息
function sl_infobox($atts, $content=null, $code="") {
  $return = '<div class="infobox">';
  $return .= $content;
  $return .= '</div>';
  return $return;
}
add_shortcode('infobox' , 'sl_infobox' );
//简码：[infobox]远方的雪山[/infobox]


//2.成功
function sl_successbox($atts, $content=null, $code="") {
  $return = '<div class="successbox">';
  $return .= $content;
  $return .= '</div>';
  return $return;
}
add_shortcode('successbox' , 'sl_successbox' );
//简码：[successbox]远方的雪山[/successbox]

//3.警告
function sl_warningbox($atts, $content=null, $code="") {
  $return = '<div class="warningbox">';
  $return .= $content;
  $return .= '</div>';
  return $return;
}
add_shortcode('warningbox' , 'sl_warningbox' );
//简码：[warningbox]远方的雪山[/warningbox]

//4.错误
function sl_errorbox($atts, $content=null, $code="") {
  $return = '<div class="errorbox">';
  $return .= $content;
  $return .= '</div>';
  return $return;
}
add_shortcode('errorbox' , 'sl_errorbox' );
//简码：[errorbox]远方的雪山[/errorbox]

// 二、按钮
////////////////////////////////////////////////////////////

function scbutton( $atts, $content = null ) {
    extract(shortcode_atts(array(
    'link'  => '#',
    'target'  => '',
    'variation' => '',
    'size'  => '',
    'align' => '',
    ), $atts));

  $style = ($variation) ? ' '.$variation : '';
  $align = ($align) ? ' align'.$align : '';
  $size = ($size == 'large') ? ' large_button' : '';
  $target = ($target == 'blank') ? 'target="_blank"' : '';

  $out = '<a '.$target.' class="scbutton '.$style.$size.$align.'" href="'.$link.'">'.do_shortcode($content).'</a>';

    return $out;
}
add_shortcode('scbutton', 'scbutton');
//简码：[scbutton link="http://salonglong.com" size="large" align="right"]远方的雪山[/scbutton ]


// 二、列表
////////////////////////////////////////////////////////////
//1.小红点
function sl_redlist($atts, $content = null) {
    return '<div class="redlist">'.$content.'</div>';
}
add_shortcode('ssredlist', 'sl_redlist');
//简码：[ssredlist]<ul> <li>列表内容1</li> <li>列表内容2</li> <li>列表内容3</li> </ul>[/ssredlist]

//2.小黄点
function sl_yellowlist($atts, $content = null) {
    return '<div class="yellowlist">'.$content.'</div>';
}
add_shortcode('ssyellowlist', 'sl_yellowlist');
//简码：[ssyellowlist]<ul> <li>列表内容1</li> <li>列表内容2</li> <li>列表内容3</li> </ul>[/ssyellowlist]

//3.小蓝点
function sl_bluelist($atts, $content = null) {
    return '<div class="bluelist">'.$content.'</div>';
}
add_shortcode('ssbluelist', 'sl_bluelist');
//简码：[ssbluelist]<ul> <li>列表内容1</li> <li>列表内容2</li> <li>列表内容3</li> </ul>[/ssbluelist]

//4.小绿点
function sl_greenlist($atts, $content = null) {
    return '<div class="greenlist">'.$content.'</div>';
}
add_shortcode('ssgreenlist', 'sl_greenlist');
//简码：[ssgreenlist]<ul> <li>列表内容1</li> <li>列表内容2</li> <li>列表内容3</li> </ul>[/ssgreenlist]

// 四、其它简码
////////////////////////////////////////////////////////////
//1.插入flash
function swf_player($atts, $content = null) {   
extract(shortcode_atts(array("width"=>'100%',"height"=>'450'),$atts));   
return '<embed type="application/x-shockwave-flash" class="flash" width="'.$width.'" height="'.$height.'" src="'.$content.'"></embed>';   
}  
add_shortcode('swf','swf_player');
//简码：[swf]Flash文件地址[/swf]

//1.开关盒
  add_shortcode('toggle_box', 'gdl_toggle_box_shortcode');
  function gdl_toggle_box_shortcode( $atts, $content = null ){
  
    $toggle_box = "<ul class='gdl-toggle-box'>";
    $toggle_box = $toggle_box . do_shortcode($content);
    $toggle_box = $toggle_box . "</ul>";
    return $toggle_box;
  }
  add_shortcode('toggle_item', 'gdl_toggle_item_shortcode');
  function gdl_toggle_item_shortcode( $atts, $content = null ){
  
    extract( shortcode_atts(array("title" => '', "active" => 'false'), $atts) );
    
    $active = ( $active == "true" )? " active": '';
    $toggle_item = "<li>";
    $toggle_item = $toggle_item . "<h2 class='toggle-box-head'>";
    $toggle_item = $toggle_item . "<i class='icon-toggle ".$active."'></i><span class='".$active."'>"; 
    $toggle_item = $toggle_item . $title . "</span></h2>";
    $toggle_item = $toggle_item . "<div class='toggle-box-content" . $active . "'>" . do_shortcode($content) . "</div>";
    $toggle_item = $toggle_item . "</li>";
  
  
    return $toggle_item;
  
  } 
//简码：[toggle_box][toggle_item title="标题" active="true"]内容[/toggle_item][toggle_item title="标题"]内容[/toggle_item][toggle_item title="标题"]内容[/toggle_item][toggle_item title="标题"]内容[/toggle_item][/toggle_box]

//2. Tabs
add_shortcode( 'tabgroup', 'sl_tab_group' );
function sl_tab_group( $atts, $content=null ){
$GLOBALS['tab_count'] = 0;
do_shortcode( $content );

if( is_array( $GLOBALS['tabs'] ) ){
foreach( $GLOBALS['tabs'] as $tab ){
$tabs[] = '<li><a href="#'.$tab['id'].'">'.$tab['title'].'</a></li>';
$panes[] = '<div id="'.$tab['id'].'">'.$tab['content'].'</div>';
}
$return = "\n".'<div id="tabwrap"><ul id="tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<div id="tab_content">'.implode( "\n", $panes ).'</div></div>'."\n";
}
return $return;
}

add_shortcode( 'tab', 'scd_tab' );
function scd_tab( $atts, $content=null ){
extract(shortcode_atts(array(
'title' => 'Tab %d',
'id' => ''
), $atts));

$x = $GLOBALS['tab_count'];
$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content, 'id' =>  $id );

$GLOBALS['tab_count']++;
}

//简码：[tabgroup][tab title="标题 1" id="1"]内容 1[/tab][tab title="标题 2" id="2"]内容 2[/tab] [tab title="标题 3" id="3"]内容 3[/tab][/tabgroup]

//3.短代码之评论可见
function reply_to_read($atts, $content=null) {
    extract(shortcode_atts(array("notice" => '<div class="warningbox">'.__('<span style="color:red; font-size=13px;">温馨提示：</span>此处内容需要<a href="#respond" title="评论本文">评论本文</a>后才能查看。','salong').'</div>'), $atts));
    $email = null;
    $user_ID = (int) wp_get_current_user()->ID;
    if ($user_ID > 0) {
        $email = get_userdata($user_ID)->user_email;
        //对博主直接显示内容
        $admin_email = get_bloginfo ( 'admin_email' ); //博主Email
        if ($email == $admin_email) {
            return $content;
        }
    } else if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {
        $email = str_replace('%40', '@', $_COOKIE['comment_author_email_' . COOKIEHASH]);
    } else {
        return $notice;
    }
    if (empty($email)) {
        return $notice;
    }
    global $wpdb;
    $post_id = get_the_ID();
    $query = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";
    if ($wpdb->get_results($query)) {
        return do_shortcode($content);
    } else {
        return $notice;
    }
}
add_shortcode('reply', 'reply_to_read'); 
//简码：[reply]评论后可见内容[/reply]或者[reply notice="自定义提醒回复内容"]自定义提醒回复内容[/reply]

//4.仅用户可以看到的内容
function sl_private_content($atts, $content = null) {
    if ( is_user_logged_in() ) {
        $items .= $content;
    }else{
        if ( class_exists( 'XH_Social' ) ){
            $login_url = '#login';
        }else{
            $login_url  = wp_login_url($_SERVER['REQUEST_URI']);//登录
        }
        $items .= sprintf('<div class="warningbox">'.__('当前内容只有登录了才能查看，如果您已经注册，<a href="%s" title="">请登录</a>。','salong').'</div>',$login_url);
    }
    return $items;
}
add_shortcode('private', 'sl_private_content');

//简码：[private]只有用户才能看到的内容[/private]


//5相关标签下的文章
function sl_related_posts( $atts ) {
    extract(shortcode_atts(array(
        'tagid' => '',
    ), $atts));
    $args=array(
        'include' => $tagid
    );
	$tags = get_tags($args);
	// 循环所有标签 
	foreach ($tags as $tag) {
		// 得到标签ID
        $tag_id = $tag->term_id; 
		// 得到标签下所有文章 
        $related .='<div class="related_tagposts">';
        $related .= '<h2>'.sprintf( __( '<a href="%s" title="查看“%s”标签的相关文章列表">“%s”的相关文章</a>' , 'salong' ), esc_attr(get_tag_link($tag)), esc_attr($tag->name), esc_attr($tag->name)).'</h2>';
        $related .='<ul>';
        $prefix_posts = new WP_Query(array('tag_id' => $tag_id,'order' => 'ASC'));if ($prefix_posts->have_posts()): while ($prefix_posts->have_posts()): $prefix_posts->the_post();
        $related .= '<li>';
        $related .= '<a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a>';
        $related .= '</li>';
        endwhile;endif;wp_reset_postdata();
        $related .= '</ul>';
        $related .= '</div>';
    }
    return $related;
}
add_shortcode('related_posts', 'sl_related_posts');
//简码：[related_posts tagid="5"]


//6.购买产品可见内容
function salong_buy_content($atts, $content = null) {
    global $current_user;
    extract(
        shortcode_atts(
            array(
                'product_id'  => ''
            ),
            $atts
        )
    );
    if ( salong_is_administrator() || wc_customer_bought_product( $current_user->email, $current_user->ID, $product_id ) ) {
        $items .= $content;
    }else{
        if ( is_user_logged_in() ) {
            $items .= sprintf('<div class="warningbox">'.__('当前内容只有购买了&nbsp;【%s】&nbsp;产品的用户才能查看，点击&nbsp;<a href="%s" target="_blank" title="前往购买">前往购买</a>。','salong').'</div>',get_the_title($product_id),get_permalink($product_id));
        }else{
            if ( class_exists( 'XH_Social' ) ){
                $login_url = '#login';
            }else{
                $login_url  = wp_login_url($_SERVER['REQUEST_URI']);//登录
            }
            $items .= sprintf('<div class="warningbox">'.__('当前内容只有购买了&nbsp;【%s】&nbsp;产品的用户才能查看，点击&nbsp;<a href="%s" target="_blank" title="前往购买">前往购买</a>，如果您已经购买，<a href="%s" title="">请登录</a>。','salong').'</div>',get_the_title($product_id),get_permalink($product_id),$login_url);
        }
    }
    return $items;
}
add_shortcode('buy', 'salong_buy_content');

//简码：[buy product_id="产品 ID"]购买产品才能查看的内容[/buy]
