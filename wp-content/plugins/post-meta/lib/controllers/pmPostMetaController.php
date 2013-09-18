<?php

if( !class_exists( 'pmPostMetaController' ) ) :
    class pmPostMetaController {
        
        function __construct() {
            add_action('admin_menu', array( $this, 'post_meta_menu' ) );
            add_action( 'wp_ajax_pm_manage_group', array($this, 'post_meta_manage_group' ) );
            add_action( 'wp_ajax_pm_add_group', array($this, 'post_meta_add_group' ) );   
            add_action( 'wp_ajax_pm_add_field', array($this, 'post_meta_add_field' ) );
            add_action( 'wp_ajax_pm_change_field', array($this, 'post_meta_change_field' ) );
            add_action( 'wp_ajax_meta_option_group_save', array($this, 'post_meta_group_save' ) );

                    
        }


        function post_meta_menu(){
            $page = add_menu_page( 'Post Meta', 'Post Meta', 'administrator', 'post-meta', array( $this, 'post_meta_menu_page' ) , PM_ASSECTS_URL.'images/icon.png',52); 
            $page = add_submenu_page( 'post-meta', 'Manage Post Meta', 'Post Meta', 'administrator', 'post-meta', array( $this, 'post_meta_menu_page' ));
        
        add_action('admin_print_styles-' . $page,array( $this,'post_meta_sc'));
        }   
        
        function post_meta_sc(){
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-droppable');
        wp_enqueue_script('jquery-ui-selectable');
        wp_enqueue_script('jquery-ui-resizable');
        wp_enqueue_script('jquery-ui-dialog');
        
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
        
        function post_meta_menu_page(){
            global $postMeta;
            $postMeta->render('manage','','postmeta');
        }        
                        
        function post_meta_manage_group(){
            global $postMeta;
            $postMeta->verifyNonce();
                        
            $postMeta->render('manageForm',array('post_type'=>$_POST['post_type']),'postmeta');
           
            die();
            
        }
        function post_meta_add_group(){
            global $postMeta;
            $postMeta->verifyNonce();
                                    
            $meta_box['id']="group_".$_POST['id'];
            $meta_box['title']="New Group ";
            $postMeta->render('group',array('meta_box'=>$meta_box,'id'=>$_POST['id'],'toggle'=>$_POST['toggle'],'post_type'=>$_POST['post_type']),'postmeta');
            
            die();
        }
        function post_meta_add_field(){
            global $postMeta;
            $postMeta->verifyNonce();
                                    
            $field_type_data    = $postMeta->getFields('key');
            $field['title']=$field_type_data[$_POST['field_type']]." Field";
            $field['type']=$_POST['field_type'];
            $postMeta->render("field",array('field'=>$field,'group_id'=>$_POST['group_id'],'id'=>$_POST['field_id'],'post_type'=>$_POST['post_type'],'field_type'=>$_POST['field_type']),'postmeta');
            
            die();
        }
        
        function post_meta_change_field(){
            global $postMeta;
            $postMeta->verifyNonce();            
            $data =  $_REQUEST ;
            $group_id_array= array_keys($data[group]);
            $group_id=$group_id_array[0];
            $field_id_array=array_keys($data[group][$group_id][field]);
            $field_id = $field_id_array[0];
            $field = $data[group][$group_id][field][$field_id];
            
            $postMeta->render("field",array('field'=>$field,'group_id'=>$group_id,'id'=>$field_id,'field_type'=>$_POST['field_type'],'toggle'=>true),'postmeta');
            
            die();
        }
        
        
        function post_meta_group_save(){
            global $postMeta;
            $postMeta->verifyNonce();            
                
                $post_type = $_POST['post_type']; 
                unset( $_REQUEST['pm_nonce'] );
                unset( $_REQUEST['action'] );
                unset( $_REQUEST['post_type'] );
                 
                $groups =  $_REQUEST ;  
                
                $pm_options = get_option($postMeta->options['post_meta']);
                if(!is_array($pm_options)){
                    $pm_options=array();
                }   
                
                 foreach($pm_options as $key => $pm_option){
                    if($key==$post_type){
                            $pm_options[$post_type]=$groups;
                            update_option($postMeta->options['post_meta'],$pm_options);
                            echo $postMeta->showMessage("Successfully Update", 'success');
                            die();
                    }
                    
                }
                $pm_options[$post_type]=$groups;
                update_option($postMeta->options['post_meta'],$pm_options);
                
                echo $postMeta->showMessage("Settings Successfully Saved", 'success');
                die();
            
        }

}
    
    
endif;

?>