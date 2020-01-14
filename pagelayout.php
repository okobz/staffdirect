<?php function getPageHeader($title){ ?>
		<!DOCTYPE html>
		<html>

		<head>
		  <!-- BASICS -->
		  <meta charset="utf-8">
		  <title><?=$title?></title>
		  <meta name="description" content="">
		  <meta name="viewport" content="width=device-width, initial-scale=1.0">
		  <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
		  <link rel="shortcut icon" type="image/png" href="http://staffdirect.ng/favicon.png"/>
		  <link rel="stylesheet" type="text/css" href="js/rs-plugin/css/settings.css" media="screen">
		  <link rel="stylesheet" type="text/css" href="css/isotope.css" media="screen">
		  <link rel="stylesheet" href="css/flexslider.css" type="text/css">
		  <link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen">
		  <link rel="stylesheet" href="css/bootstrap.css">
		  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Serif:400,400italic,700|Open+Sans:300,400,600,700">

		  <link rel="stylesheet" href="css/style.css">
		  <!-- skin -->
		  <link rel="stylesheet" href="skin/default.css">
		  <!-- =======================================================
			Theme Name: Vlava
			Theme URL: https://bootstrapmade.com/vlava-free-bootstrap-one-page-template/
			Author: BootstrapMade.com
			Author URL: https://bootstrapmade.com
		  ======================================================= -->
<? } ?>

<?	function closePageHeader(){ ?>
		</head>
	<body>
<? } ?>

<?	function getMenuLinks(){?>
		<section id="header" class="appear"></section>
		  <div class="navbar navbar-fixed-top" role="navigation" data-0="line-height:100px; height:100px; background-color:rgba(0,0,0,0.3);" data-300="line-height:60px; height:60px; background-color:rgba(5, 42, 62, 1);">
			<div class="container">
			  <div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				  <span class="fa fa-bars color-white"></span>
				</button>
				<div class="navbar-logo">
				  <a href="index.php"><img data-0="width:155px;" data-300=" width:120px;" src="img/logo3.png" alt="Staff Direct Logo"></a>
				</div>
			  </div>
			  <?php
				$curPageName = substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],"/")+1);
			  ?>
			  <div class="navbar-collapse collapse">
				<ul class="nav navbar-nav" data-0="margin-top:20px;" data-300="margin-top:5px;">
				<?	if(isset($_SESSION['sdsession'])){?>
						<li class="active"><a href="logout.php">Logout</a></li>
				<?	}else{?>
						<li class="active"><a href="<?=$curPageName==""?"":"index.php"?>#intro">Home</a></li>
						<li><a href="<?=$curPageName==""?"":"index.php"?>#section-about">About</a></li>
						<li><a href="<?=$curPageName==""?"":"index.php"?>#section-works">Portfolio</a></li>
						<li><a href="<?=$curPageName==""?"":"index.php"?>#section-contact">Contact</a></li>
				<?	}?>
				  
				</ul>
			  </div>
			  <!--/.navbar-collapse -->
			</div>
		  </div>
<?	}?>

<? function callErrorMessage(){?>
	<? if(isset($_SESSION['error']) && !empty($_SESSION['error']) && is_array($_SESSION['error'])){
		//echo "isset";
			if(isset($_SESSION['divborder'])){//on success of query
				$class = "portlet-msg-success";				
			}elseif(isset($_SESSION['alertstyle'])){// warning caution style
				$class = "portlet-msg-alert";				
			}elseif(isset($_SESSION['infostyle'])){// warning caution style
				$class = "portlet-msg-info";				
			}else{// regular error
				$class = "portlet-msg-error";				
			}
		?>
    <br />
	        <div class="<?=$class?>">
				<?php foreach ($_SESSION['error'] as $errors)  { ?>
                        <?php echo ($errors) ?>
                        <?php echo "<br>";?>
                <?php } ?>
            
	            <? 
					unset($_SESSION['error']);
					if(isset($_SESSION['divborder'])){unset($_SESSION['divborder']);}
					if(isset($_SESSION['alertstyle'])){unset($_SESSION['alertstyle']);}
					if(isset($_SESSION['infostyle'])){unset($_SESSION['infostyle']);}
				?>
   		    </div>
    <br />
    <? }?>
<? }?>

<?	function getFooter($loadContactFormJs="true"){?>
	  <section id="footer" class="section footer">
		<div class="container">
		  <div class="row animated opacity mar-bot20" data-andown="fadeIn" data-animation="animation">
			<div class="col-sm-12 align-center">
			  <ul class="social-network social-circle">
				<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>
				<li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
				<li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
				<li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
				<li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
			  </ul>
			</div>
		  </div>
		  <div class="row align-center mar-bot20">
			<ul class="footer-menu">
			  <li><a href="#">Home</a></li>
			  <li><a href="#">About us</a></li>
			  <li><a href="#">Privacy policy</a></li>
			  <li><a href="#">Get in touch</a></li>
			</ul>
		  </div>
		  <div class="row align-center copyright">
			<div class="col-sm-12">
			  <p>Copyright &copy; Staff Direct | All rights reserved | 
				<?	if(isset($_SESSION['sdsession'])){?>
						<a href="logout.php">Logout</a>
				<?	}else{?>
						<a href="login.php">Admin</a>
				<?	}?>
			  </p>
			</div>
			<!--
			<a href="/webmail" target="_blank">Webmail</a>
			-->
		  </div>
		  <div class="credits">
			
		  </div>
		</div>

	  </section>
	  <a href="#header" class="scrollup"><i class="fa fa-chevron-up"></i></a>

	  <!-- Javascript Library Files -->
	  <script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	  <script src="js/jquery.js"></script>
	  <script src="js/jquery.easing.1.3.js"></script>
	  <script src="js/bootstrap.min.js"></script>
	  <script src="js/jquery.isotope.min.js"></script>
	  <script src="js/jquery.nicescroll.min.js"></script>
	  <script src="js/fancybox/jquery.fancybox.pack.js"></script>
	  <script src="js/skrollr.min.js"></script>
	  <script src="js/jquery.scrollTo.min.js"></script>
	  <script src="js/jquery.localScroll.min.js"></script>
	  <script src="js/stellar.js"></script>
	  <script src="js/jquery.appear.js"></script>
	  <script src="js/jquery.flexslider-min.js"></script>

	  <?	if($loadContactFormJs == "true"){?>
			  <!-- Contact Form JavaScript File -->
			  <script src="contactform/contactform.js"></script>
	  <?	}else{?>
				<link href="parsley/parsley.css" rel="stylesheet">
				<script src="parsley/parsley.min.js"></script>
	  <?	}?>
	  
	  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

	  <!-- Template Main Javascript File -->
	  <script src="js/main.js"></script>

	</body>

	</html>
<?	}?>
