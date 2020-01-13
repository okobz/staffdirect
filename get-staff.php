<?php
	require_once("function.php");
	require_once("pagelayout.php");
	
	getPageHeader("Staff Direct");
	closePageHeader();
	getMenuLinks();
?>

	<section id="intro">
		<div class="intro-content">
		  <h2>Get Staff</h2>
		  <h3>Post A Vacancy</h3>

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

					
				  <div class="field subject form-group">
					<input type="text" name="organization" required placeholder="Organization" class="cform-text" size="40" data-rule="text" data-msg="Please enter your organization">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<input type="text" name="position" required placeholder="Position" class="cform-text" size="40" data-rule="minlen:4" data-msg="Please enter job position">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field your-name form-group">
					<select name="job_type" id="jobtype" class="cform-select" required>
						<option value="">Select Job Type</option>
						<option value="fulltime">Full Time</option>
						<option value="contract">Contract</option>
					</select>
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<input type="text" name="salary_budget" required placeholder="Salary Budget e.g. 100000 - 150000" class="cform-text" size="40">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field subject form-group">
					<input type="text" name="contact_person" required placeholder="Contact Person" class="cform-text" size="40">
					<div class="validation"></div>
				  </div>
				  
				  <div class="field your-email form-group">
					<input type="text" name="phone_number" required placeholder="Phone Number" class="cform-text" size="40">
					<div class="validation"></div>
				  </div>
				  
				  
				  
				  <input type="hidden" name="action" value="get-staff" />
						
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