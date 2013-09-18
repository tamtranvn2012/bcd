<?php
if( !class_exists( 'pmArrayModel' ) ) :

class pmArrayModel {

           function pmFields(){
            
            $post_meta_field_list=array(
                                        'text' => array(
                                            'title'         => 'Text box',
                                            'is_free'       => true,  
                                        ),
                                        'email' => array(
                                            'title'         => 'Email',
                                            'is_free'       => true,  
                                        ),
                                        'url' => array(
                                            'title'         => 'Website',
                                            'is_free'       => true,  
                                        ),
                                        'phone' => array(
                                            'title'         => 'Phone',
                                            'is_free'       => true,  
                                        ),
                                        'number' => array(
                                            'title'         => 'Number',
                                            'is_free'       => true,  
                                        ),
                                        'textarea' => array(
                                            'title'         => 'Paragraph',
                                            'is_free'       => true,   
                                        ),
                                        'wp_edior' => array(
                                            'title'         => 'WP Editor',
                                            'is_free'       => true,   
                                        ),
                                        'datetime' => array(
                                            'title'         => 'Date / Time',
                                            'is_free'       => true,   
                                        ),                      
                                        'select' => array(
                                            'title'         => 'Drop Down',
                                            'is_free'       => true,   
                                        ),   
                                        'checkbox' => array(
                                            'title'         => 'Checkbox',
                                            'is_free'       => true,  
                                        ),   
                                        'radio' => array(
                                            'title'         => 'Select One (radio)',
                                            'is_free'       => true,  
                                        ),
                                        'hidden' => array(
                                            'title'         => 'Hidden',
                                            'is_free'       => true,   
                                        ),
                                        'image_media' => array(
                                            'title'         => 'Image Media',
                                            'is_free'       => true,   
                                        ),
                                        'image' => array(
                                            'title'         => 'Image Upload',
                                            'is_free'       => false,
                                        ),
                                        'audio' => array(
                                            'title'         => 'Audio Upload',
                                            'is_free'       => false,
                                        ),
                                        'video' => array(
                                            'title'         => 'Video Upload',
                                            'is_free'       => false,
                                        ),
                                        'file' => array(
                                            'title'         => 'File Upload',
                                            'is_free'       => false,
                                        )  
                                
                                );
                                
                   return $post_meta_field_list;          
            
           }
           
    function pmAllExts(){
        $pmAllExts = array(
                    'file'=>array(
                                'zip'=>'ZIP',
                                'rar'=>'RAR',
                                '7z'=>'7Z',
                                'exe'=>'EXE',
                                'iso'=>'ISO',
                                'dmg'=>'DMG'
                            ),
                    'audio'=>array(
                                'mp3'=>'MP3 (Preview)',
                                'wav'=>'WAV',
                                'wma'=>'WMA'
                            ),
                    'document'=>array(
                                'pdf'=>'PDF',
                                'doc'=>'DOC',
                                'ppt'=>'PPT',
                                'txt'=>'txt'
                            ),
                    'image'=>array(
                                'jpg'=>'JPG',
                                'jpeg'=>'JPEG',
                                'png'=>'PNG',
                                'gif'=>'GIF',
                                'tif'=>'TIF',
                                'psd'=>'PSD'
                            ),
                    'video'=>array(
                                'mp4'=>'MP4 (Preview)',
                                'flv'=>'FLV (Preview)',
                                'avi'=>'AVI',
                                'wmv'=>'WMV',
                                'mpg'=>'MPG',
                                'mov'=>'MOV',
                                '3gp'=>'3GP'
                            )
                    );
        return $pmAllExts;
    }
           
           
    function nonceText(){
        return "postmeta_nonce";
    }

}

endif;

?>