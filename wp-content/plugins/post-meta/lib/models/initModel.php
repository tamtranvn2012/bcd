<?php

if( !class_exists( 'initModel' ) ) :

class initModel {
    
       /**

     * Generate nonce field

     */
    function controllersOrder(){
        return array(
            'pmPreloadsController',
            'pmPostMetaController',
            'pmPostTypeController',
            'pmTaxonomyController',
            'pmPostController',
            'pmImportExportController',
            'pmSettingsController',
            'pmVersionController',
            'postMetaPro'      
        );
    }
        
            
    /**
     * Calling views. if pro then render from pro directory
     */

        
        function create_input($name='', $type='text', $attr=array(), $options=array()){
            $name   = trim($name);
            $name   = $name ? "name=\"$name\"" : '';      
            
            if( isset($attr['value']) ){
                if( is_string( $attr['value'] ) ) $attr['value'] = esc_attr( trim( $attr['value'] ) );
            }                           
            $value  = isset( $attr['value'] ) ? $attr['value'] : null;           
            
            //filter attr for add
            $excludeAttr = array( 'before', 'after', 'enclose', 'field_enclose', 'field_control', 'label', 'by_key', 'label_class', 'label_enclose', 'label_extra', 'combind', 'option_before', 'option_after', 'file_filter');      
            $excludeType = array( 'select', 'radio', 'label', 'checkbox','textarea' );  //exclude adding value                          
            if(in_array( $type, $excludeType )) $excludeAttr[] = 'value';   
            $include = null;                  
            if($attr){
                foreach( $attr as $key => $val){
                    if( !in_array( $key, $excludeAttr ) ){
                        $include .= $val ? "$key='$val' " : "";
                    }                        
                }
            }
            
            $option_before  = isset( $attr['option_before'] )  ? $attr['option_before'] : null;
            $option_after   = isset( $attr['option_after'] )   ? $attr['option_after']  : null;    
            $by_key         = isset( $attr['by_key'] )         ? $attr['by_key']        : null;    
            $label_class    = isset( $attr['label_class'] )    ? $attr['label_class']   : null;  
            $label_extra    = isset( $attr['label_extra'] )    ? $attr['label_extra']   : null; 
            $field_enclose    = isset( $attr['field_enclose'] )    ? $attr['field_enclose']   : null;
            $field_control    = isset( $attr['field_control'] )    ? $attr['field_control']   : null;
            $file_filter    = isset( $attr['file_filter'] )    ? $attr['file_filter']   : null;
            
            $html = '';          
            if( $type == 'select' ){
                $html .= "<select $name $include>";
                if(isset($options)){                    
                    foreach($options as $key => $val){
                        if( !$by_key ) $key = $val;         
                        $key = is_string($key) ? trim($key) : $key;                                                                    
                        $selected = ($key == $value) ? "selected='selected'" : ""; 
                        $html .= "<option value='$key' $selected>$val</option>";
                    }                    
                }else{ $html .= "No option set yet"; }
                $html .= "</select>";
            }elseif($type == 'radio'){
                if(isset($options)){
                    foreach($options as $key => $val){
                        if( !$by_key ) $key = $val; 
                        $key = is_string($key) ? trim($key) : $key;
                        $checked = ($key == $value) ? "checked='checked'" : "";
                        $html .= "$option_before<input type='$type' $name $include value='$key' $checked /> $val $option_after";
                    }                    
                } else{ $html .= "No option set yet"; }
            }elseif($type == 'checkbox'){ //print_r($options);
                $attr['combind'] = isset($attr['combind']) ? $attr['combind'] : false;
                if( $attr['combind'] ){
                    $name = rtrim( $name, "\"") . "[]\"";
                    if(isset($options)){
                        foreach($options as $key => $val){
                            if( !$by_key ) $key = $val; 
                            $key = is_string($key) ? trim($key) : $key;
                            if( is_array($value) )
                                $checked = in_array( $key, $value ) ? "checked='checked'" : "";
                            else
                                $checked = ($key == $value) ? "checked='checked'" : "";
                            $html .= "$option_before<input type='$type' {$name} $include value='$key' $checked /> $val $option_after";
                        }     
                    }else{ $html .= "No option set yet"; }          
                }else{             
                    $checked = $value ? "checked='checked'" : "";                
                    $html .= "<input type='$type' $name $include $checked />";
                }
            }elseif($type == 'textarea'){
                $html .= "<textarea $name $include>$value</textarea>";
            }elseif($type == 'file'){
                global $postMeta;
                if($attr['value']){
                    $style ="block";
                    $upload_dir = wp_upload_dir();
                    $dl_url=$upload_dir['baseurl'].$attr['value'];
                    $preview_url= PM_ASSECTS_URL.'images/folder.png';
                }else{
                    $style ="none";
                    $preview_url = PM_ASSECTS_URL.'images/no_preview.png';
                }
                
                $img_media='';
                $img_media .="<div class='file_wrapper'>";
                    $img_media .="<div class ='file_preview'>";
                    $img_media .="<div class='file_thum_manage' style='display:$style;'><a target='_blank' href='$dl_url' class='dl' > Download </a><a href='#Delete' class='delete' onclick='pmDeleteFile(this); return false' >Delete</a></div>";
                                $img_media .="<div class='file_preview_thum'><img src='$preview_url' /></div>";
                    $img_media .="</div>";  
                    $img_media .="<div class='file_input'>";
                        $img_media .= "<div id='upload_response_{$attr['id']}'></div>";
                        $img_media .="<input type='hidden' $name $include  value='' />";
                        //$img_media .="<input type='text' class='upload-url'  value='' />";
                        //                        $img_media .="<a class='button thickbox update_field_media_upload' id='thumb_{$attr['id']}' href='media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=255'>Set Image</a>";
                        $img_media .="<div id='file_upload_{$attr['id']}' pm_field_id='{$attr['id']}' class='pm_file_upload_button' $file_filter name='pc_file_upload_button'> File Upload </div>";
                    $img_media .="</div>";
                
                $img_media .="</div>";
                
                $html .=$img_media;     
            }elseif($type == 'image'){
                global $postMeta;
                if($attr['value']){
                    $style ="block";
                    $preview_url= $postMeta->generate_thumb($attr['value'],150,150);
                    $upload_dir = wp_upload_dir();
                    $view_url=$upload_dir['baseurl'].$attr['value'];
                }else{
                    $style ="none";
                    $preview_url = PM_ASSECTS_URL.'images/no_preview.png';
                }
                
                $img_media='';
                $img_media .="<div class='file_wrapper'>";
                    $img_media .="<div class ='file_preview'>";
                    $img_media .="<div class='file_thum_manage' style='display:$style;'><a target='_blank' href='$view_url' class='dl' > View </a><a href='#Delete' class='delete' onclick='pmDeleteFile(this); return false' >Delete</a></div>";
                                $img_media .="<div class='file_preview_thum'><img src='$preview_url' /></div>";
                    $img_media .="</div>";  
                    $img_media .="<div class='file_input'>";
                        $img_media .= "<div id='upload_response_{$attr['id']}'></div>";
                        $img_media .="<input type='hidden' $name $include  value='' />";
                        //$img_media .="<input type='text' class='upload-url'  value='' />";
                        //                        $img_media .="<a class='button thickbox update_field_media_upload' id='thumb_{$attr['id']}' href='media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=255'>Set Image</a>";
                        $img_media .="<div id='img_upload_{$attr['id']}' pm_field_id='{$attr['id']}' class='pm_img_upload_button' $file_filter name='pc_media_upload_button'> Upload Image </div>";
                    $img_media .="</div>";
                
                $img_media .="</div>";
                
                $html .=$img_media;
                        
            }elseif($type == 'audio'){
                global $postMeta;
                if($attr['value']){
                    $style ="block";
                    $preview_url= $postMeta->render('preview_audio',array('file'=>$attr['value'],'id'=>$attr['id']));
                    $upload_dir = wp_upload_dir();
                    $dl_url=$upload_dir['baseurl'].$attr['value'];
                }else{
                    $style ="none";
                    $preview_url = "<img src='".PM_ASSECTS_URL."images/no_preview.png' />";
                }
                
                $img_media='';
                $img_media .="<div class='file_wrapper'>";
                    $img_media .="<div class ='file_preview'>";
                    $img_media .="<div class='file_thum_manage' style='display:$style;'><a target='_blank' href='$dl_url' class='dl' > Download </a><a href='#Delete' class='delete' onclick='pmDeleteFile(this); return false' >Delete</a></div>";
                                $img_media .="<div class='file_preview_thum'>$preview_url</div>";
                    $img_media .="</div>";  
                    $img_media .="<div class='file_input'>";
                        $img_media .= "<div id='upload_response_{$attr['id']}'></div>";
                        $img_media .="<input type='hidden' $name $include  value='' />";
                        //$img_media .="<input type='text' class='upload-url'  value='' />";
                        //                        $img_media .="<a class='button thickbox update_field_media_upload' id='thumb_{$attr['id']}' href='media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=255'>Set Image</a>";
                        $img_media .="<div id='audio_upload_{$attr['id']}' class='pm_audio_upload_button' $file_filter name='pm_audio_upload_button'> Audio Upload </div>";
                    $img_media .="</div>";
                
                $img_media .="</div>";
                
                $html .=$img_media;      
            }elseif($type == 'video'){
                global $postMeta;
                if($attr['value']){
                    $style ="block";
                    $preview_url= $postMeta->render('preview_video',array('file'=>$attr['value'],'id'=>$attr['id']));
                    $upload_dir = wp_upload_dir();
                    $dl_url=$upload_dir['baseurl'].$attr['value'];
                }else{
                    $style ="none";
                    $preview_url = "<img src='".PM_ASSECTS_URL."images/no_preview.png' />";
                }
                
                $img_media='';
                $img_media .="<div class='file_wrapper'>";
                    $img_media .="<div class ='file_preview'>";
                    $img_media .="<div class='file_thum_manage' style='display:$style;'><a target='_blank' class='dl' href='$dl_url' > Download </a><a href='#Delete' class='delete' onclick='pmDeleteFile(this); return false' >Delete</a></div>";
                                $img_media .="<div class='file_preview_thum'>$preview_url</div>";
                    $img_media .="</div>";  
                    $img_media .="<div class='file_input'>";
                        $img_media .= "<div id='upload_response_{$attr['id']}'></div>";
                        $img_media .="<input type='hidden' $name $include  value='' />";
                        
                        $img_media .="<div id='video_upload_{$attr['id']}' class='pm_video_upload_button' $file_filter name='pm_video_upload_button'> Video Upload </div>";
                    $img_media .="</div>";
                
                $img_media .="</div>";
                
                $html .=$img_media;      
            }elseif( $type == 'label' ){        
                $for   = isset($attr['for']) ? "for='{$attr['for']}'" : '';
                $html .= "<label $for $include>$value</label>";
            }elseif( $type == 'hidden'){
                $html .= "<input type='$type' $name $include />";
                
            }elseif($type == 'image_media'){
                global $postMeta;
                if($attr['value']){
                    $style ="block";
                    $preview_url= $postMeta->generate_thumb($attr['value'],150,150);
                }else{
                    $style ="none";
                    $preview_url = PM_ASSECTS_URL.'images/no_preview.png';
                }
                
                $img_media='';
                $img_media .="<div class='file_wrapper'>";
                    $img_media .="<div class ='file_preview'>";
                    $img_media .="<div class='file_thum_manage' style='display:$style;'><a target='_blank' href='{$attr['value']}' class='dl' > View </a><a href='#delete' class='delete' onclick='pmDeleteFile(this); return false' >delete</a></div>";
                                $img_media .="<div class='file_preview_thum'><img src='$preview_url' /></div>";
                    $img_media .="</div>";  
                    $img_media .="<div class='file_input'>";
                        $img_media .= "<div id='upload_response_{$attr['id']}'></div>";
                        $img_media .="<input type='hidden' $name $include  value='' />";
                        $img_media .="<div id='media_upload_{$attr['id']}' class='button pc_media_upload_button' type='button' name='pc_media_upload_button'>Upload Image via media </div>";
                    $img_media .="</div>";
                
                $img_media .="</div>";
                
                $html .=$img_media;
                
            }else{
                $html .= "<input type='$type' $name $include />";
            }
            
            
            $before  = isset( $attr['before'] )  ? $attr['before'] : null;
            $after   = isset( $attr['after'] )   ? $attr['after']  : null;            
            $html = $before . $html . $after;
            
            //Enclose by html tag only input field with out label
            if( isset($attr['field_enclose']) ){
                $enclose = $attr['field_enclose'];
                $encloseTag = explode( ' ', trim($enclose) );
                $encloseTag = $encloseTag[0];
                $html = "<$enclose>$html</$encloseTag>";
            }
            
            //Add lebel if required
            $label_class =  $label_class ? $label_class : 'pm_label';            
            if( isset($attr['label']) ){
                $for   = isset($attr['id']) ? "for='{$attr['id']}'" : '';
                $label_html = "<label class='$label_class' $for>{$attr['label']} {$label_extra}</label>";
                if(isset($attr['label_enclose'])){
                                $enclose = $attr['label_enclose'];
                                $encloseTag = explode( ' ', trim($enclose) );
                                $encloseTag = $encloseTag[0];
                                $label_html = "<$enclose>$label_html</$encloseTag>";                    
                                } 
            }
                                                             
            //Enclose by other html element
            if( isset($attr['enclose']) ){
                $enclose = $attr['enclose'];
                $encloseTag = explode( ' ', trim($enclose) );
                $encloseTag = $encloseTag[0];
                //$output = "<$enclose>$label_html $html</$encloseTag>";
                $html = "<$enclose>$label_html $html $field_control</$encloseTag>";
            }
                 
            
            return $html;  
            
        }
        /**
         * $message : Message content 
         * $class : success error info warning validation
         * $inAdmin : Which area
         */
        function showMessage($message, $class='success', $inAdmin=false ){
            $class = 'pc_'.$class;
            $html ='';
            $html  .= $inAdmin ? "<div class='updated'><p>$message</p></div>" : "<div class='$class'>$message</div>";
            
            return $html;
        }
        
            
            //   
            function generate_thumb($file, $width, $height, $crop = false){
                
                
                $uploads    = wp_upload_dir();
                
                if(@preg_match('/\/wp-content\/uploads\//',$file ,$match)){
                    
                   $fullPath = $uploads['basedir'].str_replace( $uploads['baseurl'] , '', $file);
                   $fullUrl = $file;
                    
                }else{
                    $fullPath   = $uploads['basedir'] . $file;
                    $fullUrl    = $uploads['baseurl'] . $file;
                }
                $fileData   = pathinfo( $fullPath );
                $fileName   = $fileData['basename'];
            
                if( !file_exists( $fullPath ) ) return;               
            
                // In case of image
                if( is_array( getimagesize( "$fullPath" ) ) ){
                    if( @$width AND @$height ){
                        $resizedImage = image_resize( $fullPath, $width, $height ,$crop);
                        if( is_wp_error($resizedImage) )
                            $error[] = $resizedImage->get_error_message();               
                        if( !isset($error) )
                            $fullUrl = str_replace( $uploads['basedir'], $uploads['baseurl'], $resizedImage );
                    }        
                    return $fullUrl;  
                }   
                
            }
            
            
            
            
    
}
    
    
    
endif;


?>