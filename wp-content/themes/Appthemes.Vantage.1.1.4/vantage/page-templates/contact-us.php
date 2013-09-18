<?php
// Template Name: Contact Us
 ?>

<div class="col-xs-10">
<div class="span7">
                <p class="title-page">CONTACT US </p>

                <p class="col-lg-11">
                Questions, Comments and Sugguestions<br/>
                Welcome to our contact page. If you have any questions, ideas or sugguestions, please do not hesitate to contact us!
                </p>
                
                <form name="register-form" id="regist">
                <div class="col-xs-11 tx">
                <label for="fname" class="col-xs-11">Name: </label>
                <div class="col-xs-11"><input type="text" placeholder="fname"  id="fname" class="form-control"/></div>
                </div>
                
                
                <div class="col-xs-11 tx">
                <label for="select" class="col-xs-11">Country:</label>
                <div class="col-xs-11"><select name="select"  id="select" class="form-control"></select></div>
                </div>
                
                <div class="col-xs-11 tx">
                <label for="select2" class="col-xs-11">City / Sate:</label>
                <div class="col-xs-11"><select name="select2"  id="select2" class="form-control"></select></div>
                </div>
                <div class="col-xs-11 tx">
                    <label class="col-xs-11">Email:</label>
                    <div class="col-xs-11"><input type="text" placeholder="Email"  class="form-control"/></div> 
                </div> 
                <div class="col-xs-11 tx">             
               	<label class="col-xs-11">Phone</label>
                <div class="col-xs-11"><input type="text"  class="form-control"/></div>
                </div> 
                <div class="col-xs-11 tx">
                <label class="col-xs-11">Subject: </label>
                <div class="col-xs-11"><input type="password"  class="form-control"/></div>
                </div>
                <div class="col-xs-11 tx">
                  <label for="textarea" class="col-xs-11">Messenger</label>
                  <div class="col-xs-11"><textarea name="textarea" cols="5" rows="3"  id="textarea" class="form-control"></textarea></div>
                </div>
                 <div class="col-xs-11 tx"  style="padding-left: 35px;">
                <button value="Submit" id="confirm" class="btn btn-danger">Send Mail</button>
                </div>
                </form>   
</div>



			  
			  
			  
<div class="span3">
<div id="register-lastnew">
              <span id="last-new">
<p>              Lasted New</p>
              </span>
              <ul class="lastnew">
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                <li> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
              </ul>
<div id="next-pre"> <a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/back.png';?>" alt="Previous"/></a>
<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/next.png';?>" alt="Next"/></a>
</div><br/>


<div class="col-xs-11"><img style="border: solid 1px #ccc;width: 100%;" src="<?php echo  get_stylesheet_directory_uri().'/images/anh.png';?> "/></div>
              </div>
<?php get_sidebar('right'); ?></div>
</div>