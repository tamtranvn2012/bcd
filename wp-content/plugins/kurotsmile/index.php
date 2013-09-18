<?php
/*
Plugin Name: kurotsmile
Plugin URI: http://www.kurot.vacau.com
Description: thêm link AppStore kurotsmile vào website
Version: 1.0
Author: KuRot
Author URI: http://www.facebook.com/kurotsmile
License: kr
*/

add_action('init','print_txt');
function print_txt(){
    echo 'kurot';
}

function code_kurot( $atts ){
 return "tran thien thanh";
}
add_shortcode( 'kurot', 'code_kurot' );

function on_load(){
   echo "thien thanh";
}
?>