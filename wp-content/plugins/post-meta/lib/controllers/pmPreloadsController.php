<?php

if( !class_exists( 'pmPreloadsController' ) ) :
class pmPreloadsController {
    
    function __construct(){ 
        global $postMeta;
        
        add_action( 'admin_print_scripts',  array( $this, 'setJqueryVariable' ) );
        add_action( 'wp_print_scripts',     array( $this, 'setJqueryVariable' ) );
        
        register_activation_hook( $postMeta->file,  array( $this, 'postMetaActivation' ) );
        register_deactivation_hook( $postMeta->file,  array( $this, 'postMetaDeActivation' ) );
        add_action( 'post_meta_schedule_event',     array( $userMeta, 'clearCache' ) );
    }
    
    function setJqueryVariable(){
        global $postMeta;            
        $ajaxurl    = admin_url( 'admin-ajax.php' );
        $nonceText  = $postMeta->nonceText();
        $nonce      = wp_create_nonce( $nonceText );
        
        if( is_admin() )
            echo "<script type='text/javascript'>pm_nonce='$nonce';</script>";
        else
            echo "<script type='text/javascript'>ajaxurl='$ajaxurl';pm_nonce='$nonce';</script>";
    }
    
    function postMetaActivation(){
        global $postMeta;
        $settings = get_option($postMeta->options['settings']);
        if(!$settings){
            $data=array(
                    'file'=>array(
                        'allext'=>array(
                            'file'      =>array('zip','rar','7z','iso'),
                            'document'  =>array('pdf','doc','ppt'),
                            'image'     =>array('jpg','jpeg','png','gif'),
                            'audio'     =>array('mp3','wav','wma'),
                            'video'     =>array('mp4','flv','avi','wmv')
                        ),
                        'max_file_size'=>'200'
                    )
            );
            
            update_option($postMeta->options['settings'],$data);
        }
        wp_schedule_event( current_time( 'timestamp' ), 'daily', 'post_meta_schedule_event');
    }
    
    function postMetaDeActivation(){
        global $postMeta;
        delete_option($postMeta->options['settings']);
    }
           
}
endif;      
?>