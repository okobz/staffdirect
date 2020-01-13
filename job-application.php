<?php
	require_once("function.php");
	require_once("pagelayout.php");
	
	getPageHeader("Staff Direct");
	closePageHeader();
	getMenuLinks();
?>

	<section id="intro">
		<div class="intro-content">
		  <h2>Job Applications</h2>
		  <h3>Complete Application Form Below</h3>

		</div>
	  </section>

	<section id="section-contact_dj" class="section appear clearfix">
		<div class="container">

		  <div class="row">
			<div class="col-md-8 col-md-offset-2">
			  <div class="cform" id="contact-form">
				<?	if(@$_GET['success'] && @$_GET['success'] == "true"){?>
					<div class="show" id="sendmessage">Your Application Submitted successfully. Thank you!</div>
				<? }?>
				
				<div id="errormessage"></div>
				<form action="controller.php" enctype="multipart/form-data" method="post" class="contactForm" data-parsley-validate="true" >

					<? $results = getSectors()?>
					
				  <div class="field your-name form-group">
					<select name="sectors" id="sectors" class="cform-select" required data-msg="Please select a Sector">
						<option value="">Select A Sector</option>
						<?	
							if($results->num_rows > 0){
								while($row = $results->fetch_assoc()) {
							?>
									<option value="<?=$row['id']?>"><?=$row['caption']?></option>
							<?
								}	
							}
						?>
					</select>
					<div class="validation"></div>
				  </div>
				  
				<div id="formLoader" style="text-align:center; display:none">
					<img src="img/spinner.gif" alt="loading"/>
				</div>
				  
				  
				  <div class="field your-name form-group">
					<select name="divisions" id="divisions" class="cform-select" required data-msg="Please select a Division">
						<option value="">Select A Division</option>
					</select>
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<input type="text" name="firstname" required placeholder="First Name" class="cform-text" size="40" data-rule="text" data-msg="Please enter your firstname">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<input type="text" name="lastname" required placeholder="Last Name" class="cform-text" size="40" data-rule="minlen:4" data-msg="Please enter your lastname">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field your-name form-group">
					<select name="gender" id="divisions" class="cform-select" required data-msg="Please select your gender">
						<option value="">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="Others">Others</option>
					</select>
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<input type="text" name="phone" required placeholder="Phone Number" class="cform-text" size="40" data-rule="minlen:4" data-msg="Please enter your phone number">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<input type="text" name="location" required placeholder="Location" class="cform-text" size="40" data-rule="minlen:4" data-msg="Please enter your location">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field your-email form-group">
					<input type="text" name="email" required placeholder="Your Email" class="cform-text" size="40" data-rule="email" data-msg="Please enter a valid email">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field your-name form-group">
					<select name="nysc" id="divisions" class="cform-select" required data-msg="">
						<option value="">Have You Completed NYSC?</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
					<div class="validation"></div>
				  </div>
				  
				  
				  <div class="field subject form-group">
					<b>Upload CV (.pdf or .doc 5MB Max)</b>&nbsp;&nbsp;
					<input type="file" name="cv" required placeholder="Upload Your CV" class="cform-text" size="40" data-msg="Please enter your CV">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<b>Upload Profile Picture (.jpg or .png 3MB Max)</b>&nbsp;&nbsp;
					<input type="file" name="picture" required placeholder="Upload Your Profile Picture" class="cform-text" size="40">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<b>Submit Video Profile (optional, .mp4 10MB)</b>&nbsp;&nbsp;
					<input type="file" name="video" placeholder="Upload Your Video Profile" class="cform-text" size="40">
					<div class="validation"></div>
				  </div>
				  

				  
				  <input type="hidden" name="action" value="job-application" />
						
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


<script>
	
	$( "#sectors" ).change(function() {
	  
		//load spinner
		$("#formLoader").show();
		
		var selectedValue = $(this).children("option:selected"). val();
	  
		page = 'ajax.php?action=load_divisions&sectorid='+selectedValue;
	  
		$.ajax({
			type: "POST",
			url: page,
			data: "",
			success: function(msg) {
				$("#divisions").html(msg);
				//stop spinner
				$("#formLoader").hide();
			}, error: function(err){
				alert(err);
			}

		});
	  
	});

</script>