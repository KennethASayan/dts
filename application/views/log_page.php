					
				<center>
				<table id="log_tbl" class="cell-border display" cellspacing="0" style="font-size:14px">
					<thead style="text-align:left">
						<tr>
								<th>id</th>
								<th>Off/Div</th>
								<th>Action</th>
								<th>Date/Time</th>
								<th>Action Person(s)</th>
								<th>Remarks</th>
						</tr>
					</thead>
					<?php foreach ($log_rec as $row):?>
					<tr>
						<td><?php echo $row['dl_id'];?></td>
						<td><?php echo $row['div_alias'];?></td>
						<td><?php echo $row['event'];?></td>
						<td><?php echo $row['e_dt'];?></td>
						<td><?php if($row['e_act_pers']=='' OR $row['e_act_pers']=='0'){echo 'None';}else{echo $row['e_act_pers'];}?></td>
						<td><?php if($row['e_remarks']=='' OR $row['e_remarks']=='0'){echo 'None';}else{echo $row['e_remarks'];}?></td>
					</tr>	
					<?php endforeach;?>
				</table>
				</center>
				
					
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('#log_tbl').DataTable({
					"bLengthChange": false,
					"bFilter": false,
					"paging": false,
					//"ordering": false,
					"info": false,
					"language": {
						"decimal": ".",
						"thousands": ",",
						//"lengthMenu": "Display _MENU_ Records",
						"zeroRecords": "No records found",
						//"info": "Page _PAGE_ of _PAGES_",
						"infoEmpty": "No records available",
						"infoFiltered": "(filtered from _MAX_ total records)"
					},
					"columnDefs": [
						{
						  "targets": "_all",
						  "orderable": false
					    },
						{
							"targets": [0],
							"visible": false,
							"searchable": false
						},
					],
					
				}).order( [ 0, 'desc' ] ).draw();
				
				
				
			});
		</script>		