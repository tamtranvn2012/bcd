<?php
// Template Name: Artide Admin
?>

<div class="col-7">
                        <p style="title_content">BLOG ADMIN</p>
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
 
<?php get_sidebar('right'); ?> 