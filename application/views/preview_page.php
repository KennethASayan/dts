	
	
	<div style="width:20%;float:right;margin:5px 0px;font-size:15px">
		<?php foreach ($records as $rec):?>
				<span><b>Document No.: </b><i><?php echo $rec['doc_no'];?></i></span>
				<br>
				<span><b>Date Uploaded: </b><i><?php echo $rec['rec_date'];?></i></span>
		<?php endforeach;?>	
	</div>	
	<div style="width:80%;float:left;margin:10px 0px 20px 0px;">
				
				<?php if($this->session->userdata('div_log_id')==1):?>
					<a href="<?php echo base_url();?>c_dts/route_slip?doc_no=<?php echo $doc_no;?>" target="_blank" id="rsb">Routing Slip</a>
				<?php endif;?>
				<?php if($this->session->userdata('role_log_id')!=6):?>
					<a href="#" id="routb">Route Document</a>
				<?php if($this->session->userdata('div_log_id')!=1):?>
					<a href="#" id="ackb">Acknowledge Receipt</a>
					<a href="#" id="recvb">Receive Document</a>
					<a href="#" id="for_dc">For Chief <?php echo $this->session->userdata('div_log_alias');?></a>
					<a href="#" id="retrnb">Return</a>
				<?php endif;?>
				
				<!--<a href="#" id="logb">Show Tracks</a>-->
				<a href="#" id="actb">Action Taken</a>
				<?php if($this->session->userdata('div_log_id')==1):?>
					<a href="#" id="editb">Edit Record</a>
				<?php endif;?>
				<?php if($this->session->userdata('role_log_id')==1):?>
					<a href="#" id="delb">Delete Record</a>
				<?php endif;?>
				<a href="#" id="saveb">Save</a>
				<a href="#" id="cnclb">Cancel</a>
				<?php endif;?>
	</div>	
		

		<div id="l_pane">


				<div id="notify"></div>
				<div id="up_msg"></div>
				<div id="act_up_modal"></div>


				<form id="doc_frm" name="doc_frm" action="" method="POST">
									<div id="modal_route">
									<center>
									<!--<h4 style="margin:0px 0px 20px 0px">ROUTE TO:</h4>-->
									<table id="rec_tbl" style="width:100%;background-color:#f4f4f4;padding:10px;border:1px solid gray">
									<tr id="act_flag_sec"><td><b>Required Action?</b></td><td><i>
									
										<input style="height:15px;width:15px;" type="checkbox" name="act_flag" id="act_flag" value="1" <?php if($rec['act_flag']=="1"){echo "checked";}?> />Yes
										
									</i></td></tr>
									<tr id="act_class_sec" style="height:70px;">
										<td style="vertical-align:top;"><b>Classification</b></td>
										<td style="text-align:left;vertical-align:top;">
											<input style="height:15px;width:15px;" type="radio" name="doc_clsf" value="Simple" <?php if($rec['act_class']=="Simple"){echo "checked";}?> />Simple
											<input style="height:15px;width:15px;margin-left:30px" type="radio" name="doc_clsf" value="Complex" <?php if($rec['act_class']=="Complex"){echo "checked";}?> />Complex
											<input style="height:15px;width:15px;margin-left:30px" type="radio" name="doc_clsf" value="Highly Technical" <?php if($rec['act_class']=="Highly Technical"){echo "checked";}?> />Highly Technical
											<input style="height:15px;width:15px;margin-left:30px" type="radio" name="doc_clsf" value="Legal Concern" <?php if($rec['act_class']=="Legal Concern"){echo "checked";}?> />Legal Concern
										</td>
									</tr>
												
									<tr id="div_sec">
										<td style="vertical-align:top;"><b>Division/Bureau</b></td>
										<td>
										<div>						
										<?php foreach ($div_list as $list):?>
										<?php if(strpos($list['div_alias'],'C-')===false AND strpos($list['div_alias'],'PA-')===false AND $list['div_id']!=1):?>
											
											<input style="height:15px;width:15px" type="checkbox" name="div_id[]" id="div_type<?php echo $list['div_id'];?>" value="<?php echo $list['div_id'];?>" <?php  $div_ids = explode(",", $rec['div_id']); foreach ($div_ids as $div){ if($list['div_id']==$div) {echo "checked";} }?> /><?php echo $list['div_name']." (".$list['div_alias'].")";?>
											<br>
											
										<?php endif;?>
										<?php endforeach;?>
										</div>
										</td>
									</tr>
									
									<tr id="sec_sec">
										<td style="vertical-align:top;width:50px"><b>Section</b></td>
										<td>
										<div style="column-count:2">						
										<?php foreach ($sec_list as $list):?>
											
											<input style="height:15px;width:15px" type="checkbox" name="sec_id[]" value="<?php echo $list['sec_id'];?>" <?php  $sec_ids = explode(",", $rec['sec_id']); foreach ($sec_ids as $sec){ if($list['sec_id']==$sec) {echo "checked";} }?> /><?php echo $list['sec_alias'];?>
											<br>
											
										<?php endforeach;?>
										</div>
										</td>
									</tr>
									
									<tr id="unit_sec">
										<td style="vertical-align:top;width:50px"><b>Unit</b></td>
										<td>	
										<div style="column-count:2">						
										<?php foreach ($unit_list as $list):?>
											
											<input style="height:15px;width:15px" type="checkbox" name="unit_id[]" value="<?php echo $list['unit_id'];?>" <?php  $unit_ids = explode(",", $rec['unit_id']); foreach ($unit_ids as $unit){ if($list['unit_id']==$unit) {echo "checked";} }?> /><?php echo $list['unit_alias'];?>
											<br>
											
										<?php endforeach;?>
										</div>
										</td>
									</tr>
									
									<tr id="actdesc_sec">
										<td style="vertical-align:top;width:50px"><b>Action</b></td>
										<td>	
										<div>						
										<?php foreach ($act_desc as $list):?>
											<?php if($this->session->userdata('div_log_id')==1 OR $list['act_id']!=6):?>
												<input style="height:15px;width:15px" type="checkbox" name="act_id[]" id="act_id<?php echo $list['act_id'];?>" value="<?php echo $list['act_id'];?>" <?php  $act_ids = explode(",", $rec['act_id']); foreach ($act_ids as $act){ if($list['act_id']==$act) {echo "checked";} }?> /><?php echo $list['act_description'];?>
											<?php endif;?>
											<br>
										<?php endforeach;?>
										</div>
										</td>
									</tr>
									
									<tr id="resp_sec">
										<td style="vertical-align:top;width:50px"><b>Action Person</b></td>
										<td>
											<input type="input" name="act_pers" id="act_pers" value="None" style="width:90%" />
										</td>
									</tr>
									
									<tr id="remarks_sec">
										<td style="vertical-align:top;width:50px"><b>Remarks</b></td>
										<td style="text-align:justify;padding-top:10px;font-size:13px;">
											<textarea rows="3" cols="34" type="input" name="doc_remarks" id="doc_remarks" >None</textarea>
										</td>
									</tr>
									<tr><td></td><td><a href="#" id="up_routb" style="float:right;margin:20px 25px 0px 0px;">ROUTE</a></td></tr>
									</table>
									
									</center>
									</div>
									

					<table id="rec_tbl">
								<?php foreach ($records as $rec):?>
								<?php $u_id = $rec['u_id'];$doc_no = $rec['doc_no'];?>

									<input type="hidden" name="doc_no" id="doc_no" value="<?php echo $rec['doc_no'];?>"/>
									<input type="hidden" name="ef_id" id="ef_id" value="<?php echo $rec['ef_id'];?>"/>
									
									<?php if($rec['ef_id']==3):?><center><h2 style="color:#ffffff;background-color: #009999;margin:0px 0px 10px 0px;padding:10px">Waiting for Acknowledgement</h2></center>	<?php endif;?>	
									
									<?php if($rec['act_flag']==1):?><center><h2 style="color:#ffffff;background-color: #CA5F5F;margin:0px 0px 10px 0px;padding:10px">Waiting for Action</h2></center>		
									<?php elseif($rec['act_flag']==2):?><center><h2 style="color:#ffffff;background-color: #37cc5e;margin:0px 0px 10px 0px;padding:10px"><?php echo $rec['act_class'];?> Document Acted</h2></center>
									<?php endif;?>		
									
									<tr><td><b>Classification</b></td><td><i>
									
										<input style="height:15px;width:15px;" type="radio" name="doc_class" value="1" <?php if($rec['doc_class']=="1"){echo "checked";}?> />For Routing
										<input style="height:15px;width:15px;margin-left:50px" type="radio" name="doc_class" value="2" <?php if($rec['doc_class']=="2"){echo "checked";}?> />For Release
										
									</i></td></tr>
									<tr>
									<td><b>Level of Priority</b></td>
									<td style="text-align:left;">
										<select name="prior_t" id="prior_t">
											<option value="">--Select Level--</option>
											<option value="Low" <?php if($rec['prior_t']=="Low"){echo "selected";}?>>Low</option>
											<option value="Normal" <?php if($rec['prior_t']=="Normal"){echo "selected";}?>>Normal</option>
											<option value="High" <?php if($rec['prior_t']=="High"){echo "selected";}?>>High</option>
										</select>
									</td>
								</tr>
									<tr>
									<td><b>Document type</b></td>
									<td style="text-align:left;">
										<select name="dt_id" id="dt_id">
											<option value="">--Select Type--</option>
											<?php foreach($doc_type as $row):?>
												<option value="<?php echo $row['dt_id'];?>" <?php if($rec['dt_id']==$row['dt_id']){echo "selected";}?>><?php echo $row['doc_description'];?></option>
											<?php endforeach; ?>
										</select>
									</td>
									</tr>
									<tr><td><b id="from_to">Sender</b></td><td><i><input type="input" name="sender_f" id="sender_f" value="<?php echo $rec['sender'];?>"/></i></td></tr>
									<tr><td><b id="dt_rr">Date/Time Received</b></td><td><i><input type="date" name="doc_date_rr" id="doc_date_rr" value="<?php echo date_format(date_create($rec['doc_date_rr']), 'Y-m-d');?>" style="width:110px" /> <input type="time" name="doc_time_rr" id="doc_time_rr" value="<?php echo date_format(date_create($rec['doc_time_rr']), 'H:i');?>" style="width:120px" /></i></td></tr>
									<tr><td><b>Document Date</b></td><td><i><input style="font-size:14px;" type="input" name="doc_date" id="doc_date" value="<?php echo $rec['doc_date'];?>" readonly="readonly"/></i></td></tr>
									<tr><td style="vertical-align:top;padding-top:10px"><b>Subject</b></td><td style="text-align:justify;padding-top:10px"><i><textarea style="font-size:14px;" rows="5" cols="36" type="input" name="doc_subject" ><?php echo $rec['doc_subject'];?></textarea></i></td></tr>
									
									
								<?php endforeach;?>
								
								
									<tr>
										<td valign="top" style="padding-top:40px">
											<b>Attachment(s)</b>
										</td>
											
										<td style="vertical-align: text-top;">
										
										<div id="f_ret">
										<table id="attach_t" class="" cellspacing="0">
										<thead style="text-align:left;"><tr><th></th><th></th><th></th><th></th></tr></thead>
											<?php foreach($files as $row):?>
												<tr><td><?php echo $row['file_id'];?></td><td><?php echo $row['file_name'];?></td><td><a href="<?php echo base_url()."uploads/".$row['file_name'];?>" target="_blank" style="text-decoration:none;"><img style="margin-right:5px;height:15px;" src="<?php echo base_url();?>ext_lib/images/icon/pdf.png" alt='' /><?php echo $row['file_name'];?></a></td><td style="width:10px"></td></tr>
											<?php endforeach; ?>
										</table>
										</div>
										
										<div id="f_up"><div style="float:left; font-size:14px; margin-top:10px"><input class="custom-file-input" type="file" name="files" id="files" style="width:220px" accept="application/pdf" multiple /></div></div>
										</td>
									</tr>
									
					</table>
									
				</form>
					
		</div>

		<div id="r_pane">
			<?php $check = count($files); foreach($files as $row):?>
				<embed src="<?php echo base_url()."uploads/".$row['file_name'];?>" width="100%" height="100%" /><?php if($check>1){echo '<br><br>';}?>
			<?php endforeach; ?>
		</div>

		<div id="logs_cont" style="clear:both;padding-top:20px;">
				<center>
				<hr style="border: 1px dashed">
				<h4 style="margin:0px;background-color:#009999;color:#ffffff;padding:5px;font-size:18px;letter-spacing:5px">DOCUMENT TRACKS</h4>
				<table id="log_tbl" class="cell-border display" cellspacing="0" style="font-size:13px">
					<thead style="text-align:left;font-size:15px">
						<tr>
								<th>id</th>
								<th>Office</th>
								<th>Status</th>
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
		</div>
