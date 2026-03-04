<div id="frm_dia">
<center>
<div id="act_up_msg"></div>
<form id="act_frm" name="act_frm" method="POST">
	<input type="hidden" name="doc_no" id="doc_no" value="<?php echo $doc_no;?>"/>
	<input type="hidden" name="doc_act_no" id="doc_act_no" value=""/>
	<?php foreach ($records as $rec):?>
	<input type="hidden" name="doc_rec_dt" id="doc_rec_dt" value="<?php echo $rec['act_date'];?>"/>
	<?php endforeach;?>
	<input type="hidden" name="doc_act_rd" id="doc_act_rd" value=""/>
	<input type="hidden" name="doc_act_file" id="doc_act_file" value=""/>
	
			
			<?php foreach ($records as $rec):?>
					<?php 
												
						$holidays=array(
								date('Y').'-01-01', //New Year's Day
								date('Y').'-02-05', //Chinese New Year
								date('Y').'-02-25', //EDSA Revolution
								date('Y').'-04-09', //Day of Valor
								date('Y').'-04-18', //Maundy Thursday
								date('Y').'-04-19', //Good Friday
								date('Y').'-04-20', //Black Saturday
								date('Y').'-05-01', //Labor Day
								date('Y').'-06-05', //Eidul Fitr
								date('Y').'-06-12', //Independence Day
								date('Y').'-08-12', //Eidul Adha
								date('Y').'-08-21', //Ninoy Aquino Day
								date('Y').'-08-26', //National Heroes Day
								date('Y').'-11-01', //All Saint's Day
								date('Y').'-11-02', //All Soul's Day
								date('Y').'-11-30', //Bonifacio Day
								date('Y').'-12-24', //Christmas Eve
								date('Y').'-12-25', //Christmas Day
								date('Y').'-12-30', //Rizal Day
								date('Y').'-12-31', //New Year's Eve
							);
								
							date_default_timezone_set('Asia/Manila');
							$dt_recv = strtotime($rec['dt_recv']);
							$dt_curr = strtotime(date('Y-m-d H:i:s'));
							$weekends = 0;
							$hc=0;
							/* for($i=$dt_recv; $i<=$dt_curr;$i=$i+86400){if(date("N",$i) == 6 OR date("N",$i) == 7) {$weekends++;}} */
							
							$date_end = new DateTime(date('Y-m-d H:i:s'));
							$date_end->add(new DateInterval('P1D'));
							$period=new DatePeriod(new DateTime($rec['dt_recv']),new DateInterval('P1D'),$date_end);
							
								if($dt_recv!=''){
									foreach($period as $date){
										$date=$date->format('Y-m-d H:i:s');
										if(strtotime($date)>$dt_recv AND strtotime($date)<$dt_curr AND date("N",strtotime($date)) == 6 OR date("N",strtotime($date)) == 7){$weekends++;}
									}
								}
								
								foreach($holidays as $holiday){
									if($dt_recv!=''){
										if(strtotime($holiday)>$dt_recv AND strtotime($holiday)<$dt_curr AND date("N",strtotime($holiday)) != 6 AND date("N",strtotime($holiday)) != 7){$hc++;}
									}
								}
								
								$dt_diff = date_diff(date_create($rec['dt_recv']),date_create(date('Y-m-d H:i:s')));
								if($dt_diff->m<=0){
									if(($dt_diff->d-$weekends)-$hc<=0){
										if($dt_diff->h<=0){
											if($dt_diff->i<=0){
												if($dt_diff->s<=0){$dt_dur = '-';
												}else{echo "<input type='hidden' name='nd_act' id='nd_act' value='".$dt_diff->s." sec(s)'/>";}
											}else{echo "<input type='hidden' name='nd_act' id='nd_act' value='".$dt_diff->i." min(s)'/>";}
										}else{echo "<input type='hidden' name='nd_act' id='nd_act' value='".$dt_diff->h." hr(s)'/>";}				
									}else{$day_dur=($dt_diff->d-$weekends)-$hc;echo "<input type='hidden' name='nd_act' id='nd_act' value='".$day_dur." day(s)'/>";}
								}else{echo "<input type='hidden' name='nd_act' id='nd_act' value='".$dt_diff->m." month(s)'/>";}
						
					?>
			<?php endforeach;?>		

	<table id="add_tbl">
			
				<tr id="rel_act_doc">
					<td><b>Action</b>
					</td><td><i>
						<!--<input style="height:15px;width:15px;" type="checkbox" name="rel_act_doc_chk" id="rel_act_doc_chk" value="1" />Release Action Document-->
						<select name="act_select" id="act_select">
							<option value="">--Select Action--</option>
							<option value="1">For PENRO's Signature</option>
							<?php if($this->session->userdata('div_log_id')==1):?>	
							<option value="2">Attach Action Document</option>
							<option value="3">Attach & Release Action Document</option>
							<option value="4">Attach Existing Record</option>
							<option value="5">No Action Required</option>
							<?php endif;?>
							
						</select>
					</i></td>
				</tr>
			
				<tr class="hid_sec1">
					<td><b>Document Type</b><span>*</span></td>
					<td style="text-align:left;">
						<select name="dt_id3" id="dt_id3">
							<option value="">--Select Type--</option>
							<?php foreach($doc_type as $row):?>
								<option value="<?php echo $row['dt_id'];?>"><?php echo $row['doc_description'];?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr class="hid_sec1">
					<td><b id="from_to">Recipient</b><span>*</span></td>
					<td style="text-align:left;">
						<select name="sender3" id="sender3">
							<option value="">--Select Recipient--</option>
							<option value="Henry A. Adornado, Ph.D">Regional Office</option>
							<?php foreach($div_list as $row):?>
								<option value="<?php echo $row['head_name'];?>"><?php echo $row['div_name'];?></option>
							<?php endforeach; ?>
							<option value="Others">Others</option>
						</select>
						<div id="alt_inp2"><input type="input" name="sender_f3" id="sender_f3" placeholder="Specify Sender"/><a href="#" id="undob3" style="position:absolute;font-size:16px;margin-top:6px;">(undo)</a></div>					
					</td>
				</tr>
				<tr class="hid_sec1">
					<td><b>Document Date</b><span>*</span></td><td><input type="input" name="doc_date3" id="doc_date3" readonly="readonly" /></td>
				</tr>
				<tr class="hid_sec1">
					<td style="vertical-align:top;padding-top:10px"><b>Subject</b><span>*</span></td><td><textarea style="margin-top:10px" rows="10" cols="40" name="doc_subject3" id="doc_subject3"></textarea></td>
				</tr>
		
				<tr class="hid_sec2">
					<td style="vertical-align:top;padding-top:10px"><b>Remarks</b></td><td><textarea style="margin-top:10px" rows="10" cols="40" name="doc_remarks" id="doc_remarks" placeholder="Optional"></textarea></td>
				</tr>
				<tr class="hid_sec3">
					<td style="vertical-align:top;padding-top:20px"><b>Attachment File(s)<span>*</span></b></td>
					<td style="vertical-align:top;padding-top:20px"><input style="font-size:14px" type="file" name="files" id="au_files" accept="application/pdf" multiple /><div id="upf_not3"></div><div style="font-size:15px"><i>(Press 'ctrl key' for multiple file attachment)</i></div></td>
				</tr>
				<tr class="hid_sec4">
					<td style="vertical-align:top;padding-top:10px"><b>Reason<span>*</span></b></td><td><textarea style="margin-top:10px" rows="10" cols="40" name="doc_reason" id="doc_reason" placeholder="Details"></textarea></td>
				</tr>
	</table>
	
				<center>
				<table id="rel_doc_tbl" class="cell-border display" cellspacing="0" data-page-length='10' style="font-size:14px;width:100%;">
				
					<thead style="text-align:left;background-color:#c4e9e9;">
						<tr>
								<th>Document_No</th>
								<th>Subject</th>
								<th>Release_Date</th>
								<!--<th>File</th>-->
						</tr>
					</thead>
				
					
				</table>
				</center>
				
