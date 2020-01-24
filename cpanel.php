<?php
	require_once("function.php");
	require_once("pagelayout.php");
	
	getPageHeader("Staff Direct");
	closePageHeader();
	getMenuLinks(1);
?>

	<!--
	<section id="intro">
		<div class="intro-content">
		  <h2>Admin Login</h2>
		  <h3>Login With Your Credentials</h3>

		</div>
	</section>
	 -->

	 <br /><br /><br /><br />
	 
	<section id="section-contact_dj" class="section appear clearfix">
		<div class="container">

		  <div class="row">
			<div class="col-md-8 col-md-offset-2">
			  <div class="cform" id="contact-form">
				<?	callErrorMessage()	?>
				
				<h2><a href="job-posting-list.php">List All Job Postings</a></h2>
				<h2><a href="job-applicants-list.php">List All Job Applicants</a></h2>
				<h2><a href="sectors.php">Manage Sectors</a></h2>
				<h2><a href="divisions.php">Manage Divisions</a></h2>
				<h2><a href="logout.php">Logout</a></h2>
				
			  </div>
			</div>
			<!-- ./span12 -->
		  </div>

		</div>
	  </section>

<?	getFooter("false")?>
