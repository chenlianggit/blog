<?php
/*
            /$$            
    /$$    /$$$$            
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$ 
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/ 
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-08-31 10:58:32
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-13 14:13:28

*/

get_header();

if( !( ( cs_get_option('home_ajax_load') != 1 ) && ( get_query_var('paged') > 1 ) ) ){

$slide_layout = cs_get_option( 'slide_layout' );
$magazine_layout = cs_get_option( 'magazine_layout' );
$slide_region = cs_get_option('slide_region');
if( $slide_region == 'magazine' ) {
  	if( $magazine_layout == 'full' ){
  		  echo '<section class="featured-area">';
  		  echo '<div class="container-fluid pd0">';
  	}else{
  		  echo '<section class="featured-area featured-area-style02">';
  		  echo '<div class="container">';
  	}

		get_template_part('template-parts/magazine');
	  echo '</div>';
	  echo '</section>';
}else if( $slide_region == 'silide' ) {

    //  全宽或居中
    if( $slide_layout == 'full' ) { 
        echo '<div class="container-fluid pd0">';
    	echo '<section class="nt-slider style01 owl-carousel">';
    }else{
    	
        echo '<div class="container container-pd0">';
    	echo '<section class="nt-slider style02 owl-carousel">';

    }
    get_template_part('template-parts/slide');
    echo '</div>';
    echo '</section>';
}

if( cs_get_option('slide_region') == 'silide' && cs_get_option('slide_below_card') ){

	if( cs_get_option('slide_below_card_layout') == 'full' ){

		echo '<section class="nt-featured-posts owl-carousel">';
		get_template_part( 'template-parts/slide-below-card' ); 
		echo '</section>';

	}else{

		echo '<div class="container container-pd0">';
		echo '<section class="nt-featured-posts owl-carousel">';
		get_template_part( 'template-parts/slide-below-card' ); 
		echo '</section>';
		echo '</div>';

	}

}
}
$index_single_layout = cs_get_option( 'index_single_layout' );
?>
    <section class="nt-warp nt-warp-full <?php $index_single_layout == 'card-4' ? printf('nt-warp-raw') : ''; ?>">
        <div class="container">
        <?php 
        	$tabs = cs_get_option('home_tab_cats');
        	$ajax_load = cs_get_option('home_ajax_load');
        	if( is_array( $tabs ) && $ajax_load ){
        ?>
            <div class="filter-menu text-center">
                <button class="active">最新</button>
                <?php 
                	foreach ($tabs as $key => $value) {
                		if( $value['home_tab_cat'] >= 1 ){
                			echo sprintf( '<button data-cid="%s">%s</button>', $value['home_tab_cat'], $value['home_tab_name'] );
                		}
                	} 
                ?>
            </div>
        <?php } ?>
            <?php           	
              	if( $index_single_layout == 'full' ) {
              		get_template_part( 'template-parts/index-single-full' );           		
              	}else{
              		get_template_part( 'template-parts/index-single-card' );
              	}
            ?>
        </div>
    </section>

<?php
get_footer();