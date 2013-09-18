
<!--header begin-->
<!--HEADER-->
<div class="main-container">
<!--begin header-->
    <div class="header">
            <!--begin top menu-->
            <div class="row menu-top-fixed" style="padding: 0;margin: 0;">
                <div class="span9 offset3" style="padding-left: 20px;padding-top: 8px;"><ul class="list-inline">
                    <li><a href="#">Post Ads</a></li>
                    <li><a href="#">Car Rentals</a></li>
                    <li><a href="#">Hotels</a></li>
                    <li><a href="#">AirPort Parking</a></li>
                    <li><a href="#">Jewelry</a></li>
                    <li><a href="#">Boutique</a></li>
                    <li><a href="#">Blog</a></li>
                    <li class="offset1" style="border-left: 1px solid black;padding-left: 10px;"><a href="#">Login</a></li>
                </ul></div>
            </div>
    <div class="row" style="border-bottom: 1px solid #ccc; margin: 0;padding: 0;">
        <div class="span7  top-menu" style="float: right !important;">
        
            <ul class="list-inline list-top">
                <li>
                    <div class="btn-group">
                        <button class="btn">Ngon ngu</button>
                        <button class="btn dropdown-toggle" data-toggle="dropdown" style="height:34px;">
                        <span class="caret"></span>
                        </button>
                        <ul class="sub-menu">
                        <li>tieng anh</li>
                        </ul>
                    </div>
                </li>
               <li>
					<a href="<?php echo get_home_url().'/article-admin/';?>">Submit Article</a>
				</li>
				<li>
					<a href="<?php echo get_home_url().'/bussineses/';?>">List your Business</a>
				</li>
				<li>
					<a href="#">Advertise</a>
				</li>
				<li>
					<a href="<?php echo get_home_url().'/register/';?>">Sign up</a>
				</li>
				<li>
					<a href="<?php echo home_url().'/login';?>">
						Login
					</a>
				</li>
            
            </ul>
        </div>
    
    </div>
<!--end top menu-->

<!--begin search-->
<div class="row form-header" style="margin: 0; padding: 0;">
<form method="get" class="form-search" action="<?php echo home_url().'/show-find/';//echo trailingslashit( get_bloginfo( 'url' ) ); ?>">
    <div class="span2 logo">
        <a href="#"><img  src="<?php echo get_stylesheet_directory_uri().'/images/logo.png';?>"/></a>
    </div>
    <ul class=" span8 list-inline  span9-search" >
        <li class="span2">

                       <select  id="combo_State"  name="country"  class="form-control span2 li-search pull-right">
								<option value="" selected="selected">Select Country</option>
								<option value="united states">United States</option>
								<option value="United Kingdom">United Kingdom</option>
								<option value="Albania">Albania</option>
								<option value="Argentina">Argentina</option>
								<option value="Belgium">Belgium</option>
								<option value="Brazil">Brazil</option>
								<option value="Canada">Canada</option>
								<option value="China">China</option>
								<option value="Denmark">Denmark</option>
								<option value="France">France</option>
								<option value="Germany">Germany</option>
								<option value="Hong kong">Hong kong</option>
								<option value="India ">India </option>
								<option value="Indonesia">Indonesia</option>
								<option value="Israel">Israel</option>
								<option value="Italy">Italy</option>
								<option value="Japan">Japan</option>
								<option value="Malaysia">Malaysia</option>
								<option value="Mexico">Mexico</option>
								<option value="Netherland">Netherland</option>
								<option value="Nigeria">Nigeria</option>
								<option value="Norway">Norway</option>
								<option value="Portugal">Portugal</option>
								<option value="Russia">Russia</option>
								<option value="Singapore">Singapore</option>
								<option value="South korea">South korea</option>
								<option value="Sweden">Sweden</option>
								<option value="Switzerland">Switzerland</option>
								<option value="Turkey">Turkey</option>
								<option value="United Kingdom">United Kingdom</option>
								<option value="Vietnam">Vietnam</option>
                            </select> 
        </li>
        
        <li class="span2 ">
             <input size="8" id="combo_State"  name="City" value="City" onclick="this.value=''" class="form-control span2 padd li-search"/>
        
        </li>
        <li class="span2 ">
             <input size="8" id="combo_State" name="State" value="Search" onclick="this.value=''"  class="form-control span2 bt1 padd li-search" />
        </li>
        <li class="span1">
        <input type="button"   class="btn btn-danger " value="Search"/>
        </li>
    
    </ul>
    </form>
</div>


<!--end search-->


 <!--begin menu-->
 <div class="col-xs-12" style="margin: 0; padding: 0;">
    <div class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse offset1">
            <?php wp_nav_menu( array( 'menu_class'=>'nav navbar-nav open') ); ?>
            <br />
     </div><!--/.nav-collapse -->
      </div>
      
      
    </div>
 
 </div>
    <?php
			if($_SERVER['REQUEST_URI']=='/bcd/classsified/' || $_SERVER['REQUEST_URI']=='/bcd/bussineses/' || $_SERVER['REQUEST_URI']=='/bcd/market-place/'){
				get_sidebar('top');
			}
		?>
 <!--end menu-->

    
    </div>
<!--end header-->

</div> 