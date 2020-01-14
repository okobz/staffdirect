<?php
	require_once("function.php");
	require_once("pagelayout.php");
	
	getPageHeader("Staff Direct");
	closePageHeader();
	getMenuLinks();
?>

	<section id="intro">
		<div class="intro-content">
		  <h2>Admin Login</h2>
		  <h3>Login With Your Credentials</h3>

		</div>
	  </section>

	<section id="section-contact_dj" class="section appear clearfix">
		<div class="container">

		  <div class="row">
			<div class="col-md-8 col-md-offset-2">
			  <div class="cform" id="contact-form">
				<?	callErrorMessage()	?>
				
				<div id="errormessage"></div>
				<form action="controller.php" enctype="multipart/form-data" method="post" class="contactForm" data-parsley-validate="true" >

					
				  <div class="field subject form-group">
					<input type="text" name="userid" required placeholder="User ID" class="cform-text" size="40">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<input type="password" name="password" required placeholder="Password" class="cform-text" size="40">
					<div class="validation"></div>
				  </div>
				  
				  <input type="hidden" name="action" value="login" />
						
					<div>
						<div class="send-btn">
							<input type="submit" id="formSubmit" value="SUBMIT" class="btn btn-theme">
						</div>
					</div>
				  
				  

				</form>
			  </div>
			</div>
			<!-- ./span12 -->
		  </div>

		</div>
	  </section>

<?	getFooter("false")?>
