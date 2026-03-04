<div id="frm_dia2">
		<center>
		<div id="up_msg2"></div>
		<form id="doc_frm2" name="doc_frm2" method="POST">
			<table id="add_tbl">
						
						<tr>
							<td><b>Classification</b><span>*</span></td>
							<td style="text-align:left;">
								<input style="height:15px;width:15px;" type="radio" name="doc_class2" value="1" checked />For Routing
								<input style="height:15px;width:15px;margin-left:50px" type="radio" name="doc_class2" value="2" />For Release
							</td>
						</tr>
						<tr id="lev_prio">
							<td><b>Level of Priority</b><span>*</span></td>
							<td style="text-align:left;">
								<select name="prior_t2" id="prior_t2">
									<option value="">--Select Level--</option>
									<option value="Low">Low</option>
									<option value="Normal">Normal</option>
									<option value="High">High</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><b>Document Type</b><span>*</span></td>
							<td style="text-align:left;">
								<select name="dt_id2" id="dt_id2">
									<option value="">--Select Type--</option>
									<?php foreach($doc_type as $row):?>
										<option value="<?php echo $row['dt_id'];?>"><?php echo $row['doc_description'];?></option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
						<tr>
							<td><b id="from_to">Sender</b><span>*</span></td>
							<td style="text-align:left;">
								<select name="sender2" id="sender2">
									<option value="">--Select Sender--</option>
									<option value="Henry A. Adornado, Ph.D">Regional Office</option>
									<?php foreach($div_list as $row):?>
										<option value="<?php echo $row['head_name'];?>"><?php echo $row['div_name'];?></option>
									<?php endforeach; ?>
									<option value="Others">Others</option>
								</select>
								<div id="alt_inpt"><input type="input" name="sender_f2" id="sender_f2" placeholder="Specify Sender"/><a href="#" id="undob2" style="position:absolute;font-size:16px;margin-top:6px;">(undo)</a></div>					
							</td>
						</tr>
						<tr>
							<td><b id="dt_rr">Date/Time Stamped Received</b><span>*</span></td><td><input type="date" name="doc_date_rr2" id="doc_date_rr2" style="width:165px" /> <input type="time" name="doc_time_rr2" id="doc_time_rr2" style="width:120px" /></td>
						</tr>
						<tr>
							<td><b>Document Date</b><span>*</span></td><td><input type="input" name="doc_date2" id="doc_date2" readonly="readonly" /></td>
						</tr>
						<tr>
							<td style="vertical-align:top;padding-top:10px"><b>Subject</b><span>*</span></td><td><textarea style="margin-top:10px" rows="10" cols="40" name="doc_subject2" id="doc_subject2"></textarea></td>
						</tr>
						<tr>
							<td style="vertical-align:top;padding-top:20px"><b>Attachment File(s)</b><span>*</span></td>
							<td style="vertical-align:top;padding-top:20px"><input style="font-size:14px" type="file" name="files2" id="files2" accept="application/pdf" multiple /><div id="upf_not"></div><div style="font-size:15px"><i>(Press 'ctrl key' for multiple file attachment)</i></div></td>
						</tr>
			</table>
						
		</form>
							<div style="margin: 30px 0px 0px 400px">				
								<a href="#" id="sub_btn">Upload</a>
							</div>
		</center>
	</div>	

