<?php
if( !class_exists( 'pmPostController' ) ) :
 class pmPostController {
    
        function __construct() {
            
            add_action('add_meta_boxes', array( $this,'add_custom_meta_box'));
            add_action( 'admin_enqueue_scripts', array( $this,'meta_option_script' ));
            add_action( 'wp_ajax_pm_img_preview', array($this, 'pm_img_preview' ) );
            add_action( 'wp_ajax_pm_audio_preview', array($this, 'pm_audio_preview' ) ); 
            add_action( 'wp_ajax_pm_video_preview', array($this, 'pm_video_preview' ) );
            add_action( 'wp_ajax_pm_file_preview', array($this, 'pm_file_preview' ) );
            add_action( 'wp_ajax_pm_load_group', array($this, 'pm_load_group' ) );
            add_action('save_post', array($this, 'save_meta_option_data')); 
            add_action('admin_head-media-upload-popup', array($this, 'popup_head'));
            }
            function popup_head()
            {
                // Don't interfere with the default Media popup
                if (isset($_GET['pm_media_file']))
                {
                ?>
                    <script>
                    (function($) {
                        $(function() {
                            $('form#filter').each(function() {
                                $(this).append('<input type="hidden" name="pm_media_file" value="1" />');
                            });
            
                            $('#media-items').bind('DOMNodeInserted', function() {
                                var $this = $(this);
                                $this.find('tr.image_alt').hide();
                                $this.find('tr.post_excerpt').hide();
                                $this.find('tr.url').hide();
                                $this.find('tr.align').hide();
                                $this.find('tr.image-size').hide();
                                $this.find('tr.submit input.button').val('<?php _e('Use This File', 'pm'); ?>');
                            }).trigger('DOMNodeInserted');
                        });
                    })(jQuery);
                    </script>
                <?php
                    }
            }
            
        function meta_option_script(){
                global $post_type;                
                
                if (($_GET['post_type']) || ($post_type)) :
                
                 if( !post_type_supports($post_type,'editor' ) ){
                      add_thickbox();
                      wp_enqueue_script('media-upload');
                      add_action( 'admin_print_footer_scripts', 'wp_tiny_mce', 25 );
                    }
                
                wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script( 'jquery-ui-widget');
                wp_enqueue_script( 'jquery-ui-mouse');
                wp_register_script( 'jquery-ui-slider', PM_ASSECTS_URL.'js/ui/jquery.ui.slider.js',array('jquery-ui-core','jquery-ui-mouse','jquery-ui-widget') );
                wp_enqueue_script('jquery-ui-slider' );
                
                wp_register_style( 'pluginCore-css', PM_ASSECTS_URL.'css/pluginCore.css' );
                wp_enqueue_style('pluginCore-css' ); 
                wp_register_style( 'post-meta-post-style', PM_ASSECTS_URL.'css/post_meta_post.css' );
                wp_enqueue_style('post-meta-post-style' );
                wp_register_script( 'jquery-fileuploader', PM_ASSECTS_URL.'js/jquery/fileuploader.js');
                wp_enqueue_script('jquery-fileuploader' );
                wp_register_style( 'jquery-fileuploader-css', PM_ASSECTS_URL.'css/jquery/fileuploader.css');
                wp_enqueue_style('jquery-fileuploader-css' );
                
                /* End of file upload */
                
                global $post;
                $uploads = wp_upload_dir();
                $data = array(
                            'on_preview'    =>PM_ASSECTS_URL.'images/no_preview.png', 
                            'uploaderURL'   =>PM_PLUGIN_URL.'/lib/helpers/uploader/uploader.php',
                            'uploadurl'     => site_url().'/wp-content/uploads',
                            'short_code_icon'  =>  PM_ASSECTS_URL.'images/icon.png'
                    );
                    wp_localize_script( 'jquery', 'pm_jsvar', $data );
                $fileupload = array(
                            'upload'        => __( 'Upload'),
                            'drop'          => __( 'Drop files here to upload'),
                            'cancel'        => __( 'Cancel'),
                            'failed'        => __( 'Failed'),
                            'invalid_extension' => sprintf( __( '%1$s has invalid extension. Only %2$s are allowed.'), '{file}', '{extensions}' ),
                            'too_large'         => sprintf( __( '%1$s is too large, maximum file size is %2$s.'), '{file}', '{sizeLimit}' ),
                            'empty_file'        => sprintf( __( '%s is empty, please select files again without it.'), '{file}' ),
                        );
                    wp_localize_script( 'jquery-fileuploader', 'fileuploader', $fileupload );
                    
                 
                 

                wp_register_script( 'jquery-ui-datepicker', PM_ASSECTS_URL.'js/ui/jquery.ui.datepicker.js',array('jquery') );
                wp_enqueue_script('jquery-ui-datepicker' );
                wp_register_script( 'jquery-ui-timepicker-addon', PM_ASSECTS_URL.'js/ui/jquery-ui-timepicker-addon.js',array('jquery','jquery-ui-slider','jquery-ui-datepicker' ) );
                wp_enqueue_script('jquery-ui-timepicker-addon' );
                wp_register_style( 'jquery-ui-all', PM_ASSECTS_URL.'css/ui/jquery.ui.all.css');
                wp_enqueue_style('jquery-ui-all' );
                
                
                wp_register_style( 'post-meta-validationEngine-css', PM_ASSECTS_URL.'css/jquery/validationEngine.css' );
                wp_enqueue_style('post-meta-validationEngine-css' );
                wp_register_script( 'post-meta-validationEngine', PM_ASSECTS_URL.'js/jquery/validationEngine.js'); 
                wp_enqueue_script('post-meta-validationEngine'); 
                wp_register_script( 'post-meta-validationEngine-en', PM_ASSECTS_URL.'js/jquery/validationEngine-en.js'); 
                wp_enqueue_script('post-meta-validationEngine-en');
                
                 wp_register_script( 'post-meta-admin-script', PM_ASSECTS_URL.'js/post_meta_admin.js' );
                wp_enqueue_script('post-meta-admin-script' );
                 wp_register_script( 'post-meta-post-script', PM_ASSECTS_URL.'js/post_meta_post.js',array('jquery','media-upload','thickbox','jquery-fileuploader') );
                wp_enqueue_script('post-meta-post-script' );       
                
                endif;
            }
            
            function pm_img_preview(){
                global $postMeta;
                
                echo $postMeta->render("thumb",array(
                                                        'file'=>$_REQUEST['imgurl'],
                                                        'width'=>150,
                                                        'height'=>150                                                        
                                                        ));
                die();
                
            }
            function pm_audio_preview(){
                global $postMeta;
                
                echo $postMeta->render("preview_audio",array('file'=>$_REQUEST['url'],'id'=>$_REQUEST['id']));
                die();
                
            }
            function pm_video_preview(){
                global $postMeta;
                
                echo $postMeta->render("preview_video",array('file'=>$_REQUEST['url'],'id'=>$_REQUEST['id']));
                die();
            }
            function pm_file_preview(){
                echo "<img src='".PM_ASSECTS_URL."images/folder.png' />";
                die();
            }
            function pm_load_group(){
                 global $postMeta;
                 $pm_options = get_option($postMeta->options['post_meta']);
                 $group=$pm_options[$_REQUEST['post_type']]['group'][$_REQUEST['group_key']];
                 echo "<div class='pm_group'>";
                    
                     foreach($group['field'] as $field){
                        echo ($field['duplicate'])?"<div class='pm_field_group_{$field['meta_key']} pm_sortable pm_field_group' style='border:none; margin:10px 0'>":'';
                            echo $postMeta->render("postField",array('field'=>$field,'group_count'=>$_REQUEST['group_count'],'group_id'=>$_REQUEST['group_key'],'key'=>1,'pm_load_group'=>true));
                        echo ($field['duplicate'])?"</div>":'';
                     }
                   
                           echo "<div class='pm-group-control'>
                                    <a class='duplicate-add-group' group_id='{$_REQUEST['group_key']}' post_type='{$_REQUEST['post_type']}' href='#Add Group'>Add New Group</a>
                                    <a class='duplicate-remove-group' style='display:inline' group_id='{$_REQUEST['group_key']}' href='#Remove Group'>Remove Group</a>
                                    <span class='group_count_label'></span>
                                  </div>";
                 echo "</div>";
                 die();
            }            
            function add_custom_meta_box(){
                global $postMeta,$post_type;
                
                
                    $pm_options = get_option($postMeta->options['post_meta']);
                    $meta_boxs =$pm_options[$post_type];                        
                        if(is_array($meta_boxs) && !empty($meta_boxs)){
                            foreach($meta_boxs['group'] as $Key => $meta_box){
                                if($meta_box['duplicate']){$groupKey=$Key;}
                                                if($meta_box['field']){
                                                            add_meta_box(  
                                                                        $meta_box['meta_key'], // $id
                                                                        $meta_box['title'], // $title
                                                                        array( $this, 'render_meta_box_content' ), // $callback
                                                                        $post_type, // $page  
                                                                        $meta_box['context'], // $context
                                                                        $meta_box['priority'],
                                                                        array('fields'=>$meta_box['field'],'group_id'=>$groupKey ,'group_metakey'=>$meta_box['meta_key'] )
                                                                        ); // $priority
                                                        }
                                            } // end of  $meta_boxs['group'] foreach
                                        }
                                        
        
            }

    function render_meta_box_content($post ,$arguments){
        wp_nonce_field( plugin_basename( __FILE__ ), 'pm_nonce' );
        global $postMeta,$post_type;
        
       $fields = $arguments['args']['fields'];
       $group_id = $arguments['args']['group_id'];
       $group_metakey= $arguments['args']['group_metakey'];

      $html= "<div class='pm-group-control'>
                <a class='duplicate-add-group' group_id='$group_id' post_type='$post_type' meta_key='$group_metakey' href='#'>Add New Group</a>
                <a class='duplicate-remove-group' style='display:none' group_id='$group_id' href='#'>Remove Group</a>
                <span class='group_count_label'></span>
              </div>";

       if($fields){
            $group_count_meta = get_post_meta($post->ID, 'group_count_'.$group_metakey, true);
            $group_count = ($group_count_meta)?$group_count_meta:1;
            $groupRemoveVisibility=($group_count>1)?'inline':'none';
           
           for($i=1;$i<=$group_count; $i++){
                   echo "<div class='pm_group'>";
                       foreach($fields as $field){
                        
                            $meta_data =get_post_meta($post->ID, $field['meta_key'],true);
                            $metas = $meta_data[$i];
                            
                            $border =(is_array($metas) && count($metas)>1)?'1px dashed #000000':'none';
                            
                                     echo ($field['duplicate'])?"<div class='pm_field_group_{$field['meta_key']} pm_sortable pm_field_group' style='border:$border; margin:10px 0'>":'';
                                      if(is_array($metas)){
                                                $last_key=count($metas);
                                                if($last_key>1){
                                                    $remove_field=true;
                                                    $label_count=true;
                                                }else{
                                                    $remove_field=false;
                                                    $label_count=false;
                                                }
                                        foreach($metas as $key=>$meta){
                                             echo $postMeta->render("postField",array('field'=>$field,'group_count'=>$i,'group_id'=>$group_id,'value'=>$meta,'key'=>"$key",'label_count'=>$label_count,'remove_field'=>$remove_field));
                                            }
                                           // echo "<input type='hidden' name='last_{$field['meta_key']}' id='last_{$field['meta_key']}' meta_key='{$field['meta_key']}' value='$last_key' />";
                                        }else{
                                            $key=($group_count)?1:null;
                                             echo $postMeta->render("postField",array('field'=>$field,'group_count'=>$i,'group_id'=>$group_id,'value'=>$metas,'key'=>"$key"));
                                            // echo "<input type='hidden' name='last_{$field['meta_key']}' id='last_{$field['meta_key']}' meta_key='{$field['meta_key']}' value='1' />";
                                        }
                                     echo ($field['duplicate'])?"</div>":'';
                       }
                       
                             $html= "<div class='pm-group-control'>
                                        <a class='duplicate-add-group' group_id='$group_id' post_type='$post_type' meta_key='$group_metakey' href='#'>Add New Group</a>
                                        <a class='duplicate-remove-group' style='display:$groupRemoveVisibility' group_id='$group_id' href='#'>Remove Group</a>
                                        <span class='group_count_label'>$i</span>
                                      </div>";
                       
                        echo ($group_id)?$html:''; 
                   echo "</div>";
            }
           echo "<input type='hidden' name='mofields[group_count_$group_metakey]' id='group_count' value='$group_count' />";
               

       }
 
    }
    function save_meta_option_data($post_id) {  
        
        // verify if this is an auto save routine. 
        // If it is our form has not been submitted, so we dont want to do anything
        
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if ( !wp_verify_nonce( $_POST['pm_nonce'], plugin_basename( __FILE__ ) ) )return;
        
          // Check permissions
          if ( $_GET['post_type'] ) 
          {
            if ( !current_user_can( 'edit_'.$_GET['post_type'], $post_id ) )
                return;
          }
                    
                    $customfields = $_POST['mofields'];
                    
                    if($customfields){
                        //echo '<pre>';
                        //print_r($customfields);
                        //echo '<pre>';
                        
                        
                                foreach( $customfields as $meta_key => $value ) {
                                    if(is_array($value)){
                                        //delete_post_meta($post_id, $meta_key);
                                        $n=1; 
                                        $data=array();
                                            foreach($value as $key=>$val){
                                                
                                                $data[$n]=$val;
                                                $n=$n+1;
                                                
                                            }
                                            $old = get_post_meta($post_id, $meta_key, true);  
                                            $new = $data;  
                                            if ($new && $new != $old) {  
                                                update_post_meta($post_id, $meta_key, $new);  
                                            } elseif ('' == $new && $old) {  
                                                delete_post_meta($post_id, $meta_key, $old);  
                                            } 
                                            //add_post_meta($post_id,$meta_key,$data);
                                        
                                    }else{
                                        $old = get_post_meta($post_id, $meta_key, true);  
                                            $new = $value;  
                                            if ($new && $new != $old) {  
                                                update_post_meta($post_id, $meta_key, $new);  
                                            } elseif ('' == $new && $old) {  
                                                delete_post_meta($post_id, $meta_key, $old);  
                                            } 
                                    }
            
                                            
                                            /*
                                            $old = get_post_meta($post_id, $meta_key, true);  
                                            $new = $value;  
                                            if ($new && $new != $old) {  
                                                update_post_meta($post_id, $meta_key, $new);  
                                            } elseif ('' == $new && $old) {  
                                                delete_post_meta($post_id, $meta_key, $old);  
                                            } */
                                      } 
                            }
                
            }  
    
    
    
}

endif;

?>