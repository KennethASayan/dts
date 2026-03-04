					
					<thead style="text-align:center">
						<tr>
								<th>Rec_ID</th>
								<th>Document No.</th>
								<th>Document Type</th>
								<th>Subject</th>
								<th>Sender</th>
								<th>Document Date</th>
								<th>Date Uploaded</th>
						</tr>
					</thead>
					<tfoot id="t_foot" style="text-align:left">
						<tr>
								<th>Rec_ID</th>
								<th>Document No.</th>
								<th>Document Type</th>
								<th>Subject</th>
								<th>Sender</th>
								<th>Document Date</th>
								<th>Date Uploaded</th>
						</tr>
					</tfoot>
						
						<?php foreach ($records as $rec):?>
						<tr>
								<td><?php echo $rec['rec_id'];?></td>
								<td><?php echo $rec['doc_no'];?></td>
								<td><?php echo $rec['doc_type'];?></td>
								<td><?php echo $rec['doc_subject'];?></td>
								<td><?php echo $rec['sender'];?></td>
								<td><?php echo $rec['doc_date'];?></td>
								<td><?php echo $rec['rec_date'];?></td>
						</tr>
						<?php endforeach;?>
				
				
	<script type="text/javascript">
		$(document).ready(function(){
			
			
			
			
		});
	</script>