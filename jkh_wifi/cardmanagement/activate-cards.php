<?php 
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/packages.php');



$allusers = USER :: getallusers();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>Lanka Communication Services Radius Manager Administration Panel For John Keells Holdings</title>
		
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="../css/reset.css" type="text/css" media="screen" />	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="../css/invalid.css" type="text/css" media="screen" />	
        <link rel="stylesheet" href="../css/jquery.alerts.css" type="text/css" media="screen" />	
        		
		<!-- Internet Explorer Fixes Stylesheet -->		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
		<![endif]-->		
		<!--                       Javascripts                       -->  
		<!-- jQuery -->
		<script type="text/javascript" src="../scripts/jquery-1.3.2.min.js"></script>		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="../scripts/simpla.jquery.configuration.js"></script>		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="../scripts/facebox.js"></script>		
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="../scripts/jquery.wysiwyg.js"></script>
        <script type="text/javascript" src="../scripts/jquery.alerts.js"></script>
        
        
        
        <script type="text/javascript" src="../scripts/js-functions.js"></script>   		
		<!-- jQuery Datepicker Plugin -->
		<!--[if IE]><script type="text/javascript" src="resources/scripts/jquery.bgiframe.js"></script><![endif]-->		
		<!-- Internet Explorer .png-fix -->		
		<!--[if IE 6]>
			<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->         

	</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
	     
			<?php require('../includes/side-top-profile-details.php'); ?>
			<?php require('../includes/side-navigation.php'); ?>
            
             <!-- End #main-nav -->
			
			 <!-- End #messages -->
			
		</div></div> <!-- End #sidebar -->
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			
            <?php require_once('../includes/page-hader.php'); ?>
            <!-- End .shortcut-buttons-set -->
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>Activate Cards</h3>
					
					<ul class="content-box-tabs">
						<!--<li><a href="#tab1" >View</a></li> -->
                        <!-- href must be unique and match the id of target div -->
                        
                  
                        
                        
                        
                        
                        
                        
						<li><a href="#tab2" class="default-tab">Activate Cards</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				 
				<div class="content-box-content">
					
					 <!-- End #tab1 -->
                    
                    
           
					
					<div class="tab-content default-tab" id="tab2">
					
						<form action="#" method="post" name="managecards">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								
								<p>
									<label>Select a Custermer</label>              
									<select name="custermer" id="custermer" class="small-input">
                                    	<option value="">Please select</option>
										<?php 
										$custermers = USER ::getCustermers();
										while($rowcustermers = mysql_fetch_array($custermers)){
										?>                                        
                                        <option value="<?php echo $rowcustermers['groupid']; ?>"><?php echo $rowcustermers['groupname']; ?></option>
                                        <?php } ?>
										
									</select> 
                                    <span id="msg_user_custermer"></span>
								</p>
                                
                                <p>
									<label>Select Card Series</label>              
									<select name="package" id="package" class="small-input">
                                    	<option value="">Please select</option>
										<?php 
										$cardpackages = PACKAGES :: getCardpackages();
										while($rowcardpackages = mysql_fetch_array($cardpackages)){
										?>                                        
                                        <option value="<?php echo $rowcardpackages['series']; ?>"><?php echo $rowcardpackages['series'];  ?></option>
                                        <?php } ?>
										
									</select> 
                                    <span id="msg_user_custermer"></span>
								</p>
                                
                               
                              <p>
									<label>Select a NAS</label>              
									<select name="nas" id="nas" class="small-input" onchange="load_services(this.value)">
                                    	<option value="">Please select</option>
										<?php 
										$nases = PACKAGES :: getnases();
										while($rownasess = mysql_fetch_array($nases)){
										?>                                        
                                        <option value="<?php echo $rownasess['id']; ?>"><?php echo $rownasess['nasname']." - ".$rownasess['shortname'];  ?></option>
                                        <?php } ?>
										
									</select> 
                                    <span id="msg_nas"></span>
								</p> 
                               
                               
                                      <p>
									<label>Select a Service</label>   
                                    
                                    <span  id="service_ld">           
									<select name="service" id="service" class="small-input">
                                    	<option value="" >Please select a NAS</option>
										
										
									</select> 
                                    </span>
                                    <span id="msg_nas"></span>
								</p> 
                                 
                               
                                
                                
                                
                                	<p>	<label>No of Cards</label>
										<input class="text-input small-input" type="text"        id="nofcards" name="nofcards" /> <span id="msg_user_name"></span> <!-- Classes for input-notification: success, error, information, attention -->
										<!--<br /><small>A small description of the field</small>-->
								</p>
								
								
                                <p><span id="msg_manage_cards"></span></p>
                                
								<p>
									<input class="button" type="button" value="Add" onclick="asigncardstocustermers();"/>
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			
			 <!-- End .content-box -->
			
			 <!-- End .content-box -->
			<div class="clear"></div>
			
			
			<!-- Start Notifications -->
			
			
			
			
			
			
			
			
			
			<!-- End Notifications -->
			
			<div id="footer">
				<?php require_once('../includes/footer.php') ?>
			</div><!-- End #footer -->
			
		</div> <!-- End #main-content -->
		
	</div></body>
       <script type="text/javascript">        
        $('#5').addClass('current');        
        </script>


</html>
