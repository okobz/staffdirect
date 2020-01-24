<?php
	require_once("function.php");
	mustLogin();
	require_once("pagelayout.php");
	
	getPageHeader("Job Applications");
	closePageHeader();
	getMenuLinks(3);
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
				<a href="controller.php?action=download-excel-applicants" title="download excel">
					Excel Download
				</a>
			 </div>
			 
		  <div class="row">
			<div class="col-md-12">
			  <div class="cform" id="contact-form">
				<?	
					callErrorMessage();
				?>
				
				<table class="table table-striped table-hover table-bordered rwd-table" id="dataTableId">
					<thead>
					<tr>
						<th style="width: 10px">#</th>
						<th>Section / Division</th>
						<th>Fullname</th>
						<th>Gender</th>
						<th>Phone</th>
						<th>Location</th>
						<th>Email</th>
						<th>NYSC</th>
						<th>Downloads</th>
						<th>Date</th>
					</tr>
					</thead>
					<tbody>
						
						<?	
							$results = getJobApplications();
							if($results->num_rows > 0){
								$i=0;
								while($row = $results->fetch_assoc()) {
							?>
									<tr>
										<td><?=++$i?></td>
										<td><?=$row['sector']?> / <?=$row['division']?></td>
										<td><?=$row['lastname']?> <?=$row['firstname']?></td>
										<td><?=$row['gender']?></td>
										<td><?=$row['phone']?></td>
										<td><?=$row['location']?></td>
										<td><?=$row['email']?></td>
										<td><?=$row['nysc']?></td>
										<td>
											<a target="_blank" href="<?=$row['picture']?>">Picture</a>
											|
											<a target="_blank" href="<?=$row['cv']?>">CV</a>
											|
											<a target="_blank" href="<?=$row['video']?>">Video</a>
										</td>
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