</form>
				
				
					<div style="margin: 30px 0px 0px 400px">				
						<a href="#" id="au_sub_btn">Submit</a>
					</div>
</center>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		
		var record_tbl = $('#record_tbl').DataTable();
		
		
		$('.hid_sec1, .hid_sec2, .hid_sec3, .hid_sec4, #rel_doc_tbl').hide();
		
		$('#act_select').on('change',function(){
			
			$('#dt_id3, #sender3, #sender_f3, #doc_date3, #doc_subject3, #doc_remarks, #au_files, #doc_act_no, #doc_act_rd, #doc_act_file').each(function() {
					$.trim($(this).val(''));
			});
			
			
			if($(this).val()==1){
				$('.hid_sec2').show();
				$('.hid_sec1, .hid_sec3, .hid_sec4,  #rel_doc_tbl').hide();
			}
			else if($(this).val()==2){
				$('.hid_sec2, .hid_sec3').show();
				$('.hid_sec1, .hid_sec4, #rel_doc_tbl').hide();
			}
			else if($(this).val()==3){
				$('.hid_sec1, .hid_sec2, .hid_sec3').show();
				$('.hid_sec4, #rel_doc_tbl').hide();
			}
			else if($(this).val()==4){
				$('#rel_doc_tbl').show();
				$('.hid_sec1, .hid_sec2, .hid_sec3, .hid_sec4').hide();
			}
			else if($(this).val()==5){
				$('.hid_sec4').show();
				$('.hid_sec1, .hid_sec2, .hid_sec3,  #rel_doc_tbl').hide();
			}
			else{
				$('.hid_sec1, .hid_sec2, .hid_sec3, .hid_sec4, #rel_doc_tbl').hide();
			}
		});
		
		$('#doc_date3').datepicker({dateFormat: "M-dd-yy"});
		$('#alt_inp2').hide();
		$('#sender3').on('change', function(){
			
			var sender_f3 = $('#sender3').val(); 
			if($(this).val()=='Others'){
				$(this).hide();
				$('#alt_inp2').show();
				$('#sender_f3').val('');
			}
			else{$('#sender_f3').val(sender_f3);}
							
		});
		$('#undob3').on('click', function(){
			$('#alt_inp2').hide();
			$('#sender3').val('').show();	
			$('#sender_f3').val('');			
		});
		
		$("#au_sub_btn").button().click(function(){ 
							  
			var doc_no = $('#doc_no').val();
			var doc_act_no = '';
			var error = '';
			var files = $('#au_files')[0].files;
			var form_data = new FormData();
			var isValid = true;
			
			if($('#act_select').val()!=''){
				
			if($('#act_select').val()==4){
					if($('#doc_act_no').val()==''){
						error = "Please select a record!";	
					}
					else{error = "";}
			}	
			
			if($('#act_select').val()==5){
				$('#doc_reason').each(function() {
					if ($.trim($(this).val()) == '') {
						isValid = false;
						error = "Please fill out all required (*) fields.";
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
			}
			
			if($('#act_select').val()==3){
				$('#dt_id3, #sender3, #sender_f3, #doc_date3, #doc_subject3').each(function() {
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
			}
			else if($('#act_select').val()==''){isValid = false;}
				
			if($('#act_select').val()!=1 && $('#act_select').val()!=4 && $('#act_select').val()!=5){
				if (isValid == false){
					error = "Please fill out all required (*) fields.";
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
				  }else {error = "No PDF file(s) attached.";}
				}
			}
					
			  if(error == '')
			  {
				  
				  if($('#act_select').val()!=1 && $('#act_select').val()!=5){
					  
								$.ajax({ 
										type: "POST", 
										url: "<?php echo base_url();?>c_dts/act_up_record?doc_no="+doc_no+"",
										data: $("#act_frm").serialize(),
										success: function(data){
											
											doc_act_no = data;
											
											$.ajax({
												url:"<?php echo base_url(); ?>c_dts/upload?doc_no="+doc_no+"&doc_act_no="+doc_act_no+"",
												method:"POST",
												data:form_data,
												contentType:false,
												cache:false,
												processData:false,
												beforeSend:function(){
													$('#act_up_modal').dialog('close');
													$('#act_up_msg').html('<center><table><tr><td><label style="color:#009999;">Updating Record</label></td> <td><img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" alt="" style="height:50px;margin:0" /></td></tr></table></center>').dialog({
														title: 'Please wait',
														resizable: false,
														width: 500,
														modal: true,
														//open: function(event, ui) {$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();},
													});
												},
												success:function(data)
												{
													$('#act_up_msg').dialog('close');
													
													$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
														title: 'Record Preview',
														resizable: false,
														width: '90%',
														show: 'fade',
														hide: 'fade',
														modal: true,
														closeOnEscape: false,
														close: function() {window.location.reload();},
														position: {
															my: 'center',
															at: 'top',
														},
																				
																				
													});
													
												}
										   });
											
											
										}
								});	

				  }
				  else{
								
								$.ajax({ 
										type: "POST", 
										url: "<?php echo base_url();?>c_dts/act_up_record?doc_no="+doc_no+"",
										data: $("#act_frm").serialize(),
										success: function(data){
												$('#act_up_modal').dialog('close');
												$('#act_up_msg').html('<center><table><tr><td><label style="color:#009999;">Updating Record</label></td> <td><img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" alt="" style="height:50px;margin:0" /></td></tr></table></center>').dialog({
														title: 'Please wait',
														resizable: false,
														width: 500,
														modal: true,
														//open: function(event, ui) {$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();},
												});
												
												setTimeout(function() {$('#act_up_msg').dialog('close');}, 1000);
												
												$("#modal_content").load("<?php echo base_url();?>c_dts/get_prev_page?doc_no="+doc_no+"").dialog({
													title: 'Record Preview',
													resizable: false,
													width: '90%',
													show: 'fade',
													hide: 'fade',
													modal: true,
													closeOnEscape: false,
													close: function() {
														window.location.reload();
													},
													position: {
														my: 'center',
														at: 'top',
													},
																			
																			
												});
											
										}
								});		
					}			
									
				}
					  
			  else
			  {
				$('#act_up_msg').html('<label style="color:red;border: 1px solid red;padding:5px;"><b>'+error+'</b></label>').show().delay(2000).fadeOut('slow');
			  }	 
		}
		else{$('#act_up_msg').html('<label style="color:red;border: 1px solid red;padding:5px;"><b>Please select an action!</b></label>').show().delay(2000).fadeOut('slow');}
				  
		});
		
		
		$('input, select, textarea').on('input change',function(){
				$(this).css({
					"border": "",
					"background": ""
				});
		});
						
								
		$('#au_files').on('change', function(){
			var filesup = $('#au_files')[0].files;
			var sumup = 0;
			for(var count = 0; count<filesup.length; count++) { sumup+=this.files[count].size; }
				
				sumup=(sumup/1024/1024).toFixed(2);
							  
				if(sumup>50){
					$(this).val('');
					$('#upf_not3').text('Total filesize exceeded 50MB limit!').css({"color": "red",}).show().delay(4000).fadeOut('slow');
				}
				/*else{
					$('#uploaded_files').text(sumup+' MB').css({"color": "red",});
				} */
							  
		});
		
		
		$('#rel_doc_tbl').DataTable({
				
					"processing":true,
					"serverSide":true,
					'serverMethod': 'post',
					"ajax":"<?php echo base_url();?>c_dts/get_rel_docs_data",
					
					'columns': [
						 { data: 'doc_no' },
						 { data: 'doc_subject' },
						 { data: 'act_date' },
						 //{ data: 'file_name' },
					 ],
					
					//"bLengthChange": true,
					"dom": 'rt',
					//"dom": 'Bfrtip',
					//"lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
					"language": {
					"processing": "Loading Data...",
					"sSearch": "Search Keywords:",
					"loadingRecords": "Please wait - loading...",
					"lengthMenu": "Display _MENU_ Records",
					"zeroRecords": "No records found",
					"infoEmpty": "No records available",
					"infoFiltered": "(filtered from _MAX_ total records)"
				},
				"columnDefs": [
					
					/* {
						"targets": [3],
						"visible": false,
						"searchable": false
					},
					 */
				],
			
				
			}).order( [ 0, 'desc' ] ).draw();
			
		
		
		/* $('#rel_doc_tbl2').DataTable({
					"bDestroy": true,
					"dom": 'rti',
					"bLengthChange": true,
					"paging": true,
					"info": false,
					"language": {
					"processing": "Loading Data...",
					"sSearch": "Search Keywords:",
					"decimal": ".",
					"thousands": ",",
					"loadingRecords": "Please wait - loading...",
					"lengthMenu": "Display _MENU_ Records",
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
							"targets": [3],
							"visible": false,
							"searchable": false
						},
					],
					
		}).order( [ 0, 'desc' ] ).draw(); */
		
		
		
		$('#rel_doc_tbl thead th').each( function (i) {
					var title = $(this).text();

					$(this).html( '<input type="text" id="'+title+'" placeholder="'+title+'" data-index="'+i+'" />' );
						
					$('#Release_Date').datepicker({dateFormat: "M-dd-yy"});
		});
		
		var table = $('#rel_doc_tbl').DataTable();
		
		$('#rel_doc_tbl tbody').on('click', 'tr', function() {
												
				var idx = table.row(this).data();
				
				$('#doc_act_no').val(idx['doc_no']);
				$('#doc_act_rd').val(idx['act_date']);
				//$('#doc_act_file').val(idx['file_name']);

				if ( $(this).hasClass('selected') ) {
					$(this).removeClass('selected');
					$('#doc_act_no, #doc_act_rd, #doc_act_file').val('');
				}
				else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}				
										
		}).tooltip({
			items: "td",
			content: "Click to select record",
		});
		
		$( table.table().container() ).on( 'keyup change', 'thead input', function () {
				table
					.column( $(this).data('index') )
					.search( this.value )
					.draw();
		});
		
	});

</script>