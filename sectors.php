<?php
	require_once("function.php");
	mustLogin();
	require_once("pagelayout.php");
	
	getPageHeader("Manage Sectors");
	closePageHeader();
	getMenuLinks(4);
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

			<!--
			<div style="float:right">
				<a href="controller.php?action=download-excel-applicants" title="download excel">
					Excel Download
				</a>
			 </div>
			 -->
			 
		  <div class="row">
		  
			<div class="col-md-12">
				
				
				<div>
					<button type="button" class="btn btn-sm btn-primary btn-add-new" data-toggle="tooltip" data-placement="top" data-title="register new record"><i class="fa fa-plus"></i> Register New Record</button>
					
					<button type="button" id="savebutton" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" data-title="save new records" style="display:none"><i class="fa fa-save"></i> Save Records</button>
					
				</div>
				<br>
				<form id="new-record" data-parsley-validate="true" action="controller.php" method="post">
					<table id="table_item" class="table table-default table-middle table-striped table-bordered table-condensed rwd-table">
					  <thead>
						  <tr id="noclick">
							  <th>Caption</th>
							  <th>Description</th>
							  <th>&nbsp;</th>
						  </tr>
					  </thead>   

					  <tbody>

					  </tbody>
					  
					</table>
					<input type="hidden" name="action" value="new-sector" />
				</form>
				
				<br><br><br><br>
				
				
			</div>
			
			<div class="col-md-12">
			  <div class="cform" id="contact-form">
				<?	
					callErrorMessage();
				?>
				
				<table class="table table-striped table-hover table-bordered rwd-table" id="dataTableId">
					<thead>
					<tr>
						<th style="width: 10px">#</th>
						<th>Caption</th>
						<th>Description</th>
					</tr>
					</thead>
					<tbody>
						
						<?	
							$results = getSectors();
							if($results->num_rows > 0){
								$i=0;
								while($row = $results->fetch_assoc()) {
							?>
									<tr>
										<td><?=++$i?></td>
										<td><?=$row['caption']?></td>
										<td><?=$row['description']?></td>
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
  
  
  $(document).ready(function() {
	$(".btn-add-new").click(function(){			
		$("#savebutton").show();
		
		var exp = new Date();
		var unique = exp.getTime() ;
		
		html = "<tr id='trrow"+unique+"' class='light'><td align='left'><input name='caption[]' type='text' data-parsley-required='true' title='enter caption' placeholder='Caption' class='form-control col-md-7 col-xs-12'></td><td align='left'><input name='description[]' type='text' title='enter description' placeholder='Description' class='form-control col-md-7 col-xs-12'></td><td align='center'><a style='float:right;cursor:pointer' id='delete"+unique+"' title='delete this record' class='noprint'><i style='color:#a00'>Delete</i></a></td></tr>";
				
		$("#table_item").append(html);
		
		//on delete of fee items
		$("#delete"+unique).click(function(){
			if(confirm("Delete this record?")){
				$('#trrow'+unique).remove();
			}
		});//end of onclick function

	});//end of onclick function
	
	$("#savebutton").click(function(){
		$("#new-record").submit();
	});//end of onclick function
	
	$("#deleteBtnID").click(function(){
		$("#form-records").submit();
	});//end of onclick function

});	//end of document ready function

</script>