<script type="text/javascript">
	$(document).ready(function(){
		
		var record_tbl = $('#record_tbl').DataTable();
		
		$(document).on("keyup", "#doc_subject2" , function(e){
			
				$.ajax({
					url:"<?php echo base_url(); ?>c_dts/get_doc_subjects",
					method:"POST",
					dataType: 'json',
					data:{'doc_subject': $(this).val()},
					success: function(data) {
						
						
						var title_arr = data;
						var doc_sub = [];
						for (var i = 0; i < title_arr.length; i++) {
							doc_sub[i] = title_arr[i]['doc_subject'];
						}
						
						
						var auto_sub = doc_sub;
						$('#doc_subject2').autocomplete({
							source: auto_sub,
							minLength: 5,
							select: function(event, ui){ 
							
								$(this).after('<label id="noti" style="font-weight:bold;color:red;">This subject already exist!</label>');
								
							},
						});
						
					}
				});
		});
		
		
		
		$('#doc_date2').datepicker({dateFormat: "M-dd-yy"});
		$('#alt_inpt').hide();
		$('#sender2').on('change', function(){
			
			var sender_f2 = $('#sender2').val(); 
			if($(this).val()=='Others'){
				$(this).hide();
				$('#alt_inpt').show();
				$('#sender_f2').val('');
			}
			else{$('#sender_f2').val(sender_f2);}
							
		});
		
		$('#undob2').on('click', function(){
			$('#alt_inpt').hide();
			$('#sender2').val('').show();	
			$('#sender_f2').val('');			
		});
		
		$('input[type="radio"]').on('change',function(){	
		   if($(this).val()==1){
			   $('#prior_t2').val('');
			   $('#lev_prio').show();
			   $('#from_to').text('sender2');
			   $('#dt_rr').text('Date/Time Received');
			   $('#sender_f2').attr("placeholder", "Specify sender2");
		   }
		   else if($(this).val()==2){
			   $('#prior_t2').val('Normal');
			   $('#lev_prio').hide();
			   $('#from_to').text('Recipient');
			   $('#dt_rr').text('Date/Time Released');
			   $('#sender_f2').attr("placeholder", "Specify Recipient(s)");
		   }
		});
		
		$("#sub_btn").button().click(function(){ 
							  
								var doc_no = '';
								var error = '';
								var files = $('#files2')[0].files;
								var form_data = new FormData();
								var isValid = true;

										$('#doc_frm2 input[type="date"], input[type="time"], input[type="input"], input[type="radio"], select[name!="sec_filter"], textarea').each(function() {
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
										  }else {
												error = "No PDF file(s) attached.";
											  }
										}	
										
								  if(error == '')
										  {
											  
											  $('.uploading_img').show();
											  $(this).val('Uploading...');
											  
											  $.ajax({ 
													type: "POST", 
													url: "<?php echo base_url();?>c_dts/add_record",
													data: $("#doc_frm2").serialize(),
													success: function(data){
															
															doc_no = data;
															
															if(doc_no!=''){
																$.ajax({
																	url:"<?php echo base_url(); ?>c_dts/upload?doc_no="+doc_no+"",
																	method:"POST",
																	data:form_data,
																	contentType:false,
																	cache:false,
																	processData:false,
																	beforeSend:function(){
																	 
																		$('#sub_btn').text('Uploading ').append('<img src="<?php echo base_url();?>ext_lib/images/load_logo.gif" class="uploading_img" style="float:right;height:30px;margin:-5px 0px -10px 0px;mix-blend-mode:multiply" />');
								
																	},
																	success:function(data)
																	{
																		record_tbl.draw();
																		$('#add_record_modal').dialog('close');
																		
																	}
															   });
															}
																
													}
											  });
											  
											   
											   
											   
										  }
								  else
								  {
									$('#up_msg2').html('<label style="color:red;border: 1px solid red;padding:5px;"><b>'+error+'</b></label>').show().delay(2000).fadeOut('slow');
								  }	  
				  
		});
		
								$('input, select, textarea').on('input change',function(){
											$(this).css({
													"border": "",
													"background": ""
												});
								});
								
								$('#files2').on('change', function(){
									var filesup = $('#files2')[0].files;
									var sumup = 0;
									for(var count = 0; count<filesup.length; count++) { sumup+=this.files[count].size; }
										
										sumup=(sumup/1024/1024).toFixed(2);
													  
										if(sumup>100){
											$(this).val('');
											$('#upf_not').text('Total filesize exceeded 100MB limit!').css({"color": "red",}).show().delay(4000).fadeOut('slow');
										}
										/*else{
											$('#uploaded_files').text(sumup+' MB').css({"color": "red",});
										} */
													  
								});
		
		
								
		
	});

</script>