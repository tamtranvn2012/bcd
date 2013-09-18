<?php

if( !class_exists( 'pmPostTypeController' ) ) :
    class pmPostTypeController {
        
        function __construct() {
            add_action('admin_menu', array( $this, 'post_type_menu' ) );
            add_action( 'wp_ajax_pm_post_type_add', array($this, 'pm_post_type_add' ) );
            add_action( 'wp_ajax_pm_post_type_edit', array($this, 'pm_post_type_edit' ) );
            add_action( 'wp_ajax_pm_post_type_delete', array($this, 'pm_post_type_delete' ) );
            add_action( 'wp_ajax_pm_post_type_update', array($this, 'pm_post_type_update' ) );
           
           
           add_action('init', array( &$this, 'pm_register_post_types' ) );
        }
        function post_type_menu(){
            
            $page = add_submenu_page( 'post-meta', 'Manage Custom Post Types', 'Post Types', 'administrator', 'manage-post-types', array( $this, 'post_types_menu_page' ));
        
        add_action('admin_print_styles-' . $page,array( $this,'post_types_sc'));
        }
        
        
        function post_types_menu_page(){
                 global $postMeta;
                 $postMeta->render('managePostTypes','','posttype');
        }
        
        function post_types_sc(){
                wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script( 'jquery-ui-widget');
                wp_enqueue_script( 'jquery-ui-mouse');
                wp_enqueue_script('jquery-ui-tabs');
                
                wp_register_style( 'jquery-ui-all', PM_ASSECTS_URL.'css/ui/jquery.ui.all.css');
                wp_enqueue_style('jquery-ui-all' );
                
                wp_register_style( 'pluginCore-style', PM_ASSECTS_URL.'css/pluginCore.css' );
                wp_enqueue_style('pluginCore-style' );
                wp_register_style( 'post-meta-admin-style', PM_ASSECTS_URL.'css/post_meta_admin.css' );
                wp_enqueue_style('post-meta-admin-style' );
                wp_register_style( 'post-meta-validationEngine-css', PM_ASSECTS_URL.'css/jquery/validationEngine.css' );
                wp_enqueue_style('post-meta-validationEngine-css' ); 
                 
                wp_register_script( 'post-meta-admin-script', PM_ASSECTS_URL.'js/post_meta_admin.js'); 
                wp_enqueue_script('post-meta-admin-script' ); 
                wp_register_script( 'post-meta-third-party-slug-string', PM_ASSECTS_URL.'js/jquery/jquery.stringToSlug.js'); 
                wp_enqueue_script('post-meta-third-party-slug-string'); 
                wp_register_script( 'post-meta-validationEngine', PM_ASSECTS_URL.'js/jquery/validationEngine.js'); 
                wp_enqueue_script('post-meta-validationEngine'); 
                wp_register_script( 'post-meta-validationEngine-en', PM_ASSECTS_URL.'js/jquery/validationEngine-en.js'); 
                wp_enqueue_script('post-meta-validationEngine-en');
        }
        
        
        function pm_post_type_add(){
            global $postMeta;
            $postMeta->verifyNonce();   
            echo $postMeta->render('postType','','posttype');
            die();
        }
        function pm_post_type_update(){
              global $postMeta;
          if ( wp_verify_nonce( $_REQUEST['pm_nonce'],'nonce') ){
                        unset( $_REQUEST['_wp_http_referer'] );
                        unset( $_REQUEST['pm_nonce'] );
                        unset( $_REQUEST['action'] );
                        unset( $_REQUEST['post_type'] );
                         
                        $postType =  $_REQUEST['pm_posttype']; 
                        
                        $pm_options = get_option( $postMeta->options['post_types'] );
                        
                        
                        //check if option exists, if not create an array for it
                        if ( !is_array( $pm_options ) ) {
                        	$pm_options = array();
                        }
                        
                        $editKey = $_REQUEST['edit_key'];
                        
                        foreach($pm_options as $key => $pm_option){
                            if($pm_option['type']==$postType['type']){
                                
                                if($_REQUEST['edit'] && isset($editKey)){
                                    $pm_options[$key]=$postType;
                                    update_option($postMeta->options['post_types'], $pm_options );
                                    $msg = $postMeta->showMessage("Successfully Update", 'success');
                                    echo json_encode(array('msg'=>$msg));
                                    die();
                                }
                                
                                $msg= $postMeta->showMessage("This post type allready exist", 'error');
                                echo json_encode(array('msg'=>$msg));
                                die();
                            }
                            
                        } 
                        
                        if($_REQUEST['edit'] && isset($editKey)){
                                    $pm_options[$editKey]=$postType;
                                    update_option($postMeta->options['post_types'], $pm_options );
                                    $msg = $postMeta->showMessage("Successfully Update", 'success');
                                    echo json_encode(array('msg'=>$msg));
                                    die();
                                }
                        
                        
                        		//insert new custom post type into the array*/
                        	//array_push( $pm_options, $postType );
                            $pm_options[$postType['type']]=$postType;
                        
                        	//save new custom post type array in the CPT option
                        	update_option( $postMeta->options['post_types'], $pm_options );         
                        
                        $msg = $postMeta->showMessage("New Post Type Successfully Saved", 'success');
                        
                        $menu="<div class='pm_menu_option'>
                                <span><b>{$postType['name']}</b></span>
                                <span class='pm_manage_menu_option'>
                                    <a href='#Edit' rel='{$postType['type']}' class='button' onclick='editPostType(this); return false;'>Edit</a> 
                                    <a href='#Delete' rel='{$postType['type']}' class='button delete' onclick='deletePostType(this); return false;'>Delete</a>
                                </span>
                            </div>";
                        
                        
                        echo json_encode(array('msg'=>$msg,'menu'=>$menu));
                        die();
                }else{
                    $msg = $postMeta->showMessage("Security Error", 'error');
                    echo json_encode(array('msg'=>$msg));
                    die();
                }
                
        }
        function pm_post_type_edit(){
            global $postMeta;
            $postMeta->verifyNonce();   
            
             if($_REQUEST['post_type_key']){
               $pm_options = get_option( $postMeta->options['post_types'] );
               $editKey = $_REQUEST['post_type_key'] ;
               echo $postMeta->render('postType', array('data'=>$pm_options[$editKey],'editKey'=>$editKey),'posttype');
               die();
            }
        }
        
        function pm_post_type_delete(){
            global $postMeta;
            $postMeta->verifyNonce();   
            if($_REQUEST['post_type_key']){
               $pm_options = get_option( $postMeta->options['post_types'] );
               $deleteKey = $_REQUEST['post_type_key'];
               unset($pm_options[$deleteKey]);

		      update_option( $postMeta->options['post_types'], $pm_options );
               echo $postMeta->showMessage("Post Type Successfully Deleted", 'success');
               die();
            }else{
                echo 'Error';
            }
        }
        
        
        function pm_register_post_types(){
            global $postMeta;
            
            $pm_postTypes = get_option( $postMeta->options['post_types'] );
            
            if($pm_postTypes){
                        foreach($pm_postTypes as $postType){
                            
                            $name = $postType['type'];
                            $postType['labels'] =  (is_array($postType['labels']))?$postType['labels']:array();  
                            $option = array();
                            $option = $postType['option'];
                            $postType['taxonomy'] = (is_array($postType['taxonomy']))?$postType['taxonomy']:array();
                            $postType['support'] =  (is_array($postType['support']))?$postType['support']:array();
                            $option['public']               = ($option['public']==true)?true:false; 
                            $option['publicly_queryable']   = ($option['publicly_queryable']==true)?true:false; 
                            $option['exclude_from_search']  = ($option['exclude_from_search']==true)?true:false;
                            $option['show_ui']              = ($option['show_ui']==true)?true:false; 
                            $option['show_in_menu']         = ($option['show_in_menu']==true)?true:false; 
                            $option['hierarchical']         = ($option['hierarchical']==true)?true:false; 
                            $option['has_archive']          = ($option['has_archive']==true)?true:false; 
                            $option['rewrite']              = ($option['rewrite']==true)?true:false; 
                            $option['query_var']            = ($option['query_var']==true)?true:false; 
                            $option['can_export']           = ($option['can_export']==true)?true:false; 
                            $option['show_in_nav_menus']    = ($option['show_in_nav_menus']==true)?true:false; 
                            $option['description'] = $postType['description'];
                            
                                                                                     
                                if(isset($option['has_archive']) && $option['has_archive'] && isset($option['has_archive_slug']) && $option['has_archive_slug'])	
                                    $option['has_archive'] = $option['has_archive_slug'];
                                
                                  if($option['rewrite'] && $option['rewrite_slug'])
                                    $option['rewrite'] = array( 'slug' => $option['rewrite_slug'],'with_front' => true );
                                
                                  //check Capability type
                                trim($option['capability_type']);
                                if(empty($option['capability_type'])){
                                    $option['capability_type'] = 'post';
                                }elseif( !in_array($option['capability_type'],array('post','page')) ){
                                $option['capabilities'] = $this->_get_cap($option['capability_type']);
                                }
                            $option['labels'] = $postType['labels'];
                            $option['taxonomies']= $postType['taxonomy'];
                            $option['supports'] =   $postType['support'];
                            
                            
                                
                          $args = array(
                            'labels' => $postType['labels'],
                            'public' => $option['public'],
                            'publicly_queryable' => $option['publicly_queryable'],
                            'show_ui' => $option['show_ui'], 
                            'show_in_menu' => $option['show_in_menu'], 
                            'query_var' => $option['query_var'],
                            'rewrite' =>  $option['rewrite'],
                            'capability_type' => 'post',
                            'has_archive' => $option['has_archive'], 
                            'hierarchical' => $option['hierarchical'],
                            'menu_position' => (isset($option['menu_position']))?$option['menu_position']:null,
                            'taxonomies'            =>$postType['taxonomy'],
                            'supports' => $postType['support'],
                            'can_export' => $option['can_export'],
                            'description' => $postType['description'],
                            'show_in_nav_menus' =>$option['show_in_nav_menus']
                          ); 
                          register_post_type($name,$args);
                        }
            }
            
        }
        
      public function _get_cap($name){

            $caps = array(
              'edit_post'          => sprintf('edit_%s',$name),
              'read_post'          => sprintf('read_%s',$name),
              'delete_post'        => sprintf('delete_%s',$name),
              'edit_posts'         => sprintf('edit_%ss',$name),
              'edit_others_posts'  => sprintf('edit_others_%ss',$name),
              'publish_posts'      => sprintf('publish_%ss',$name),
              'read_private_posts' => sprintf('read_private_%ss',$name)
            );
        
              return $caps;
          }
        

}
    
endif;

?>
