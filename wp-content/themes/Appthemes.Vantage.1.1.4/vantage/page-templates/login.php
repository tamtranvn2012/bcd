<?php
// Template Name: Login
?>
<div class="col-xs-10">

    
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

 <div class="span7"> 
 <p class="title-page">Login</p>
                        <div class="row">
                        
                        	<?php do_action( 'appthemes_notices' ); ?>
                            <form action="<?php echo APP_Login::get_url(); ?>" method="post" name="">
                                <div class="col-xs-11" style="margin-top: 10px;">
                                <label class="col-xs-11">Username:</label><br />
                               <div class="col-xs-11"> <input type="text" id="name" value="" name="log" class="tx form-control" placeholder="Username"/></div>
                                
                                </div>
                                <div class="col-xs-11" style="margin-top: 10px;">
                                <label class="col-xs-11">Password</label><br />
                                <div class="col-xs-11"><input type="password" id="pass" value="" name="pwd" class="tx form-control" placeholder="Password"/></div>
                                
                                </div>
                                <div class="col-xs-11" style="margin-top: 10px;">
                                    <input type="checkbox" name="rememberme" id="ck" style="margin-left: 10px;"/> Remember me  <br />                                     
                                </div>
                                <div class="col-xs-11" style="margin-top: 10px;">
                                    <input type="submit" name="submit" id="submit" class="btn btn-danger" value="Login"/>  
                                </div>
                            </form>
                                
                        </div>
                    
</div>              
                    <!--End of register-content-->
              <div id="register-lastnew" class="span3" style="margin: 0;">
              <span id="last-new">
              <p>Lasted New</p>              
              </span>
              <ul class="lastnew">
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
              </ul>
<div id="next-pre"> <a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/back.png';?>" alt="Previous"></a>
<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/next.png';?>" alt="Next"></a>
</div><br>


<div class="col-xs-11"><img style="border: solid 1px #ccc;width: 100%;" src="<?php echo  get_stylesheet_directory_uri().'/images/anh.png';?> "/></div>
              </div>
    
</div>
