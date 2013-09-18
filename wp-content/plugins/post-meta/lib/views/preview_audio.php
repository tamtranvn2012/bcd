<?php
$html ='';
if( @$file ) :
                $uploads    = wp_upload_dir();
                
                if(preg_match('/\/wp-content\/uploads\//',$file ,$match)){
                   $fullUrl = $file;
                    
                }else{
                    $fullUrl = $uploads['baseurl'].$file;
                }
                $player_url = PM_ASSECTS_URL.'player.swf';
                $base_path = get_bloginfo('url');
                $id='jwplayer-'.rand(1,99);
                
                $html .="<object width='295' height='20' type='application/x-shockwave-flash' data='$player_url' bgcolor='#000000' id='$id' name='$id' tabindex='0'>
                            <param name='allowfullscreen' value='true'/>
                            <param name='allowscriptaccess' value='always'/>
                            <param name='seamlesstabbing' value='true'/>
                            <param name='wmode' value='opaque'/>
                            <param name='flashvars' value='netstreambasepath=$base_path&amp;id=$id&amp;flashplayer=$player_url&amp;autostart=false&amp;image=&amp;file=$fullUrl&amp;controlbar.position=bottom&amp;dock=false'/>
                        </object>"; 
         
endif;  
?>