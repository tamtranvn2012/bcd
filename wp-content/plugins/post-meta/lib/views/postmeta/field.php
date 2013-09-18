<?php
global $postMeta;

$field_type_data    = $postMeta->getFields('key');

/* Extention Control */
if($field['type']=='image' || $field['type']=='audio' || $field['type']=='video' || $field['type']=='file'){
    
    $pmAllExts = $postMeta->pmAllExts();
    $settings=get_option($postMeta->options['settings']);
    
    if($field['type']=='image'){
        $imageExts = $pmAllExts['image'];
        $setting_imgExt = $settings['file']['allext']['image'];
        if(!$setting_imgExt){
            $setting_imgExt=array();
        }
        foreach($imageExts as $key=>$ext){
            if(!in_array( $key, $setting_imgExt )){
                unset($imageExts[$key]);
            }
        }
        
    }elseif($field['type']=='audio'){
        $audioExts = $pmAllExts['audio'];
        $setting_audioExt = $settings['file']['allext']['audio'];
        if(!$setting_audioExt){
            $setting_audioExt=array();
        }
        foreach($audioExts as $key=>$ext){
            if(!in_array( $key, $setting_audioExt )){
                unset($audioExts[$key]);
            }
        }
        
    }elseif($field['type']=='video'){
        $videoExts = $pmAllExts['video'];
        $setting_videoExt = $settings['file']['allext']['video'];
        if(!$setting_videoExt){
            $setting_videoExt=array();
        }
        foreach($videoExts as $key=>$ext){
            if(!in_array( $key, $setting_videoExt )){
                unset($videoExts[$key]);
            }
        }
        
    }elseif($field['type']=='file'){
        $fileExts = $pmAllExts['file'];
        $setting_fileExt = $settings['file']['allext']['file'];
        if(!$setting_fileExt){
            $setting_fileExt=array();
        }
        foreach($fileExts as $key=>$ext){
            if(!in_array( $key, $setting_fileExt )){
                unset($fileExts[$key]);
            }
        }
        
    }
}



/* End Extention Control */
if(!$field['title']){$field['title']='Untitled Field';}
$field_type = isset($field_type) ? $field_type : $field['type'] ;

$style=($toggle)?"block":"none";

if($field[ 'type' ]=='phone'){
    $des='555-555-5555';
}else{
    $des=null;
}
$fielsTitle = $postMeta->create_input("group[$group_id][field][$id][title]","text", array( 
                                        "value"     => $field['title'], 
                                        "label"     => "Field Label", 
                                        "id"        => "pm_title_$id",
                                        "class"     => "pm_input pm_field_label validate[required]",
                                        "onclick"     => "moChangeFieldTitle(this)",
                                        "onkeyup"     => "moChangeFieldTitle(this)",
                                        "onmouseout"  =>  "moChangeFieldTitle(this)",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ));
