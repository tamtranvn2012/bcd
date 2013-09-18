<?php
// Template Name: Login
?>

<?php
// make sure there's the correct url
if (!isset($action)) 
	$action = site_url('wp-login.php');
	
// set a redirect for after logging in
if ( isset( $_REQUEST['redirect_to'] ) ) {
	$redirect = $_REQUEST['redirect_to'];
}

if (!isset($redirect)) $redirect = home_url();

?>

 <div class="left"> 
                        <div class="div_form">
                        <p>LOGIN</p>
                        	<?php do_action( 'appthemes_notices' ); ?>
                            <form action="<?php echo APP_Login::get_url(); ?>" method="post" name="">
                                <div class="form_area1">
                                <label>Username:</label><br />
                                <input type="text" id="name" value="" name="log" class="tx"/>
                                
                                </div>
                                <div class="form_area1">
                                <label>Password</label><br />
                                <input type="password" id="pass" value="" name="pwd" class="tx"/>
                                
                                </div>
                                <div class="form_area1" style="margin-left: 160px;">
                                    <input type="checkbox" name="rememberme" id="ck"/> Remember me  <br />
                                    <input type="submit" name="submit" id="submit" class="sb" value="Login"/>                                
                                </div>
                            </form>
                                
                        </div>
                    
</div>              
                    <div class="right">
                        <div class="new">
                            <p style="color:#528bd0;font-weight: bold;">LATEST NEW</p>
                            <ul>
                                        <li><a href="#">Lorem Ipsum is simply dummy text of the printing and typesetting industry</a> </li>
                                        <li><a href="#">Lorem Ipsum is simply dummy text of the printing and typesetting industry</a></li>
                                        <li><a href="#">Lorem Ipsum is simply dummy text of the printing and typesetting industry</a></li>
                                        <li><a href="#">Lorem Ipsum is simply dummy text of the printing and typesetting industry</a></li>
                                        
                            </ul>  
                            <div class="latest_post_dk1" style="margin-left: 250px;">
                               <a href="#"> <img style="width: 10px; height: 10px; border: none;margin-right: 5px;" src="<?php echo  get_stylesheet_directory_uri().'/images/back.png';?>" alt=""/></a>
                                <a href="#"><img style="width: 10px; height: 10px; border: none;" src="<?php echo  get_stylesheet_directory_uri().'/images/next.png';?>" alt=""/></a>
                            </div>
                        </div>
                        <div class="images1">
                            <a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/anh.png';?>" alt=""/></a>
                        
                        </div>
                        
                    
                    </div>
