<?php
global $postMeta;
$pmAllExts = $postMeta->pmAllExts();
$allExt='';
foreach($pmAllExts as $type=>$exts){
    
    $allExt.=$postMeta->create_input( "settings[file][allext][$type]", "checkbox", array( 
                                        "value"     => (isset($file['allext'][$type]))?$file['allext'][$type]:null,
                                        "label"     => "Allowed $type Extension",
                                        "id"        => "checkbox_$type",
                                        "class"     => "validate[required,minCheckbox[1]]",
                                        "option_after"     => "<br />",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "combind"   => true,
                                        "by_key"    => true,
                                     ),$exts );
    
}

$allExt .= $postMeta->create_input("settings[file][allext_custom]","text", array( 
                                        "value"     => (isset($file['allext_custom']))?$file['allext_custom']:null,
                                        "label"     => "Custom Extension",
                                        "class"     => "pm_input",
                                        "after"     => "<div class='pm_note'>Must use comma as separeetor (e.g. zip,rar)</div>",
                                        "enclose"   => "div class='pm_field_segment'",
                                     ));
$allExt.="<hr />";

$maxFileSize = $postMeta->create_input( "settings[file][max_file_size]", "select", array( 
                                        "value"     => (isset($file['max_file_size']))?$file['max_file_size']:'200',
                                        "label"     => "Max File Size",
                                        "class"     => "pm_input ",
                                        "id"        =>"max_file_size",
                                        "onchange"  => "getinfo(this)",
                                        "enclose"       => "div class='pm_field_segment'",
                                        "by_key"    => true,
                                     ),array('50'=>'50MB','100'=>'100MB','200'=>'200MB',''=>'Custom File Size') );
$maxFileSizeCustom=$postMeta->create_input("settings[file][max_file_size_custom]","text", array( 
                                        "value"     => (isset($file['max_file_size_custom']))?$file['max_file_size_custom']:null,
                                        "label"     => "Max File Size Custom",
                                        "id"        => "max_file_size_custom",
                                        "class"     => "pm_input validate[required]",
                                        "after"     => "<div class='pm_note'>Must use comma as separeetor (e.g. zip,rar)</div>",
                                        "enclose"   => "div class='pm_field_segment custom_file_size'",
                                     ));
if($file['max_file_size_custom'] && !$file['max_file_size']){
    $maxFileSize .=$maxFileSizeCustom;
}

echo "$allExt $maxFileSize";

?>