<?php
	require_once("function.php");
	require_once("pagelayout.php");
	
	getPageHeader("Job Postings");
	closePageHeader();
	getMenuLinks(2);
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

			 <div style="float:right">
				<a href="controller.php?action=download-excel-posting" title="download excel">
					Excel Download
				</a>
			 </div>

			 
		  <div class="row">
			<div class="col-md-12">
			  <div class="cform" id="contact-form">
				<?	
					callErrorMessage();
					$results = getJobPostings();
				?>
				
				<table class="table table-striped table-hover table-bordered rwd-table" id="dataTableId">
					<thead>
					<tr>
						<th style="width: 10px">#</th>
						<th>Organization</th>
						<th>Position</th>
						<th>Job Type</th>
						<th>Salary Budget (N)</th>
						<th>Contact Person</th>
						<th>Phone Number</th>
						<th>Date</th>
					</tr>
					</thead>
					<tbody>
						
						<?	
							if($results->num_rows > 0){
								$i=0;
								while($row = $results->fetch_assoc()) {
							?>
									<tr>
										<td><?=++$i?></td>
										<td><?=$row['organization']?></td>
										<td><?=$row['position']?></td>
										<td><?=$row['job_type']?></td>
										<td><?=$row['salary_budget']?></td>
										<td><?=$row['contact_person']?></td>
										<td><?=$row['phone_number']?></td>
										<td><?=system_date($row['record_date'])?></td>
									</tr>
							<?
								}	
							}
						?>
						
					</tbody>
				</table>
				
			  </div>
			</div>
			<!-- ./span12 -->
		  </div>

		</div>
	  </section>

	<link href="datatables/dataTables.bootstrap.css" rel="stylesheet">
	<script src="datatables/jquery.dataTables.min.js"></script>
	<script src="datatables/dataTables.bootstrap.min.js"></script>
		
<?	getFooter("false")?>

<?
$options='{"iDisplayLength": 50,"aLengthMenu": [ 25, 50, 75, 100 ],"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": true}';
?>
<script>
  $(function () {
    $("#dataTableId").DataTable(<?=$options?>);
  });
</script>
