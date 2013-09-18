<?php
// Template Name: List Profile
 ?>
<div class="col-xs-10">
<p class="title-page">Companies</p>
    <div class="span7">

<div class="col-lg-12" style="border: 1px solid rgb(228, 219, 219);background: rgb(79, 167, 226);padding-bottom: 5px;padding-top: 5px;margin-top: 13px;">

<form  name="frmcompany" action="<?php echo home_url().'/list-profile/';?>" method="get">

<?php
$str='';
for($i='A';$i<='Z';$i++){
    $str=$str.'<option value="'.$i.'">'.$i.'</option>';
}
echo '<select id="combo_Categories" name="company" class="form-control span3 offset1"><option value="">Company</option>'.$str.'</select>';
?>
<button type="submit" class="btn btn-danger btpro" style="margin-left: 10px;" >Search</button>
</form>
</div><!--end div form-->
<?php
global $wpdb;
$query = "SELECT * from $wpdb->users  ORDER BY 'company'";

$author_ids = $wpdb->get_results($query);

if($_GET['company']==null){
foreach($author_ids as $author) :
        if(get_the_author_meta('company', $author->ID)!=null && $author->ID!=1){
		  ?>
		  <div class="col-lg-11">
			<div class="col-lg-3">
				<div class="images_avata" style="margin-top:30px;">
					<a  href="<?php echo home_url().'/edit-profile/?id='.$author->ID;?>"  title="<?php the_author_meta( 'display_name', $author->ID ); ?> "><?php echo get_avatar($author->ID) ;  ?></a>
				</div><!--end images_avata-->
			</div><!--end col-3-->
            
			<ul class="col-lg-4" style="margin-bottom:20px;margin-top:30px;list-style: none; line-height: 20px;">
			<li class="title_com"><b style="font-size: 20px;"><?php the_author_meta( 'company', $author->ID ); ?></b></li>
            <li class="uer" style="font-size: 13px;"> <?php the_author_meta( 'description', $author->ID ); ?></li>
            <li class="uer"><?php the_author_meta( 'address', $author->ID ); ?></li>
            <li class="uer"> <a href="<?php echo 'http://'.get_the_author_meta('website', $author->ID); ?>"><?php the_author_meta( 'website', $author->ID ); ?></a></li>

			<ul class="col-12 list-inline" style="margin-top:10px;margin-bottom:10px;font-weight: bold;">
				<li class="col-6">
					<p class="visit"><a href="<?php echo home_url().'/edit-profile/?id='.$author->ID;?>">Visit Site</a></p>
				</li><!--end col-3-->
				<li class="col-3">
				<p class="contact"><a href="<?php echo 'mailto:'.get_the_author_meta('user_email', $author->ID);?>">Contact</a></p>
				</li><!--end col-3-->
			</ul><!--end col-12-->
			
			</ul><!--end col3-->
		  </div><!--end col-12-->
            
		<?php
        }
endforeach;
}
else{
     echo '<h2>Seacrch title begin "'.$_GET['company']. '"...</h2>' ;
foreach($author_ids as $author) :
         $st=get_the_author_meta( 'company', $author->ID );
         $str = substr($st, 0,1);
         

         if($_GET['company']==$str){
            if(get_the_author_meta('company', $author->ID)!=null && $author->ID!=1){
		  ?>
          
		  <div class="col-lg-11">
			<div class="col-lg-3">
				<div class="images_avata" style="margin-top:10px;">
					<a  href="<?php echo home_url().'/edit-profile/?id='.$author->ID;?>"  title="<?php the_author_meta( 'display_name', $author->ID ); ?> "><?php echo get_avatar($author->ID) ;  ?></a>
				</div><!--end images_avata-->
			</div><!--end col-3-->
            
			<div class="col-3" style="margin-bottom:20px;margin-top:25px;">
			<p class="title_com"><b style="font-size: 20px;"><?php the_author_meta( 'company', $author->ID ); ?></b></p><br />
            <p class="uer" style="font-size: 13px;"> <?php the_author_meta( 'description', $author->ID ); ?></p><br />
            <p class="uer"><?php the_author_meta( 'address', $author->ID ); ?></p><br />
            <p class="uer"> <a href="<?php echo 'http://'.get_the_author_meta('website', $author->ID); ?>"><?php the_author_meta( 'website', $author->ID ); ?></a></p><br />

			<div class="col-12" style="margin-top:10px;margin-bottom:10px;">
				<div class="col-6">
					<p class="visit"><a href="<?php echo home_url().'/edit-profile/?id='.$author->ID;?>">Visit Site</a></p>
				</div><!--end col-3-->
				<div class="col-3">
				<p class="contact"><a href="<?php echo 'mailto:'.get_the_author_meta('user_email', $author->ID);?>">Contact</a></p>
				</div><!--end col-3-->
			</div><!--end col-12-->
			
			</div><!--end col3-->
		  </div><!--end col-12-->
            
		<?php
        }
        }
endforeach;
}

wp_reset_query();
?>

</div><!--end col--->

