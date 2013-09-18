<?php
        global $postMeta;
        global $post;        
        
        $fieldType      = 'text';
        $class          = 'pm_post_input ';
        $divClass       = null;
        $divStyle       = null;
        $fieldOptions   = null;
        $html           = null;
        $validation     = null;
        $maxlength      = null;
        $option_after   = null;
        $by_key         = false;
        
        
        if( isset( $field['required'] ) ){
            
            $validation .= 'required,';
           
        }
         if($field['type']=="url"){
                $validation .= "custom[url],";
            }
        if($field['type']=="email"){
            $validation .= "custom[email],";
        }
        if($field['type']=="phone"){
            $validation .= "custom[phone],";
        }       
        if($field[ 'type' ]=='hidden'){
            $value = ($field['hidden_value'])?$field['hidden_value']:'1';
            $divStyle .="display:none; ";
         }
        
        if( isset( $field['css_class'] ) ){
            $divClass .= "{$field['css_class']} ";
        }
        $field['type']=isset($field['type'])?$field['type']:"text";
        
        
        
        if( isset( $field['css_style'] ) ){
            $divStyle .= "{$field['css_style']} ";
        }
        $divStyle = $divStyle ? "style='$divStyle'" : null;
        
        $style = null;
         if($field['width']){
            $style .= "width:{$field['width']} ";
         }
         if($field['height']){
            $style .= "height:{$field['height']} ";
         }
         if($field['type']=="wp_edior"){
            $field['type'] ="textarea";
            $class .= "pm_wp_edior pm_add_wp_edior ";
        }
         
        if($field['type']=='textarea'){
            
            $style ="$style 'cols='60' rows='10";
         }
         
         
         if($field['type']=='checkbox'){
            if( isset( $field['required'] ) ) :
                $validation .= 'minCheckbox[1],';  
            endif; 
            if($field['alignment']=='horizontal'){
                $option_after = "<br />";
            }
            
            if(!$value){
                $value=array();
                $values = (array)preg_split("/\\n/",$field['default_value']);
                foreach($values as $val){
                    $value[]=trim($val);
                }
            }
            
            $combind        = true;
         }
         
         if($field['type']=='radio'){
            if($field['alignment']=='horizontal'){
                $option_after = "<br />";
            }
            if(!$value){
                $value=trim($field['default_value']);
            }
         }
         if( $field['type']=='select'){
            
            if($field['multiple']){
                $multiple="multiple";
            }
            if(!$value){
                $value=trim($field['default_value']);
            }
         }
         
         if( $field['max_char'] ){
                $maxlength = $field['max_char'];
            }
         
        if(  $field['options']  ){
                $temp = (array)preg_split("/\\n/",$field['options']);
                foreach( $temp as $val ){
                    $option     = explode( "=", $val );
                    $optionKey  = trim($option[0]);
                    $optionVal  = isset($option[1]) ? trim($option[1]) : $optionKey;
                    $fieldOptions[$optionKey] = $optionVal;
                }
                $by_key = true;
            }
        if($field['type'] == "email" || $field['type'] == "url" || $field['type'] == "phone") $field['type']="text";
         if($field['type']=='text' || $field['type']=='textarea'){
            $placeholder = $field['title'];
         }
        
        if($field['type']=='image_media' || $field['type']=='image' || $field['type']=='file' || $field['type']=='audio' || $field['type']=='video'){
            $class .='pm_uploaded_url ';
        }

        if($field['type'] == 'image' || $field['type'] == 'audio' || $field['type'] == 'video' || $field['type']=='file'){
            $ext_default = ($field['allowed_extension'])?implode(',',$field['allowed_extension']):null;
            $ext_custom = ($field['allowed_extension_custom'])?','.$field['allowed_extension_custom']:null;
            $ext = $ext_default.$ext_custom;
            $file_filter =($ext)?" extension='$ext'":null;
            $file_filter .=(isset($field['max_file_size']))?" maxsize='".$field['max_file_size']*1024*1024 ."'":null;
        }  

if( $field['type'] == 'number' ){  
    $validation     .= "custom[integer],";
    if( isset( $field['min_number'] ) ) :
        $validation .= "min[{$field['min_number']}],";
    endif;
    if( isset( $field['max_number'] ) ) :
        $validation .= "max[{$field['max_number']}],";
    endif;     
}
  

if( $field['type'] == 'datetime' ){
    if( $field['datetime_selection'] == 'date' ) :
        $validation .= "custom[date],";
        $class      .= "pm_date ";
    elseif( $field['datetime_selection'] == 'time' ) :
        $validation .= "custom[time],";
        $class      .= "pm_time ";  
    elseif( $field['datetime_selection'] == 'datetime' ) :
        $validation .= "custom[datetime],";
        $class      .= "pm_datetime ";                
    endif;
}

$required = ($field['required'])?"<span class='required_label'>*</span>":""; 

if($field['duplicate']){
    // begin a table row with  
        $keyIndex=($key)?$key:'';
        $labelCountVisibility=($label_count)?'inline':'none';
        $label_repeat = "<em style='display: $labelCountVisibility; '>(<span class='pm_field_index'>$keyIndex</span>)</em>";
        
    $arrayKey=($key)?"[$key]":'';
    $repeatClass ="repeat-{$field['meta_key']} ";
    if($pm_load_group){
        $removeVisibility='none';
    }else{
        $removeVisibility=($remove_field)?'inline':'none';
    }
    
    $field_control ="<div class='pm-field-control'><span class='hndle' style='display:$removeVisibility'></span><a class='duplicate-add' meta_key='{$field['meta_key']}' href='#Add Field'>Add</a><a class='duplicate-remove' style='display:$removeVisibility' meta_key='{$field['meta_key']}' href='#Remove Field'>Remove</a> </div> ";
}
if($group_count){
    $arrayKey=($group_count)?"[$group_count]":'';
    $arrayKey .=($key)?"[$key]":'';
}

        if( $validation ) $class .= "validate[" . rtrim( $validation, ',') . "]";
        
        
                        $html .= $postMeta->create_input("mofields[{$field['meta_key']}]$arrayKey",$field['type'], array( 
                                        "value"             =>isset($value)?$value: null,
                                        "label"             => "<span class='name'>$field[title]</span> $label_repeat $required",
                                        "label_class"     => "pm_field_title",
                                        "id"                => "pm_field_$field[id]_{$group_count}_$key",
                                        "class"             =>  $class,
                                        "multiple"          =>  $multiple,
                                        "after"             => "<span class='pm_note'>{$field['desc']} </span>",
                                        "option_after" =>   isset($option_after)  ? $option_after : null,
                                        "placeholder"       =>  isset($placeholder)?$placeholder:null,
                                        "style"             =>  isset($style)?$style:null, 
                                        "field_enclose"     =>  "div class='pm_field_item'",
                                        "maxlength"         => isset($maxlength)?$maxlength:null,
                                        "file_filter"       => $file_filter,
                                        "field_control"     => $field_control,
                                        "enclose"           =>  "div class='pm_field $repeatClass $divClass' $divStyle ",
                                        
                                        "onblur"    => isset($onBlur)           ? $onBlur : null,
                                        "combind"   => isset($combind)          ? $combind : false,
                                        "by_key"            =>$by_key
                                     ),$fieldOptions); 
                                     
                                     
        $html = "$html";

?>