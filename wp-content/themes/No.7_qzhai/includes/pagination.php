<?php
// 分页代码
function par_pagenavi($range = 3){
    global $paged, $wp_query;
    if ( !$max_page ) {
        $max_page = $wp_query->max_num_pages;
    }

    if($max_page > 1){

        if(!$paged){$paged = 1;
        }

    if($paged != 1){
        echo "<li><a href='" . get_pagenum_link(1) . "' class='extend' title='跳转到首页'>«</a></li>";
    }
    if($max_page > $range){
        if($paged < $range){
            for($i = 1; $i <= ($range + 1); $i++){
                echo "<li";
            if($i==$paged){
                echo " class='uk-active'";
                echo " ><span>$i</span></li>";
            }else{
                echo " ><a href='" . get_pagenum_link($i) ."'>$i</a></li>";  
            }
        }
    }elseif($paged >= ($max_page - ceil(($range/2)))){
        for($i = $max_page - $range; $i <= $max_page; $i++){
           echo "<li";
            if($i==$paged){
                echo " class='uk-active'";
                echo " ><span>$i</span></li>";
            }else{
                echo " ><a href='" . get_pagenum_link($i) ."'>$i</a></li>";  
            }
    }
    }elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
        for($i = ($paged - ceil($range/2)); 
            $i <= ($paged + ceil(($range/2))); $i++){
                echo "<li";
            if($i==$paged){
                echo " class='uk-active'";
                echo " ><span>$i</span></li>";
            }else{
                echo " ><a href='" . get_pagenum_link($i) ."'>$i</a></li>";  
            }
    }
    }
}
    else{
        for($i = 1; $i <= $max_page; $i++){
            echo "<li";
            if($i==$paged){
                echo " class='uk-active'";
                echo " ><span>$i</span></li>";
            }else{
                echo " ><a href='" . get_pagenum_link($i) ."'>$i</a></li>";  
            }

}

}
    echo "<li>";
    next_posts_link('»');
    echo "</li>";
}   
}

