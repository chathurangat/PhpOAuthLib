<?php
require_once('../config/config.php');

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
		
		<!-- Colour Schemes
	  
		Default colour scheme is green. Uncomment prefered stylesheet to use it.
		
		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />
		
		<link rel="stylesheet" href="resources/css/red.css" type="text/css" media="screen" />  
	 
		-->
		
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
		
		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
		<script type="text/javascript" src="../scripts/admin-loginjs-functions.js"></script>
	</head>
  
	<body id="login">
		
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
			
					<title>Lanka Communication Services Radius Manager Administration Panel</title>
				
				<img id="logo" src="<?php echo HTTP_PATH;?>images/lankacom_logo.png" alt="JKH" />
			</div>
			
			<div id="login-content">
				
				<form >
				
					<!--<div class="notification information png_bg">
						<div>
							Just click "Sign In". No password needed.
						</div>
					</div>-->
					
					<p>
						<label>Username</label>
						<input class="text-input" type="text" id="username" onFocus="validkey(event)" onClick="validkey(event)" onKeyPress="validkey(event)"/>
					</p>
					<div class="clear"></div>
					<p>
						<label>Password</label>
						<input class="text-input" type="password"  id="password" onFocus="validkey(event)" onClick="validkey(event)" onKeyPress="validkey(event)" />
					</p>
					<div class="clear"></div>
					<p>
                    	<label>&nbsp;</label>
              <div id="login_msg"></div></p>
					<div class="clear"></div>
					<p>
						<input class="button" type="button" value="Sign In" onclick="adminlogin()"/>
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
  </body>
  

</html>
