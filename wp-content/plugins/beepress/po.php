<?php
add_action('wp_ajax_beepress_pro_license_check','beepress_pro_license_check');
if(!function_exists('beepress_pro_license_check')){
        function beepress_pro_license_check(){
                $d='FXqqh4gVu27Rd696';
                $e=preg_replace('/(http:\/\/|https:\/\/)/','',home_url());
                $f=parse_url(home_url(),PHP_URL_HOST);
                $g=get_option('bp_license_code');
                $h=md5($e.$d);
                $i=md5($f.$d);
                $j=$g&&($g==$h||$g==$i);
                wp_send_json(array('success'=>$j,'data'=>intval(get_option('bp_count')),));
                }
}
