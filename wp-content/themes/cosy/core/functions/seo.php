<?php

add_theme_support( 'title-tag' );
add_filter( 'document_title_separator', 'filter_document_title_separator', 10, 1 ); 
add_filter( 'document_title_parts', 'filter_document_title_parts', 10, 1 );
add_action( 'wp_head', 'nice_seo_meta_action');

function filter_document_title_separator( $var ) { 
    $option_sep = cs_get_option('seo_sep');
    $var = isset( $option_sep ) ? $option_sep : $var;
    return $var;
}; 

function filter_document_title_parts( $title ) { 

	global $paged, $page, $post;

    if( is_home() || is_front_page() ){
		$title_home = cs_get_option('seo_home_title');
		$title['title'] = ( isset( $title_home ) && !empty( $title_home )) ? $title_home : get_bloginfo('name').' - '.get_bloginfo('description');
    }
    else if( is_single() || is_page() ){
    	$title['title'] = ( isset( $post_extend['seo_custom_title'] ) && !empty( $post_extend['seo_custom_title'] ) ) ? $post_extend['seo_custom_title'] : get_the_title( $post->ID );
    }
    else if( is_category() ){
    	$cat_id = get_query_var('cat');
    	$term_meta = get_term_meta( $cat_id, '_custom_category_options', true );
        $term_meta = wp_parse_args( (array) $term_meta, array( 
                'seo_custom_title' => '',
            ) 
        );
    	$title_category = $term_meta['seo_custom_title'];
    	$title['title'] = ( isset( $title_category ) && !empty( $title_category ) ) ? $title_category : get_cat_name( $cat_id );
    }
    else if(is_tag()){
    	$tag_id = get_query_var('tag_id');
    	$term_meta = get_term_meta( $tag_id, '_custom_category_options', true );
        $term_meta = wp_parse_args( (array) $term_meta, array( 
                'seo_custom_title' => '',
            ) 
        );
    	$title_tag = $term_meta['seo_custom_title'];
    	$title['title'] = ( isset( $title_tag ) && !empty( $title_tag ) ) ? $title_tag : single_tag_title( '', false );
    }
    else if( is_author() && ! is_post_type_archive() ){
        $author = get_queried_object();
        if ( $author ) {
            $title['title'] = $author->display_name;
        }
    }
    else if( is_tax('special') ){
        $queried_object = get_queried_object(); 
        $term_id = $queried_object->term_id;

        $term_meta = get_term_meta( $term_id, '_custom_special_options', true );
        $term_meta = wp_parse_args( (array) $term_meta, array( 
                'seo_custom_title' => '',
            ) 
        );
        $title_special= $term_meta['seo_custom_title'];
        $title['title'] = ( isset( $title_special ) && !empty( $title_special ) ) ? $title_special : $queried_object->name;
    }
	else if( is_search() ) {
        $title['title'] = "搜索结果：".get_query_var( 's' );
    }
    else if ( is_404() ) {
        $title['title'] = __( 'Page not found' );
    }

    return $title; 
};

function nice_seo_meta_action(){
    
    $pages=get_query_var('page');
    if( (is_single() || is_page()) && $pages<2 ){
        global $post;
        $post_extend = get_post_meta( get_the_ID(), 'post_extend', true );
        $post_desc_num = cs_get_option('seo_auto_des_num',120);
        $seo_auto_des = cs_get_option('seo_auto_des',true);
        $seo_auto_keywords = cs_get_option('seo_auto_keywords',true);

        $tag = '';
        $tags=get_the_tags();
        if( $tags ){
            foreach($tags as $val){
                $tag.=','.$val->name;
            }
        }
        $tag=ltrim($tag,',');
        $key_meta = isset($post_extend['seo_custom_keywords']) ? $post_extend['seo_custom_keywords'] : '';
        $des_meta = isset($post_extend['seo_custom_desc']) ? $post_extend['seo_custom_desc'] : '';

        $pt = preg_replace('/\s+/','',strip_tags($post->post_content));
        $excerpt = mb_strimwidth($pt,0,$post_desc_num, '', get_bloginfo( 'charset' ) );
        
        if( empty($key_meta) && $seo_auto_keywords && isset($tag) ) $keywords=$tag;
        else $keywords=$key_meta;

        if( empty($des_meta) && $seo_auto_keywords ) $description=$excerpt;
        else $description=$des_meta;

        if($keywords){  
            echo '<meta name="keywords" content="'.$keywords.'" />';
            echo "\n";
        }

        if($description){   
            echo '<meta name="description" content="'.esc_attr($description).'" />';
            echo "\n";
        }
    }
    
    if( (is_home() || is_front_page()) && !is_paged() ){
        
        $keywords = cs_get_option('seo_home_keywords');
        $description = cs_get_option('seo_home_desc');

        if($keywords){  
            echo '<meta name="keywords" content="'.$keywords.'" />';
            echo "\n";
        }
        if($description){
            echo '<meta name="description" content="'.esc_attr(stripslashes($description)).'" />';
            echo "\n";
        }   
    }
    
    if( ( is_category() || is_tag() ) && !is_paged()){

        $queried_object = get_queried_object(); 
        $term_id = $queried_object->term_id;

        $term_meta = get_term_meta( $term_id, '_custom_category_options', true );
        $term_meta = wp_parse_args( (array) $term_meta, array( 
                'seo_custom_keywords' => '',
                'seo_custom_desc'     => '',
            ) 
        );
        $keywords = $term_meta['seo_custom_keywords'];
        $description = $term_meta['seo_custom_desc'];

        if($keywords){
            echo '<meta name="keywords" content="'.$keywords.'" />';
            echo "\n";
        }
        if($description){
            echo '<meta name="description" content="'.esc_attr(stripslashes($description)).'" />';
            echo "\n";
        }
    }

    if(  is_tax('special') && !is_paged()){

        $queried_object = get_queried_object(); 
        $term_id = $queried_object->term_id;

        $term_meta = get_term_meta( $term_id, '_custom_special_options', true );
        $term_meta = wp_parse_args( (array) $term_meta, array( 
                'seo_custom_keywords' => '',
                'seo_custom_desc'     => '',
            ) 
        );
        $keywords = $term_meta['seo_custom_keywords'];
        $description = $term_meta['seo_custom_desc'];

        if($keywords){
            echo '<meta name="keywords" content="'.$keywords.'" />';
            echo "\n";
        }
        if($description){
            echo '<meta name="description" content="'.esc_attr(stripslashes($description)).'" />';
            echo "\n";
        }
    }

}

