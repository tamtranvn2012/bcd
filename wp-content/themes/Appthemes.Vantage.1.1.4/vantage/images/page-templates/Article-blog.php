<?php
// Template Name: Artide BLOG
?>

<div class="content_left">
                        <p>BLOG BLOG</p>
                            <div class="div_from_area">
                                <form name="mailing" method="post">
                                    <div class="from_area">
                                        <label id="labe1">Subject:</label>
                                        <select id="select_area">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                     <div class="from_area">
                                        <label id="labe1">Toppic Title:</label>
                                        <select id="select_area">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="from_area">
                                        <label id="labe1">Post:</label>
                                        <textarea id="txarea"></textarea>
                                    </div>
                                    
                                    <div class="from_area">
                                        <label id="labe1">URL\Link</label>
                                        <input type="text" name="txfiled" id="txfiled">
                                    </div>
                                    <div class="from_area">
                                        <input type="button" name="preview" value="PREVIEW" id="button1">
                                        <input type="button" name="post" value="POST" id="button2">
                                    </div>
                                </form>
                             </div>
                        </div>
                        

<div class="content_right">
                            <div id="article_categories">
                                <label id="labe2">ARTICLE CATEGORIES</label>
                                <select id="select_area_right">
                                    <option>Arts</option>
                                </select>
                            </div>
                            <div class="latest_post">
                                <p id="name_title">LATEST POSTS</p>
                                <div class="new-articale">
                                  <a href="#">  <img src="<?php echo  get_stylesheet_directory_uri().'/images/header_home_cosmetics.png';?>" alt=""></a>
                                    <div class="info-articale">
                                        <span id="title"><a href="#">Lorem Ipsum</a></span>
                                        <p id="bottom">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                                  </div>
                              </div>
                                 
                                
                            </div>
                            <div class="latest_post">
                                <p id="name_title">LATEST POSTS</p>
                                <div class="new-articale">
                                   <a href="#"> <img src="<?php echo  get_stylesheet_directory_uri().'/images/handshake.png';?>" alt=""></a>
                                    <div class="info-articale">
                                        <span id="title"><a href="#">Lorem Ipsum</a></span>
                                        <p id="bottom">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                                  </div>
                              </div>
                                 
                                
                            </div>
                            <div class="latest_post">
                                <p id="name_title">LATEST POSTS</p>
                                <div class="new-articale">
                                   <a href="#"> <img src="<?php echo  get_stylesheet_directory_uri().'/images/hiphop.png';?>" alt=""></a>
                                    <div class="info-articale">
                                        <span id="title"><a href="#">Lorem Ipsum</a></span>
                                        <p id="bottom">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                                  </div>
                              </div>
                                 
                                
                            </div>
                            <div class="latest_post">
                                  <a href="#">  <img src="<?php echo  get_stylesheet_directory_uri().'/images/anh.png';?>" alt="">  </a>                           
                            </div>
                            
                            <div class="latest_post">
                                <p id="name_title">RECENT POST</p>
                                   <ul>
                                        <li><a href="#">Lorem Ipsum is simply dummy text of the printing and typesetting industry</a> </li>
                                        <li><a href="#">Lorem Ipsum is simply dummy text of the printing and typesetting industry</a></li>
                                        <li><a href="#">Lorem Ipsum is simply dummy text of the printing and typesetting industry</a></li>
                                   </ul>                            
                            </div>
                            <div class="latest_post_dk">
                               <a href="#"> <img src="<?php echo  get_stylesheet_directory_uri().'/images/back.png';?>" alt=""></a>
                                <a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/next.png';?>" alt=""></a>
                            </div>
                        </div>
						
	<?php get_sidebar('right'); ?>