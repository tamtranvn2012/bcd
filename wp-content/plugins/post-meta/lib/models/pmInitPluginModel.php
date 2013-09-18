<?php

if( !class_exists( 'pmInitPluginModel' ) ) :
class pmInitPluginModel {    
        
    function pluginInit(){
        global $postMeta;
        
        $postMeta->loadControllers( $postMeta->controllersPath );
        $postMeta->loadDirectory( $postMeta->helperPath );
    }
               
}
endif;