<div class="span3">
	<div class="images1">
		<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_2.png';?>" alt="" style="width:100%; height:600px;"/></a>
                        
    </div>
	<div class="video">
	 <object height="90" width="300"><param name="allowFullScreen" value="true">
					<param name="movie" value="http://www.youtube.com/v/suYXAdT58hk&amp;rel=0&amp;color1=0x999999&amp;color2=0xe8e8e8">
					<param name="wmode" value="transparent">
					<embed height="90" type="application/x-shockwave-flash" width="100%" wmode="transparent" src="http://www.youtube.com/v/suYXAdT58hk&amp;rel=0&amp;color1=0x999999&amp;color2=0xe8e8e8" allowfullscreen="true" style="margin-top:10px;">
				</object>
			
			<div class="col-xs-12 post_right">
				<p class="title_video">Lorem Ipsum is simply dummmy</p>
				<p>By :<strong class="str">Joseph Luke PLC</strong></p>
				<p>30 July 2013 Views:456,543</p>
				<p>Likes:232</p>
			</div><!--end post_right-->
	</div><!--end video-->
	<div class="video">
	 <object height="110" width="300"><param name="allowFullScreen" value="true">
					<param name="movie" value="http://www.youtube.com/v/suYXAdT58hk&amp;rel=0&amp;color1=0x999999&amp;color2=0xe8e8e8">
					<param name="wmode" value="transparent">
					<embed height="110" type="application/x-shockwave-flash" width="100%" wmode="transparent" src="http://www.youtube.com/v/suYXAdT58hk&amp;rel=0&amp;color1=0x999999&amp;color2=0xe8e8e8" allowfullscreen="true" style="margin-top:10px;">
				</object>
			
			<div class="col-xs-12  post_right">
				<p class="title_video">Lorem Ipsum is simply dummmy</p>
				<p>By :<strong class="str">Joseph Luke PLC</strong></p>
				<p>30 July 2013 Views:456,543</p>
				<p>Likes:232</p>
			</div><!--end post_right-->
	</div><!--end video-->
	<div class="images_logo">
		<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_3.jpg';?>" alt="" style="width:100%; height:50px;margin-top: 4px;"/></a>
                        
    </div>
	
	<div class="Lastes">
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
		 <div class="read_more"><a href="#">Read More</a></div>
		 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
		 <div class="read_more"><a href="#">Read More</a></div>
		 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
		 <div class="read_more"><a href="#">Read More</a></div>
	</div><!--end Lastes-->
	<div class="images1">
		<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_6.jpg';?>" alt="" style="width:250px; height:300px; margin-top:4px;margin-left:7px;"/></a>
          
	</div>
	<div class="video">
		<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_4.png';?>" alt="" style="width:160px; height:600px;margin-left:30px; margin-top:10px;"/></a>
          	
			<div class="col-xs-12 post_right">
				<p class="title_video">Lorem Ipsum is simply dummmy</p>
				<p>By :<strong class="str">Joseph Luke PLC</strong></p>
				<p>30 July 2013 Views:456,543</p>
				<p>Likes:232</p>
			</div><!--end post_right-->
	</div><!--end video-->
	<div class="video">
		 <object height="200" width="100%" style="margin-top:10px;"><param name="allowFullScreen" value="true">
					<param name="movie" value="http://www.youtube.com/v/suYXAdT58hk&amp;rel=0&amp;color1=0x999999&amp;color2=0xe8e8e8">
					<param name="wmode" value="transparent">
					<embed height="200" type="application/x-shockwave-flash" width="260" wmode="transparent" src="http://www.youtube.com/v/suYXAdT58hk&amp;rel=0&amp;color1=0x999999&amp;color2=0xe8e8e8" allowfullscreen="true" style="margin-top:10px;">
				</object>
			<div class="col-xs-12 post_right">
				<p class="title_video">Lorem Ipsum is simply dummmy</p>
				<p>By :<strong class="str">Joseph Luke PLC</strong></p>
				<p>30 July 2013 Views:456,543</p>
				<p>Likes:232</p>
			</div><!--end post_right-->
	</div><!--end video-->
	<div class="images2" style="margin-top:10px;">
		<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_5.png';?>" alt="" style=" height:150px;width:100%;"/></a>
          
	</div>
</div><!--end col-3-->



            <!--
			<a style="font-size: 15px;text-decoration:none;" href="<?php echo home_url().'/edit-profile/?id='.$author->ID;  ?>" title="<?php the_author_meta( 'display_name', $author->ID ); ?>"><?php the_author_meta( 'display_name', $author->ID ); ?></a><br />
            <p class="uer">User Login: <b style="font-size: 15px;"><?php the_author_meta( 'User Login', $author->ID ); ?></b></p><br />
            <p class="uer">Phone: <b style="font-size: 15px;"><?php the_author_meta( 'phone', $author->ID ); ?></b></p><br />
            <p class="uer">Address: <b style="font-size: 15px;"><?php the_author_meta( 'address', $author->ID ); ?></b></p><br />
            <p class="uer">Website: <b style="font-size: 15px;"><?php the_author_meta( 'website', $author->ID ); ?></b></p><br />
            
            !-->

</div>