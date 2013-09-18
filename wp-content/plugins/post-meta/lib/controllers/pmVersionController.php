<?php

if( !class_exists( 'pmVersionController' ) ) :
class pmVersionController {
    
    function __construct() {
        
        add_action('admin_head',array($this,'init'));
        add_filter( 'site_transient_update_plugins',array( $this, 'pluginUpdateNotification' ) ); 
              
    }
    
    function init(){
        global $postMeta;
        if($postMeta->isPro()){
            $this->plugin_pro_version_check();
        }else{
            add_action('pm_notice',array($this,'pm_update_free_to_pro'));
        }
    }
     
    
    function pluginUpdateNotification($data){
        global $postMeta;
        
        if( isset( $data->response[ $postMeta->pluginSlug ] ) ){
            $plugin = $data->response[ $postMeta->pluginSlug ];                
            if( $postMeta->isPro() ){
                $data->response[ $postMeta->pluginSlug ]->url       = $postMeta->website;
                $data->response[ $postMeta->pluginSlug ]->package   = null;  
                $data = new stdClass;                 
            }                                 
        }
        return $data; 
    }
    
    function pm_update_free_to_pro(){
        global $postMeta;
        echo "<div class='error fade'><p>Recommended ,Update your <b>Post Meta</b> from free version to <b>Post Meta pro</b> version for getting all feature and get better performance <a href='{$postMeta->website}' target='_blank'>Get it now <em>!</em></a></p></div>";
    } 
    function pm_update_pro(){
        global $postMeta;
        $cacheData=get_option($postMeta->options['cache']);
        $remote_pro_version = $cacheData['pm_new_ver'];
        echo "<div class='update-nag'>Recommended , <b> Post Meta Pro $remote_pro_version</b> is available! <a href='{$postMeta->website}/downloads' target='_blank'>Please update now.</a></div>";
    }   
    
    function pm_update_admin_pro(){
        global $postMeta;
        $cacheData=get_option($postMeta->options['cache']);
        $remote_pro_version = $cacheData['pm_new_ver'];
        echo "<div class='error fade'><p>Recommended , <b> Post Meta Pro $remote_pro_version</b> is available! <a href='{$postMeta->website}/downloads' target='_blank'>Please update now.</a></p></div>";
    }   
    
       
    
    function plugin_pro_version_check(){
        global $postMeta;
        $cacheData=get_option($postMeta->options['cache']);
        
        $update_last_check =$cacheData['last_ver_check'];
        
        if ($cacheData['pm_new_ver']) {
			add_action('admin_notices',array($this,'pm_update_pro'));
            
		}
		$update_check_int_seconds = 24 * 3600;
		$now = time();
		if ( empty( $update_last_check ) ) {
				//first run
				$this->compare_pro_ver();
                $cacheData['last_ver_check']=$now;
				update_option($postMeta->options['cache'],$cacheData);
			} else {
				$time_ago = $now - $update_last_check;
				if ( $time_ago > $update_check_int_seconds ) {
					$cacheData['last_ver_check']=$now;
				    update_option($postMeta->options['cache'],$cacheData);
				}
			}
        
    }
    
    function compare_pro_ver(){
        global $postMeta;
        $local_version =$postMeta->version;
        $remote_text = file_get_contents($postMeta->website.'/post-meta-pro-version.php');
        if ($remote_text !== false) {
            $remote_version = $remote_text;
            if ($local_version == $remote_version) {
                $cacheData=get_option($postMeta->options['cache']);
                $cacheData['pm_new_ver']=false;
                update_option($postMeta->options['cache'],$cacheData);
            }else{
                if ( version_compare( $remote_text,$local_version,'>=' ) ) {
                      $cacheData['pm_new_ver']=$remote_version;
                      update_option($postMeta->options['cache'],$cacheData);
                    }
            }
        }
        
    }  
 
}

endif;

?>