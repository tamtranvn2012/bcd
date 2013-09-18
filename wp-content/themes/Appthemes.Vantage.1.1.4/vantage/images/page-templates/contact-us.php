<?php
// Template Name: Contact Us
 ?>

<div id="register-content">
              	<div id="regist-title">
                <h3>CONTACT US </h3>
                </div>
                <p class="htu">
                Questions, Comments and Sugguestions<br/>
                Welcome to our contact page. If you have any questions, ideas or sugguestions, please do not hesitate to contact us!
                </p>
                
                <form name="register-form" id="regist">
                <p>
                <label for="fname">Name: </label>
                <input type="text" placeholder="fname" class="input-text" id="fname"/><br/>
                </p>
                <p>
                <label for="select">Country:</label>
                <select name="select" class="input-text" id="select">
                </select>
                <br/>
                </p>
                <p>
                <label for="select2">City / Sate:</label>
                <select name="select2" class="input-text" id="select2">
                </select>
                <br/>
                </p>
                <p>
                <label>Email:</label>
                <input type="text" placeholder="Email" class="input-text"/><br/>  
                </p>
                <p>              
               	<label>Phone</label>
                <input type="text" class="input-text"/><br/>
                </p>
                <p>
                <label>Subject: </label>
                <input type="password" class="input-text"/>
                </p>
<p>

  <label for="textarea">Messenger</label>
  <textarea name="textarea" cols="5" rows="3" class="input-text" id="textarea"></textarea>
</p>
                <p>
                <button value="Submit" id="confirm">Send Mail</button></p>
                </form>   
</div>


<div id="register-lastnew">
              <span id="last-new">
<p>              Lasted New</p>
              </span>
              <p><img src="<?php echo  get_stylesheet_directory_uri().'/images/tick.png';?>"/>&nbsp;&nbsp;Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><br/>
                            <p> <img src="<?php echo  get_stylesheet_directory_uri().'/images/tick.png';?>"/>&nbsp;&nbsp;Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><br/>
                                          <p><img src="<?php echo  get_stylesheet_directory_uri().'/images/tick.png';?>"/>&nbsp;&nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><br/>
                                                        <p><img src="<?php echo  get_stylesheet_directory_uri().'/images/tick.png';?>"/>&nbsp;&nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><br/>
<div id="next-pre"> <a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/back.png';?>" alt="Previous"/></a>
<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/next.png';?>" alt="Next"/></a>
</div><br/>


<p><img style="border: solid 5px gray;" src="<?php echo  get_stylesheet_directory_uri().'/images/anh.png';?>"/></p>
              </div>
			  
			  
			  
<?php get_sidebar('right'); ?>