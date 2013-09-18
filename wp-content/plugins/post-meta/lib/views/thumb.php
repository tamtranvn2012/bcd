<?php
$html ='';
if( @$file ) :
                $uploads    = wp_upload_dir();
                
                if(preg_match('/\/wp-content\/uploads\//',$file ,$match)){
                    
                   $fullPath = $uploads['basedir'].str_replace( $uploads['baseurl'] , '', $file);
                   $fullUrl = $file;
                    
                }else{
                    
                $fullPath   = $uploads['basedir'] . $file;
                $fullUrl    = $uploads['baseurl'] . $file;
                }
                $fileData   = pathinfo( $fullPath );
                $fileName   = $fileData['basename'];
            
                if( !file_exists( $fullPath ) ) return;               
            
                // In case of image
                if( is_array( getimagesize( "$fullPath" ) ) ){
                    if( @$width AND @$height ){
                        $resizedImage = image_resize( $fullPath, $width, $height, false);
                        if( is_wp_error($resizedImage) )
                            $error[] = $resizedImage->get_error_message();               
                        if( !isset($error) )
                            $fullUrl = str_replace( $uploads['basedir'], $uploads['baseurl'], $resizedImage );
                    }        
                    $html .= "<img src='$fullUrl' alt='$fileName' title='$fileName' />";  
                }                
endif;
    
?>