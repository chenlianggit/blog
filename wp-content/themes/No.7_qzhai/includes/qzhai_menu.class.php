<?php
class qzhai_menu extends Walker_Nav_Menu
{
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent <div class=\"uk-dropdown uk-dropdown-navbar\"> <ul class=\"uk-nav uk-nav-navbar\">\n";
     }
     public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
     public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $q_children = explode(" ",$class_names);
        $adate = $qclass = $dropdown = '';
        
        if(in_array('menu-item-has-children', $q_children)) {
            $qclass .= 'uk-parent';
            $dropdown .='data-uk-dropdown="{pos:\'right-top\'}"';
        }
        if(in_array('current-menu-item', $q_children)){
            $qclass .= ' uk-active';
        }

        
        $output .= $indent . '<li' . $id . ' class="'. $qclass.'" '.$dropdown.'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .' class = "qzhai_bgc_hover">';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}
class qzhai_menu_s extends Walker_Nav_Menu
{
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent <ul class=\"uk-nav-sub\">\n";
     }
     public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
     public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $q_children = explode(" ",$class_names);
        $adate = $qclass = $dropdown = '';
        
        if(in_array('menu-item-has-children', $q_children)) {
            $qclass .= 'uk-parent';
            $dropdown .='"';
        }
        if(in_array('current-menu-item', $q_children)){
            $qclass .= ' ';
        }

        
        $output .= $indent . '<li' . $id . ' class="'. $qclass.'" '.$dropdown.'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'> ';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}
class qzhai_menu_link extends Walker_Nav_Menu
{
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent <ul class=\"uk-nav-sub\">\n";
     }
     public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
     public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $q_children = explode(" ",$class_names);
        $adate = $qclass = $dropdown = '';
        
        if(in_array('menu-item-has-children', $q_children)) {
            $qclass .= 'uk-parent';
            $dropdown .='"';
        }
        if(in_array('current-menu-item', $q_children)){
            $qclass .= ' ';
        }

        
        $output .= $indent . '<li' . $id . ' class="'. $qclass.'" '.$dropdown.'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
                $qzhai_url = $value;
                $qzhai_is = wp_cache_get('accc_' . $item->ID);
                if(!$qzhai_is){
                    $qzhai_title = get_meta_tags($qzhai_url);
                    if(!$qzhai_title){
                        $qzhai_title = null;
                    }
                    wp_cache_set('accc_' . $item->ID,$qzhai_title);
                   
                }else{
                   $qzhai_title = wp_cache_get('accc_' . $item->ID);
                }
                
            }

        }
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .' target="_blank">';
        $item_output .= '<h6><img src="http://g.soz.im/'.  $qzhai_url .'?defaulticon=wp" alt="Sina" width="20" height="20" />' .$args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after .'</h6>';
        $item_output .= '<p>'.$qzhai_title['description'].'</p>';
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}
class qzhai_menu_index_link extends Walker_Nav_Menu
{
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent <div class=\"uk-dropdown uk-dropdown-navbar\"> <ul class=\"uk-nav uk-nav-navbar\">\n";
     }
     public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
     public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $q_children = explode(" ",$class_names);
        $adate = $qclass = $dropdown = '';
        
        if(in_array('menu-item-has-children', $q_children)) {
            $qclass .= 'uk-parent';
            $dropdown .='data-uk-dropdown="{pos:\'right-top\'}"';
        }
        if(in_array('current-menu-item', $q_children)){
            $qclass .= ' uk-active';
        }

        
        $output .= $indent . '<li' . $id . ' class="'. $qclass.'" '.$dropdown.'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
                $qzhai_url = $value;
                
            }
        }
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .' target="_blank" >';
        $item_output .= '<h6><img src="http://g.soz.im/'.  $qzhai_url .'?defaulticon=wp" alt="Sina" width="20" height="20" />' .$args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after .'</h6>';
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}