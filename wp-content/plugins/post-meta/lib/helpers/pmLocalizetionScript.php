<?php

if( !class_exists( 'pmLocalizetionScript' ) ) :
class pmLocalizetionScript {    
    
    function __construct(){
        add_action( 'admin_enqueue_scripts',        array( $this, 'runLocalization' ) );
    }
        
    function runLocalization(){
        
        $data = array(
                'on_preview'=>'images/noimage.gif',       
        );
        wp_localize_script( 'post-meta-post-script', 'js', $data );
     
    }
              
}
endif;

?>