<?php
// Template Name: List Profile
 ?>
<div class="col-7">
<div class="col-lg-12"style="border: 1px solid rgb(228, 219, 219);margin-bottom: 7px;height: 45px;border-radius: 5px;margin-top: 6px;background: rgb(79, 167, 226);">
	<form  name="frmcompany" action="<?php echo home_url().'/list-profile/';?>" method="get" style="margin-top:-24px;">

<?php
$str='';
for($i='A';$i<='Z';$i++){
    $str=$str.'<option value="'.$i.'">'.$i.'</option>';
}
echo '<select id="combo_Categories" name="company" class="text"><option value="">Company</option>'.$str.'</select>';
?>
<button type="button" class="btn btn-danger btpro" >Search</button>
</form>
</div><!--end div form-->
<?php
global $wpdb;
$query = "SELECT * from $wpdb->users  ORDER BY 'company'";

$author_ids = $wpdb->get_results($query);

if($_GET['company']==null){
foreach($author_ids as $author) :

		  ?>
            
            <div class="col-12" class="authors">
			Company:<b style="font-size: 15px;"><?php the_author_meta( 'company', $author->ID ); ?></b><br />
            <a style="float: left;width:100px;margin:5px;" href="<?php echo home_url().'/edit-profile/?id='.$author->ID; ?>" title="<?php the_author_meta( 'display_name', $author->ID ); ?>"><?php echo get_avatar($author->ID); ?></a>
			<a style="font-size: 15px;text-decoration:none;" href="<?php echo home_url().'/edit-profile/?id='.$author->ID;  ?>" title="<?php the_author_meta( 'display_name', $author->ID ); ?>"><?php the_author_meta( 'display_name', $author->ID ); ?></a><br />
            User Login:<b style="font-size: 15px;"><?php the_author_meta( 'User Login', $author->ID ); ?></b><br />
            Phone:<b style="font-size: 15px;"><?php the_author_meta( 'phone', $author->ID ); ?></b><br />
            Address:<b style="font-size: 15px;"><?php the_author_meta( 'address', $author->ID ); ?></b><br />
            Website:<b style="font-size: 15px;"><?php the_author_meta( 'website', $author->ID ); ?></b><br />
            Email:<i><?php the_author_meta( 'user_email', $author->ID ); ?></i><br />
            Description:<b style="font-size: 15px;"><?php the_author_meta( 'description', $author->ID ); ?></b><br />
            </div>
		<?php
endforeach;
}
else{
     echo '<h2>Seacrch title begin "'.$_GET['company']. '"...</h2>' ;
foreach($author_ids as $author) :
         $st=get_the_author_meta( 'company', $author->ID );
         $str = substr($st, 0,1);
         

         if($_GET['company']==$str){
		  ?>
            
            <div class="col-12" class="authors">
			Company:<b style="font-size: 15px;"><?php the_author_meta( 'company', $author->ID ); ?></b><br />
            <a style="float: left;width:100px;margin:5px;" href="<?php echo home_url().'/edit-profile/?id='.$author->ID; ?>" title="<?php the_author_meta( 'display_name', $author->ID ); ?>"><?php echo get_avatar($author->ID); ?></a>
			<a style="font-size: 15px;text-decoration:none;" href="<?php echo home_url().'/edit-profile/?id='.$author->ID;  ?>" title="<?php the_author_meta( 'display_name', $author->ID ); ?>"><?php the_author_meta( 'display_name', $author->ID ); ?></a><br />
			
            User Login:<b style="font-size: 15px;"><?php the_author_meta( 'User Login', $author->ID ); ?></b><br />
            Phone:<b style="font-size: 15px;"><?php the_author_meta( 'phone', $author->ID ); ?></b><br />
            Address:<b style="font-size: 15px;"><?php the_author_meta( 'address', $author->ID ); ?></b><br />
            Website:<b style="font-size: 15px;"><?php the_author_meta( 'website', $author->ID ); ?></b><br />
            Company:<b style="font-size: 15px;"><?php the_author_meta( 'company', $author->ID ); ?></b><br />
            Email:<i><?php the_author_meta( 'user_email', $author->ID ); ?></i><br />
            Description:<b style="font-size: 15px;"><?php the_author_meta( 'description', $author->ID ); ?></b><br />
            </div>
		<?php
        }
endforeach;
}

wp_reset_query();
?>

</div><!--end col--->