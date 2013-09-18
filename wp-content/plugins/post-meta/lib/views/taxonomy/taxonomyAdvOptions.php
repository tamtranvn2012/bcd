<?php

global $postMeta;

$html='';
$html .= $postMeta->create_input("pm_taxonomy[option][public]","checkbox", array( 
                        "value"     => isset($taxonomy['public'])?$taxonomy['public']:true, 
                        "label"     => "Public",
                        "id"        => "pm_taxonomy_option_public",
                        "class"     => "",
                        "before"    => "<input name='pm_taxonomy[option][public]' type='hidden' value='0'>",
                        "after"     => "<div class='pm_note'>Should this taxonomy be exposed in the admin UI.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'"
                     ));   
$html .= $postMeta->create_input("pm_taxonomy[option][show_in_nav_menus]","checkbox", array( 
                        "value"     => isset($taxonomy['show_in_nav_menus'])?$taxonomy['show_in_nav_menus']:true, 
                        "label"     => "Show in nav menus",
                        "id"        => "pm_taxonomy_option_show_in_nav_menus",
                        "class"     => "",
                        "before"    => "<input name='pm_taxonomy[option][show_in_nav_menus]' type='hidden' value='0'>",
                        "after"     => "<div class='pm_note'>true makes this taxonomy available for selection in navigation menus.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'"
                     )); 
$html .= $postMeta->create_input("pm_taxonomy[option][show_ui]","checkbox", array( 
                        "value"     => isset($taxonomy['show_ui'])?$taxonomy['show_ui']:true, 
                        "label"     => "Show ui",
                        "id"        => "pm_taxonomy_option_show_ui",
                        "class"     => "",
                        "before"    => "<input name='pm_taxonomy[option][show_ui]' type='hidden' value='0'>",
                        "after"     => "<div class='pm_note'>Whether to generate a default UI for managing this taxonomy.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'"
                    ));                     
$html .= $postMeta->create_input("pm_taxonomy[option][show_tagcloud]","checkbox", array( 
                        "value"     => isset($taxonomy['show_tagcloud'])?$taxonomy['show_tagcloud']:false, 
                        "label"     => "Show tagcloud",
                        "id"        => "pm_taxonomy_option_show_tagcloud",
                        "class"     => "",
                        "after"     => "<div class='pm_note'>Wether to allow the Tag Cloud widget to use this taxonomy.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'"
                    )); 
$html .= $postMeta->create_input("pm_taxonomy[option][hierarchical]","checkbox", array( 
                        "value"     => isset($taxonomy['hierarchical'])?$taxonomy['hierarchical']:true, 
                        "label"     => "Hierarchical",
                        "id"        => "pm_taxonomy_option_hierarchical",
                        "class"     => "",
                        "before"    => "<input name='pm_taxonomy[option][hierarchical]' type='hidden' value='0'>",
                        "after"     => "<div class='pm_note'>Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'"
                     ));
$html .= $postMeta->create_input("pm_taxonomy[option][update_count_callback]","text", array( 
                        "value"     => isset($taxonomy['update_count_callback'])?$taxonomy['update_count_callback']:null, 
                        "label"     => "Update count callback",
                        "id"        => "pm_taxonomy_option_update_count_callback",
                        "class"     => "pm_input",
                        "after"     => "<div class='pm_note'>A function name that will be called to update the count of an associated $object_type, such as post, is updated.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     )); 
$html .= $postMeta->create_input("pm_taxonomy[option][rewrite]","checkbox", array( 
                        "value"     => isset($taxonomy['rewrite'])?$taxonomy['rewrite']:false, 
                        "label"     => "Rewrite",
                        "id"        => "pm_taxonomy_option_rewrite",
                        "class"     => "",
                        "after"     => "<div class='pm_note'>Set to false to prevent rewrite, Default will use $taxonomy as query var</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'"
                     )); 
$html .= $postMeta->create_input("pm_taxonomy[option][rewrite_slug]","text", array( 
                        "value"     => isset($taxonomy['rewrite_slug'])?$taxonomy['rewrite_slug']:null, 
                        "label"     => "Rewrite slug",
                        "id"        => "pm_taxonomy_option_rewrite_slug",
                        "class"     => "pm_input",
                        "after"     => "<div class='pm_note'>Prepend posts with this slug - defaults to taxonomy's name</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[option][query_var]","checkbox", array( 
                        "value"     => isset($taxonomy['query_var'])?$taxonomy['query_var']:true, 
                        "label"     => "Query var",
                        "id"        => "pm_taxonomy_option_query_var",
                        "class"     => "",
                        "before"    => "<input name='pm_taxonomy[option][query_var]' type='hidden' value='0'>",
                        "after"     => "<div class='pm_note'>False to prevent queries, or string to customize query var. Default will use $taxonomy as query var.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'"
                     ));                                                                                                                                                                                                                                                                                                                                                                                                   
                     
return $html;
?>