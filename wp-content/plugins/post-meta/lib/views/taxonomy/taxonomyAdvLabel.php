<?php

global $postMeta;

$html='';
$html .= $postMeta->create_input("pm_taxonomy[labels][name]","text", array( 
                        "value"     => isset($taxonomy['name'])?$taxonomy['name']:'Categories', 
                        "label"     => "Name",
                        "id"        => "pm_taxonomy_labels_name",
                        "class"     => "pm_input",
                        "rel"       => "",
                        "after"     => "<div class='pm_note'>General name for the taxonomy, usually plural.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[labels][singular_name]","text", array( 
                        "value"     => isset($taxonomy['singular_name'])?$taxonomy['singular_name']:'Category', 
                        "label"     => "Singular name",
                        "id"        => "pm_taxonomy_labels_singular_name",
                        "class"     => "pm_input",
                        "rel"       => "",
                        "after"     => "<div class='pm_note'>Name for one object of this taxonomy.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[labels][search_items]","text", array( 
                        "value"     => isset($taxonomy['search_items'])?$taxonomy['search_items']:'Search Categories', 
                        "label"     => "Search items",
                        "id"        => "pm_taxonomy_labels_search_items",
                        "class"     => "pm_input",
                        "rel"       => "Search",
                        "after"     => "<div class='pm_note'>The search items text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[labels][add_new_item]","text", array( 
                        "value"     => isset($taxonomy['add_new_item'])?$taxonomy['add_new_item']:'Add New Category', 
                        "label"     => "Add new item",
                        "id"        => "pm_taxonomy_labels_add_new_item",
                        "class"     => "pm_input",
                        "rel"       => "Add New",
                        "after"     => "<div class='pm_note'>The add new item text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
                                          
$html .= $postMeta->create_input("pm_taxonomy[labels][popular_items]","text", array( 
                        "value"     => isset($taxonomy['popular_items'])?$taxonomy['popular_items']:'Popular Tags', 
                        "label"     => "Popular items",
                        "id"        => "pm_taxonomy_labels_popular_items",
                        "class"     => "pm_input",
                        "rel"       => "Popular",
                        "after"     => "<div class='pm_note'>The popular items text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));  
$html .= $postMeta->create_input("pm_taxonomy[labels][all_items]","text", array( 
                        "value"     => isset($taxonomy['all_items'])?$taxonomy['all_items']:'All Categories', 
                        "label"     => "All items",
                        "id"        => "pm_taxonomy_labels_all_items",
                        "class"     => "pm_input",
                        "rel"       => "All",
                        "after"     => "<div class='pm_note'>The all items text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));  
$html .= $postMeta->create_input("pm_taxonomy[labels][parent_item]","text", array( 
                        "value"     => isset($taxonomy['parent_item'])?$taxonomy['parent_item']:'Parent Category', 
                        "label"     => "Parent item",
                        "id"        => "pm_taxonomy_labels_parent_item",
                        "class"     => "pm_input",
                        "rel"       => "Parent",
                        "after"     => "<div class='pm_note'>he parent item text. This string is not used on non-hierarchical taxonomies such as post tags.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[labels][parent_item_colon]","text", array( 
                        "value"     => isset($taxonomy['parent_item_colon'])?$taxonomy['parent_item_colon']:'Parent Category:', 
                        "label"     => "Parent item colon",
                        "id"        => "pm_taxonomy_labels_parent_item_colon",
                        "class"     => "pm_input",
                        "rel"       => "Parent:",
                        "after"     => "<div class='pm_note'>The same as parent_item, but with colon:</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[labels][edit_item]","text", array( 
                        "value"     => isset($taxonomy['edit_item'])?$taxonomy['edit_item']:'Edit Category', 
                        "label"     => "Edit item",
                        "id"        => "pm_taxonomy_labels_edit_item",
                        "class"     => "pm_input",
                        "rel"       => "Edit",
                        "after"     => "<div class='pm_note'>Edit item text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[labels][update_item]","text", array( 
                        "value"     => isset($taxonomy['update_item'])?$taxonomy['update_item']:'Update Category', 
                        "label"     => "Update item",
                        "id"        => "pm_taxonomy_labels_update_item",
                        "class"     => "pm_input",
                        "rel"       => "Update",
                        "after"     => "<div class='pm_note'>The update item text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
                     
                     
$html .= $postMeta->create_input("pm_taxonomy[labels][new_item_name]","text", array( 
                        "value"     => isset($taxonomy['new_item_name'])?$taxonomy['new_item_name']:'New Category Name', 
                        "label"     => "New item name",
                        "id"        => "pm_taxonomy_labels_new_item_name",
                        "class"     => "pm_input",
                        "rel"       => "New Name",
                        "after"     => "<div class='pm_note'>The new item name text.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
$html .= $postMeta->create_input("pm_taxonomy[labels][separate_items_with_commas]","text", array( 
                        "value"     => isset($taxonomy['separate_items_with_commas'])?$taxonomy['separate_items_with_commas']:'Separate tags with commas', 
                        "label"     => "Separate items with commas",
                        "id"        => "pm_taxonomy_labels_separate_items_with_commas",
                        "class"     => "pm_input",
                        "rel"       => "Separate  with commas",
                        "after"     => "<div class='pm_note'>The separate item with commas text used in the taxonomy meta box. This string isn't used on hierarchical taxonomies.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));

$html .= $postMeta->create_input("pm_taxonomy[labels][add_or_remove_items]","text", array( 
                        "value"     => isset($taxonomy['add_or_remove_items'])?$taxonomy['add_or_remove_items']:'Update Category', 
                        "label"     => "Add or remove items",
                        "id"        => "pm_taxonomy_labels_add_or_remove_items",
                        "class"     => "pm_input",
                        "rel"       => "Update",
                        "after"     => "<div class='pm_note'>The add or remove items text and used in the meta box when JavaScript is disabled. This string isn't used on hierarchical taxonomies.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));
                     
$html .= $postMeta->create_input("pm_taxonomy[labels][choose_from_most_used]","text", array( 
                        "value"     => isset($taxonomy['choose_from_most_used'])?$taxonomy['choose_from_most_used']:'Choose from the most used tags', 
                        "label"     => "Choose from most used",
                        "id"        => "pm_taxonomy_labels_choose_from_most_used",
                        "class"     => "pm_input",
                        "rel"       => "Choose from the most used",
                        "after"     => "<div class='pm_note'>The choose from most used text used in the taxonomy meta box. This string isn't used on hierarchical taxonomies.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));

 $html .= $postMeta->create_input("pm_taxonomy[labels][menu_name]","text", array( 
                        "value"     => isset($taxonomy['menu_name'])?$taxonomy['menu_name']:'Categories', 
                        "label"     => "Menu name",
                        "id"        => "pm_taxonomy_labels_menu_name",
                        "class"     => "pm_input validate[required]",
                        "rel"       => "",
                        "after"     => "<div class='pm_note'>The menu name text. This string is the name to give menu items. Defaults to value of name.</div>",
                        "field_enclose"     =>  "div class='pm_field_item'",
                        "enclose"   => "div class='pm_field'",
                     ));                                                                                                                                                                                                                  
                     
return $html;
?>