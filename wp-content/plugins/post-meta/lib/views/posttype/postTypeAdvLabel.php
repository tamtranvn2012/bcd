<?php

global $postMeta;

$html='';
$html .= $postMeta->create_input("pm_posttype[labels][name]","text", array( 
                        "value"     => isset($postType['name'])?$postType['name']:'Posts', 
                        "label"     => "Name",
                        "id"        => "pm_posttype_labels_name",
                        "class"     => "pm_input",
                        "rel"       => "",
                        "after"     => "<div class='pm_note'>General name for the post type, usually plural.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][singular_name]","text", array( 
                        "value"     => isset($postType['singular_name'])?$postType['singular_name']:'Post', 
                        "label"     => "Singular name",
                        "id"        => "pm_posttype_labels_singular_name",
                        "class"     => "pm_input",
                        "rel"       => "",
                        "after"     => "<div class='pm_note'>Name for one object of this post type. Defaults to value of name.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][add_new]","text", array( 
                        "value"     => isset($postType['add_new'])?$postType['add_new']:'Add New', 
                        "label"     => "Add new",
                        "id"        => "pm_posttype_labels_add_new",
                        "class"     => "pm_input",
                        "rel"       => "Add",
                        "after"     => "<div class='pm_note'>General name for the post type, usually plural.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][all_items]","text", array( 
                        "value"     => isset($postType['all_items'])?$postType['all_items']:'All', 
                        "label"     => "All",
                        "id"        => "pm_posttype_labels_all_items",
                        "class"     => "pm_input",
                        "rel"       => "All",
                        "after"     => "<div class='pm_note'>The all items text used in the menu. Default is the Name label.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][add_new_item]","text", array( 
                        "value"     => isset($postType['add_new_item'])?$postType['add_new_item']:'Add New Post', 
                        "label"     => "Add new item",
                        "id"        => "pm_posttype_labels_add_new_item",
                        "class"     => "pm_input",
                        "rel"       => "All New",
                        "after"     => "<div class='pm_note'>The add new item text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][edit_item]","text", array( 
                        "value"     => isset($postType['edit_item'])?$postType['edit_item']:'Edit Post', 
                        "label"     => "Edit item",
                        "id"        => "pm_posttype_labels_edit_item",
                        "class"     => "pm_input",
                        "rel"       => "Edit",
                        "after"     => "<div class='pm_note'>General name for the post type, usually plural.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][new_item]","text", array( 
                        "value"     => isset($postType['new_item'])?$postType['new_item']:'New Post', 
                        "label"     => "New item",
                        "id"        => "pm_posttype_labels_new_item",
                        "class"     => "pm_input",
                        "rel"       => "New",
                        "after"     => "<div class='pm_note'>The new item text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][view_item]","text", array( 
                        "value"     => isset($postType['view_item'])?$postType['view_item']:'View Post', 
                        "label"     => "View item",
                        "id"        => "pm_posttype_labels_view_item",
                        "class"     => "pm_input",
                        "rel"       => "View",
                        "after"     => "<div class='pm_note'>The view item text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][search_items]","text", array( 
                        "value"     => isset($postType['search_items'])?$postType['search_items']:'Search Posts', 
                        "label"     => "Search items",
                        "id"        => "pm_posttype_labels_search_items",
                        "class"     => "pm_input",
                        "rel"       => "No found",
                        "after"     => "<div class='pm_note'>The search items text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][not_found]","text", array( 
                        "value"     => isset($postType['not_found'])?$postType['not_found']:'No %s found', 
                        "label"     => "Not found",
                        "id"        => "pm_posttype_labels_not_found",
                        "class"     => "pm_input",
                        "rel"       => "No found",
                        "after"     => "<div class='pm_note'>The not found text. Default is No posts found/No pages found</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][not_found_in_trash]","text", array( 
                        "value"     => isset($postType['not_found_in_trash'])?$postType['not_found_in_trash']:'No posts found in Trash', 
                        "label"     => "Not found in trash",
                        "id"        => "pm_posttype_labels_not_found_in_trash",
                        "class"     => "pm_input",
                        "rel"       => "No found in Trash",
                        "after"     => "<div class='pm_note'>The not found in trash text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_posttype[labels][parent_item_colon]","text", array( 
                        "value"     => isset($postType['parent_item_colon'])?$postType['parent_item_colon']:'Parent Item:', 
                        "label"     => "Parent item colon",
                        "id"        => "pm_posttype_labels_parent_item_colon",
                        "class"     => "pm_input",
                        "rel"       => "Parent:",
                        "after"     => "<div class='pm_note'>The same as parent_item, but with colon:</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
 $html .= $postMeta->create_input("pm_posttype[labels][menu_name]","text", array( 
                        "value"     => isset($postType['menu_name'])?$postType['menu_name']:'Post', 
                        "label"     => "Menu name",
                        "id"        => "pm_posttype_labels_menu_name",
                        "class"     => "pm_input",
                        "rel"       => "",
                        "after"     => "<div class='pm_note'>The name of the menu</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));                                                                                                                                                                                                                  
                     
return $html;
?>