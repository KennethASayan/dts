<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="<?php echo base_url();?>ext_lib/images/denr.png" type="image/png">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document Tracking System</title>


<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>ext_lib/main.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>ext_lib/JQ/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>ext_lib/data_tables/datatables.css" />


<script type="text/javascript" src="<?php echo base_url();?>ext_lib/JQ/external/jquery/jquery.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>ext_lib/JQ/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>ext_lib/FormatCurrency.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>ext_lib/data_tables/datatables.js" ></script>

</head>


<body>
	<div id="menu_bar">
	
		<?php if($this->session->userdata('valid') == true):?>
		<a href="<?php echo base_url();?>c_dts/logout" id="" style="float:right;margin-right:10px"><img src="<?php echo base_url();?>ext_lib/images/icon/logout.png" alt="Logout" /></a>
		
		<div style="float:right;">	
		<?php
			echo "<div class='dropdown'>
					<a href='#'><i style='color:#ffffff;vertical-align:top;font-size:17px'>Menu</i><img src='".base_url()."ext_lib/images/icon/menu.png' alt='' title='User Group' style='margin-left:15px;' /></a>
						<div class='dropdown-content' style='margin-top:27px;'>";
						if($this->session->userdata('role_log_id')==1){
							echo "<a href='".base_url()."c_dts/user_page'><img src='".base_url()."ext_lib/images/icon/ugroup.png' alt='' /><span style='vertical-align:top'>User Account</span></a>";
						}
						if($this->session->userdata('role_log_id')!=1){
							echo "<a href='".base_url()."c_dts/cpwd_page' id=''><img src='".base_url()."ext_lib/images/icon/pwd.png' alt='' /><span style='vertical-align:top'>Change Password</span></a>";
						}
			echo "<a href='".base_url()."c_dts/export_page' id=''><img src='".base_url()."ext_lib/images/icon/report.png' alt='' /><span style='vertical-align:top'>Export Record</span></a>
				  <a href='".base_url()."c_dts/system_update' id=''><img src='".base_url()."ext_lib/images/icon/log.png' alt='' /><span style='vertical-align:top'>System Update</span></a>
				  
							
							
						</div>
					
				  </div>
			";
		?>	
		</div>
		
		<div style="float:right;margin:5px 50px;color:#ffffff;font-style:italic">	
			<?php echo "<img src='".base_url()."ext_lib/images/icon/user.png' alt='' title='User Group' style='margin-right:10px;' /><span style='vertical-align:top'>".$this->session->userdata('div_log_alias')." ".$this->session->userdata('role_log_name')."</span>";?>	
		</div>	
		<?php endif;?>
		
	</div>
	<div id="header">
			<table>
				<tr>
				<td style="padding-left:10px"><img src="<?php echo base_url();?>ext_lib/images/denr.png" alt="" /></td>
				<td>
					<ul>
						<li>Republic of the Philippines</li>
						<?php if($this->session->userdata('off_log_penro')==''):?>
						<li><h2>Department of Environment and Natural Resources</h2></li>
						<li>DENR-10 Regional Office, Cagayan de Oro City</li>
						<?php else:?>
						<li><h2><?php echo $this->session->userdata('off_log_penro');?></h2></li>
						<li><?php echo $this->session->userdata('off_log_address');?></li>
						<?php endif;?>
					</ul>
				</td>
				</tr>
			</table>
	</div>
	

	<div style="width:90%;margin-right:5%;margin-left:5%">



				<center>
				<div id="msg"><?php if($msg!=''){echo '<label style="color:green;border: 1px solid green;padding:5px;font-weight:bold">Successfully '.$msg.'</label>';}?></div>
							<div id="ua_diag">
							<center>
							
							<div id="notice"></div>
							<div id="notify"></div>
							
							<form id="ua_control" action="" method="POST">
							<input type="hidden" name="trig" id="trig" />
							<input type="hidden" name="usr_id" id="usr_id" />
							<table id="add_tbl">
								<tr>
									<td>First Name</td>
									<td><input type="input" name="fname" id="fname" /></td>
								</tr>
								<tr>
									<td>Middle Name</td>
									<td><input type="input" name="mname" id="mname" /></td>
								</tr>
								<tr>
									<td>Last Name</td>
									<td><input type="input" name="lname" id="lname" /></td>
								</tr>
								<tr id="pwd_row">
									<td>Password</td>
									<td><input type="password" name="u_pwd" id="u_pwd"  /></td>
								</tr>
								<tr>
								<td>Office</td>
								<td>
									<select name="off_id" id="off_id">
									<option value="">--Select Office--</option>
										<?php foreach ($u_off as $row):?>
										<?php if($row['off_id']!=1):?>
										<option value="<?php echo $row['off_id'];?>"><?php echo $row['off_alias'];?></option>
										<?php endif;?>
										<?php endforeach;?>
									</select>
								</td>
								</tr>								
								<tr>
								<td>Division</td>
								<td>
									<select name="div_id" id="div_id">
									<option value="">--Select Division--</option>
										<?php foreach ($off_div as $row):?>
										<option value="<?php echo $row['div_id'];?>"><?php echo $row['div_name'];?></option>
										<?php endforeach;?>
									</select>
								</td>
								</tr>
								<tr>
								<td>User Role</td>
								<td>
									<select name="role_id" id="role_id">
									<option value="">--Select Role--</option>
										<?php foreach ($off_role as $row):?>
										<option value="<?php echo $row['role_id'];?>"><?php echo $row['role_name'];?></option>
										<?php endforeach;?>
									</select>
								</td>
								</tr>
								<tr>
								<td>Status</td>
								<td>
									<select name="u_stat" id="u_stat">
										<option value="">--Select Status--</option>
										<option value="1">Activate</option>
										<option value="0">Deactivate</option>
									</select>
								</td>
								</tr>								
																
							</table>	
							</form>
							</center>
							</div>
						
						
							<div>
							
							
								
							<br>
							<br>
							<a href='<?php echo base_url();?>/c_dts' id='home_btn' style="float:left"><img src='<?php echo base_url();?>ext_lib/images/icon/return.png' alt='' width='15'/> Return Home</a>
							<input type="button" id="a_btn" value="Add Account" style="height:auto;width:auto;float:left;margin-left:20px"/>
							<!--<input type="button" id="u_btn" value="Update" style="height:auto;width:auto;float:left"/>
							<input type="button" id="d_btn" value="Delete" style="height:auto;width:auto;float:left"/>-->
							
							<table id="user_tbl" class="cell-border stripe" cellspacing="0" data-page-length='7'>
								<thead style="text-align:left">
									<tr>
											<th>ID</th>
											<th>First Name</th>
											<th>Middle Name</th>
											<th>Last Name</th>
											<th>Username</th>
											<th>Password</th>
											<th>Division id</th>
											<th>Division</th>
											<th>Role id</th>
											<th>User Role</th>
											<th>Off_id</th>
											<th>Office</th>
											<th>Stat_id</th>
											<th>Status</th>
											<th style="width:160px"><center>Action</center></th>
									</tr>
								</thead>
								<?php foreach ($user as $row):?>
								<tr>
									<td><?php echo $row['u_id'];?></td>
									<td><?php echo $row['f_name'];?></td>
									<td><?php echo $row['m_name'];?></td>
									<td><?php echo $row['l_name'];?></td>
									<td><?php echo $row['u_name'];?></td>
									<td><?php echo $row['u_pwd'];?></td>
									<td><?php echo $row['div_id'];?></td>
									<td><?php echo $row['div_name'];?></td>
									<td><?php echo $row['role_id'];?></td>
									<td><?php echo $row['role_name'];?></td>
									<td><?php echo $row['off_id'];?></td>
									<td><?php echo $row['off_alias'];?></td>
									<td><?php echo $row['stat_flag'];?></td>
									<td><?php if($row['stat_flag']=='1'){echo '<label style="color:green">Activated</label>';}else{echo '<label style="color:red">Deactivated</label>';}?></td>
									<td></td>
								</tr>	
								<?php endforeach;?>
							</table>
							</div>
					
				</center>
		</div>
				
					
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('#home_btn').button().css({'background-color':'#CA5F5F', 'color':'#ffffff'});
				
				$("#msg").delay(3000).fadeOut('medium');
				
				$('#u_name, #u_pwd').on('input',function(){
						if (!( /^([a-zA-Z0-9_!@#$%&])+$/.test( $(this).val()))){
							$(this).val('');
						}
				});
				
				$("#ua_diag").dialog({
							
									title: "Form",
									autoOpen: false,
									width: '35%',
									show: 'fade',
									hide: 'fade',
									modal: true,
									resizable: false,
									closeOnEscape: false,
									close: function() {
										
												//table.$('tr.selected').removeClass('selected');
												$('#ua_control input, select').css({
															"border": "",
															"background": ""
												}).val('');
												$('#pwd_row').show();
												$('#ua_control input[type="input"], select').prop('disabled', false);
												$('#notice').html('');
												$('.ui-dialog-buttonpane button:contains("Add"), button:contains("Update"), button:contains("Delete"), button:contains("Reset")').button().show();
											},
										
									buttons: {
										
										Add: function(e){
											
												e.preventDefault();
												var isValid = true;
												
												$('#ua_control input[type="input"], select').each(function() {
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
												
												if (isValid == false){$('#notify').html('<center><label style="color:red;border: 1px solid red;padding:5px;"><b>All fields are required</b></label></center>').show().delay(2000).fadeOut('slow');}
												else{$('#ua_control').attr('action', "<?php echo base_url();?>c_dts/ua_ctrl").submit();}
											
										},
										
										Update: function(e){
											
												e.preventDefault();
												var isValid = true;
												
												$('#ua_control input[type="input"], select').each(function() {
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
												
												if (isValid == false){$('#notify').html('<center><label style="color:red;border: 1px solid red;padding:5px;"><b>All fields are required</b></label></center>').show().delay(2000).fadeOut('slow');}
												else{$('#ua_control').attr('action', "<?php echo base_url();?>c_dts/ua_ctrl").submit();}
											
										},
										
										Delete: function(e){
											
												$('#ua_control').attr('action', "<?php echo base_url();?>c_dts/ua_ctrl").submit();
											
										},
										Reset: function(e){
											
												$('#ua_control').attr('action', "<?php echo base_url();?>c_dts/ua_ctrl").submit();
											
										},
										
									},
										  
						});
				
				$('#ua_control input[type="input"], input[type="password"], select').on('input change',function(){
					$(this).css({
								"border": "",
								"background": ""
					});
				});
				
				$('#a_btn').button().on('click', function(e){
					
					table.$('tr.selected').removeClass('selected');
					$('#ua_control input, select').css({
								"border": "",
								"background": ""
					}).val('');
					$('#trig').val('1');
					$('.ui-dialog-buttonpane button:contains("Update"), button:contains("Delete"), button:contains("Reset")').button().hide();
					$('#u_pwd').attr('placeholder', '');
					$("#ua_diag").dialog("option","title",$(this).val()).dialog('open');
					
				}).css({'background-color':'#CA5F5F', 'color':'#ffffff'});
								
				$('#user_tbl').DataTable({
		
						//"dom": '<"toolbar">frtip',
						"bLengthChange": false,
						"language": {
						"decimal": ".",
						"thousands": ",",
						"lengthMenu": "Display _MENU_ Records",
						"zeroRecords": "No records found",
						//"info": "Page _PAGE_ of _PAGES_",
						"infoEmpty": "No records available",
						"infoFiltered": "(filtered from _MAX_ total records)"
					},
					"columnDefs": [
						{
							"targets": [0,5,6,8,10,12],
							"visible": false,
							"searchable": false
						},
						{
							"targets": -1,
							"data": null,
							"defaultContent": "<input type='button' class='u_btn' value='Update' />"+"<input type='button' class='d_btn' value='Delete' />"+"<input type='button' class='r_btn' value='Reset'/>"
						}
					]
					
				});
					
				var table = $('#user_tbl').DataTable();
				
				$('#user_tbl tbody').on('click', '.u_btn', function (e) {
						$('#trig').val('2');
						var datas = table.row( $(this).parents('tr') ).data();
						
						$('#ua_control input, select').css({
									"border": "",
									"background": ""
						});
						$('#usr_id').val(datas[0]);
						$('#fname').val(datas[1]);
						$('#mname').val(datas[2]);
						$('#lname').val(datas[3]);
						$('#div_id').val(datas[6]);
						$('#role_id').val(datas[8]);
						$('#off_id').val(datas[10]);
						$('#u_pwd').attr('placeholder', 'Optional');
						$('#u_stat').val(datas[12]);
						
						$('.ui-dialog-buttonpane button:contains("Add"), button:contains("Delete"), button:contains("Reset")').button().hide();
						$("#ua_diag").dialog("option","title",$(this).val()+" Account").dialog('open');
				});
				
				$('#user_tbl tbody').on('click', '.d_btn', function (e) {
						$('#trig').val('3');
						var datas = table.row( $(this).parents('tr') ).data();
						
						$('#ua_control input, select').css({
									"border": "",
									"background": ""
						});
						$('#usr_id').val(datas[0]);
						$('#fname').val(datas[1]);
						$('#mname').val(datas[2]);
						$('#lname').val(datas[3]);
						$('#div_id').val(datas[6]);
						$('#role_id').val(datas[8]);
						$('#off_id').val(datas[10]);
						$('#u_pwd').attr('placeholder', 'Optional');
						$('#u_stat').val(datas[12]);
					
											
						$('#pwd_row').hide();
						$('#ua_control input[type="input"], select').prop('disabled', true);
						$('.ui-dialog-buttonpane button:contains("Add"), button:contains("Update"), button:contains("Reset")').button().hide();
						$('#notice').html('<center><label style="color:red;border: 1px solid red;padding:5px;"><b>Are you sure you want to remove this account?</b></label></center>');
						$("#ua_diag").dialog("option","title",$(this).val()+" Account").dialog('open');
					
				});
				
				$('#user_tbl tbody').on('click', '.r_btn', function (e) {
						$('#trig').val('4');
						var datas = table.row( $(this).parents('tr') ).data();
						
						$('#ua_control input, select').css({
									"border": "",
									"background": ""
						});
						$('#usr_id').val(datas[0]);
						$('#fname').val(datas[1]);
						$('#mname').val(datas[2]);
						$('#lname').val(datas[3]);
						$('#div_id').val(datas[6]);
						$('#role_id').val(datas[8]);
						$('#off_id').val(datas[10]);
						$('#u_pwd').attr('placeholder', 'Optional');
						$('#u_stat').val(datas[12]);;
					
											
						$('#pwd_row').hide();
						$('#ua_control input[type="input"], select').prop('disabled', true);
						$('.ui-dialog-buttonpane button:contains("Add"), button:contains("Update"), button:contains("Delete")').button().hide();
						$('#notice').html('<center><label style="color:red;border: 1px solid red;padding:5px;"><b>Are you sure you want to reset password?</b></label></center>');
						$("#ua_diag").dialog("option","title",$(this).val()).dialog('open');
											
				});
					
				$('.u_btn').button().css({'font-size':'13px','width':'55px','padding':'5px'});
				$('.d_btn').button().css({'font-size':'13px','width':'55px','padding':'5px'});
				$('.r_btn').button().css({'font-size':'13px','width':'55px','padding':'5px'});
				
			/*
				$('#user_tbl tbody').on('click', 'tr', function() {
					var datas = table.row(this).data();
					alert(datas[0]);
					
					if ($(this).hasClass('selected')){$(this).removeClass('selected');}
					else {table.$('tr.selected').removeClass('selected');$(this).addClass('selected');}
					
					$('#ua_control input, select').css({
								"border": "",
								"background": ""
					});
					$('#usr_id').val(datas[0]);
					$('#emp_name').val(datas[1]);
					$('#u_name').val(datas[2]);
					$('#role_id').val(datas[4]);
					$('#off_id').val(datas[6]);
					$('#u_pwd').attr('placeholder', 'Optional');
					$('#u_stat').val(datas[8]);
				});
			*/
				
			});
		</script>		