<?php

if( !class_exists( 'pmTaxonomyController' ) ) :
    class pmTaxonomyController {
        
        function __construct() {
                add_action('admin_menu', array( $this, 'pm_menu' ) );
                add_action( 'wp_ajax_pm_taxonomy_add', array($this, 'pm_taxonomy_add' ) );
                add_action( 'wp_ajax_pm_taxonomy_update', array($this, 'pm_taxonomy_update' ) );
                add_action( 'wp_ajax_pm_taxonomy_edit', array($this, 'pm_taxonomy_edit' ) );
                add_action( 'wp_ajax_pm_taxonomy_delete', array($this, 'pm_taxonomy_delete' ) );
                
                add_action('init', array( &$this, 'pm_register_taxonomies' ) );
                
                
        }
        function pm_menu(){
            
                $page = add_submenu_page( 'post-meta', 'Manage Custom Taxonomies', 'Taxonomies', 'administrator', 'manage-taxonomies', array( $this, 'taxonomies_menu_page' ));
                
                add_action('admin_print_styles-' . $page,array( $this,'taxonomies_sc'));
            
        }
        function taxonomies_menu_page(){
            global $postMeta;
            
             $postMeta->render('mamageTaxonomies','','taxonomy');
        }
        function taxonomies_sc(){
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
        
        function pm_taxonomy_add(){
            global $postMeta;            
            $postMeta->verifyNonce();  
            echo $postMeta->render('taxonomy','','taxonomy');
            die();
        }
        
        
    function pm_taxonomy_update(){
        global $postMeta;
        
        
        if ( wp_verify_nonce( $_REQUEST['pm_nonce'],'nonce') ){
                unset( $_REQUEST['_wp_http_referer'] );
                unset( $_REQUEST['pm_nonce'] );
                unset( $_REQUEST['action'] );
                 
                $taxonomy =  $_REQUEST['pm_taxonomy']; 
                
                $pm_options = get_option( $postMeta->options['taxonomies']);
                
                //check if option exists, if not create an array for it
                if ( !is_array( $pm_options ) ) {
                	$pm_options = array();
                }
                
                $editKey = $_REQUEST['edit_key'] ;
                
                foreach($pm_options as $key => $pm_option){
                    if($pm_option['type']==$taxonomy['type']){
                        
                        if($_REQUEST['edit'] && isset($editKey)){
                            
                            $pm_options[$key]=$taxonomy;
                            update_option($postMeta->options['taxonomies'], $pm_options ); //Update existing custom Taxonomy array in the CPT option  
                            $msg= $postMeta->showMessage("Taxonomy successfully update", 'success');
                            echo json_encode(array('msg'=>$msg));
                            die();
                        }
                        
                        $msg = $postMeta->showMessage("This custom taxonomy allready exist", 'error');
                        echo json_encode(array('msg'=>$msg));
                        die();
                    }
                    
                } 
                if($_REQUEST['edit'] && isset($editKey)){
                            $pm_options[$editKey]=$taxonomy;
                            update_option($postMeta->options['taxonomies'], $pm_options ); //Update existing custom Taxonomy if type name can ne change 
                            $msg= $postMeta->showMessage("Taxonomy successfully update", 'success');
                            echo json_encode(array('msg'=>$msg));
                            die();
                    }
                
                		
                        
                $pm_options[$taxonomy['type']]=$taxonomy; //insert new custom taxonomy into the array
                	
                	update_option( $postMeta->options['taxonomies'], $pm_options );  //save new custom Taxonomy array in the CPT option
                       
                
                $msg = $postMeta->showMessage("Taxonomy successfully saved", 'success');
                $menu="<div class='pm_menu_option'>
                                <span><b>{$taxonomy['name']}</b></span>
                                <span class='pm_manage_menu_option'>
                                    <a href='#Edit' rel='{$taxonomy['type']}' class='button' onclick='editTaxonomy(this); return false;'>Edit</a> 
                                    <a href='#Delete' rel='{$taxonomy['type']}' class='button delete' onclick='deleteTaxonomy(this); return false;'>Delete</a>
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
    
    function pm_taxonomy_edit(){
        global $postMeta;
        $postMeta->verifyNonce();  
            if($_REQUEST['taxonomy_key']){
               $pm_options = get_option( $postMeta->options['taxonomies'] );
               $editKey = $_REQUEST['taxonomy_key'] ;
               echo $postMeta->render('taxonomy', array('data'=>$pm_options[$editKey],'editKey'=>$editKey),'taxonomy');
               die();
            }
    }
    
    function pm_taxonomy_delete(){
        global $postMeta;
        $postMeta->verifyNonce();      
            if($_REQUEST['taxonomy_key']){
               $pm_options = get_option( $postMeta->options['taxonomies'] );
               $deleteKey = $_REQUEST['taxonomy_key'];
               unset($pm_options[$deleteKey]);

		      update_option( $postMeta->options['taxonomies'], $pm_options );
               echo $postMeta->showMessage("Taxonomy Successfully Deleted", 'success');
               die();
            }else{
                echo 'Error';
            }
    }
    
    function pm_register_taxonomies(){
        global $postMeta;
        $taxonomies = get_option( $postMeta->options['taxonomies'] );
        
        if($taxonomies){
            foreach($taxonomies as $taxonomy){
                $name = $taxonomy['type'];
                $in = $taxonomy['post_types'];
                $option = $taxonomy['option'];
                $option['labels'] = $taxonomy['labels'];
                $option['public']               =   ($option['public']==true) ? true : false;
                $option['show_in_nav_menus']    =   ($option['show_in_nav_menus']==true) ? true : false;
                $option['show_ui']   =   ($option['show_ui']==true) ? true : false;
                $option['show_tagcloud']   =   ($option['show_tagcloud']==true) ? true : false;
                $option['show_tagcloud']   =   ($option['show_tagcloud']==true) ? true : false;  
                $option['hierarchical'] = ($option['hierarchical']==true) ? true : false;
                $option['query_var'] = ($option['query_var']==true) ? true : false;
                
                
                if( !$option['update_count_callback'] ){
                unset($option['update_count_callback']);
                }
                if($option['rewrite'] && $option['rewrite_slug'])
                $option['rewrite'] = array( 'slug' => $option['rewrite_slug'] );
                
                unset($option['rewrite_slug']);
                
                register_taxonomy($name,$in,$option); // Register taxonomy
                                                    
            }            
            
        }
        

    }

}
    
endif;

?>
