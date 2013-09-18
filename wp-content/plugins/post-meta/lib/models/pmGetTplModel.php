<?php
if( !class_exists( 'pmGetTplModel' ) ) :

class pmGetTplModel {
        function get_field_type($metaKey){
             if($metaKey){
                global $postMeta,$post;
                $postType= get_post_type( $post->ID );
                
                $pm_options= get_option($postMeta->options['post_meta']);
                
                $groups=$pm_options[$postType]['group'];
                
                if($groups){
                    foreach($groups as $group ){
                        if($group['field']){
                            foreach($group['field'] as $field){
                                  if($field['meta_key']== $metaKey){
                                        $fieldType = $field['type'];
                                        break;
                                    }
                            }
                        }
                    }
                }
                
                return $fieldType;
             }
        }
        
        function get_file_display_label($metaKey){
            if($metaKey){
                global $postMeta,$post;
                $postType= get_post_type( $post->ID );
                
                $pm_options= get_option($postMeta->options['post_meta']);
                
                $groups=$pm_options[$postType]['group'];
                
                if($groups){
                    foreach($groups as $group ){
                        if($group['field']){
                            foreach($group['field'] as $field){
                                  if($field['meta_key']== $metaKey){
                                        $fieldDisplayLabel = $field['register_only'];
                                        break;
                                    }
                            }
                        }
                    }
                }
                
                return $fieldDisplayLabel;
             }
            
        }
    
    
        function get_field_tpl($metaKey,$groupIndex=1,$fieldIndex=1,$post_id=null){
                    if($metaKey){
                        
                        global $postMeta;
                        if(!$post_id){
                            global $post;
                            $post_id=$post->ID;
                        }
                        $meta_data=get_post_meta($post_id,$metaKey,true);
                        
                        if($meta_data){
                            if($groupIndex){
                                $data=$meta_data[$groupIndex];
                                if($fieldIndex){
                                    $data=$meta_data[$groupIndex][$fieldIndex];
                                }
                             }
                        }
                        $label = $postMeta->get_label($metaKey);
                        
                        $fieldType=$this->get_field_type($metaKey);
                        
                        if($fieldType=='file'){
                            $fieldDsLabel=$this->get_file_display_label($metaKey);
                        }
                        
                        $types = array('image_media','image','audio','video','file');
                        if($fieldType =='image_media'){
                            $fieldType ='image';
                        }
                        if(in_array( $fieldType, $types )){
                            $data = $postMeta->preview($data,$fieldType,$fieldDsLabel);
                        }
                        
                        $html="<div style='width=100%'>
                                    <label style='width:25%;float:left'>$label :</label>
                                    <div style='width=60%;'>
                                        $data
                                    </div>
                                </div>";
                         
                     
                     return $html;  
                 }
        }
        
        function get_duplicate_field_tpl($metaKey,$groupIndex=1,$post_id=null){
                    if($metaKey){
                        global $postMeta;
                        if(!$post_id){
                            global $post;
                            $post_id=$post->ID;
                        }
                        $meta_data=get_post_meta($post_id,$metaKey,true);
                        
                        if($meta_data){
                            if($groupIndex){
                                $data=$meta_data[$groupIndex];
                             }
                        }
                        $label = $postMeta->get_label($metaKey);
                        $fieldType=$this->get_field_type($metaKey);
                        
                        if($fieldType=='file'){
                            $fieldDsLabel=$this->get_file_display_label($metaKey);
                        }
                        
                        $html="<div style='width=100%'>
                                    <label style='width:25%;float:left'>$label :</label>
                                    <div style='width=60%; display:inline-block;'>
                                    <ul style='list-style:none;'>";
                                    if(is_array($data)){
                                                foreach($data as $val){
                                                    $types = array('image_media','image','audio','video','file','checkbox');
                                                    if($fieldType =='image_media'){
                                                        $fieldType ='image';
                                                    }
                                                    if(in_array( $fieldType, $types )){
                                                        $val = $postMeta->preview($val,$fieldType,$fieldDsLabel);
                                                   }
                                                    
                                                    $html .= "<li> $val</li>";     
                                                } 
                                            }else{
                                                $types = array('image_media','image','audio','video','file','checkbox');
                                                    if($fieldType =='image_media'){
                                                        $fieldType ='image';
                                                    }
                                                    if(in_array( $fieldType, $types )){
                                                        $val = $postMeta->preview($val,$fieldType);
                                                   }
                                                    
                                                    $html .= "<li> $val</li>"; 
                                                
                                            }    
                        $html .=    "
                                    </ul>
                                    </div>
                                </div>";
                         
                     
                     return $html;  
                 }
        }
        
