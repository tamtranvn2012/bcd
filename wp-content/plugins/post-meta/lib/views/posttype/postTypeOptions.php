<?php


global $postMeta;

$html='';

$supports = array('title'=>'Title','editor'=>'Editor','author'=>'Author','thumbnail'=>'Thumbnail','excerpt'=>'Excerpt','trackbacks'=>'Trackbacks','custom-fields'=>'Custom Fields','comments'=>'Comments','revisions'=>'Revisions','page-attributes'=>'Page Attributes');
$taxs=get_taxonomies(array( 'public'   => true ),'objects');

$taxonomies =array();
foreach($taxs as $tax){
    if( !in_array($tax->name,array('nav_menu','post_format') ) ){
        $taxonomies[$tax->name]=$tax->label;
    }
}       

$html .= $postMeta->create_input("pm_posttype[type]","text", array( 
                        "value"     => isset($postType['type'])?$postType['type']:null, 
                        "label"     => "Post Type",
                        "label_extra"       =>"<span class='pm_required'>*</span>",
                        "id"        => "pm_posttype_type",
                        "class"     => "pm_input validate[required,custom[onlyLc]]",
                        "after"     => "<div class='pm_note'>(e.g. movies)The type must have less than 20 characters and only are accepted lowercases letters and undescores. Once created the post type, the type cannot be changed</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[name]","text", array( 
                        "value"     => isset($postType['name'])?$postType['name']:null, 
                        "label"     => "Label",
                        "label_extra"       =>"<span class='pm_required'>*</span>",
                        "id"        => "pm_posttype_name",
                        "class"     => "pm_input validate[required]",
                        "onkeyup"     => "pmPostTypeSuggetion(this)",
                        "onkeypress"  =>  "pmPostTypeSuggetion(this)",
                        "after"     => "<div class='pm_note'>(e.g. Movie)Singular label of the post type.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[label]","text", array( 
                        "value"     => isset($postType['label'])?$postType['label']:null, 
                        "label"     => "Labels",
                        "id"        => "pm_posttype_label",
                        "class"     => "pm_input",
                        "after"     => "<div class='pm_note'>(e.g. Movies)Plural label of the post type.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));                     
$html .= $postMeta->create_input("pm_posttype[description]","text", array( 
                        "value"     => isset($postType['description'])?$postType['description']:null, 
                        "label"     => "Description",
                        "id"        => "pm_posttype_name",
                        "class"     => "pm_input",
                        "after"     => "<div class='pm_note'>A short descriptive about post type</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$supprot= $postMeta->create_input("pm_posttype[support]","checkbox", array( 
                        "value"     => isset($postType['support'])?$postType['support']:null, 
                        "label"     => "Supports",
                        "id"        => "pm_posttype_name",
                        "class"     => "",
                        "option_after"=>"<br />",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                        "combind"   =>true,
                        "by_key"        => true
                     ), $supports );
$texonomies= $postMeta->create_input("pm_posttype[taxonomy]","checkbox", array( 
                        "value"     => isset($postType['taxonomy'])?$postType['taxonomy']:null, 
                        "label"     => "Taxonomies",
                        "id"        => "pm_posttype_name",
                        "class"     => "",
                        "option_after"=>"<br />",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                        "combind"   =>true,
                        "by_key"        => true
                     ), $taxonomies );
 
 $html = "$html<div >$supprot $texonomies </div>"; 
 
                     
return $html;
?>