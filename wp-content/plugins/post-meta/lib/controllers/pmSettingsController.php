<?php

if( !class_exists( 'pmSettingsController' ) ) :
    class pmSettingsController {
        
        function __construct() {
            add_action('admin_menu', array( $this, 'settings_menu' )); 
            add_action( 'wp_ajax_pm_update_settings', array($this, 'pm_update_settings' ) );
            add_action( 'wp_ajax_pm_reset_settings', array($this, 'pm_reset_settings' ) );
        }
        function settings_menu(){
             $page = add_submenu_page( 'post-meta', 'Post Meta Settings', 'Settings', 'administrator', 'post-meta-settings', array( $this, 'settings_menu_page' ));
        
            add_action('admin_print_styles-' . $page,array( $this,'settings_sc'));
        }
        function settings_sc(){   
            wp_enqueue_scripts('jquery');
            wp_enqueue_script('jquery-ui-tabs');
            wp_register_style( 'pluginCore-style', PM_ASSECTS_URL.'css/pluginCore.css' );
                wp_enqueue_style('pluginCore-style' );
            wp_register_style( 'post-meta-admin-style', PM_ASSECTS_URL.'css/post_meta_admin.css' );
            wp_enqueue_style('post-meta-admin-style' );
             
            wp_register_script( 'post-meta-admin-script', PM_ASSECTS_URL.'/js/post_meta_admin.js'); 
            wp_enqueue_script('post-meta-admin-script' ); 
            wp_register_style( 'jquery-ui-all', PM_ASSECTS_URL.'css/ui/jquery.ui.all.css');
            wp_enqueue_style('jquery-ui-all' );
            
            wp_register_script( 'post-meta-validationEngine', PM_ASSECTS_URL.'js/jquery/validationEngine.js'); 
            wp_enqueue_script('post-meta-validationEngine'); 
            wp_register_script( 'post-meta-validationEngine-en', PM_ASSECTS_URL.'js/jquery/validationEngine-en.js'); 
            wp_enqueue_script('post-meta-validationEngine-en');
            wp_register_style( 'post-meta-validationEngine-css', PM_ASSECTS_URL.'css/jquery/validationEngine.css' );
            wp_enqueue_style('post-meta-validationEngine-css' );
          
        }
        
        function settings_menu_page(){
            global $postMeta;
            
             $postMeta->render("manageSettings",'','setting'); 
        }
        function pm_update_settings(){
            global $postMeta;
            $postMeta->verifyNonce();  
            $settings =  $_REQUEST['settings'];
            update_option($postMeta->options['settings'], $settings ); //Update existing custom Taxonomy array in the CPT option  
            echo $postMeta->showMessage("Settings successfully update", 'success');
            die();
        }
        
        function pm_reset_settings(){
            global $postMeta;
            $postMeta->verifyNonce(); 
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
            
            update_option($postMeta->options['settings'], $data );
            echo $postMeta->showMessage("Settings successfully Restored to default", 'success');
            die();
        }

}
    
endif;

?>
