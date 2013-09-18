<?php


global $postMeta;

$html='';
$ptys=$postMeta->pm_get_post_types();

$postTypes=array();
foreach($ptys as  $pt){
    if($pt->name != 'attachment'){
        $postTypes[$pt->name]=$pt->name;
    }
}
   

$html .= $postMeta->create_input("pm_taxonomy[type]","text", array( 
                        "value"     => isset($taxonomy['type'])?$taxonomy['type']:null, 
                        "label"     => "Taxonomy Type",
                        "label_extra"       =>"<span class='pm_required'>*</span>",
                        "id"        => "pm_taxonomy_type",
                        "class"     => "pm_input validate[required,custom[onlyLcNs]]",
                        "after"     => "<div class='pm_note'>(e.g. actors)Name of the object type for the taxonomy object. Name must not contain capital letters or spaces</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[name]","text", array( 
                        "value"     => isset($taxonomy['name'])?$taxonomy['name']:null, 
                        "label"     => "Label",
                        "label_extra"       =>"<span class='pm_required'>*</span>",
                        "id"        => "pm_taxonomy_name",
                        "class"     => "pm_input validate[required]",
                        "onkeyup"     => "pmTaxonomySuggetion(this)",
                        "onkeypress"  =>  "pmTaxonomySuggetion(this)",
                        "after"     => "<div class='pm_note'>(e.g. Actor)Singular label of the taxonomy.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[label]","text", array( 
                        "value"     => isset($taxonomy['label'])?$taxonomy['label']:null, 
                        "label"     => "Labels",
                        "id"        => "pm_taxonomy_label",
                        "class"     => "pm_input",
                        "after"     => "<div class='pm_note'>(e.g. Actors)A plural descriptive name for the taxonomy marked for translation.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));                     
$html .= $postMeta->create_input("pm_taxonomy[description]","text", array( 
                        "value"     => isset($taxonomy['description'])?$taxonomy['description']:null, 
                        "label"     => "Description",
                        "id"        => "pm_taxonomy_name",
                        "class"     => "pm_input",
                        "after"     => "<div class='pm_note'>A short descriptive summary of what the custom taxonomy is.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[post_types]","checkbox", array( 
                        "value"         => isset($taxonomy['post_types'])?$taxonomy['post_types']:null, 
                        "label"         => "Post types",
                        "label_extra"   =>"<span class='pm_required'>*</span>",
                        "id"            => "pm_taxonomy_post_types",
                        "class"         => "validate[required,minCheckbox[1]]",
                        "option_after"  =>"<br />",
                        "field_enclose" =>  "div class='pm_field_item'",
                        "enclose"       => "div class='pm_field'",
                        "combind"       =>true,
                        "by_key"        => true
                     ), $postTypes );

                     
return $html;
?>