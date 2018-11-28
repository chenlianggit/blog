<?php

//移除 admin bar
if( cs_get_option('display_adminbar') ){
	add_filter( 'show_admin_bar', '__return_false' );
}

//移除 WP_Head 无关紧要的代码
if( cs_get_option('remove_head_links') ){
	remove_action('wp_head', 'wp_generator'); //删除 head 中的 WP 版本号
	foreach (array('rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header', 'atom_head', 'comments_atom_head', 'opml_head', 'app_head') as $action) {
	    remove_action($action, 'the_generator');
	}

	remove_action('wp_head', 'rsd_link'); //删除 head 中的 RSD LINK
	remove_action('wp_head', 'wlwmanifest_link'); //删除 head 中的 Windows Live Writer 的适配器？

	remove_action('wp_head', 'feed_links_extra', 3); //删除 head 中的 Feed 相关的link
	//remove_action( 'wp_head', 'feed_links', 2 );

	remove_action('wp_head', 'index_rel_link'); //删除 head 中首页，上级，开始，相连的日志链接
	remove_action('wp_head', 'parent_post_rel_link', 10);
	remove_action('wp_head', 'start_post_rel_link', 10);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); //删除 head 中的 shortlink

	remove_action('wp_head', 'rest_output_link_wp_head', 10); // 删除头部输出 WP RSET API 地址

	remove_action('template_redirect', 'wp_shortlink_header', 11); //禁止短链接 Header 标签。
	remove_action('template_redirect', 'rest_output_link_header', 11); // 禁止输出 Header Link 标签。
}

//前台不加载语言包
if (cs_get_option('locale')) {
    global $nice_locale;
    $nice_locale = get_locale();

    add_filter('language_attributes', 'nice_language_attributes');
    function nice_language_attributes($language_attributes)
    {
        global $nice_locale;

        if (function_exists('is_rtl') && is_rtl()) {
            $attributes[] = 'dir="rtl"';
        }

        if ($nice_locale) {
            if (get_option('html_type') == 'text/html') {
                $attributes[] = "lang=\"$nice_locale\"";
            }

            if (get_option('html_type') != 'text/html') {
                $attributes[] = "xml:lang=\"$nice_locale\"";
            }
        }

        $output = implode(' ', $attributes);

        return $output;
    }

    add_filter('locale', 'nice_locale');
}

function nice_locale($locale)
{
    $locale = (is_admin()) ? $locale : 'en_US';

    return $locale;
}


//禁用日志修订功能
if (cs_get_option('diable_revision')) {
    // define('WP_POST_REVISIONS', false);
    remove_action('pre_post_update', 'wp_save_post_revision');

    // 自动保存设置为10个小时
    // define('AUTOSAVE_INTERVAL', 36000);
}

if (cs_get_option('disable_trackbacks')) {
    //彻底关闭 pingback
    add_filter('xmlrpc_methods', 'nice_xmlrpc_methods');
    function nice_xmlrpc_methods($methods)
    {
        $methods['pingback.ping']                    = '__return_false';
        $methods['pingback.extensions.getPingbacks'] = '__return_false';

        return $methods;
    }

    //禁用 pingbacks, enclosures, trackbacks
    remove_action('do_pings', 'do_all_pings', 10);

    //去掉 _encloseme 和 do_ping 操作。
    remove_action('publish_post', '_publish_post_hook', 5);
}


//禁用 XML-RPC 接口
if (cs_get_option('disable_xml_rpc')) {
    add_filter('xmlrpc_enabled', '__return_false');
    remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
}

// 屏蔽 REST API
if (cs_get_option('disable_rest_api')) {
    remove_action('init', 'rest_api_init');
    remove_action('rest_api_init', 'rest_api_default_filters', 10);
    remove_action('parse_request', 'rest_api_loaded');

    add_filter('rest_enabled', '__return_false');
    add_filter('rest_jsonp_enabled', '__return_false');

    // 移除头部 wp-json 标签和 HTTP header 中的 link
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11);
}

//禁用 Auto OEmbed
if (cs_get_option('disable_autoembed')) {
    //remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'run_shortcode' ), 8 );
    remove_filter('the_content', array($GLOBALS['wp_embed'], 'autoembed'), 8);
    //remove_action( 'pre_post_update', array( $GLOBALS['wp_embed'], 'delete_oembed_caches' ) );
    //remove_action( 'edit_form_advanced', array( $GLOBALS['wp_embed'], 'maybe_run_ajax_cache' ) );
}

if (cs_get_option('disable_post_embed')) {
    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);

    add_filter('embed_oembed_discover', '__return_false');

    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_filter('oembed_response_data', 'get_oembed_response_data_rich', 10, 4);

    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');

    add_filter('tiny_mce_plugins', 'nice_disable_post_embed_tiny_mce_plugin');
    function nice_disable_post_embed_tiny_mce_plugin($plugins)
    {
        return array_diff($plugins, array('wpembed'));
    }

    add_filter('query_vars', 'nice_nice_disable_post_embed_query_var');
    function nice_nice_disable_post_embed_query_var($public_query_vars)
    {
        return array_diff($public_query_vars, array('embed'));
    }
}

//阻止非法访问
add_action('init', 'nice_block_bad_queries');
function nice_block_bad_queries()
{
    if (is_admin()) {
        return;
    }
    //if(strlen($_SERVER['REQUEST_URI']) > 255 ||
    if (
        strpos($_SERVER['REQUEST_URI'], "eval(") ||
        strpos($_SERVER['REQUEST_URI'], "base64") ||
        strpos($_SERVER['REQUEST_URI'], "/**/")
    ) {
        @header("HTTP/1.1 414 Request-URI Too Long");
        @header("Status: 414 Request-URI Too Long");
        @header("Connection: Close");
        @exit;
    }
}

//删除中文包中的一些无用代码
add_action('init', 'nice_remove_zh_ch_functions');
function nice_remove_zh_ch_functions()
{
    remove_action('admin_init', 'zh_cn_l10n_legacy_option_cleanup');
    remove_action('admin_init', 'zh_cn_l10n_settings_init');
    wp_embed_unregister_handler('tudou');
    wp_embed_unregister_handler('youku');
    wp_embed_unregister_handler('56com');
}

//当搜索结果只有一篇时直接重定向到日志
add_action('template_redirect', 'nice_redirect_single_post');
function nice_redirect_single_post()
{
    if (is_search() && get_query_var('module') == '') {
        global $wp_query;
        $paged = get_query_var('paged');
        if (1 == $wp_query->post_count && empty($paged)) {
            wp_redirect(get_permalink($wp_query->posts['0']->ID));
        }
    }
}