       /**
        * Get Group by meta key   with a meta key
        */
       
       
       public function get_group_tpl($metaKey,$groupIndex=1,$post_id=null){
                 if($metaKey){
                            global $postMeta,$post;
                            if(!$post_id){
                                $post_id=$post->ID;
                            }
                    
                            
                            $postType= get_post_type( $post_id );
                            
                            $pm_options= get_option($postMeta->options['post_meta']);
                            
                            $groups=$pm_options[$postType]['group'];
                            
                            if($groups){
                                foreach($groups as $group){
                                    if($group['meta_key']==$metaKey){
                                        $groupTitle= $group['title'];
                                        $fields=$group['field'];
                                        break;
                                    }
                                }
                            }
                            $html = null;
                            /* $html .="<h2>$groupTitle</h2>"; */
                            if($fields){
                                foreach($fields as $field){
                                    
                                    $label = $postMeta->get_label($field['meta_key']);
                                    $fieldType=$this->get_field_type($field['meta_key']);
                                    if($fieldType=='file'){
                                            $fieldDsLabel=$this->get_file_display_label($field['meta_key']);
                                        }
                                    $meta_data=get_post_meta($post_id,$field['meta_key'],true);
                                    if($groupIndex){
                                        $data=$meta_data[$groupIndex];
                                     }
                                $html .="<div style='width=100%'>
                                                <label style='width:25%;float:left'>$label :</label>
                                                <div style='width=60%; display:inline-block;'>
                                                <ul style='list-style:none;'>";
                                                if(is_array($data)){
                                                    foreach($data as $val){
                                                        $types = array('image_media','image','audio','video','file','checkbox');
                                                        if($fieldType =='image_media'){
                                                            $fieldType ='image';
                                                        }
                                                        if(in_array( $fieldType, $types )){
                                                            $val = $postMeta->preview($val,$fieldType,$fieldDsLabel);
                                                       }
                                                        
                                                        $html .= "<li> $val</li>";     
                                                    } 
                                                }else{
                                                    $types = array('image_media','image','audio','video','file','checkbox');
                                                        if($fieldType =='image_media'){
                                                            $fieldType ='image';
                                                        }
                                                        if(in_array( $fieldType, $types )){
                                                            $val = $postMeta->preview($val,$fieldType,$fieldDsLabel);
                                                       }
                                                        
                                                        $html .= "<li> $val</li>"; 
                                                    
                                                }
                                                   
                                    $html .=    "
                                                </ul>
                                                </div>
                                            </div>";
                                }
                            }
                            
                            return $html;
                    
                 }
                 
       }
       
       /**
        * Get all Duplicate Group by meta key   with a meta key
        */
       
       
       public function get_duplicate_group_tpl($metaKey,$post_id=null){
                 if($metaKey){
                            global $postMeta,$post;
                            if(!$post_id){
                                $post_id=$post->ID;
                            }
                    
                            
                            $postType= get_post_type( $post_id );
                            
                            $pm_options= get_option($postMeta->options['post_meta']);
                            
                            $groups=$pm_options[$postType]['group'];
                            
                            if($groups){
                                foreach($groups as $group){
                                    if($group['meta_key']==$metaKey){
                                        $groupTitle= $group['title'];
                                        $fields=$group['field'];
                                        break;
                                    } 
                                }
                            }
                            $group_count_meta = get_post_meta($post->ID, 'group_count_'.$metaKey, true);
                            $group_count = ($group_count_meta)?$group_count_meta:1;
                            
                            $data=array();
                            $html = null;
                            
                            for($i=1;$i<=$group_count; $i++){
                                if($groupTitle){
                                    $count_html="($i)";
                                }
                                
                                /* $html .= "<h2>$groupTitle $count_html</h2>" ; */ 
                                if($fields){
                                    foreach($fields as $field){
                                        
                                        $label = $postMeta->get_label($field['meta_key']);
                                        $fieldType=$this->get_field_type($field['meta_key']);
                                        if($fieldType=='file'){
                                            $fieldDsLabel=$this->get_file_display_label($field['meta_key']);
                                        }
                                        
                                        $meta_data=get_post_meta($post_id,$field['meta_key'],true);
                                        $data=$meta_data[$i];
                                      
                                    $html .="<div style='width=100%'>
                                                    <label style='width:25%;float:left'>$label :</label>
                                                    <div style='width=60%; display:inline-block;'>
                                                    <ul style='list-style:none;'>";
                                                    if(is_array($data)){
                                                            foreach($data as $val){
                                                                $types = array('image_media','image','audio','video','file','checkbox');
                                                                if($fieldType =='image_media'){
                                                                    $fieldType ='image';
                                                                }
                                                                if(in_array( $fieldType, $types )){
                                                                    $val = $postMeta->preview($val,$fieldType,$fieldDsLabel);
                                                               }
                                                                
                                                                $html .= "<li> $val</li>";     
                                                            } 
                                                        }else{
                                                            $types = array('image_media','image','audio','video','file','checkbox');
                                                                if($fieldType =='image_media'){
                                                                    $fieldType ='image';
                                                                }
                                                                if(in_array( $fieldType, $types )){
                                                                    $val = $postMeta->preview($val,$fieldType,$fieldDsLabel);
                                                               }
                                                                
                                                                $html .= "<li> $val</li>"; 
                                                            
                                                        }    
                                        $html .=    "
                                                    </ul>
                                                    </div>
                                                </div>";
                                    }
                                }
                            }
                            
                            
                            return $html;
                    
                 }
                 
       }    
}

endif;

?>