<script type="text/javascript">

	function get_count_rec(doc_cat){
		
			return	$.ajax({
					url:"<?php echo base_url(); ?>c_dts/get_count_rec",
					method:"POST",
					dataType: 'json',
					data:{'doc_cat': doc_cat},
					success: function(data) {
						
						//return data[0]['cnt'];
						
					}
				});
		
	}
	
	$(document).ready(function(){
		
			var rp_height= $('#r_pane').height();
			$('#l_pane').css({'height':rp_height});
			
			var record_tbl = $('#record_tbl').DataTable();
			
		var ef_id = $('#ef_id').val();
	
		var radioValue = $("input[name='doc_class']:checked").val();
		if(radioValue==1){ $('#from_to').text('Sender');$('#dt_rr').text('Date/Time Received');}
		else if(radioValue==2){$('#from_to').text('Recipient');$('#dt_rr').text('Date/Time Released');}
		
		if(<?php echo $this->session->userdata('div_log_id');?>==1){
			if(ef_id==2 || ef_id==3 || ef_id==4){$('#routb').hide();}
			$('#act_flag_sec').hide();
			$('#act_class_sec').hide();
		}
		if(ef_id==2 || ef_id==5 || ef_id==7 || ef_id==8 || ef_id==10){$('#routb, #for_dc').hide();}
		if(ef_id!=3){$('#ackb').hide();}
		if(ef_id==3 || ef_id==4 || ef_id==6){$('#recvb').hide();}
		if(ef_id==5 || ef_id==7 || ef_id==8 || ef_id==9 || ef_id==10){$('#recvb, #retrnb, #for_dc').hide();}
		if(ef_id!=9){$('#actb').hide();}
		
		
		$('#modal_route').hide();
		//$('#div_type1').on('click', false);
		<?php if($this->session->userdata('div_log_id')!=1):?>$('#div_sec').hide();<?php endif;?>
		<?php if($this->session->userdata('div_log_id')==1):?>$('#sec_sec, #unit_sec').hide();<?php endif;?>
		//$('#sec_sec, #unit_sec, #resp_sec ').hide();
		
		var f_count = 0;
		var x = 0;
		var fdel = [];
		
		$('#log_tbl').DataTable({
					"bDestroy": true,
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
						{ "width": "30%", "targets": 5 },
					],
					
				}).order( [ 0, 'desc' ] ).draw();
		
		$('#attach_t').DataTable({
						"bDestroy": true,
						"bLengthChange": false,
						"searching": false,
						"paging": false,
						"info": false,
						"ordering": false,
						"language": {
						"zeroRecords": "-- No Attachment(s) --",
						"infoEmpty": "No file(s) available",
					},
					
					"columnDefs": [
						{
							"targets": [0],
							"visible": false,
							"searchable": false
						},
						{
							"targets": [1],
							"visible": false,
							"searchable": false
						},
						{
							"targets": [3],
							"data": null,
							"visible": false,
							"searchable": false,
							"defaultContent": "<input type='button' class='d_btn' value='remove' style='height:20px;width:50px;font-size:12px;' />"
						}
					]
					
				});
				
		$('input[name="doc_class"]').on('change',function(){	
			   if($(this).val()==1){
				   $('#from_to').text('Sender');
				   $('#dt_rr').text('Date/Time Received');
			   }else if($(this).val()==2){
				   $('#from_to').text('Recipient');
				   $('#dt_rr').text('Date/Time Released');
			   }
		});
		
		$('#f_up').hide();
		$('#doc_date').datepicker({dateFormat: "M-dd-yy"});
		
		if($('#act_flag').is(':checked')){$('input[name="doc_clsf"]').prop( "disabled", false );}
		else{$('input[name="doc_clsf"]').prop( "disabled", true );}
		
		$('#act_flag').on('change',function(){
		if($('#act_flag').is(':checked')){$('input[name="doc_clsf"]').prop( "disabled", false );}
		else{$('input[name="doc_clsf"]').prop( "disabled", true );$('input[name="doc_clsf"]').prop( "checked", false );}
		});
		
		$('#l_pane input[type="date"], input[type="time"], input[type="input"], input[name="doc_class"], textarea, select[name!="sec_filter"]').prop( "disabled", true );
		$('#l_pane input[type="date"], input[type="time"], input[type="input"], textarea, select[name!="sec_filter"]').css({'color':'black','background-color':'#ffffff', 'border':'0px'});
		$('#act_flag').prop( "disabled", false );
		$('#act_pers').prop( "disabled", false ).css({'color':'black','background-color':'#ffffff', 'border':'1px solid gray'});
		$('#doc_remarks').prop( "disabled", false ).css({'color':'black','background-color':'#ffffff', 'border':'1px solid gray'});
		
		$('input, select[name!="sec_filter"], textarea').on('input change',function(){
					$(this).css({
								"border": "",
								"background": ""
					});
		});
				
		$('#saveb').button().hide().on('click', function(){
			
								var doc_no = $('#doc_no').val();
								var files = $('#files')[0].files;
								var error = '';
								var form_data = new FormData();
								var isValid = true;

										$('#doc_frm input[type="input"], input[name="doc_class"], select[name="prior_t"], select[name="dt_id"], textarea[name="doc_subject"]').each(function() {
											if ($.trim($(this).val()) == '') {
												isValid = false;
												$(this).css({
													"border": "1px solid red",
													"background": "#feebeb"
												});
											}
											else {
												$(this).css({
													"border": "",
													"background": ""
												});
											}
										});
										
										if (isValid == false){
											error = "Please fill out all fields.";
										}
										else
										{
										  if(files.length!=''){
											  for(var count = 0; count<files.length; count++)
													  {
														   var name = files[count].name;
														   var extension = name.split('.').pop().toLowerCase();
														   if(jQuery.inArray(extension, ['pdf']) == -1)
															   {
																if(count!=0){error = count+" invalid file attached. Please attach PDF file(s) only."}
																else{error = "Invalid file attached. Please attach PDF file(s) only."}
															   }
															else
																{
																form_data.append("files[]", files[count]);
																}
													  }
										  }
										}	
										
								  if(error == '')
										  {
												$.ajax({ 
														type: "POST", 
														url: "<?php echo base_url();?>c_dts/update_record?doc_no="+doc_no+"&ef_id="+ef_id+"",
														data: $("#doc_frm").serialize(),
														success: function(){
														
														}
												});
												
											if(f_count!=0){	
												for(var fcount = 0; fcount<f_count; fcount++){
													$.ajax({ 
															type: "POST", 
															url: "<?php echo base_url();?>c_dts/delete_file_sel?f_id="+fdel[fcount].f_id+"&f_name="+fdel[fcount].f_name+"",
													});
												}
											}	
											
											if(files.length!=''){
												$.ajax({
													url:"<?php echo base_url(); ?>c_dts/upload?doc_no="+doc_no+"",
													method:"POST",
													data:form_data,
													contentType:false,
													cache:false,
													processData:false,
													beforeSend:function(){
														
														$('#saveb').text('Saving ').append('<img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" class="uploading_img" style="float:right;height:30px;margin:-5px 0px -10px 0px;mix-blend-mode:multiply" />');
								
													},
													success:function(data)
													{
														
														setTimeout(function() {
															
															$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
																title: 'Record Preview',
																resizable: false,
																width: '90%',
																show: 'fade',
																hide: 'fade',
																modal: true,
																closeOnEscape: false,
																close: function() {
																	
																	$('.doc_count').each(function(){
																		var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
																		get_count_rec(ids).done(function(response){
																			$('#'+ids).text(response[0]['cnt']);
																		});
																	});
																	record_tbl.draw();
																	// window.location.reload();
																},
																position: {
																	my: 'center',
																	at: 'top',
																},
																
																
															});
															
														}, 2000);
														//window.location.reload();
														//$('#f_ret').html(data);
														//$('#r_pane').html('<embed src="<?php echo base_url()."uploads/";?>'+name.replace(" ","_")+'" width="100%" height="100%" />');
														
													}
												});
											}else{
												
												$('#saveb').text('Saving ').append('<img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" class="uploading_img" style="float:right;height:30px;margin:-5px 0px -10px 0px;mix-blend-mode:multiply" />');
								
												setTimeout(function() {$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
																title: 'Record Preview',
																resizable: false,
																width: '90%',
																show: 'fade',
																hide: 'fade',
																modal: true,
																closeOnEscape: false,
																close: function() {
																	$('.doc_count').each(function(){
																		var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
																		get_count_rec(ids).done(function(response){
																			$('#'+ids).text(response[0]['cnt']);
																		});
																	});
																	record_tbl.draw();
																	// window.location.reload();
																},
																position: {
																	my: 'center',
																	at: 'top',
																},
																
																
												});}, 2000);
												
												
											}
														//$('#l_pane input[type="input"], input[type="radio"], textarea, select').prop( "disabled", true );
														//$('#saveb, #cnclb, #f_up').hide();
														//$('#f_ret, #editb, #delb').show();
														
										  }
								  else
										  {
											$('#notify').html('<label style="color:red;border: 1px solid red;padding:5px;"><b>'+error+'</b></label>').show().delay(2000).fadeOut('slow');
										  }	  
		
			
			
		});
		
		$('#delb').button().on('click', function(){
			
					$('#up_msg').html('<center><label>Delete this record permanently?</label></center>').dialog({
											title: 'Confirm',
											resizable: false,
											width: 400,
											modal: true,
											resizeable: false,
											buttons:{
												
												Proceed: function(){
													$('.ui-dialog-buttonpane').button().hide();
													$.ajax({ 
															type: "POST", 
															url: "<?php echo base_url();?>c_dts/delete_record",
															data: $("#doc_frm").serialize(),
															beforeSend:function(){
																	$('#up_msg').html('<center><table><tr><td><label style="color:#009999"><b>Deleting Record</b></label></td> <td><img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" alt="" style="height:50px;margin:0" /></td></tr></table></center>').dialog({
																			title: 'Please wait',
																			resizable: false,
																			width: 400,
																			modal: true,
																	});
															},
															success: function(){
																
																	$('#up_msg').html('<center><br><label style="color:#009999"><b>Successfully deleted!</b></label></center>').dialog({
																			title: 'Success',
																			resizable: false,
																			width: 400,
																			modal: true,
																	});
																
																	setTimeout(function() {
																		$('.doc_count').each(function(){
																			var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
																			get_count_rec(ids).done(function(response){
																				$('#'+ids).text(response[0]['cnt']);
																			});
																		});
																		record_tbl.draw();
																		// window.location.reload();
											
																	}, 1000);																	
															}
													});
													
												},
												/*
												Cancel: function(){
													$(this).dialog('close');
												},
												*/
											}
									});
			
					
		});
		var table = $('#attach_t').DataTable();
		
		if(ef_id==7 || ef_id==8 || ef_id==10){
			$('#editb').hide();
		}
		
		$('#editb').button().on('click', function(e){
			
			e.preventDefault();
			table.column(3).visible(true);
			
			$(this).hide();
			
			
			
			$('#l_pane input[type="date"], input[type="time"], input[type="input"], input[name="doc_class"], textarea, select[name!="sec_filter"]').prop( "disabled", false );
			$('#l_pane input[type="date"], input[type="time"], input[type="input"], textarea, select[name!="sec_filter"]').css({'color':'black','background-color':'#ffffff', 'border':'1px solid gray'});
			$('#saveb, #cnclb, #f_up').show();$('#delb, #dl_link, #routb, #rsb, #logb, #actb').hide();
			$('#modal_route').slideUp();
			
			if(ef_id==1 || ef_id==2 || ef_id==4 || ef_id==6){
				$(document).off("click", "#l_pane input[name='doc_class']");
			}else{
				$(document).on("click", "#l_pane input[name='doc_class']", function(e){return false});
			}
			
		});
		
		
		$('#cnclb').button().hide().on('click', function(e){
			
			var doc_no = $('#doc_no').val();
			
			e.preventDefault();
			table.column(3).visible(false);
			
			$(this).hide();
			$('#l_pane input[type="input"], input[name="doc_class"], textarea, select[name!="sec_filter"]').prop( "disabled", true );
			$('#files').val('');
			f_count = 0;
			
			
			$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
				title: 'Record Preview',
				resizable: false,
				width: '90%',
				show: 'fade',
				hide: 'fade',
				modal: true,
				closeOnEscape: false,
				close: function() {
					$('.doc_count').each(function(){
						var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
						get_count_rec(ids).done(function(response){
							$('#'+ids).text(response[0]['cnt']);
						});
					});
					record_tbl.draw();
					// window.location.reload();
				},
				position: {
					my: 'center',
					at: 'top',
				},
										
										
			});
			
			
			
		});
		
		
		$('#actdesc_sec input[type="checkbox"]').on('change', function(){
			if($('#act_id6').is(':checked')){
				$('#div_sec input[type="checkbox"], #actdesc_sec input[id!="act_id6"]').each(function(){
					$(this).prop('checked', false);
					$(this).prop('disabled', true);
				});
			}else{
				$('#div_sec input[type="checkbox"], #actdesc_sec input[id!="act_id6"]').each(function(){
					$(this).prop('disabled', false);
				});
			}
		});
		
		$('#up_routb').button().on('click', function(e) {
			var doc_no = $('#doc_no').val();
			var chk_error = '';
			var $div_checkboxes = $('#div_sec input[type="checkbox"]');
			var $sec_checkboxes = $('#sec_sec input[type="checkbox"]');
			var $checkboxes = $('#actdesc_sec input[type="checkbox"]');
			var $checkradio = $('input[name="doc_clsf"]');
			var countDivCheckedCheckboxes = $div_checkboxes.filter(':checked').length;
			var countSecCheckedCheckboxes = $sec_checkboxes.filter(':checked').length;
			var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
			var countCheckedradio = $checkradio.filter(':checked').length;
			
			
			if($('#act_id6').is(':checked')){
				chk_error = '';
			}else{
				
				if(countDivCheckedCheckboxes < 1){chk_error = 'Please select a "Division/Bureau" for referral';}
				<?php if($this->session->userdata('div_log_id')!=1):?>
				if(countSecCheckedCheckboxes < 1){chk_error = 'Please select a "Section" for referral';}
				<?php endif;?>
				if(countCheckedCheckboxes==0){chk_error = 'Please select an "Action" for this document';}
				if($('#act_flag').is(':checked')){if(countCheckedradio==0){chk_error = 'Please select action document classification: "Simple, Complex, Highly Technical or Legal Concern"';}}
				
			}
		
			
			if(chk_error==''){
			
					$.ajax({ 
							type: "POST",
							<?php if($this->session->userdata('div_log_id')==1):?>url: "<?php echo base_url();?>c_dts/update_stat?doc_no="+doc_no+"&ef_id=2",
							<?php else:?>url: "<?php echo base_url();?>c_dts/update_stat?doc_no="+doc_no+"&ef_id=3",
							<?php endif;?>
							
							data: $("#doc_frm").serialize(),
							success: function(){
							
								
								$('#up_routb').text('ROUTING ').append('<img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" class="uploading_img" style="float:right;height:30px;margin:-5px 0px -10px 0px;mix-blend-mode:multiply" />');
								setTimeout(function() {$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
												title: 'Record Preview',
												resizable: false,
												width: '90%',
												show: 'fade',
												hide: 'fade',
												modal: true,
												closeOnEscape: false,
												close: function() {
													$('.doc_count').each(function(){
														var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
														get_count_rec(ids).done(function(response){
															$('#'+ids).text(response[0]['cnt']);
														});
													});
													record_tbl.draw();
													// window.location.reload();
												},
												position: {
													my: 'center',
													at: 'top',
												},
												
												
								});}, 2000);			
							}
					});
			}
			else{
				$('#up_msg').html('<center><br><label style="color:#009999"><b>'+chk_error+'</b></label></center>').dialog({
						title: 'Notification',
						resizable: false,
						width: 400,
						modal: true,
						open: function(event, ui) {
							
						},
				});
			}
			
		}).css({'background-color':'#CA5F5F', 'color':'#ffffff'});
		$('#routb').button().on('click', function(e) {
			
					if($('#modal_route').is(":visible")){
							$('#modal_route').slideUp();
					}
					else{
						$('#modal_route').slideDown();
					}
				
					
		}).css({'background-color':'#CA5F5F', 'color':'#ffffff'});
		
	/* 	$('#logb').button().on('click', function(e) {
			
				var doc_no = $('#doc_no').val();
				$('#logs_cont').load("<?php echo base_url();?>c_dts/get_logs?doc_no="+doc_no+"").dialog({
							title: 'Record Tracks',
							resizable: false,
							width: '70%',
							//minHeight: 300,
							show: 'fade',
							hide: 'fade',
							modal: true,
							closeOnEscape: false,
							close: function() {$('#log_tbl').DataTable().destroy();},
							position: {
								my: 'center',
								at: 'top',
							},
							open: function(event, ui) {
								//
							}
				});
		}); */
		
		$('#rsb').button();
				
		$('#recvb').button().on('click', function(e) {
			var doc_no = $('#doc_no').val();
					$.ajax({ 
							type: "POST", 
							url: "<?php echo base_url();?>c_dts/update_stat?doc_no="+doc_no+"&ef_id=4",
							data: $("#doc_frm").serialize(),
							success: function(){
								
								$('#recvb').text('Updating ').append('<img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" class="uploading_img" style="float:right;height:30px;margin:-5px 0px -10px 0px;mix-blend-mode:multiply" />');
								
								setTimeout(function() {$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
												title: 'Record Preview',
												resizable: false,
												width: '90%',
												show: 'fade',
												hide: 'fade',
												modal: true,
												closeOnEscape: false,
												close: function() {
													$('.doc_count').each(function(){
														var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
														get_count_rec(ids).done(function(response){
															$('#'+ids).text(response[0]['cnt']);
														});
													});
													record_tbl.draw();
													// window.location.reload();
												},
												position: {
													my: 'center',
													at: 'top',
												},
												
												
								});}, 2000);			
							}
					});
				
		}).css({'background-color':'#CA5F5F', 'color':'#ffffff'});
		
		$('#for_dc').button().on('click', function(e) {
			var doc_no = $('#doc_no').val();
					$.ajax({ 
							type: "POST", 
							url: "<?php echo base_url();?>c_dts/update_stat?doc_no="+doc_no+"&ef_id=7",
							data: $("#doc_frm").serialize(),
							success: function(){
								
								$('#for_dc').text('Archiving Record ').append('<img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" class="uploading_img" style="float:right;height:30px;margin:-5px 0px -10px 0px;mix-blend-mode:multiply" />');
										
								setTimeout(function() {$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
												title: 'Record Preview',
												resizable: false,
												width: '90%',
												show: 'fade',
												hide: 'fade',
												modal: true,
												closeOnEscape: false,
												close: function() {
													$('.doc_count').each(function(){
														var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
														get_count_rec(ids).done(function(response){
															$('#'+ids).text(response[0]['cnt']);
														});
													});
													record_tbl.draw();
													// window.location.reload();
												},
												position: {
													my: 'center',
													at: 'top',
												},
												
												
								});}, 2000);			
							}
					});
				
		});
		
		$('#retrnb').button().on('click', function(e) {
				
				var doc_no = $('#doc_no').val();
				$('#up_msg').html('<center><br><table><tr><td style="vertical-align:top;width:100px"><b>Reason: </b></td><td><textarea rows="5" cols="34" type="input" name="ret_reason" id="ret_reason" placeholder="Optional" ></textarea></td></tr></table></center>').dialog({
											title: 'Confirm Returning',
											resizable: false,
											width: 500,
											modal: true,
											open: function(event, ui) {
												
												//$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
												
												$('#ret_reason').on('keyup', function (e) {
			
														$('#doc_remarks').val($(this).val());
														
												});
											},
											buttons:{
												
												Proceed: function(){
													$('.ui-dialog-buttonpane').button().hide();
													
													$.ajax({ 
															type: "POST", 
															url: "<?php echo base_url();?>c_dts/update_stat?doc_no="+doc_no+"&ef_id=6",
															data: $("#doc_frm").serialize(),
															beforeSend:function(){
																
																$('#retrnb').text('Returning ').append('<img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" class="uploading_img" style="float:right;height:30px;margin:-5px 0px -10px 0px;mix-blend-mode:multiply" />');
										
															},
															success: function(){
																	
																	$('#up_msg').html('<center><br><label style="color:#009999"><b>Document Returned!</b></label></center>').dialog({
																					title: 'Success',
																					resizable: false,
																					width: 400,
																					modal: true,
																					open: function(event, ui) {
																						
																					},
																	});
																	
																	setTimeout(function() {$('#up_msg').dialog('close');}, 2000);
																	setTimeout(function() {window.location.reload();}, 2000);	
																	
															}
													});
													
													
												},
												
												Cancel: function(){
														$(this).dialog('close');
														$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
																		title: 'Record Preview',
																		resizable: false,
																		width: '90%',
																		show: 'fade',
																		hide: 'fade',
																		modal: true,
																		closeOnEscape: false,
																		close: function() {
																			$('.doc_count').each(function(){
																				var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
																				get_count_rec(ids).done(function(response){
																					$('#'+ids).text(response[0]['cnt']);
																				});
																			});
																			record_tbl.draw();
																			// window.location.reload();
																		},
																		position: {
																			my: 'center',
																			at: 'top',
																		},
																		
																		
														});
												},
												
											}
					
				});
		});
		
		$('#ackb').button().on('click', function(e) {
				
				var doc_no = $('#doc_no').val();
				
				$('#up_msg').html('<center><br><table><tr><td style="vertical-align:top;width:100px"><b>Remarks: </b></td><td><textarea rows="5" cols="34" type="input" name="ack_remarks" id="ack_remarks" placeholder="Optional" ></textarea></td></tr></table></center>').dialog({
														title: 'Confirm Acknowledgement',
														resizable: false,
														width: 500,
														modal: true,
														open: function(event, ui) {
															$('#ack_remarks').on('keyup', function (e) {
			
																$('#doc_remarks').val($(this).val());
														
															});
														},
														buttons:{
															Confirm: function(){
																	$(this).dialog('close');
																	 $.ajax({ 
																			type: "POST", 
																			url: "<?php echo base_url();?>c_dts/update_stat?doc_no="+doc_no+"&ef_id=8",
																			data: $("#doc_frm").serialize(),
																			success: function(){
																								$('#up_msg').html('<center><br><label style="color:#009999"><b>Document Acknowledged!</b></label></center>').dialog({
																												title: 'Success',
																												resizable: false,
																												width: 400,
																												modal: true,
																												open: function(event, ui) {
																												},
																												buttons:{
																												},
																								});
																								
																								setTimeout(function() {$('#up_msg').dialog('close');}, 2000);
																								//setTimeout(function() {window.location.reload();}, 2000);
																								setTimeout(function() {$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
																												title: 'Record Preview',
																												resizable: false,
																												width: '90%',
																												show: 'fade',
																												hide: 'fade',
																												modal: true,
																												closeOnEscape: false,
																												close: function() {
																													$('.doc_count').each(function(){
																														var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
																														get_count_rec(ids).done(function(response){
																															$('#'+ids).text(response[0]['cnt']);
																														});
																													});
																													record_tbl.draw();
																													// window.location.reload();
																												},
																												position: {
																													my: 'center',
																													at: 'top',
																												},
																												
																												
																								});}, 2000);			
																			}
																	});	
																	
															},
														}
										});
				
					
		}).css({'background-color':'#009999', 'color':'#ffffff'});
		
		$('#actb').button().on('click', function(e){
			
					var doc_no = $('#doc_no').val();
					
					$('#act_up_modal').load("<?php echo base_url();?>c_dts/act_up?doc_no="+doc_no+"").dialog({
							title: 'Action Taken',
							resizable: false,
							width: '45%',
							minHeight: 150,
							show: 'fade',
							hide: 'fade',
							modal: true,
							closeOnEscape: false,
							close: function() {
								$('.doc_count').each(function(){
									var ids = $('#'+$(this).attr('id'))['selector'].replace('#', '');
									get_count_rec(ids).done(function(response){
										$('#'+ids).text(response[0]['cnt']);
									});
								});
								record_tbl.draw();
								// window.location.reload();
							},
							position: {
								my: 'center',
								at: 'top',
							},
							open: function(event, ui) {
								//$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
							}
					});
			}).css({'background-color':'#CA5F5F', 'color':'#ffffff'});
		
		
		$('#attach_t tbody').on('click', '.d_btn', function (e) {
			
			var datas = table.row( $(this).parents('tr') ).data();
			
			fdel[x] = {f_id:datas[0], f_name:datas[1]};
			f_count = fdel.length;
			
			//console.log(fdel[0].f_id);
			
			table.row( $(this).parents('tr') ).remove().draw();		
			x++;	
		});
		
		
							
	});

</script>