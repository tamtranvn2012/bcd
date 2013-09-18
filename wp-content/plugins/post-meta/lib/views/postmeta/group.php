<?php

global $postMeta;
            if(!$meta_box['title']){$meta_box['title']='Untitled Group'.$id;}
            $style=($loop==1 || $toggle == true)?" ":"style='display:none'";
            $html ='';
                                $html .=  "<div class='meta-group meta-box-sortables'>
                                            <div id='$meta_box[id]' class='postbox'>
                                                        <div class='pm_trash' title='Click to Romove' onclick='meta_option_remove_meta_box(this);'></div>
                                                        <div class='handlediv' title='Click to toggle' onclick='meta_option_toggole(this);'><br/></div>
                                                        <h3 class='hndle'>$meta_box[title] ID: $id</h3>
                                                        <div class='inside' $style>
                                                        <div class='meta_box_info'>";
                                                        $html .= $postMeta->create_input("group[$id][title]","text", array( 
                                                                            "value"     => $meta_box['title'], 
                                                                            "label"     => "Group Name", 
                                                                            "id"        => "pm_group_$id",
                                                                            "class"     => "pm_input validate[required]",
                                                                            "onkeyup"     => "moChangeGroupTitle(this)",
                                                                            "enclose"   => "div class='pm_segment'",
                                                                         ));
                                                        $html .=$postMeta->create_input( "group[$id][context]", "select", array( 
                                                                        "value"     => isset($meta_box['context']) ? $meta_box['context'] : 'advanced',
                                                                        "label"     => "Context", 
                                                                        "class"     => "pm_input",
                                                                        "enclose"   => "div class='pm_segment'",
                                                                        "by_key"    => true,
                                                                     ), array('normal'=>'Normal','advanced' => 'Advanced','side' => 'Side') );
                                                        $html .=$postMeta->create_input( "group[$id][priority]", "select", array( 
                                                                        "value"     => isset($meta_box['priority']) ? $meta_box['priority'] : null,
                                                                        "label"     => "Priority", 
                                                                        "class"     => "pm_input",
                                                                        "enclose"   => "div class='pm_segment'",
                                                                        "by_key"    => true,
                                                                     ), array('high' => 'High','core' => 'Core','default' => 'Default','low' => 'Low') );
                                                        $html .= $postMeta->create_input("group[$id][meta_key]","text", array( 
                                                                            "value"     => $post_type."_".$id, 
                                                                            "label"     => "Meta Key", 
                                                                            "id"        => "pm_group_$id",
                                                                            "class"     => "pm_input pm_group_meta_key validate[required,custom[onlyLcNs]]",
                                                                            "readonly"  =>"true",
                                                                            "after"     => "<div class='pm_note pm_required'>Must be unique and have no space</div>",
                                                                            "enclose"   => "div class='pm_segment'",
                                                                         ));
                                                        $groupMetakeyEdit = $postMeta->create_input( "", "checkbox", array( 
                                                                            "value"     => null,
                                                                            "class"     =>"edit_meta_key",
                                                                            "onclick"     => "editMetaKey(this)",
                                                                            "after"     => " Edit Group Metakey <br />",
                                                                         ) ); 
                                                        $groupDuplicate = $postMeta->create_input( "group[$id][duplicate]", "checkbox", array( 
                                                                            "value"     => isset($meta_box['duplicate']) ? $meta_box['duplicate'] : null,
                                                                            "disabled"  => ($postMeta->isPro()) ? null: "disabled",
                                                                            "after"     => ($postMeta->isPro()) ? "Allow Duplicate" : "Allow Duplicate (Only for Pro)" ,
                                                                         ) );
                                                          $html .="<div class='pm_segment group_control'>
                                                                    $groupMetakeyEdit $groupDuplicate
                                                                    </div>"; 
                                                          $html .="</div>";
                                                        echo $html;
                                                            echo "<input type='hidden' name='group[$id][post_type]' value='$post_type' />";
                                                        ?>
                                                        <div class="metabox-option-list">
                                                  <div class="metabox-fields-holder ui-sortable ui-droppable" >
                                                <?php @$fields= $meta_box['field'];
                                                if($fields){
                                                    $j=0;
                                                foreach($fields as $field):
                                                $j++;
                                                  $postMeta->render("field",array('field'=>$field,'id'=>$j,'group_id'=>$id,'post_type'=>$meta_box['post_type']),'postmeta');
                                                 endforeach; //end of field
                                                 }
                                                 else{
                                                    echo "<div id='not-found'>No field found</div>";
                                                 }
                                                  ?>
                                                    
                                                </div>
                                                <div class="meta-option-fields-list">
                                                    <?php
                                                     $pmFieldList = $postMeta->pmFields();
                                                         
                                                     
                                                        echo "<div id='side-sortables' class='meta-box-sortables'>
                                                                    <div id='user_meta' class='postbox '>
                                                                        
                                                                        <div class='handlediv' title='Click to toggle' onclick='meta_option_toggle(this);'><br></div>
                                                                        <h3 class='hndle'>Available Field List</h3>
                                                                        <div class='inside'>
                                                                            <p></p>";
                                                                            foreach($pmFieldList as $fieldKey => $fieldValue){
                                                                                if($postMeta->isPro()){
                                                                                    echo "<div field_type='$fieldKey' post_type='$post_type' group_id='$id' class='button meta_option_field_selecor' onclick='moNewField(this)'>$fieldValue[title]</div>";
                                                                                }else{
                                                                                    if(!$fieldValue['is_free']){
                                                                                        echo "<div field_type='$fieldKey' post_type='$post_type' disabled='disabled' group_id='$id' class='button meta_option_field_selecor' onclick='getProMsg(this)'>$fieldValue[title]</div>";
                                                                                    }else{
                                                                                        echo "<div field_type='$fieldKey' post_type='$post_type' group_id='$id' class='button meta_option_field_selecor' onclick='moNewField(this)'>$fieldValue[title]</div>";
                                                                                    }
                                                                                }
                                                                                
                                                                            }
                                                        echo "<p></p>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                                ";
                                                    ?>
                                               
                                                </div>
                                            </div>
                                  </div>
                                </div>
                            <input type="hidden" class="group_count" value="<?php echo $id; ?>"/>
                            <?php $maxKey      = $postMeta->maxKey( $fields ); ?>
                            <?php $last_field_id    = $maxKey ? $maxKey : 0 ?>
                            <input type="hidden" id="last_<?php echo $id; ?>_field_id" value="<?php echo $last_field_id; ?>" />
                            </div>   
