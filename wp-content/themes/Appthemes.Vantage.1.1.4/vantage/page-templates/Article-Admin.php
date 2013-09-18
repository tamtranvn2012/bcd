<?php
// Template Name: Artide Admin
?>

<div class="col-xs-10">
<p class="title-page">BLOG ADMIN</p>
    <div class="span7" style="margin: 0;">
                        
                            <div class=" span5 div_from_area">
                                <form name="mailing" method="post">
                                    <div class="span5 form-area">
                                        <label class="span5">Subject:</label>
                                        <div class="span5">
                                            <select id="select_area" class="form-control">
                                            <option value=""></option>
                                        </select>
                                        </div>
                                    </div>
                                     <div class="span5 form-area">
                                        <label class="span5">Toppic Title:</label>
                                        <div class="span5">
                                        <select id="select_area" class="form-control">
                                            <option value=""></option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="span5 form-area">
                                        <label class="span5">Post:</label>
                                        <div class="span5">
                                        <textarea id="txarea" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="span5 form-area">
                                        <label class="span5">URL\Link</label>
                                        <div class="span5">
                                        <input type="text" name="txfiled" id="txfiled" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="span5 form-area">
                                        <div class="span5">
                                            <input type="button" name="preview" value="PREVIEW" id="button1" class="bnt btn-primary">
                                        <input type="button" name="post" value="POST" id="button2"  class="bnt btn-primary">
                                        </div>
                                    </div>
                                </form>
                             </div>
                        </div>
 
<div class="span3 pull-right" >
    <?php get_sidebar('right'); ?>
</div>

</div>