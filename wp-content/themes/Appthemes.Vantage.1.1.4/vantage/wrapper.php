<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
     <link  href="<?php echo get_stylesheet_directory_uri().'/css/style.css';?>" rel="stylesheet" type="text/css"/>
    <link  href="<?php echo get_stylesheet_directory_uri().'/css/bootstrap.css';?>" rel="stylesheet" type="text/css"/>
    <link  href="<?php echo get_stylesheet_directory_uri().'/css/bootstrap-responsive.css';?>" rel="stylesheet" type="text/css"/>
 
    <script src="<?php echo get_stylesheet_directory_uri().'/js/jquery.js';?>"></script>
    <script src="<?php echo get_stylesheet_directory_uri().'/js/bootstrap.min.js';?>"></script> 
    <title><?php wp_title(''); ?></title>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri().'/js/slides.min.jquery.js';?>"></script>
<script src="<?php echo get_stylesheet_directory_uri().'/js/thanh.js';?>"></script>-->


    
	<!--[if lte IE 9]><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/ie.css" type="text/css" media="screen" /><![endif]-->
</head>

<body >
    <?php //body_class(); ?>
	<?php appthemes_before(); ?>

	<?php appthemes_before_header(); ?>
	<?php get_header('thanh'); ?>
	<?php appthemes_after_header(); ?>

            <!--content begin-->
                <div class="main-container">

                <?php get_sidebar('left'); ?>
				<?php include app_template_path(); ?>
                
                </div>
            <!--content end-->

	<?php appthemes_before_footer(); ?>
	<?php get_footer( app_template_base() ); ?>
	<?php appthemes_after_footer(); ?>

	<?php appthemes_after(); ?>

	<?php wp_footer();?>
	<!-- this cssfile can be found in the jScrollPane package -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri().'/jquery.jscrollpane.css';?>" />	
		
	<!-- latest jQuery direct from google's CDN -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<!-- the jScrollPane script -->
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri().'/jquery.jscrollpane.min.js';?>"></script>
	
	<!--instantiate after some browser sniffing to rule out webkit browsers-->
	<script type="text/javascript">
	
	  $(document).ready(function () {
	      if (!$.browser.webkit) {
	          $('.thienthanh').jScrollPane();
	      }
	  });
	
	</script>
</body>
</html>