$fieldMetaKey = $postMeta->create_input("group[$group_id][field][$id][meta_key]","text", array( 
                                        "value"     => isset($field['meta_key'])?$field['meta_key']:$post_type."_".$group_id."_".$id,
                                        "label"     => "Meta Key", 
                                        "id"        => "pm_metakey_$id",
                                        //"readonly"  =>"true",
                                        "class"     => "pm_input pm_field_meta_key validate[required,custom[onlyLcNs]]",
                                        "onkeyup"     => "moChangeFieldMetaKey(this)",
                                        "after"     => "<div class='pm_note pm_required'>Must be unique and have no space</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ));
$fieldId = $postMeta->create_input("group[$group_id][field][$id][id]","hidden", array( 
                                        "value"     => $post_type."_".$group_id."_".$id
                                     ));
$fieldType = $postMeta->create_input("group[$group_id][field][$id][type]","select", array( 
                                        "value"     => isset($field['type']) ? $field['type'] : null, 
                                        "label"     => "Field Type", 
                                        "id"        => "pm_type_$id",
                                        "class"     => "pm_input pm_field_type",
                                        "by_key"    => true,
                                        "onchange"  => "moChangeField(this, $id ,$group_id)",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ),$field_type_data);
$fieldDescription = $postMeta->create_input("group[$group_id][field][$id][desc]","textarea", array( 
                                        "value"     => ($field['desc']) ? $field['desc']  : $des, 
                                        "label"     => "Field Help Text", 
                                        "id"        => "pm_desc_$id",
                                        "class"     => "pm_input",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ));
$fieldOptions = $postMeta->create_input( "group[$group_id][field][$id][options]", "textarea", array( 
                                        "value"     => isset($field['options']) ? $field['options'] : null,
                                        "label"     => "Field Options",
                                        "id"        => "pm_opt_$id", 
                                        "class"     => "pm_input validate[required]",
                                        "rows"       => "5",
                                        "after"     => "<div class='pm_note'><span class='pm_required'>Required Field.</span> Separate each option with a newline \n(e.g itm1) for Key Value: itm1=Item 1</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) );  
                                     
$fieldDefaultValueMulti = $postMeta->create_input( "group[$group_id][field][$id][default_value]", "textarea", array( 
                                        "value"     => isset($field['default_value']) ? $field['default_value'] : null,
                                        "label"     => "Default Value", 
                                        "id"        => "pm_deflt_$id",
                                        "class"     => "pm_input",
                                        "after"     => "<div class='pm_note'>Separate each option with a newline</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) );  

$fieldDefaultValueSingle = $postMeta->create_input( "group[$group_id][field][$id][default_value]", "text", array( 
                                        "value"     => isset($field['default_value']) ? $field['default_value'] : null,
                                        "label"     => "Default Value", 
                                        "id"        => "pm_deflt_$id",
                                        "class"     => "pm_input",
                                        "after"     => "<div class='pm_note'>One option For default(e.g itm1)</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) ); 
$imageAllowedExt = $postMeta->create_input( "group[$group_id][field][$id][allowed_extension]", "checkbox", array( 
                                        "value"     => isset($field['allowed_extension']) ? $field['allowed_extension'] : array('jpg','jpeg','png','gif'),
                                        "label"     => "Allowed Extension",
                                        "class"     => "",
                                        "option_after"     => "<br />",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "combind"   => true,
                                        "by_key"    => true,
                                    ),$imageExts );
$imageMaxFileSize = $postMeta->create_input( "group[$group_id][field][$id][max_file_size]", "select", array( 
                                        "value"     => isset($field['max_file_size']) ? $field['max_file_size'] : '2',
                                        "label"     => "Max File Size",
                                        "class"     => "pm_input",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "by_key"    => true,
                                     ),array('.5'=>'.5MB','1'=>'1MB','2' => '2MB','3' => '3MB','4'=>'4MB','5'=>'5MB','10'=>'10MB') );
 
                                     
$audioAllowedExt = $postMeta->create_input( "group[$group_id][field][$id][allowed_extension]", "checkbox", array( 
                                        "value"     => isset($field['allowed_extension']) ? $field['allowed_extension'] : 'mp3',
                                        "label"     => "Allowed Extension",
                                        "class"     => "",
                                        "option_after"     => "<br />",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "combind"   => true,
                                        "by_key"    => true,
                                     ),$audioExts );

$audioMaxFileSize = $postMeta->create_input( "group[$group_id][field][$id][max_file_size]", "select", array( 
                                        "value"     => isset($field['max_file_size']) ? $field['max_file_size'] : '10',
                                        "label"     => "Max File Size",
                                        "class"     => "pm_input",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "by_key"    => true,
                                     ),array('5'=>'5MB','10'=>'10MB','15'=>'15MB','20'=>'20MB','30'=>'30MB','50'=>'50MB') );
 

$videoAllowedExt = $postMeta->create_input( "group[$group_id][field][$id][allowed_extension]", "checkbox", array( 
                                        "value"     => isset($field['allowed_extension']) ? $field['allowed_extension'] : array('mp4','avi','flv'),
                                        "label"     => "Allowed Extension",
                                        "class"     => "",
                                        "option_after"     => "<br />",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "combind"   => true,
                                        "by_key"    => true,
                                     ),$videoExts );

$videoMaxFileSize = $postMeta->create_input( "group[$group_id][field][$id][max_file_size]", "select", array( 
                                        "value"     => isset($field['max_file_size']) ? $field['max_file_size'] : '50',
                                        "label"     => "Max File Size",
                                        "class"     => "pm_input",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "by_key"    => true,
                                     ),array('10'=>'10MB','50'=>'50MB','60'=>'60MB','70'=>'70MB','80'=>'80MB','90'=>'90MB','100'=>'100MB','200'=>'200MB') );
 
$fileAllowedExt = $postMeta->create_input( "group[$group_id][field][$id][allowed_extension]", "checkbox", array( 
                                        "value"     => isset($field['allowed_extension']) ? $field['allowed_extension'] : array('zip','rar','pdf'),
                                        "label"     => "Allowed Extension",
                                        "class"     => "",
                                        "option_after"     => "<br />",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "combind"   => true,
                                        "by_key"    => true,
                                     ),$fileExts );
$fileAllowedExtCustom = $postMeta->create_input( "group[$group_id][field][$id][allowed_extension_custom]", "text", array( 
                                        "value"     => isset($field['allowed_extension_custom']) ? $field['allowed_extension_custom'] : null,
                                        "label"     => "Allowed Extension Custom",
                                        "class"     => "",
                                        "after"     => "<div class='pm_note'><span class='pm_required'>Must Be selected on file extensions settings</span>(e.g exe,rar)</div>",
                                        "enclose"       => "div class='pm_field_segment'"
                                     ));
$fileMaxFileSize = $postMeta->create_input( "group[$group_id][field][$id][max_file_size]", "select", array( 
                                        "value"     => isset($field['max_file_size']) ? $field['max_file_size'] : '10',
                                        "label"     => "Max File Size",
                                        "class"     => "pm_input",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "by_key"    => true,
                                     ),array('5'=>'5MB','10'=>'10MB','50'=>'50MB','100'=>'100MB','200'=>'200MB') );
 

$fieldRequired = $postMeta->create_input( "group[$group_id][field][$id][required]", "checkbox", array( 
                                        "value"     => isset($field['required']) ? $field['required'] : null,
                                        "after"     => " Required <br />",
                                     ) ); 
$fieldDuplicate = $postMeta->create_input( "group[$group_id][field][$id][duplicate]", "checkbox", array( 
                                        "value"     => isset($field['duplicate']) ? $field['duplicate'] : null,
                                        "after"     => " Allow Duplicate <br />",
                                     ) );  
$fieldDlRegisterOnly = $postMeta->create_input( "group[$group_id][field][$id][register_only]", "checkbox", array( 
                                        "value"     => isset($field['register_only']) ? $field['register_only'] : null,
                                        "after"     => "Display Download link Only for Register User<br />",
                                     ) );                                                                  

$fieldAlignment = $postMeta->create_input( "group[$group_id][field][$id][alignment]", "radio", array( 
                                        "value"     => isset($field['alignment']) ? $field['alignment'] : "vertical",
                                        "after"     =>  "<br />",
                                        "by_key"            =>true
                                     ),array('vertical'=>'Vertical','horizontal'=>'Horizontal'));
$selectMultiple = $postMeta->create_input( "group[$group_id][field][$id][multiple]", "checkbox", array( 
                                        "value"     => isset($field['multiple']) ? $field['multiple'] : null,
                                        "after"     => " Multiple values <br />",
                                     ) );  
                                     
                                     

$fieldCssClass = $postMeta->create_input("group[$group_id][field][$id][css_class]","text", array( 
                                        "value"     => $field['class'], 
                                        "label"     => "Field Class", 
                                        "id"        => "pm_css_class_$id",
                                        "class"     => "pm_input",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ));
$fieldCssStyle = $postMeta->create_input( "group[$group_id][field][$id][css_style]", "textarea", array( 
                                        "value"     => isset($field['css_style']) ? $field['css_style'] : null,
                                        "label"     => "CSS Style",
                                        "id"        => "pm_css_style_$id",
                                        "class"     => "pm_input",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) ); 
 
$fieldSize = $postMeta->create_input( "group[$group_id][field][$id][size]", "text", array( 
                                        "value"     => isset($field['size']) ? $field['size'] : null,
                                        "label"     => "Field Size",
                                        "id"        => "pm_field_size_$id", 
                                        "class"     => "pm_input ",
                                        "after"     => "<div class='pm_note'>(e.g. 200px;)</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) ); 
 
$fieldMaxChar = $postMeta->create_input( "group[$group_id][field][$id][max_char]", "text", array( 
                                        "value"     => isset($field['max_char']) ? $field['max_char'] : null,
                                        "label"     => "Max Character", 
                                        "id"        => "pm_max_char_$id",
                                        "class"     => "pm_input",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) ); 
$fieldWidth =  $postMeta->create_input( "group[$group_id][field][$id][width]", "text", array( 
                                        "value"     => isset($field['width']) ? $field['width'] : null,
                                        "label"     => "Width", 
                                        "id"        => "pm_width_$id",
                                        "class"     => "pm_input",
                                        "after"     => "<div class='pm_note'>(e.g. 200px;)</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) );
$fieldHeight = $postMeta->create_input( "group[$group_id][field][$id][height]", "text", array( 
                                        "value"     => isset($field['height']) ? $field['height'] : null,
                                        "label"     => "Height", 
                                        "id"        => "pm_height_$id",
                                        "class"     => "pm_input",
                                        "after"     => "<div class='pm_note'>(e.g. 200px;)</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) ); 
$fieldMinNumber = $postMeta->create_input( "group[$group_id][field][$id][min_nimber]", "text", array( 
                                        "value"     => isset($field['min_nimber']) ? $field['min_nimber'] : null,
                                        "label"     => "Minimum Number",
                                        "id"        => "pm_minnumber_$id", 
                                        "class"     => "pm_input ",
                                        "after"     => "<div class='pm_note'>(e.g. 5;)</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) ); 
$fieldMaxNumber = $postMeta->create_input( "group[$group_id][field][$id][max_number]", "text", array( 
                                        "value"     => isset($field['max_number']) ? $field['max_number'] : null,
                                        "label"     => "Maximum Number", 
                                        "id"        => "pm_maxnumber_$id",
                                        "class"     => "pm_input",
                                        "after"     => "<div class='pm_note'>(e.g. 40;)</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) ); 
$fieldDateTimeSelection = $postMeta->create_input( "group[$group_id][field][$id][datetime_selection]", "select", array( 
                                        "value"         => isset($field['datetime_selection']) ? $field['datetime_selection'] : null,
                                        "label"         => 'Type Selection',
                                        "id"        => "pm_datetime_$id",
                                        "class"         => "pm_input",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "by_key"        => true,
                                     ), array( 'date'=>'Date', 'time'=>'Time', 'datetime'=>'Date and Time') ); 
 
$fieldHiddenValue = $postMeta->create_input( "group[$group_id][field][$id][hidden_value]", "text", array( 
                                        "value"     => isset($field['hidden_value']) ? $field['hidden_value'] : '1',
                                        "label"     => "Hidden Value",
                                        "id"        => "pm_field_size_$id", 
                                        "class"     => "pm_input ",
                                        "after"     => "<div class='pm_note'>(e.g. Number or Text;)</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ) );                                                                       

$output = "$fielsTitle $fieldType $fieldMetaKey $fieldDescription $fieldId $fieldSize";
$output .= "<div class='pm_field_segment'>";
$output .= "$fieldRequired $fieldDuplicate";//$fieldDuplicate
    if($field['type']=='file'){
       $output .= "$fieldDlRegisterOnly";
    }
    
    if($field['type'] == 'checkbox' || $field['type'] == 'radio'){
        $output .= "$fieldAlignment";
    }
    if($field['type']=='select'){
        $output .="$selectMultiple";
    }
    
$output .= "</div>";

    if($field['type'] == 'image'){
        $output .="$imageAllowedExt $imageMaxFileSize";
    }
    if($field['type'] == 'audio'){
        $output .="$audioAllowedExt $audioMaxFileSize";
    }
    if($field['type'] == 'video'){
        $output .="$videoAllowedExt $videoMaxFileSize";
    }
    if($field['type'] == 'file'){
        $output .="$fileAllowedExt $fileAllowedExtCustom $fileMaxFileSize";
    }
    if($field['type'] == 'select' || $field['type'] == 'radio' || $field['type'] == 'checkbox'){
        $output .="$fieldOptions";
    }
    if($field['type'] == 'checkbox'){
        $output .="$fieldDefaultValueMulti";
    }
        if($field['type'] == 'select' || $field['type'] == 'radio'){
        $output .="$fieldDefaultValueSingle";
    }
    
    if($field['type']=='textarea'){
        $output .="$fieldWidth $fieldHeight ";
    }
    
    if($field['type'] == 'text' || $field['type'] == 'textarea'){
        $output .= "$fieldMaxChar";
    }
    
    if($field['type'] == 'number'){
        $output .= "$fieldMinNumber $fieldMaxNumber";
    }
    if($field['type'] == 'datetime'){
        $output .= "$fieldDateTimeSelection";
    } 
    

$output .= "$fieldCssClass $fieldCssStyle"; 

    if($field['type'] == 'hidden'){
        $output = "$fielsTitle $fieldType $fieldMetaKey $fieldId $fieldHiddenValue";
    }
 
$output .= "<div class='pm_note' style='padding:5px;'>By default, <b>Required</b> validation will be set with this field.<br/></div>";   

                              
                        $html ='';
                                                 
                        $html .=  "<div id='side-sortables' class='meta-box-sortables meta-field'>
                                    <div id='$field[title]' class='postbox box fieldbox'>
                                        <div class='pm_trash' title='Click to Romove' onclick='meta_option_remove_field(this);'></div>
                                        <div class='handlediv' title='Click to toggle'  onclick='meta_option_toggole_field(this);'><br/></div>
                                        <h3 class='hndle'><span class='pm_admin_field_title'> $field[title] </span> <span class ='pm_admin_field_type'>( $field_type )</span> ID : $id  </h3> 
                                        <div class='inside' style='display:$style'>
                                        <div id='field$group_id$id' class='field-holder'>";
                                        $html .= "$output";
                                        
                                $html .="</div> 
                                        </div>
                                    </div>
                                    <input type='hidden' class='field_count_$group_id' value='$id' />
                                 </div>";
            
            echo $html;

?>