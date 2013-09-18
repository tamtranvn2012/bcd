<?php
// Template Name:Delete

?>

<?php
   // wp_delete_post($_GET['id']);
?>

 <div class="left"> 
                        <div class="div_form">
                                <p style="margin-top: 35px;">
                                <img align="left" src="<?php echo  get_stylesheet_directory_uri().'/images/deletes.png';?>" alt=""/>
                                <h2>Delete product "<?php echo $_GET['names']; ?>" success!</h2>
                                <a href="<?php  echo get_home_url().'/show-find/'; ?>">Go back list product</a><br />
                                <a href="<?php  echo get_home_url().'/user/'.$_GET['authors']; ?>">Go back manager product user</a>
                                </p>
                                
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