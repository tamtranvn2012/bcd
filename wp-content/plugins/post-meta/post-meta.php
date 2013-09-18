<?php
/*
Plugin Name: Post Meta
Plugin URI: http://post-meta.com
Description: Post Meta is a wordpress custom post field, post type and taxonomy management Plugin. It has smart and modern (ajax and jquery based) interface to create post meta option or custom meta field as group or field.
Author: Mahbubur Rahman
Version: 1.0.6
Author URI: http://post-meta.com
*/

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Please don\'t access this file directly.');
}

require_once ( 'lib/init.php' );  
require_once ( 'lib/api.php' ); 

if (!class_exists( 'postMeta' )){
    class postMeta extends pluginCore {
        
        public $title       = 'Post Meta';
        public $name        = 'post-meta';
        public $version     = '1.0.6';
        public $prefix      = 'pm_';  
        public $prefixLong  = 'post_meta_';
        public $website     = 'http://post-meta.com';     
        
        
        function __construct(){ 
            $this->file             = __FILE__;
            $this->pluginSlug       = plugin_basename(__FILE__);
            $this->pluginPath       = dirname( __FILE__ );
            $this->modelsPath       = $this->pluginPath . '/lib/models/';
            $this->controllersPath  = $this->pluginPath . '/lib/controllers/';
            $this->viewsPath        = $this->pluginPath . '/lib/views/';
            $this->helperPath        = $this->pluginPath . '/lib/helpers/';
            
            $this->pluginUrl        = plugins_url( '' , __FILE__ ); 
            $this->assetsUrl        = $this->pluginUrl  . '/assets/'; 
            $this->helperUrl        = $this->pluginUrl  .'/lib/helpers/';
            define('PM_PATH',dirname( __FILE__ )); 
            define('PM_PLUGIN_URL',plugins_url( '' , __FILE__ )).'/';
            define('PM_ASSECTS_URL', PM_PLUGIN_URL.'/assets/');
            define('PM_HELPER_URL', PM_PLUGIN_URL.'/lib/helpers/');
            
          
          $this->loadModels( $this->modelsPath );
          $this->loadModels( $this->modelsPath.'enc/' , true);
          
          $this->options=array(
                            'post_meta' =>'pm_post_meta',
                            'post_types'=>'pm_post_types',
                            'taxonomies'=>'pm_taxonomies',
                            'settings'  =>'pm_settings',
                            'cache'     =>'pm_cache'
                            );
          

        }
        function init(){
            
            $this->pluginInit();        
        }
        
        
    }
    global $postMeta;
    $postMeta = new postMeta;
    $postMeta->init();
}