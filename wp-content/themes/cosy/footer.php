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
  	@Date:   2017-08-31 14:33:48
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-10 21:06:44

*/
$header_layout = cs_get_option( 'header_layout' );
$header_layout = $header_layout == 'center' ? 'container' : 'container-fluid';
?>
    <footer class="nt-footer">
        <div class="<?php echo $header_layout; ?> footer-container"> 
                <div class="site-info">
                    <?php 
                        $footer_info = cs_get_option('site_footer_info');
                        if( $footer_info ){
                            echo '<p>Copyright © '.intval(date('Y')).' <a href="'.get_bloginfo('url').'" title="'.get_bloginfo('name').'" rel="home">'.get_bloginfo('name').'</a>.  Design by <a href="https://www.nicetheme.cn" title="最有范的WordPress主题开发团队" target="_blank">Nicetheme</a>. '.$footer_info.'</p>'; 
                        }else{
                            echo '<p>Copyright © '.intval(date('Y')).' <a href="'.get_bloginfo('url').'" title="'.get_bloginfo('name').'" rel="home">'.get_bloginfo('name').'</a>.  Design by <a href="https://www.nicetheme.cn" title="最有范的WordPress主题开发团队" target="_blank">Nicetheme</a>.</p>';                     }
                    ?>            
                </div>
                <div class="social-links">
                <?php 
                    $social_group = cs_get_option('social_group');
                    //p($social_group);
                    if( is_array( $social_group ) ){

                        foreach ($social_group as $key => $value) {
                            
                            if( $value['social_group_type'] == 'link' ){

                                echo sprintf('
                                        <a href="%s" class="link" title="%s" target="_blank">
                                        <i class="%s"></i>
                                        </a>',
                                    $value['social_group_link'], 
                                    $value['social_group_title'], 
                                    $value['social_group_icon'] 
                                );

                            }else if( $value['social_group_type'] == 'image' ){
                                if( is_numeric( $value['social_group_img'] ) ){
                                    $src = wp_get_attachment_image_src( $value['social_group_img'], 'full' );
                                    $src = $src[0];
                                }else{
                                    $src = 'null';
                                }
                                echo sprintf('
                                   
                                    <a data-module="miPopup" data-selector="#footer_qrcode" href="javascript:void(0);" class="link btn-social-weixin"><i class="%s"></i></a>
                                    <div id="footer_qrcode" class="dialog-suxing">
                                        <div class="dialog-content dialog-wechat-content">
                                            <p>%s</p>
                                            <img src="%s" alt="%s">
                                            <div class="btn-close">
                                                <i class="icon icon-close"></i>
                                            </div>
                                        </div>    
                                    </div>
                                    ',
                                    $value['social_group_icon'],
                                    $value['social_group_title'],
                                    $src,
                                    $value['social_group_title']

                                );

                            }else if( $value['social_group_type'] == 'email' ){
                            	echo sprintf('
                                        <a href="mailto:%s" class="link" title="%s">
                                        <i class="%s"></i>
                                        </a>',
                                    $value['social_group_email'], 
                                    $value['social_group_title'], 
                                    $value['social_group_icon'] 
                                );
                            }

                        }

                    }
                ?>
                </div> 
                <nav class="footer-menu">
                    <ul id="menu-footer-menu" class="nav-list">
                    <?php 
                        if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('footer-nav') ) {  
                            wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'footer-nav', 'depth'=>1 ) ); 
                        } else { 
                            echo '<li><a href="/wp-admin/nav-menus.php">请到[后台->外观->菜单]中设置菜单。</a></li>'; 
                        } 
                    ?>
                    </ul>           
                </nav>
            </div>
       
    </footer>
    <div class="scroll-to-top floating-button hidden-sm hidden-xs"><a href="#"><i class="fa fa-angle-up"></i></a></div>
</div>

<?php wp_footer(); ?>
</body>
</html>